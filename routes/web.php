<?php

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


Auth::routes();

Route::get('/', [App\Http\Controllers\ApiController::class, 'index'])->name('home');
Route::get('/product/{id}', [App\Http\Controllers\ApiController::class, 'detail']);


Route::post('/add', [App\Http\Controllers\CartController::class, 'addToCart'])->name('add');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index']);
Route::post('/clear', [App\Http\Controllers\CartController::class, 'clear']);

Auth::routes();

