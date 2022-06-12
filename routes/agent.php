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


            Route::prefix('{wallet_id}')->group(function () {
                Route::get('/', [\App\Http\Controllers\Agent\CustomerWalletController::class, 'show'])->name('agent.customer.wallet.show');
                Route::get('/rib', [\App\Http\Controllers\PdfController::class, 'showRib'])->name('agent.customer.wallet.showRib');
                Route::get('/report', [\App\Http\Controllers\Agent\CustomerWalletController::class, 'report'])->name('agent.customer.wallet.report');
                Route::post('/decouvert', [\App\Http\Controllers\Agent\CustomerWalletController::class, 'requestDecouvert'])->name('agent.customer.wallet.requestDecouvert');
                Route::put('/', [\App\Http\Controllers\Agent\CustomerWalletController::class, 'update'])->name('agent.customer.wallet.update');

                Route::prefix('/transactions')->group(function () {
                    Route::post('/', [\App\Http\Controllers\Agent\CustomerTransactionController::class, 'store'])->name('customer.wallet.transaction.store');
                    Route::put('{id}/confirm', [\App\Http\Controllers\Agent\CustomerTransactionController::class, 'confirm'])->name('customer.wallet.transaction.confirm');
                });

                Route::prefix('/virement')->group(function () {
                    Route::post('/', [\App\Http\Controllers\Agent\CustomerVirementController::class, 'store'])->name('customer.wallet.virement.store');
                    Route::put('{transfer_id}/accept', [\App\Http\Controllers\Agent\CustomerVirementController::class, 'accept'])->name('customer.wallet.virement.accept');
                    Route::put('{transfer_id}/reject', [\App\Http\Controllers\Agent\CustomerVirementController::class, 'reject'])->name('customer.wallet.virement.reject');
                });

                Route::prefix('beneficiaire')->group(function () {
                    Route::post('/', [\App\Http\Controllers\Agent\CustomerBeneficiaireController::class, 'store'])->name('agent.customer.wallet.beneficiaire.store');
                    Route::put('{id}', [\App\Http\Controllers\Agent\CustomerBeneficiaireController::class, 'update'])->name('agent.customer.wallet.beneficiaire.update');
                    Route::delete('{id}', [\App\Http\Controllers\Agent\CustomerBeneficiaireController::class, 'delete'])->name('agent.customer.wallet.beneficiaire.delete');
                });

                Route::prefix('sepas')->group(function () {
                    Route::get('{id}', [\App\Http\Controllers\Agent\CustomerSepaController::class, 'show'])->name('agent.customer.wallet.sepas.show');
                    Route::put('{id}/refund', [\App\Http\Controllers\Agent\CustomerSepaController::class, 'refund_request'])->name('agent.customer.wallet.sepas.refund');
                    Route::put('{id}/accept', [\App\Http\Controllers\Agent\CustomerSepaController::class, 'accept'])->name('agent.customer.wallet.sepas.accept');
                    Route::put('{id}/reject', [\App\Http\Controllers\Agent\CustomerSepaController::class, 'reject'])->name('agent.customer.wallet.sepas.reject');
                    Route::put('{id}/opposit', [\App\Http\Controllers\Agent\CustomerSepaController::class, 'opposit'])->name('agent.customer.wallet.sepas.opposit');
                });

                Route::prefix('check')->group(function () {
                    Route::post('/', [\App\Http\Controllers\Agent\CustomerCheckController::class, 'store'])->name('agent.customer.wallet.check.store');
                    Route::get('{id}', [\App\Http\Controllers\Agent\CustomerCheckController::class, 'info'])->name('agent.customer.wallet.check.info');
                    Route::put('{id}', [\App\Http\Controllers\Agent\CustomerCheckController::class, 'update'])->name('agent.customer.wallet.check.update');
                    Route::delete('{id}', [\App\Http\Controllers\Agent\CustomerCheckController::class, 'destroy'])->name('agent.customer.wallet.check.destroy');
                });

                Route::prefix('loan')->group(function () {
                    Route::get('{loan_id}/check', [\App\Http\Controllers\Agent\CustomerLoanController::class, 'check'])->name('agent.customer.wallet.loan.check');
                    Route::put('{loan_id}/status', [\App\Http\Controllers\Agent\CustomerLoanController::class, 'status'])->name('agent.customer.wallet.loan.status');
                });
            });
        });
    });
});

