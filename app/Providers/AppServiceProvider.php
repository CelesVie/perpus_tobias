<?php

namespace App\Providers;

use App\Enums\BorrowingStatus;
use App\Models\Book;
use App\Models\Borrowing;
use App\Policies\BookPolicy;
use App\Policies\BorrowingPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Book::class, BookPolicy::class);
        Gate::policy(Borrowing::class, BorrowingPolicy::class);

        Paginator::useTailwind();

        View::composer('layouts.admin', function ($view): void {
            $view->with('pendingCount', auth()->check() ? Borrowing::query()->where('status', BorrowingStatus::Requested)->count() : 0);
        });

        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(6)
            ->by(Str::lower((string) $request->input('email')).'|'.$request->ip()));

        RateLimiter::for('register', fn (Request $request) => Limit::perHour(20)->by($request->ip()));
    }
}
