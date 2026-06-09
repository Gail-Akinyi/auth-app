<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

// Redirect root to login
Route::get('/', fn() => redirect()->route('login'));

// Register
Route::get('/register', [RegisterController::class, 'showForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');

// Login
Route::get('/login', [LoginController::class, 'showForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Admin user management
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');
    Route::patch('/users/{user}/ban', [App\Http\Controllers\Admin\UserController::class, 'ban'])->name('users.ban');
    Route::patch('/users/{user}/unban', [App\Http\Controllers\Admin\UserController::class, 'unban'])->name('users.unban');
});

// Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
});

// Forgot & Reset Password
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendLink'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

// Email Verification
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard')->with('success', 'Email verified!');
    })->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');
});

// Posts
Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/my-posts', [App\Http\Controllers\PostController::class, 'myPosts'])->name('posts.my');
    Route::get('/posts/create', [App\Http\Controllers\PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [App\Http\Controllers\PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');
});

// Categories
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Contact
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Admin contact messages
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/messages', [App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
    Route::patch('/admin/messages/{message}/read', [App\Http\Controllers\ContactController::class, 'markRead'])->name('contact.read');
    Route::delete('/admin/messages/{message}', [App\Http\Controllers\ContactController::class, 'destroy'])->name('contact.destroy');
});

// Newsletter
Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'store'])->name('newsletter.store');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/subscribers', [App\Http\Controllers\NewsletterController::class, 'index'])->name('newsletter.index');
    Route::delete('/admin/subscribers/{newsletterSubscriber}', [App\Http\Controllers\NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::get('/admin/subscribers/export', [App\Http\Controllers\NewsletterController::class, 'export'])->name('newsletter.export');
});

// Comments
Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');
});

// Likes
Route::middleware('auth')->post('/posts/{post}/like', [App\Http\Controllers\PostLikeController::class, 'toggle'])->name('posts.like');

// Tags
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/tags', [App\Http\Controllers\PostTagController::class, 'index'])->name('tags.index');
    Route::post('/tags', [App\Http\Controllers\PostTagController::class, 'store'])->name('tags.store');
    Route::delete('/tags/{postTag}', [App\Http\Controllers\PostTagController::class, 'destroy'])->name('tags.destroy');
});

// Notifications
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{notification}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/clear', [App\Http\Controllers\NotificationController::class, 'clearAll'])->name('notifications.clear');
});

// 2FA
Route::middleware('auth')->group(function () {
    Route::get('/2fa', [App\Http\Controllers\TwoFactorController::class, 'show'])->name('2fa.show');
    Route::post('/2fa/enable', [App\Http\Controllers\TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/disable', [App\Http\Controllers\TwoFactorController::class, 'disable'])->name('2fa.disable');
    Route::get('/2fa/verify', [App\Http\Controllers\TwoFactorController::class, 'showVerify'])->name('2fa.verify');
    Route::post('/2fa/verify', [App\Http\Controllers\TwoFactorController::class, 'verify'])->name('2fa.verify.submit');
});

// Admin Charts
Route::middleware(['auth', 'admin'])->get('/admin/charts', [App\Http\Controllers\Admin\ChartController::class, 'index'])->name('admin.charts');