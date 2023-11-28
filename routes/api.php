<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\GeoController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware(['auth:api'])->group(function () {
    Route::get('/run', ContentController::class)->name('run');
    Route::get('/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/addresses', [AddressController::class, 'index'])->name('address.index');
    Route::get('/companies', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/geo', [GeoController::class, 'index'])->name('geo.index');
});

Route::get('/login', ['as' => 'login']);
