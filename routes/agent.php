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
        Route::put('{customer}', [\App\Http\Controllers\Agent\CustomerController::class, 'update'])->name('agent.customer.update');
        Route::put('{customer}/updateStatus', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'updateStatus'])->name('agent.customer.updateStatus');
        Route::put('{customer}/updateTypeAccount', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'updateTypeAccount'])->name('agent.customer.updateTypeAccount');
        Route::put('{customer}/reinitPass', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'reinitPass'])->name('agent.customer.reinitPass');
        Route::put('{customer}/reinitCode', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'reinitCode'])->name('agent.customer.reinitCode');
        Route::put('{customer}/reinitAuth', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'reinitAuth'])->name('agent.customer.reinitAuth');
        Route::post('{customer}/writeSms', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'writeSms'])->name('agent.customer.writeSms');
        Route::post('{customer}/writeMail', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'writeMail'])->name('agent.customer.writeMail');

        Route::prefix('{customer}/verify')->group(function () {
            Route::get('/', [\App\Http\Controllers\Agent\VerifyController::class, 'go'])->name('agent.customer.verify.start');
        });

        Route::prefix('{customer}/wallets')->group(function () {
            Route::post('/', [\App\Http\Controllers\Agent\CustomerWalletController::class, 'store'])->name('agent.customer.wallet.store');
            Route::post('decouvert', [\App\Http\Controllers\Agent\CustomerWalletController::class, 'decouvert'])->name('agent.customer.wallet.decouvert');
            Route::get('{wallet_id}', [\App\Http\Controllers\Agent\CustomerWalletController::class, 'show'])->name('agent.customer.wallet.show');

            Route::prefix('{wallet_id}/transactions')->group(function () {
                Route::put('{id}/confirm', [\App\Http\Controllers\Agent\CustomerTransactionController::class, 'confirm'])->name('customer.wallet.transaction.confirm');
            });
        });
    });
});

