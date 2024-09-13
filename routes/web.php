<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('guest.index');
});

Route::get('/home', function () {
    return view('posts.index');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'details'])->name('profile.details');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // GROUP
    Route::get('/group/{groupId}', [GroupController::class, 'index'])->name('group.index');
    Route::get('/group/create', [GroupController::class, 'create'])->name('group.create');
    Route::post('/group', [GroupController::class, 'store'])->name('group.store');
    Route::get('/group/{groupId}', [GroupController::class, 'show'])->name('group.show');
    Route::get('/group/{groupId}/edit', [GroupController::class, 'edit'])->name('group.edit');
    Route::put('/group/{groupId}', [GroupController::class, 'update'])->name('group.update');
    Route::patch('/group/{groupId}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('/group/{groupId}', [GroupController::class, 'destroy'])->name('group.destroy');

    // POSTS
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{postId}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{postId}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{postId}', [PostController::class, 'update'])->name('posts.update');
    Route::patch('/posts/{postId}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{postId}', [PostController::class, 'destroy'])->name('posts.destroy');

    // GROUP POSTS
    Route::get('/group/{groupId}/posts', [GroupController::class, 'index'])->name('group.posts.index');
    Route::get('/group/{groupId}/posts/create', [GroupController::class, 'create'])->name('group.posts.create');
    Route::post('/group/{groupId}/posts', [GroupController::class, 'store'])->name('group.posts.store');
    Route::get('/group/{groupId}/posts/{postId}', [GroupController::class, 'show'])->name('group.posts.show');
    Route::get('/group/{groupId}/posts/{postId}/edit', [GroupController::class, 'edit'])->name('group.posts.edit');
    Route::put('/group/{groupId}/posts/{postId}', [GroupController::class, 'update'])->name('group.posts.update');
    Route::patch('/group/{groupId}/posts/{postId}', [GroupController::class, 'update'])->name('group.posts.update');
    Route::delete('/group/{groupId}/posts/{postId}', [GroupController::class, 'destroy'])->name('group.posts.destroy');

    // POSTS
    // Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    // Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    // Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    // Route::get('/posts/{postId}', [PostController::class, 'show'])->name('posts.show');
    // Route::get('/posts/{postId}/edit', [PostController::class, 'edit'])->name('posts.edit');
    // Route::put('/posts/{postId}', [PostController::class, 'update'])->name('posts.update');
    // Route::patch('/posts/{postId}', [PostController::class, 'update'])->name('posts.update');
    // Route::delete('/posts/{postId}', [PostController::class, 'destroy'])->name('posts.destroy');












});

// Route::get('/accounts/{accountId}', [AccountsController::class, 'showById'])
// $account_id = $request->route('accountId')

// https://yoururl.com/foo?accountId=4490
// $account_id = $request->query('accountId');

require __DIR__.'/auth.php';
