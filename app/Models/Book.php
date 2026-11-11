<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[Fillable([
    'title', 'slug', 'isbn', 'category_id', 'publisher_id', 'publication_year',
    'page_count', 'description', 'cover_path', 'total_copies', 'available_copies', 'is_featured',
])]
class Book extends Model
{
    /** @use HasFactory<BookFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'publication_year' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** @return BelongsTo<Category, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** @return BelongsTo<Publisher, $this> */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    /** @return BelongsToMany<Author, $this> */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    /** @return HasMany<Borrowing, $this> */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    public function authorNames(): string
    {
        return $this->authors->pluck('name')->implode(', ');
    }

    public function isAvailable(): bool
    {
        return $this->available_copies > 0;
    }

    public function coverUrl(): ?string
    {
        return $this->cover_path ? asset('storage/'.$this->cover_path) : null;
    }

    /**
     * Cover palette derived from the title when no image was uploaded.
     *
     * @return array{0: string, 1: string, 2: string}
     */
    public function coverPalette(): array
    {
        $palettes = [
            ['#243447', '#4F8A83', '#FAF9F6'],
            ['#3B4A5A', '#8A6E4F', '#F6F1E8'],
            ['#1F3A34', '#7BA88F', '#F2F7F4'],
            ['#432F2F', '#B07A5E', '#FAF3EE'],
            ['#2C2F45', '#6C7BA8', '#F3F4FA'],
        ];

        return $palettes[crc32($this->slug) % count($palettes)];
    }

    #[Scope]
    protected function search(Builder $query, ?string $term): void
    {
        $term = trim((string) $term);

        if ($term === '') {
            return;
        }

        $query->where(function (Builder $q) use ($term): void {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('isbn', 'like', "%{$term}%")
                ->orWhereHas('authors', fn (Builder $author) => $author->where('name', 'like', "%{$term}%"));
        });
    }

    #[Scope]
    protected function available(Builder $query): void
    {
        $query->where('available_copies', '>', 0);
    }

    protected static function booted(): void
    {
        static::saving(function (Book $book): void {
            if (blank($book->slug)) {
                $book->slug = Str::slug($book->title).'-'.Str::lower(Str::random(4));
            }

            $book->available_copies = min($book->available_copies, $book->total_copies);
        });
    }
}
