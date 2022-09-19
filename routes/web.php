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

include 'auth.php';
include 'front.php';
include 'admin.php';
include 'agent.php';
include 'customer.php';
include 'reseller.php';

Route::get('/redirect', [\App\Http\Controllers\Front\HomeController::class, 'redirect']);
Route::get('/test', [\App\Http\Controllers\TestController::class, 'test']);
Route::get('/home', [\App\Http\Controllers\TestController::class, 'home']);
Route::post('/push', [\App\Http\Controllers\TestController::class, 'pushStore']);
Route::post('webhooks/stripe', [\App\Http\Controllers\StripeWebhookController::class, 'handleWebhook']);

