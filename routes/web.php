<?php

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\AdminController;
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

Route::get('/', [AccueilController::class, 'index'])->name('/');

Route::get('/logout', [AccueilController::class, 'logout'])->name('logout');
Route::post('/login', [AccueilController::class, 'login'])->name('login');
Route::post('/signUp', [AccueilController::class, 'signUp'])->name('signUp');
Route::get('/lang/{lang}', [AccueilController::class, 'lang'])->where('lang', '[a-z]+');

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
