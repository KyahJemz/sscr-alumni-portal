<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\AlumniInformationController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GroupAdminsController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMembersController;
use App\Http\Controllers\GroupPostController;
use App\Http\Controllers\HobbiesController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserHobbiesController;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

// 'roles' => [
//     'alumni' => 'Alumni',
//     'cict_admin' => 'CICT Admin',
//     'program_chair' => 'Program Chair',
//     'alumni_coordinator' => 'Alumni Coordinator',
// ],

Route::get('/test', [TestController::class, 'index'])->name('test.index');

Route::get('/', function () {
    return view('guest.index');
});

Route::get('/home', function () {
    return redirect()->route('posts.index');
})->middleware(['auth', 'verified'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'details'])->name('profile.details');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // USER
    Route::get('/user/{id?}', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::patch('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // ACCOUNT
    Route::post('/accounts/export', [AccountController::class, 'export'])->name('account.export');
    Route::post('/api/accounts/import', [AccountController::class, 'apiImport'])->name('api.account.import');

    Route::get('/accounts/{type}', [AccountController::class, 'index'])->name('account.index');
    Route::get('/api/accounts/{type}', [AccountController::class, 'apiIndex'])->name('api.account.index');

    // https://www.itsolutionstuff.com/post/laravel-11-import-export-excel-and-csv-file-tutorialexample.html

    Route::post('/api/accounts', [AccountController::class, 'apiStore'])->name('api.account.store');
    Route::delete('/api/accounts/{user}', [AccountController::class, 'apiDestroy'])->name('api.account.destroy');
    Route::post('/api/accounts/approval/{user}', [AccountController::class, 'apiApproval'])->name('api.account.approval');
    Route::post('/api/accounts/activation/{user}', [AccountController::class, 'apiActivation'])->name('api.account.activation');

    Route::get('/accounts/{user}', [AccountController::class, 'show'])->name('account.show');
    Route::get('/accounts/{user}/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/accounts/{user}', [AccountController::class, 'update'])->name('account.update');
    Route::patch('/api/accounts/{user}', [AccountController::class, 'update'])->name('account.update');


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

    // NOTIFICATIONS
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/api/notifications', [NotificationController::class, 'apiIndex'])->name('api.notification.index');
    // Route::get('/user-hobbies/create', [UserHobbiesController::class, 'create'])->name('user-hobbies.create');
    // Route::post('/user-hobbies', [UserHobbiesController::class, 'store'])->name('user-hobbies.store');
    // Route::get('/user-hobbies/{user_id}', [UserHobbiesController::class, 'show'])->name('user-hobbies.show');
    // Route::get('/user-hobbies/{user_id}/edit', [UserHobbiesController::class, 'edit'])->name('user-hobbies.edit');
    // Route::put('/user-hobbies/{user_id}', [UserHobbiesController::class, 'update'])->name('user-hobbies.update');
    // Route::patch('/user-hobbies/{user_id}', [UserHobbiesController::class, 'update'])->name('user-hobbies.update');
    // Route::delete('/user-hobbies/{user_id}', [UserHobbiesController::class, 'destroy'])->name('user-hobbies.destroy');

    // ANNOUNCEMENTS
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/{post}', [AnnouncementController::class, 'show'])->name('announcements.show');

    // EVENTS
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{post}', [EventController::class, 'show'])->name('events.show');

    // NEWS
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{post}', [NewsController::class, 'show'])->name('news.show');

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
    Route::get('/groups/{group}/manage', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/api/groups/{group}', [GroupController::class, 'apiUpdate'])->name('api.groups.update');
    Route::patch('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');

    // GROUP MEMBERS
    Route::get('/group-members', [GroupMembersController::class, 'index'])->name('group-members.index');
    Route::get('/group-members/create', [GroupMembersController::class, 'create'])->name('group-members.create');
    Route::post('/group-members', [GroupMembersController::class, 'store'])->name('group-members.store');
    Route::post('/api/group-members', [GroupMembersController::class, 'apiStore'])->name('api.group-members.store');
    Route::get('/api/group-members/{group}', [GroupMembersController::class, 'apiShow'])->name('api.group-members.show');
    Route::get('/group-members/{group}/edit', [GroupMembersController::class, 'edit'])->name('group-members.edit');
    Route::put('/group-members/{group}', [GroupMembersController::class, 'update'])->name('group-members.update');
    Route::patch('/api/group-members/{groupMember}', [GroupMembersController::class, 'apiUpdate'])->name('api.group-members.update');
    Route::delete('/group-members/{groupMember}', [GroupMembersController::class, 'destroy'])->name('group-members.destroy');
    Route::delete('/api/group-members/{group}/{user}', [GroupMembersController::class, 'apiDestroy'])->name('api.group-members.destroy');

    // GROUP ADMINS
    Route::get('/group-admins', [GroupAdminsController::class, 'index'])->name('group-admins.index');
    Route::get('/group-admins/create', [GroupAdminsController::class, 'create'])->name('group-admins.create');
    Route::post('/group-admins/{group}', [GroupAdminsController::class, 'store'])->name('group-admins.store');
    Route::get('/api/group-admins/{group}', [GroupAdminsController::class, 'apiShow'])->name('api.group-admins.show');
    Route::get('/group-admins/{group}/edit', [GroupAdminsController::class, 'edit'])->name('group-admins.edit');
    Route::put('/group-admins/{group}', [GroupAdminsController::class, 'update'])->name('group-admins.update');
    Route::patch('/group-admins/{group}', [GroupAdminsController::class, 'update'])->name('group-admins.update');
    Route::delete('/group-admins/{groupMember}', [GroupAdminsController::class, 'destroy'])->name('group-admins.destroy');
    Route::delete('/api/group-admins/{group}/{user}', [GroupAdminsController::class, 'apiDestroy'])->name('api.group-admins.destroy');

    // FEEDBACK
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    // Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    // Route::get('/feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    // Route::get('/feedback/{feedback}/edit', [FeedbackController::class, 'edit'])->name('feedback.edit');
    // Route::put('/feedback/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update');
    // Route::patch('/feedback/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update');
    // Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    // POSTS
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/api/posts', [PostController::class, 'apiIndex'])->name('api.posts');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/api/posts/{id}', [PostController::class, 'apiShow'])->name('api.posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'apiDestroy'])->name('api.posts.destroy');

    // GROUP POSTS
    Route::get('/api/group/{group}/posts', [GroupPostController::class, 'apiIndex'])->name('api.group.posts.index');
    Route::post('/api/group/{group}/posts', [GroupPostController::class, 'apiStore'])->name('api.group.posts.store');
    Route::get('/group/{group}/posts/{post}', [GroupPostController::class, 'show'])->name('group.posts.show');
    Route::get('/api/group/{group}/posts/{post}', [GroupPostController::class, 'apiShow'])->name('api.group.posts.show');
    Route::get('/group/{group}/posts/{post}/edit', [GroupPostController::class, 'edit'])->name('group.posts.edit');
    Route::patch('/api/group/{group}/posts/{post}', [GroupPostController::class, 'apiUpdate'])->name('api.group.posts.update');
    Route::delete('/api/group/{group}/posts/{post}', [GroupPostController::class, 'apiDestroy'])->name('api.group.posts.destroy');

    // COMMENTS
    //Route::get('/comment', [CommentController::class, 'index'])->name('comment.index');
    //Route::get('/comment/create', [CommentController::class, 'create'])->name('comment.create');
    Route::post('/api/comment', [CommentController::class, 'store'])->name('api.comment.store');
    //Route::get('/comment/{comment}', [CommentController::class, 'show'])->name('comment.show');
    //Route::get('/comment/{comment}/edit', [CommentController::class, 'edit'])->name('comment.edit');
    //Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    //Route::patch('/comment/{comment}', [CommentController::class, 'update'])->name('comment.update');
    Route::delete('/api/comment', [CommentController::class, 'apiDestroy'])->name('api.comment.destroy');

    // LIKES
    //Route::get('/like', [LikeController::class, 'index'])->name('like.index');
    //Route::get('/like/create', [LikeController::class, 'create'])->name('like.create');
    Route::post('/api/like', [LikeController::class, 'store'])->name('api.like.store');
    //Route::get('/like/{like}', [LikeController::class, 'show'])->name('like.show');
    //Route::get('/like/{like}/edit', [LikeController::class, 'edit'])->name('like.edit');
    //Route::put('/like/{like}', [LikeController::class, 'update'])->name('like.update');
    //Route::patch('/like/{like}', [LikeController::class, 'update'])->name('like.update');
    Route::delete('/api/like', [LikeController::class, 'apiDestroy'])->name('api.like.destroy');

    // MESSAGES
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessagesController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessagesController::class, 'show'])->name('messages.show');
    Route::get('/messages/{message}/edit', [MessagesController::class, 'edit'])->name('messages.edit');
    Route::put('/messages/{message}', [MessagesController::class, 'update'])->name('messages.update');
    Route::patch('/messages/{message}', [MessagesController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [MessagesController::class, 'destroy'])->name('messages.destroy');

    // CHAT
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/create', [ChatController::class, 'create'])->name('chats.create');
    Route::post('/chats', [ChatController::class, 'store'])->name('chats.store');
    Route::get('/chats/{id}', [ChatController::class, 'show'])->name('chats.show');
    Route::get('/chats/{id}/edit', [ChatController::class, 'edit'])->name('chats.edit');
    Route::put('/chats/{id}', [ChatController::class, 'update'])->name('chats.update');
    Route::patch('/chats/{id}', [ChatController::class, 'update'])->name('chats.update');
    Route::delete('/chats/{id}', [ChatController::class, 'destroy'])->name('chats.destroy');












});

// Route::get('/accounts/{accountId}', [AccountsController::class, 'showById'])
// $account_id = $request->route('accountId')

// https://yoururl.com/foo?accountId=4490
// $account_id = $request->query('accountId');

require __DIR__.'/auth.php';
