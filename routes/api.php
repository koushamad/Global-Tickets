<?php

use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UserController;
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
Route::middleware('auth:sanctum')->name('api.')->group(function () {

    Route::get('/user', UserController::class)->name('user');

    Route::apiResource('short-links', ShortLinkController::class)
        ->names([
            'index' => 'short-links.index',
            'show' => 'short-links.show',
            'store' => 'short-links.store',
            'update' => 'short-links.update',
            'destroy' => 'short-links.destroy',
        ]);
});
