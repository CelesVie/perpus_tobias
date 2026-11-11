<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/books', [CatalogController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [CatalogController::class, 'show'])->name('books.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/dashboard', fn () => auth()->user()->isAdmin()
    ? redirect()->route('admin.dashboard')
    : redirect()->route('member.dashboard'))->middleware('auth')->name('dashboard');

Route::prefix('member')->name('member.')->middleware(['auth', 'role:member'])->group(function (): void {
    Route::get('/dashboard', Member\DashboardController::class)->name('dashboard');
    Route::get('/books', [CatalogController::class, 'index'])->name('books');
    Route::get('/books/{book}', [CatalogController::class, 'show'])->name('books.show');
    Route::get('/borrowings', [Member\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/borrowings/{borrowing}', [Member\BorrowingController::class, 'show'])->name('borrowings.show');
    Route::post('/books/{book}/borrow', [Member\BorrowingController::class, 'store'])
        ->middleware('throttle:10,1')->name('borrowings.store');
    Route::patch('/borrowings/{borrowing}/cancel', [Member\BorrowingController::class, 'cancel'])->name('borrowings.cancel');
    Route::get('/history', Member\HistoryController::class)->name('history');
    Route::get('/profile', [Member\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Member\ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function (): void {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::resource('books', Admin\BookController::class)->except('show')->scoped(['book' => 'id']);

    Route::get('/categories', [Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category:id}', [Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category:id}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/authors', [Admin\AuthorController::class, 'index'])->name('authors.index');
    Route::post('/authors', [Admin\AuthorController::class, 'store'])->name('authors.store');
    Route::patch('/authors/{author:id}', [Admin\AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/authors/{author:id}', [Admin\AuthorController::class, 'destroy'])->name('authors.destroy');

    Route::get('/publishers', [Admin\PublisherController::class, 'index'])->name('publishers.index');
    Route::post('/publishers', [Admin\PublisherController::class, 'store'])->name('publishers.store');
    Route::patch('/publishers/{publisher:id}', [Admin\PublisherController::class, 'update'])->name('publishers.update');
    Route::delete('/publishers/{publisher:id}', [Admin\PublisherController::class, 'destroy'])->name('publishers.destroy');

    Route::get('/members', [Admin\MemberController::class, 'index'])->name('members.index');
    Route::get('/members/{member:id}', [Admin\MemberController::class, 'show'])->name('members.show');
    Route::patch('/members/{member:id}/toggle', [Admin\MemberController::class, 'toggle'])->name('members.toggle');

    Route::get('/borrowings', [Admin\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/returns', [Admin\BorrowingController::class, 'index'])->defaults('status', 'approved')->name('returns.index');
    Route::get('/borrowings/{borrowing}', [Admin\BorrowingController::class, 'show'])->name('borrowings.show');
    Route::patch('/borrowings/{borrowing}/approve', [Admin\BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::patch('/borrowings/{borrowing}/reject', [Admin\BorrowingController::class, 'reject'])->name('borrowings.reject');
    Route::patch('/borrowings/{borrowing}/return', [Admin\BorrowingController::class, 'returnBook'])->name('borrowings.return');

    Route::get('/fines', [Admin\FineController::class, 'index'])->name('fines.index');
    Route::patch('/fines/{fine}/pay', [Admin\FineController::class, 'pay'])->name('fines.pay');

    Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [Admin\ReportController::class, 'export'])->name('reports.export');

    Route::get('/settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::patch('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');
});
