<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAreaTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_area(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
        $this->get('/admin/books')->assertRedirect(route('login'));
    }

    public function test_member_cannot_access_admin_area(): void
    {
        $member = User::factory()->create();

        $this->actingAs($member)->get('/admin')->assertForbidden();
        $this->actingAs($member)->get('/admin/books')->assertForbidden();
        $this->actingAs($member)->get('/admin/settings')->assertForbidden();
    }

    public function test_admin_can_open_every_admin_page(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create();
        $book = Book::factory()->create();

        $pages = [
            '/admin',
            '/admin/books',
            '/admin/books/create',
            '/admin/books/'.$book->id.'/edit',
            '/admin/categories',
            '/admin/authors',
            '/admin/publishers',
            '/admin/members',
            '/admin/members/'.$member->id,
            '/admin/borrowings',
            '/admin/returns',
            '/admin/fines',
            '/admin/reports',
            '/admin/settings',
        ];

        foreach ($pages as $page) {
            $response = $this->actingAs($admin)->get($page);
            $this->assertSame(200, $response->status(), $page.' returned '.$response->status().' '.$response->getContent());
        }
    }

    public function test_admin_dashboard_renders_six_visible_monthly_bars(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertSee('h-72 items-end', false)
            ->assertSee('min-h-[4px]', false);
        $this->assertSame(6, substr_count($response->getContent(), 'style="height:'));
    }

    public function test_admin_can_create_update_and_delete_a_book(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $author = Author::factory()->create();

        $this->actingAs($admin)->post('/admin/books', [
            'title' => 'Filosofi Teras',
            'author_ids' => [$author->id],
            'isbn' => '9786024125187',
            'category_id' => $category->id,
            'publication_year' => 2018,
            'page_count' => 320,
            'description' => 'Panduan filsafat Stoa untuk kehidupan sehari-hari.',
            'total_copies' => 4,
        ])->assertRedirect(route('admin.books.index'));

        $book = Book::query()->where('title', 'Filosofi Teras')->firstOrFail();
        $this->assertSame(4, $book->available_copies);

        $this->actingAs($admin)->put('/admin/books/'.$book->id, [
            'title' => 'Filosofi Teras Edisi Revisi',
            'author_ids' => [$author->id],
            'isbn' => '9786024125187',
            'category_id' => $category->id,
            'publication_year' => 2019,
            'page_count' => 340,
            'total_copies' => 2,
        ])->assertRedirect(route('admin.books.index'));

        $book->refresh();
        $this->assertSame('Filosofi Teras Edisi Revisi', $book->title);
        $this->assertSame(2, $book->available_copies);

        $this->actingAs($admin)->delete('/admin/books/'.$book->id)
            ->assertRedirect(route('admin.books.index'));

        $this->assertSoftDeleted('books', ['id' => $book->id]);
    }

    public function test_book_validation_rejects_missing_title(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post('/admin/books', [
            'title' => '',
            'category_id' => Category::factory()->create()->id,
            'total_copies' => 1,
        ])->assertSessionHasErrors('title');
    }

    public function test_admin_can_toggle_member_status(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->create();

        $this->actingAs($admin)->patch('/admin/members/'.$member->id.'/toggle')->assertRedirect();

        $this->assertFalse($member->fresh()->is_active);
    }

    public function test_admin_can_update_settings(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->patch('/admin/settings', [
            'library_name' => 'Pustaka Nusantara',
            'library_tagline' => 'Ilmu yang terbuka untuk semua',
            'library_address' => 'Jl. Diponegoro No. 42, Bandung',
            'library_phone' => '(022) 8842 1901',
            'library_email' => 'halo@pustaka.test',
            'loan_duration_days' => 10,
            'max_active_loans' => 3,
            'fine_per_day' => 1500,
            'max_fine_days' => 30,
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', ['key' => 'loan_duration_days', 'value' => '10']);
        $this->assertDatabaseHas('settings', ['key' => 'fine_per_day', 'value' => '1500']);
    }

    public function test_report_export_streams_csv(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/reports/export?periode=bulan-ini');

        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('content-type'));
    }

    public function test_member_history_paginates_fines(): void
    {
        $member = User::factory()->create();
        $category = Category::factory()->create();
        foreach (range(1, 16) as $index) {
            $book = Book::factory()->create([
                'title' => 'History Book '.$index,
                'category_id' => $category->id,
            ]);
            $borrowing = Borrowing::factory()->create([
                'user_id' => $member->id,
                'book_id' => $book->id,
            ]);
            Fine::factory()->create([
                'user_id' => $member->id,
                'borrowing_id' => $borrowing->id,
            ]);
        }

        $this->actingAs($member)->get(route('member.history'))
            ->assertOk()
            ->assertViewHas('fines', fn ($fines) => $fines->count() === 10 && $fines->total() === 16);

        $this->get(route('member.history', ['fines' => 2]))
            ->assertOk()
            ->assertViewHas('fines', fn ($fines) => $fines->count() === 6 && $fines->currentPage() === 2);
    }

    public function test_category_crud_from_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'Sejarah',
            'description' => 'Buku tentang peristiwa masa lalu.',
        ])->assertRedirect();

        $category = Category::query()->where('name', 'Sejarah')->firstOrFail();
        $this->assertSame('sejarah', $category->slug);

        $this->actingAs($admin)->patch('/admin/categories/'.$category->id, ['name' => 'Sejarah Indonesia'])
            ->assertRedirect();

        $this->assertSame('Sejarah Indonesia', $category->fresh()->name);
    }
}
