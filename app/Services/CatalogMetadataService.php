<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CatalogMetadataService
{
    /** @param array{name: string, description?: ?string} $data */
    public function createCategory(array $data): Category
    {
        return DB::transaction(function () use ($data): Category {
            $category = Category::query()->create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'] ?? null,
            ]);

            ActivityLog::record('category.created', "Kategori \"{$category->name}\" ditambahkan.", $category);

            return $category;
        });
    }

    /** @param array{name: string, description?: ?string} $data */
    public function updateCategory(Category $category, array $data): Category
    {
        return DB::transaction(function () use ($category, $data): Category {
            $category->update($data + ['slug' => Str::slug($data['name'])]);

            return $category;
        });
    }

    public function deleteCategory(Category $category): void
    {
        DB::transaction(function () use ($category): void {
            if ($category->books()->exists()) {
                throw ValidationException::withMessages(['category' => 'Kategori masih dipakai oleh buku.']);
            }

            $category->delete();
        });
    }

    /** @param array{name: string, bio?: ?string} $data */
    public function createAuthor(array $data): Author
    {
        return DB::transaction(function () use ($data): Author {
            $author = Author::query()->create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(4)),
                'bio' => $data['bio'] ?? null,
            ]);

            ActivityLog::record('author.created', "Penulis \"{$author->name}\" ditambahkan.", $author);

            return $author;
        });
    }

    /** @param array{name: string, bio?: ?string} $data */
    public function updateAuthor(Author $author, array $data): Author
    {
        return DB::transaction(function () use ($author, $data): Author {
            $author->update($data);

            return $author;
        });
    }

    public function deleteAuthor(Author $author): void
    {
        DB::transaction(function () use ($author): void {
            if ($author->books()->exists()) {
                throw ValidationException::withMessages(['author' => 'Penulis masih terhubung dengan buku.']);
            }

            $author->delete();
        });
    }

    /** @param array{name: string, city?: ?string} $data */
    public function createPublisher(array $data): Publisher
    {
        return DB::transaction(function () use ($data): Publisher {
            $publisher = Publisher::query()->create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(4)),
                'city' => $data['city'] ?? null,
            ]);

            ActivityLog::record('publisher.created', "Penerbit \"{$publisher->name}\" ditambahkan.", $publisher);

            return $publisher;
        });
    }

    /** @param array{name: string, city?: ?string} $data */
    public function updatePublisher(Publisher $publisher, array $data): Publisher
    {
        return DB::transaction(function () use ($publisher, $data): Publisher {
            $publisher->update($data);

            return $publisher;
        });
    }

    public function deletePublisher(Publisher $publisher): void
    {
        DB::transaction(function () use ($publisher): void {
            if ($publisher->books()->exists()) {
                throw ValidationException::withMessages(['publisher' => 'Penerbit masih terhubung dengan buku.']);
            }

            $publisher->delete();
        });
    }
}
