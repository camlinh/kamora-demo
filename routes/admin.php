<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\UserController;

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

Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('admin.login.post');

Route::middleware('auth:admin')->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
  Route::post('/send-notification', [DashboardController::class, 'sendNotification'])->name('admin.notification.deadline');
  Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

  Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('admin.books');
    Route::get('/create', [BookController::class, 'create'])->name('admin.books.create');
    Route::get('/order', [BookController::class, 'order'])->name('admin.books.order');
    Route::post('/store', [BookController::class, 'store'])->name('admin.books.store');
    Route::get('/edit/{id}', [BookController::class, 'edit'])->name('admin.books.edit');
    Route::put('/update/{id}', [BookController::class, 'update'])->name('admin.books.update');
    Route::post('/order', [BookController::class, 'userBorrow'])->name('admin.books.order.post');
    Route::put('/order/return/{id}', [BookController::class, 'userReturn'])->name('admin.books.order.return');
  });

  

  Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.users');
    Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
  });
});