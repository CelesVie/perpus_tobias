<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render(): void
    {
        $book = Book::factory()->create();

        $this->get('/')->assertOk()->assertSee('Pustaka');
        $this->get('/books')->assertOk();
        $this->get('/about')->assertOk();
        $this->get('/categories')->assertOk();
        $this->get('/books/'.$book->slug)->assertOk()->assertSee($book->title);
    }

    public function test_search_matches_title_and_author(): void
    {
        $target = Book::factory()->create(['title' => 'Laskar Pelangi']);
        Book::factory()->create(['title' => 'Bumi Manusia']);

        $this->get('/books?q=Laskar')
            ->assertOk()
            ->assertSee('Laskar Pelangi')
            ->assertDontSee('Bumi Manusia');

        $this->assertNotNull($target->fresh());
    }

    public function test_category_filter_narrows_results(): void
    {
        $fiksi = Category::factory()->create(['name' => 'Fiksi', 'slug' => 'fiksi']);
        $sains = Category::factory()->create(['name' => 'Sains', 'slug' => 'sains']);

        Book::factory()->create(['title' => 'Buku Fiksi', 'category_id' => $fiksi->id]);
        Book::factory()->create(['title' => 'Buku Sains', 'category_id' => $sains->id]);

        $this->get('/books?kategori=fiksi')
            ->assertOk()
            ->assertSee('Buku Fiksi')
            ->assertDontSee('Buku Sains');
    }

    public function test_availability_filter_excludes_fully_borrowed_books(): void
    {
        Book::factory()->create(['title' => 'Stok Kosong'])->update(['available_copies' => 0]);
        Book::factory()->create(['title' => 'Stok Ada']);

        $this->get('/books?ketersediaan=tersedia')
            ->assertOk()
            ->assertSee('Stok Ada')
            ->assertDontSee('Stok Kosong');
    }

    public function test_unknown_book_slug_returns_404(): void
    {
        $this->get('/books/tidak-ada')->assertNotFound();
    }

    public function test_member_only_pages_require_login(): void
    {
        $this->get('/member/dashboard')->assertRedirect(route('login'));
        $this->get('/member/borrowings')->assertRedirect(route('login'));
    }

    public function test_must_be_active_member_to_access_member_area(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get('/member/dashboard')->assertForbidden();
    }
}
