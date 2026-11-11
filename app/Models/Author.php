<?php

namespace App\Models;

use Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'bio'])]
class Author extends Model
{
    /** @use HasFactory<AuthorFactory> */
    use HasFactory, SoftDeletes;

    /** @return BelongsToMany<Book, $this> */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_author');
    }

    protected static function booted(): void
    {
        static::saving(function (Author $author): void {
            if (blank($author->slug)) {
                $author->slug = Str::slug($author->name);
            }
        });
    }
}
