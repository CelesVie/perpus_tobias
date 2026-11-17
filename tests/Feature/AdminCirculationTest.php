<?php

namespace Tests\Feature;

use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCirculationTest extends TestCase
{
    use RefreshDatabase;

    public function test_borrowings_page_focuses_on_pending_requests_by_default(): void
    {
        $admin = User::factory()->admin()->create();

        $pending = Borrowing::factory()->create(['status' => 'requested']);
        $active = Borrowing::factory()->approved()->create();

        $response = $this->actingAs($admin)->get('/admin/borrowings');

        $response->assertOk()
            ->assertSee('<title>Peminjaman &middot;', false)
            ->assertSee('Kelola pengajuan peminjaman buku dari anggota.')
            ->assertSee($pending->code)
            ->assertDontSee($active->code);
    }

    public function test_returns_page_focuses_on_active_loans_by_default(): void
    {
        $admin = User::factory()->admin()->create();

        $pending = Borrowing::factory()->create(['status' => 'requested']);
        $active = Borrowing::factory()->approved()->create();

        $response = $this->actingAs($admin)->get('/admin/returns');

        $response->assertOk()
            ->assertSee('<title>Pengembalian &middot;', false)
            ->assertSee('Proses pengembalian buku aktif dan pantau keterlambatan.')
            ->assertSee($active->code)
            ->assertDontSee($pending->code);
    }

    public function test_returns_page_lists_overdue_loans_on_the_late_filter(): void
    {
        $admin = User::factory()->admin()->create();

        $overdue = Borrowing::factory()->overdue()->create();
        $active = Borrowing::factory()->approved()->create();

        $this->actingAs($admin)->get('/admin/returns?status=terlambat')
            ->assertOk()
            ->assertSee($overdue->code)
            ->assertSee('Telat')
            ->assertDontSee($active->code);
    }

    public function test_returns_page_shows_finished_history_on_the_returned_filter(): void
    {
        $admin = User::factory()->admin()->create();

        $returned = Borrowing::factory()->returned()->create();
        $active = Borrowing::factory()->approved()->create();

        $this->actingAs($admin)->get('/admin/returns?status=returned')
            ->assertOk()
            ->assertSee($returned->code)
            ->assertDontSee($active->code);
    }

    public function test_borrowings_page_groups_rejected_and_cancelled_rows(): void
    {
        $admin = User::factory()->admin()->create();

        $rejected = Borrowing::factory()->rejected()->create();
        $cancelled = Borrowing::factory()->create(['status' => 'cancelled']);
        $pending = Borrowing::factory()->create(['status' => 'requested']);

        $this->actingAs($admin)->get('/admin/borrowings?status=ditolak')
            ->assertOk()
            ->assertSee($rejected->code)
            ->assertSee($cancelled->code)
            ->assertDontSee($pending->code);
    }

    public function test_borrowings_page_lists_everything_on_the_all_filter(): void
    {
        $admin = User::factory()->admin()->create();

        $pending = Borrowing::factory()->create(['status' => 'requested']);
        $active = Borrowing::factory()->approved()->create();

        $this->actingAs($admin)->get('/admin/borrowings?status=semua')
            ->assertOk()
            ->assertSee($pending->code)
            ->assertSee($active->code);
    }
}
