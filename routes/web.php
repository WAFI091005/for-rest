<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MemoryController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommunityController;

/*
|-------------------------------------------------------------------------- 
| Public Routes
|-------------------------------------------------------------------------- 
*/

Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Auth: Register dan login
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');
require __DIR__.'/auth.php'; // login, logout, forgot password, dsb

/*
|-------------------------------------------------------------------------- 
| Protected Routes (Requires Login)
|-------------------------------------------------------------------------- 
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [BerandaController::class, 'index'])->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Memori
    Route::get('/memori', [MemoryController::class, 'index'])->name('memori');
    Route::get('/memori/create', [MemoryController::class, 'create'])->name('create.memori');
    Route::get('/memori/category/{slug}', [MemoryController::class, 'filterByCategory'])->name('memories.byCategory');
    Route::post('/memori', [MemoryController::class, 'store'])->name('memori.store');
    Route::get('/memories/{id}', [MemoryController::class, 'show'])->name('memories.show');

    // Galeri & Komunitas
    Route::middleware(['auth'])->group(function () {
        Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri');
        Route::resource('gallery', GalleryController::class);
    });


    Route::get('/komunitas', [BerandaController::class, 'komunitas'])->name('komunitas');
});

Route::get('/download-image/{article}/{imageIndex}', [BerandaController::class, 'downloadImage'])->name('articles.download');





Route::post('/notifications/read/{id}', function ($id) {
    $notif = auth()->user()->unreadNotifications->where('id', $id)->first();
    if ($notif) {
        $notif->markAsRead();
    }

    return back();
})->name('notifications.read');


Route::get('/articles/{id}', [BerandaController::class, 'show'])->name('articles.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/memories/{id}/edit', [MemoryController::class, 'edit'])->name('memories.edit');
    Route::put('/memories/{id}', [MemoryController::class, 'update'])->name('memories.update');
    Route::delete('/memories/{id}', [MemoryController::class, 'destroy'])->name('memories.destroy');
});

Route::patch('/article/{id}/toggle-public', [MemoryController::class, 'togglePublic'])->name('article.togglePublic')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
    Route::get('/communities/create', [CommunityController::class, 'create'])->name('communities.create');
    Route::post('/communities', [CommunityController::class, 'store'])->name('communities.store');
    Route::post('/communities/{id}/join', [CommunityController::class, 'join'])->name('communities.join');
    Route::post('/communities/{id}/leave', [CommunityController::class, 'leave'])->name('communities.leave');
});
Route::get('/communities/{id}', [CommunityController::class, 'show'])->name('communities.show');

Route::get('/communities/{community}/articles/create', [CommunityController::class, 'createArticleCommunity'])
    ->name('communities.articles.create');
    Route::post('/communities/{community}/articles', [CommunityController::class, 'storeArticle'])->name('communities.articles.store');
Route::post('/communities/articles/{article}/react', [CommunityController::class, 'reactToArticle'])->name('communities.articles.react');
Route::post('/communities/articles/{id}/comment', [CommunityController::class, 'storeComment'])->name('communities.articles.comment');





// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');