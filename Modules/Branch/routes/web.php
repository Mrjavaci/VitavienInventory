<?php

use Illuminate\Support\Facades\Route;
use Modules\Branch\App\Http\Controllers\BranchController;

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
    Route::resource('branch', BranchController::class)
         ->names('branch')
         ->middleware(['auth']);
});
