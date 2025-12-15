<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
// Маршруты для постов
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
// Маршруты для постов с проверкой прав
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
    ->name('posts.edit')
    ->middleware(['auth', 'post.owner']);
    
Route::get('/posts-api', function() {
    return view('posts.api');
})->name('posts.api');

Route::put('/posts/{id}', [PostController::class, 'update'])
    ->name('posts.update')
    ->middleware(['auth', 'post.owner']); 

Route::delete('/posts/{id}', [PostController::class, 'destroy'])
    ->name('posts.destroy')
    ->middleware(['auth', 'post.owner']); 
// Маршруты профиля
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');


Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
