<?php

use Illuminate\Support\Facades\Route;
use Modules\WareHouse\App\Http\Controllers\WaitingDispatchesController;
use Modules\WareHouse\App\Http\Controllers\WareHouseController;

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
    //Route::resource('warehouse', WareHouseController::class)->names('warehouse')->middleware(['auth']);
});
Route::get('warehouse/inventory', [WareHouseController::class, 'index'])->name('warehouseinventory.index')->middleware(['auth']);
Route::resource('waitingdispatches', WaitingDispatchesController::class)->names('waitingdispatches')->middleware(['auth']);

