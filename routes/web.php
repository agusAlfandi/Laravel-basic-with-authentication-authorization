<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
  return view('welcome');
});

Route::middleware(['auth', 'revalidate'])->group(function () {
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
});
