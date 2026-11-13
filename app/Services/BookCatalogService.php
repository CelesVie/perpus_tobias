<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookCatalogService
{
    /** @param array<string, mixed> $data */
    public function create(array $data, ?string $coverPath): Book
    {
        return DB::transaction(function () use ($data, $coverPath): Book {
            $authorIds = $data['author_ids'];
            unset($data['author_ids'], $data['cover_path']);

            $book = new Book($data);
            $book->available_copies = $book->total_copies;
            $book->slug = Str::slug($book->title).'-'.Str::lower(Str::random(5));
            $book->cover_path = $coverPath;
            $book->save();
            $book->authors()->sync($authorIds);

            ActivityLog::record('book.created', "Buku \"{$book->title}\" ditambahkan.", $book);

            return $book;
        });
    }

    /** @param array<string, mixed> $data */
    public function update(Book $book, array $data, ?string $newCoverPath): Book
    {
        return DB::transaction(function () use ($book, $data, $newCoverPath): Book {
            $book = Book::query()->lockForUpdate()->findOrFail($book->id);
            $onLoan = $book->borrowings()->where('status', 'approved')->count();

            if ($data['total_copies'] < $onLoan) {
                $data['total_copies'] = $onLoan;
            }

            $data['available_copies'] = $data['total_copies'] - $onLoan;
            $authorIds = $data['author_ids'];
            unset($data['author_ids'], $data['cover_path']);

            if ($newCoverPath !== null) {
                $oldCoverPath = $book->cover_path;
                $data['cover_path'] = $newCoverPath;
            }

            $book->update($data);
            $book->authors()->sync($authorIds);
            ActivityLog::record('book.updated', "Buku \"{$book->title}\" diperbarui.", $book);

            if (isset($oldCoverPath) && $oldCoverPath !== null) {
                Storage::disk('public')->delete($oldCoverPath);
            }

            return $book;
        });
    }

    public function delete(Book $book): void
    {
        DB::transaction(function () use ($book): void {
            $book = Book::query()->lockForUpdate()->findOrFail($book->id);

            if ($book->borrowings()->exists()) {
                throw ValidationException::withMessages([
                    'book' => 'Buku memiliki riwayat peminjaman dan tidak dapat dihapus.',
                ]);
            }

            if ($book->cover_path !== null) {
                Storage::disk('public')->delete($book->cover_path);
            }

            $book->delete();
            ActivityLog::record('book.deleted', "Buku \"{$book->title}\" dihapus.", $book);
        });
    }
}
