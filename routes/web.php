<?php

use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\AlumniInformationController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HobbiesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserHobbiesController;
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

    // USER
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::patch('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // ALUMNI INFORMATION
    Route::get('/alumni-information', [AlumniInformationController::class, 'index'])->name('alumni-information.index');
    Route::get('/alumni-information/create', [AlumniInformationController::class, 'create'])->name('alumni-information..create');
    Route::post('/alumni-information', [AlumniInformationController::class, 'store'])->name('alumni-information.store');
    Route::get('/alumni-information/{alumniInformation}', [AlumniInformationController::class, 'show'])->name('alumni-information.show');
    Route::get('/alumni-information/{alumniInformation}/edit', [AlumniInformationController::class, 'edit'])->name('alumni-information.edit');
    Route::put('/alumni-information/{alumniInformation}', [AlumniInformationController::class, 'update'])->name('alumni-information.update');
    Route::patch('/alumni-information/{alumniInformation}', [AlumniInformationController::class, 'update'])->name('alumni-information.update');
    Route::delete('/alumni-information/{alumniInformation}', [AlumniInformationController::class, 'destroy'])->name('alumni-information.destroy');

    // ADMIN INFORMATION
    Route::get('/admin-information', [AdminInformationController::class, 'index'])->name('admin-information.index');
    Route::get('/admin-information/create', [AdminInformationController::class, 'create'])->name('admin-information.create');
    Route::post('/admin-information', [AdminInformationController::class, 'store'])->name('admin-information.store');
    Route::get('/admin-information/{adminInformation}', [AdminInformationController::class, 'show'])->name('admin-information.show');
    Route::get('/admin-information/{adminInformation}/edit', [AdminInformationController::class, 'edit'])->name('admin-information.edit');
    Route::put('/admin-information/{adminInformation}', [AdminInformationController::class, 'update'])->name('admin-information.update');
    Route::patch('/admin-information/{adminInformation}', [AdminInformationController::class, 'update'])->name('admin-information.update');
    Route::delete('/admin-information/{adminInformation}', [AdminInformationController::class, 'destroy'])->name('admin-information.destroy');

    // USER HOBBIES
    Route::get('/user-hobbies', [UserHobbiesController::class, 'index'])->name('user-hobbies.index');
    Route::get('/user-hobbies/create', [UserHobbiesController::class, 'create'])->name('user-hobbies.create');
    Route::post('/user-hobbies', [UserHobbiesController::class, 'store'])->name('user-hobbies.store');
    Route::get('/user-hobbies/{user_id}', [UserHobbiesController::class, 'show'])->name('user-hobbies.show');
    Route::get('/user-hobbies/{user_id}/edit', [UserHobbiesController::class, 'edit'])->name('user-hobbies.edit');
    Route::put('/user-hobbies/{user_id}', [UserHobbiesController::class, 'update'])->name('user-hobbies.update');
    Route::patch('/user-hobbies/{user_id}', [UserHobbiesController::class, 'update'])->name('user-hobbies.update');
    Route::delete('/user-hobbies/{user_id}', [UserHobbiesController::class, 'destroy'])->name('user-hobbies.destroy');

    // HOBBIES
    Route::get('/hobbies', [HobbiesController::class, 'index'])->name('hobbies.index');
    Route::get('/hobbies/create', [HobbiesController::class, 'create'])->name('hobbies.create');
    Route::post('/hobbies', [HobbiesController::class, 'store'])->name('hobbies.store');
    Route::get('/hobbies/{hobbies}', [HobbiesController::class, 'show'])->name('hobbies.show');
    Route::get('/hobbies/{hobbies}/edit', [HobbiesController::class, 'edit'])->name('hobbies.edit');
    Route::put('/hobbies/{hobbies}', [HobbiesController::class, 'update'])->name('hobbies.update');
    Route::patch('/hobbies/{hobbies}', [HobbiesController::class, 'update'])->name('hobbies.update');
    Route::delete('/hobbies/{hobbies}', [HobbiesController::class, 'destroy'])->name('hobbies.destroy');

    // GROUP
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::patch('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');

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