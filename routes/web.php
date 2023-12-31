<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebcameraController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\CreditController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('credit',CreditController::class);
    Route::get('/order/view/{id_order}',[OrderController::class,'orderView'])->name('orders.view');
    Route::get('/find', [OrderController::class,'find'])->name('orders.find');
    Route::get('/download/{id_order}',[OrderController::class,'downloadPhoto'])->name('order.download');
    Route::get('/display/{id_order}',[OrderController::class,'displayImage'])->name('display.image');

});
