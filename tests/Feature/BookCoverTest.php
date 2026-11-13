<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookCoverTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_a_cover_and_file_is_stored_in_covers_directory(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $author = Author::factory()->create();

        $this->actingAs($admin)->post('/admin/books', [
            'title' => 'Buku Bersampul',
            'author_ids' => [$author->id],
            'category_id' => $category->id,
            'total_copies' => 1,
            'cover' => UploadedFile::fake()->image('cover.jpg', 400, 600),
        ])->assertRedirect(route('admin.books.index'));

        $book = Book::query()->where('title', 'Buku Bersampul')->firstOrFail();

        $this->assertNotNull($book->cover_path);
        Storage::disk('public')->assertExists($book->cover_path);
    }

    public function test_replacing_a_cover_deletes_the_old_file(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $book = Book::factory()->create(['cover_path' => 'covers/old.jpg']);
        Storage::disk('public')->put('covers/old.jpg', 'lama');

        $author = Author::factory()->create();
        $newCover = UploadedFile::fake()->image('new.png', 400, 600);

        $this->actingAs($admin)->put('/admin/books/'.$book->id, [
            'title' => $book->title,
            'author_ids' => [$author->id],
            'category_id' => $book->category_id,
            'total_copies' => $book->total_copies,
            'cover' => $newCover,
        ])->assertRedirect(route('admin.books.index'));

        $book->refresh();
        Storage::disk('public')->assertMissing('covers/old.jpg');
        $this->assertNotSame('covers/old.jpg', $book->cover_path);
        Storage::disk('public')->assertExists($book->cover_path);
    }

    public function test_deleting_a_book_removes_its_cover_file(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $book = Book::factory()->create(['cover_path' => 'covers/to-delete.jpg']);
        Storage::disk('public')->put('covers/to-delete.jpg', 'dihapus');

        $this->actingAs($admin)->delete('/admin/books/'.$book->id)
            ->assertRedirect(route('admin.books.index'));

        Storage::disk('public')->assertMissing('covers/to-delete.jpg');
        $this->assertSoftDeleted('books', ['id' => $book->id]);
    }
}
