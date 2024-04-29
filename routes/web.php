<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-order', function () {
    return view('send-order');
})->name('send-order');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'create'])->name('orders');
Route::get('/orders/{id}/upload', [OrderController::class, 'showUploadForm'])
    ->name('orders.upload-form');
Route::post('/orders/{id}/upload', [OrderController::class, 'handleUpload'])
    ->name('orders.upload');
Route::get('/orders/{id}/download-pdf', [OrderController::class, 'downloadPdf'])
    ->name('orders.downloadPdf');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/logout', function () {
    Auth::logout();

    return redirect('/login');
})->name('logout');

Route::get('/users', [UsersController::class, 'index'])->name('getUsers');
