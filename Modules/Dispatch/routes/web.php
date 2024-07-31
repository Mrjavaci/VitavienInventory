<?php

use Illuminate\Support\Facades\Route;
use Modules\Dispatch\App\Http\Controllers\DispatchController;

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

Route::group([], function () {
    Route::resource('dispatch', DispatchController::class)->names('dispatch')->middleware(['auth']);
});
