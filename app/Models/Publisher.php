<?php

namespace App\Models;

use Database\Factories\PublisherFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'city'])]
class Publisher extends Model
{
    /** @use HasFactory<PublisherFactory> */
    use HasFactory, SoftDeletes;

    /** @return HasMany<Book, $this> */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Publisher $publisher): void {
            if (blank($publisher->slug)) {
                $publisher->slug = Str::slug($publisher->name);
            }
        });
    }
}
