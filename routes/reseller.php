<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AgenceController;
use App\Http\Controllers\Admin\BanksController;
use App\Http\Controllers\Admin\CmsCategoryController;
use App\Http\Controllers\Admin\CmsPagesController;
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\EpargneController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PretController;
use App\Http\Controllers\Admin\ServiceController;
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

Route::prefix('reseller')->middleware(['auth', 'reseller'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Reseller\ResellerController::class, 'dashboard'])->name('reseller.dashboard');

    Route::prefix('withdraw')->group(function () {
        Route::post('/', [\App\Http\Controllers\Reseller\ResellerController::class, 'postWithdraw'])->name('reseller.post-withdraw');
        Route::get('/{id}', [\App\Http\Controllers\Reseller\ResellerController::class, 'getWithdraw'])->name('reseller.get-withdraw');
        Route::post('/{id}/valid', [\App\Http\Controllers\Reseller\ResellerController::class, 'validWithdraw'])->name('reseller.valid-withdraw');
    });
});
