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
use App\Http\Controllers\Agent\AgentController;
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

Route::prefix('agence')->middleware(['auth', 'agent'])->group(function() {
    Route::get('/', [AgentController::class, 'dashboard'])->name('agent.dashboard');

    Route::prefix('customers')->group(function () {
        Route::get('/', [\App\Http\Controllers\Agent\CustomerController::class, 'index'])->name('agent.customer.index');
        Route::get('create', [\App\Http\Controllers\Agent\CustomerController::class, 'create'])->name('agent.customer.create');
        Route::post('create', [\App\Http\Controllers\Agent\CustomerController::class, 'store'])->name('agent.customer.store');
        Route::get('{customer}', [\App\Http\Controllers\Agent\CustomerController::class, 'show'])->name('agent.customer.show');
        Route::put('{customer}/updateStatus', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'updateStatus'])->name('agent.customer.updateStatus');
        Route::put('{customer}/updateTypeAccount', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'updateTypeAccount'])->name('agent.customer.updateTypeAccount');

        Route::prefix('{customer}/verify')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\VerifyController::class, 'go'])->name('agent.customer.verify.start');
        });
    });
});

