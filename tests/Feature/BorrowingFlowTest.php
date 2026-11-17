<?php

namespace Tests\Feature;

use App\Enums\BorrowingStatus;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Setting;
use App\Models\User;
use App\Services\BorrowingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class BorrowingFlowTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_member_can_request_an_available_book(): void
    {
        $member = User::factory()->create();
        $book = Book::factory()->create(['total_copies' => 2, 'available_copies' => 2]);

        $this->actingAs($member)
            ->post(route('member.borrowings.store', $book), ['member_note' => 'Untuk tugas sekolah'])
            ->assertRedirect();

        $borrowing = Borrowing::query()->firstOrFail();
        $this->assertSame(BorrowingStatus::Requested, BorrowingStatus::from($borrowing->status));
        $this->assertSame($member->id, $borrowing->user_id);
        $this->assertNotEmpty($borrowing->code);
    }

    public function test_cannot_request_book_without_available_copies(): void
    {
        $member = User::factory()->create();
        $book = Book::factory()->create(['total_copies' => 1, 'available_copies' => 0]);

        $this->actingAs($member)
            ->post(route('member.borrowings.store', $book))
            ->assertSessionHasErrors('book');

        $this->assertSame(0, Borrowing::query()->count());
    }

    public function test_cannot_create_duplicate_active_request_for_same_book(): void
    {
        $member = User::factory()->create();
        $book = Book::factory()->create(['total_copies' => 3, 'available_copies' => 3]);

        Borrowing::factory()->create([
            'user_id' => $member->id,
            'book_id' => $book->id,
            'status' => BorrowingStatus::Requested->value,
        ]);

        $this->actingAs($member)
            ->post(route('member.borrowings.store', $book))
            ->assertSessionHasErrors('book');

        $this->assertSame(1, Borrowing::query()->count());
    }

    public function test_active_loan_limit_is_enforced(): void
    {
        Setting::put('max_active_loans', '1');
        $member = User::factory()->create();

        Borrowing::factory()->approved()->create(['user_id' => $member->id]);
        $other = Book::factory()->create(['total_copies' => 2, 'available_copies' => 2]);

        $this->actingAs($member)
            ->post(route('member.borrowings.store', $other))
            ->assertSessionHasErrors('book');
    }

    public function test_member_can_cancel_pending_request(): void
    {
        $member = User::factory()->create();
        $borrowing = Borrowing::factory()->create(['user_id' => $member->id]);

        $this->actingAs($member)
            ->patch(route('member.borrowings.cancel', $borrowing))
            ->assertRedirect();

        $this->assertSame(BorrowingStatus::Cancelled->value, $borrowing->fresh()->status);
    }

    public function test_member_cannot_view_another_members_borrowing(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $borrowing = Borrowing::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)->get(route('member.borrowings.show', $borrowing))->assertForbidden();
    }

    public function test_admin_approval_decrements_stock_and_sets_due_date(): void
    {
        Setting::put('loan_duration_days', '7');
        $admin = $this->admin();
        $borrowing = Borrowing::factory()->create([
            'book_id' => Book::factory()->create(['total_copies' => 2, 'available_copies' => 2])->id,
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.borrowings.approve', $borrowing))
            ->assertRedirect();

        $fresh = $borrowing->fresh();
        $this->assertSame(BorrowingStatus::Approved->value, $fresh->status);
        $this->assertNotNull($fresh->due_at);
        $this->assertSame(1, $fresh->book->fresh()->available_copies);
    }

    public function test_approval_fails_when_stock_is_exhausted(): void
    {
        $admin = $this->admin();
        $book = Book::factory()->create(['total_copies' => 1, 'available_copies' => 1]);
        $borrowing = Borrowing::factory()->create(['book_id' => $book->id]);

        $book->update(['available_copies' => 0]);

        $this->actingAs($admin)
            ->patch(route('admin.borrowings.approve', $borrowing))
            ->assertSessionHas('error');

        $this->assertSame(BorrowingStatus::Requested->value, $borrowing->fresh()->status);
    }

    public function test_approved_borrowing_cannot_be_approved_twice(): void
    {
        $admin = $this->admin();
        $book = Book::factory()->create(['total_copies' => 1, 'available_copies' => 1]);
        $borrowing = Borrowing::factory()->create(['book_id' => $book->id]);
        $service = app(BorrowingService::class);

        $service->approve($borrowing, $admin);
        $this->expectException(ValidationException::class);

        $service->approve($borrowing->fresh(), $admin);
    }

    public function test_returned_borrowing_cannot_be_returned_twice(): void
    {
        $admin = $this->admin();
        $book = Book::factory()->create(['total_copies' => 1, 'available_copies' => 0]);
        $borrowing = Borrowing::factory()->approved()->create(['book_id' => $book->id]);
        $service = app(BorrowingService::class);

        $service->returnBook($borrowing, $admin);
        $this->expectException(ValidationException::class);

        $service->returnBook($borrowing->fresh(), $admin);
    }

    public function test_requested_borrowing_cannot_be_rejected_after_processing(): void
    {
        $admin = $this->admin();
        $borrowing = Borrowing::factory()->create();
        $service = app(BorrowingService::class);

        $service->approve($borrowing, $admin);
        $this->expectException(ValidationException::class);

        $service->reject($borrowing->fresh(), $admin, 'Duplikat');
    }

    public function test_approved_borrowing_cannot_be_cancelled_by_service(): void
    {
        $admin = $this->admin();
        $book = Book::factory()->create(['total_copies' => 1, 'available_copies' => 1]);
        $borrowing = Borrowing::factory()->create(['book_id' => $book->id]);
        $service = app(BorrowingService::class);

        $service->approve($borrowing, $admin);
        $this->expectException(ValidationException::class);

        $service->cancel($borrowing->fresh());
    }

    public function test_admin_can_reject_with_reason(): void
    {
        $admin = $this->admin();
        $borrowing = Borrowing::factory()->create();

        $this->actingAs($admin)
            ->patch(route('admin.borrowings.reject', $borrowing), ['reject_reason' => 'Data anggota tidak lengkap'])
            ->assertRedirect();

        $fresh = $borrowing->fresh();
        $this->assertSame(BorrowingStatus::Rejected->value, $fresh->status);
        $this->assertSame('Data anggota tidak lengkap', $fresh->reject_reason);
    }

    public function test_return_on_time_restores_stock(): void
    {
        $admin = $this->admin();
        $book = Book::factory()->create(['total_copies' => 2, 'available_copies' => 1]);
        $borrowing = Borrowing::factory()->approved()->create(['book_id' => $book->id]);

        $this->actingAs($admin)
            ->patch(route('admin.borrowings.return', $borrowing))
            ->assertRedirect();

        $fresh = $borrowing->fresh();
        $this->assertSame(BorrowingStatus::Returned->value, $fresh->status);
        $this->assertNotNull($fresh->returned_at);
        $this->assertSame(2, $book->fresh()->available_copies);
    }

    public function test_return_of_late_loan_still_restores_stock(): void
    {
        $admin = $this->admin();
        $book = Book::factory()->create(['total_copies' => 1, 'available_copies' => 0]);
        $borrowing = Borrowing::factory()->create([
            'book_id' => $book->id,
            'status' => BorrowingStatus::Approved->value,
            'approved_at' => now()->subDays(10),
            'due_at' => now()->subDays(3),
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.borrowings.return', $borrowing))
            ->assertRedirect();

        $fresh = $borrowing->fresh();
        $this->assertSame(BorrowingStatus::Returned->value, $fresh->status);
        $this->assertNotNull($fresh->returned_at);
        $this->assertSame(1, $book->fresh()->available_copies);
    }
}
