<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\UserController;

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

Route::get('login', [UserController::class, 'index'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
