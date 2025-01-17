<?php

use App\Mail\TestingMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Jobs\ProsesTestMails;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
  return view('welcome');
});

Route::middleware(['auth', 'revalidate', 'verified'])->group(function () {
  Route::get('/blog', [BlogController::class, 'index'])->name('blog');
  Route::get('/blog/add', [BlogController::class, 'add'])->middleware('role');
  Route::post('/blog/create', [BlogController::class, 'create']);
  Route::get('/blog/{id}/detail', [BlogController::class, 'show'])->name(
    'blog-detail'
  );
  Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name(
    'blog-edit'
  );
  Route::patch('/blog/{id}/update', [BlogController::class, 'update'])->name(
    'blog-update'
  );
  Route::get('/blog/{id}/delete', [BlogController::class, 'delete']);
  Route::get('/blog/{id}/restore', [BlogController::class, 'restore']);
  Route::get('/logout', [AuthController::class, 'logout']);
  Route::get('/user', [UserController::class, 'index']);
  Route::get('/phones', [UserController::class, 'phones']);
  Route::post('/comment/{blog_id}', [CommentController::class, 'store']);
  Route::get('/comment', [CommentController::class, 'show']);
  Route::get('/image', [ImageController::class, 'index']);
  Route::get('/article', [ArticleController::class, 'index']);
});

Route::middleware(['guest', 'revalidate'])->group(function () {
  Route::get('/login', [AuthController::class, 'index'])->name('login');
  Route::post('/auth', [AuthController::class, 'auth']);
  Route::get('/register', [AuthController::class, 'register']);
  Route::post('/register', [AuthController::class, 'createUser']);
  Route::get('/forgot-password', function () {
    return view('Auth.forgot-password');
  })->name('password.request');
  Route::post('/forgot-password', [
    AuthController::class,
    'forgotPassword',
  ])->name('password.email');
  Route::get('/reset-password/{token}', [
    AuthController::class,
    'resetPassword',
  ])->name('password.reset');
  Route::post('/reset-password/update', [
    AuthController::class,
    'updatePassword',
  ])->name('password.update');
});

Route::middleware('auth')->group(function () {
  Route::get('/email/verify', function () {
    return view('Auth.verify-email');
  })->name('verification.notice');

  Route::get('/email/verify/{id}/{hash}', function (
    EmailVerificationRequest $request
  ) {
    $request->fulfill();

    return redirect()->route('blog');
  })
    ->middleware('signed')
    ->name('verification.verify');

  Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
  })
    ->middleware('throttle:6,1')
    ->name('verification.send');
});

Route::get('/send-mail', function () {
  $data = [
    ['email' => 'user0@example.com', 'password' => '123'],
    ['email' => 'user1@example.com', 'password' => 'abc123'],
    ['email' => 'user2@example.com', 'password' => 'def456'],
    ['email' => 'user3@example.com', 'password' => 'ghi789'],
    ['email' => 'user4@example.com', 'password' => 'jkl012'],
    ['email' => 'user5@example.com', 'password' => 'mno345'],
    ['email' => 'user6@example.com', 'password' => 'pqr678'],
    ['email' => 'user7@example.com', 'password' => 'stu901'],
    ['email' => 'user8@example.com', 'password' => 'vwx234'],
    ['email' => 'user9@example.com', 'password' => 'yz5678'],
  ];

  foreach ($data as $user) {

    ProsesTestMails::dispatch($user)->onQueue('send-email');
  }
});
