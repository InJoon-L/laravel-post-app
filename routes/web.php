<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/posts/create', [PostsController::class, 'create'])->name('create');
Route::get('/posts/index', [PostsController::class, 'index'])->name('index');
Route::get('/posts/myindex', [PostsController::class, 'myIndex'])->name('myIndex');
Route::get('/posts/show/{id}', [PostsController::class, 'show'])->name('posts.show');
Route::get('/posts/{id}', [PostsController::class, 'edit'])->name('post.edit');

Route::post('/posts/store', [PostsController::class, 'store']);
Route::delete('/posts/{id}', [PostsController::class, 'destroy'])->name('post.delete');
Route::put('/posts/{id}', [PostsController::class, 'update'])->name('post.update');

Route::get('/chart/index', [ChartController::class, 'index']);

require __DIR__ . '/auth.php';
