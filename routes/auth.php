<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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

Route::get('/logout', function () {
    auth()->guard()->logout();

    session()->invalidate();

    session()->regenerateToken();

    return redirect()->route('home');
});

Route::prefix('register')->group(function () {
    Route::get('/cart', [\App\Http\Controllers\Auth\RegisterController::class, 'cart'])->name('register.cart');
    Route::get('/card', [\App\Http\Controllers\Auth\RegisterController::class, 'card'])->name('register.card');
    Route::get('/personnal/home', [\App\Http\Controllers\Auth\RegisterController::class, 'persoHome'])->name('register.perso-home');
    Route::get('/personnal/pro', [\App\Http\Controllers\Auth\RegisterController::class, 'persoPro'])->name('register.perso-pro');
    Route::get('/personnal/final', [\App\Http\Controllers\Auth\RegisterController::class, 'persoFinal'])->name('register.perso-final');
    Route::get('/signate/init', [\App\Http\Controllers\Auth\RegisterController::class, 'signateInit'])->name('register.signate-init');
    Route::get('/signate/sign', [\App\Http\Controllers\Auth\RegisterController::class, 'signateSign'])->name('register.signate-sign');
    Route::post('/signate/sign', [\App\Http\Controllers\Auth\RegisterController::class, 'signate'])->name('register.signate');
    Route::get('/identity/init', [\App\Http\Controllers\Auth\RegisterController::class, 'identityInit'])->name('register.identity-init');
    Route::get('/terminate', [\App\Http\Controllers\Auth\RegisterController::class, 'terminate'])->name('register.terminate')->middleware(['auth', 'customer']);
});
