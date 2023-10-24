<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/posts/create',[PostController::class, 'create']);

Route::post('/posts',[PostController::class, 'store']);

Route::get('/posts',[PostController::class,'index']);

Route::get('/', [PostController::class, 'welcome']);

Route::get('/myPosts', [PostController::class, 'myPosts']);

Route::get('/posts/{id}', [PostController::class, 'show']);

Route::get('/posts/{id}/edit', [PostController::class, 'edit']);

Route::put('/posts/{id}', [PostController::class, 'update']);

Route::delete('/posts/{id}', [PostController::class, 'archive']);

Route::patch('/posts/{id}', [PostController::class, 'activate']);

Route::put('/posts/{id}/like', [PostController::class, 'like']);

Route::put('/posts/{id}/comment', [PostController::class, 'comment']);