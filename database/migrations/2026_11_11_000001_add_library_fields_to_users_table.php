<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('member_number')->nullable()->unique()->after('email');
            $table->string('role', 20)->default('member')->index()->after('password');
            $table->boolean('is_active')->default(true)->index()->after('role');
            $table->string('phone', 30)->nullable()->after('is_active');
            $table->text('address')->nullable()->after('phone');
            $table->date('joined_at')->nullable()->after('address');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['member_number', 'role', 'is_active', 'phone', 'address', 'joined_at', 'deleted_at']);
        });
    }
};
