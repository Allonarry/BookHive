<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\book\BookController;
use App\Http\Controllers\AdminController; // Add this import
use Illuminate\Support\Facades\Route;

// Public routes (no auth required)
Route::controller(BookController::class)->group(function() {
    Route::get("/", "index")->name("bookhive.index");
    Route::get('/all-books', 'allBooks')->name('all.books');
    Route::get('/public-books/{book}', 'showPublic')->name('books.show.public');
    Route::get('/browse', 'browse')->name('browse'); // Fixed syntax
});

Route::view('/pricing', 'bookhive.pricing')->name('pricing');
Route::view('/about', 'bookhive.about')->name('about');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Book management routes
    Route::controller(BookController::class)->group(function() {
        Route::get("/bookhive/create", "create")->name("bookhive.create");
        Route::get("/mybook", "mybook")->name("mybook"); // Fixed route name (removed /create)
        Route::post("/book/create", "store")->name("book.store");
        Route::get("/dashboard", "dashboard")->name("dashboard");
        Route::get('/books/{book}', 'show')->name('books.show');
        Route::get('/books/{book}/edit', 'edit')->name('books.edit');
        Route::put('/books/{book}', 'update')->name('books.update');
        Route::delete('/books/{book}', 'destroy')->name('books.destroy');
        Route::post('/books/{book}/toggle-status', 'toggleStatus')->name('books.toggle-status');
        Route::post('/books/{book}/comments', 'storeComment')->name('books.comments.store');
        Route::post('/comments/{comment}/toggle-like', [BookController::class, 'toggleLike'])
     ->name('comments.toggle-like');
        Route::post('/books/{book}/toggle-favorite', 'toggleFavorite')->name('books.toggle-favorite');
        Route::get('/favorites', 'favorites')->name('favorites.index');
    });

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Newsletter route (public)
Route::post('/newsletter/subscribe', [BookController::class, 'subscribeToNewsletter'])
    ->name('newsletter.subscribe');
// Admin routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Books management
    Route::get('books', [AdminController::class, 'books'])->name('admin.books');
    Route::post('books/feature/{book}', [AdminController::class, 'toggleFeatured'])->name('admin.books.feature');
    Route::delete('books/{book}', [AdminController::class, 'destroy'])->name('admin.books.destroy');
    
    // Users management
    Route::get('users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('users/block/{user}', [AdminController::class, 'toggleBlock'])->name('admin.users.block');
    
    // Genres management
    Route::get('genres', [AdminController::class, 'genres'])->name('admin.genres');
    Route::post('genres', [AdminController::class, 'addGenre'])->name('admin.genres.add');
    Route::delete('genres/{genre}', [AdminController::class, 'deleteGenre'])->name('admin.genres.delete');
});


require __DIR__.'/auth.php';