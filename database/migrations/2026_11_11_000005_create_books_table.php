<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->string('isbn', 20)->nullable()->unique();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('publisher_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedSmallInteger('publication_year')->nullable()->index();
            $table->unsignedSmallInteger('page_count')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_path')->nullable();
            $table->unsignedSmallInteger('total_copies')->default(1);
            $table->unsignedSmallInteger('available_copies')->default(1)->index();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'available_copies']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
