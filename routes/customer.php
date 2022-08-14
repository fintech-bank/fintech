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

Route::prefix('customer')->middleware(['auth', 'customer'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Customer\CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('offline', [\App\Http\Controllers\Customer\CustomerController::class, 'offline'])->name('customer.offline');

    Route::prefix('profil')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\ProfilController::class, 'index'])->name('customer.profil.index');
        Route::get('/password', [\App\Http\Controllers\Customer\ProfilController::class, 'requestPassword'])->name('customer.profil.requestPassword');

        Route::put('/', [\App\Http\Controllers\Customer\ProfilController::class, 'update'])->name('customer.profil.update');
    });

    Route::prefix('wallets')->group(function () {
        Route::get('{wallet_id}', [\App\Http\Controllers\Customer\CustomerWalletController::class, 'index'])->name('customer.wallet.index');
        Route::post('{wallet_id}/refund', [\App\Http\Controllers\Customer\CustomerWalletController::class, 'refund'])->name('customer.wallet.refund');
        Route::get('{wallet_id}/refund/success', [\App\Http\Controllers\Customer\CustomerWalletController::class, 'refundSuccess'])->name('customer.wallet.refundSuccess');
        Route::get('{wallet_id}/refund/cancel', [\App\Http\Controllers\Customer\CustomerWalletController::class, 'refundCancel'])->name('customer.wallet.refundCancel');
    });

    Route::prefix('transfers')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\TransferController::class, 'index'])->name('customer.transfer.index');
        Route::post('/', [\App\Http\Controllers\Customer\TransferController::class, 'store'])->name('customer.transfer.store');
        Route::get('/history', [\App\Http\Controllers\Customer\TransferController::class, 'history'])->name('customer.transfer.history');

        Route::put('/{transfer_id}', [\App\Http\Controllers\Customer\TransferController::class, 'update'])->name('customer.transfer.update');
        Route::delete('/{transfer_id}', [\App\Http\Controllers\Customer\TransferController::class, 'delete'])->name('customer.transfer.delete');

        Route::get('/{transfer_id}/print', [\App\Http\Controllers\Customer\TransferController::class, 'print'])->name('customer.transfer.print');
    });

    Route::prefix('beneficiaire')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\BeneficiaireController::class, 'index'])->name('customer.beneficiaire.index');
        Route::post('/', [\App\Http\Controllers\Customer\BeneficiaireController::class, 'store'])->name('customer.beneficiaire.store');
        Route::put('{beneficiaire_id}', [\App\Http\Controllers\Customer\BeneficiaireController::class, 'update'])->name('customer.beneficiaire.update');
        Route::delete('{beneficiaire_id}', [\App\Http\Controllers\Customer\BeneficiaireController::class, 'delete'])->name('customer.beneficiaire.delete');
    });

    Route::prefix('payment')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\PaymentController::class, 'index'])->name('customer.payment.index');
        Route::post('/', [\App\Http\Controllers\Customer\PaymentController::class, 'store'])->name('customer.payment.store');
        Route::get('{card_id}', [\App\Http\Controllers\Customer\PaymentController::class, 'show'])->name('customer.payment.show');
        Route::put('{card_id}', [\App\Http\Controllers\Customer\PaymentController::class, 'update'])->name('customer.payment.update');
    });

    Route::prefix('documents')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\DocumentController::class, 'index'])->name('customer.document.index');
    });

    Route::prefix('subscribe')->group(function () {
        Route::get('/', [\App\Http\Controllers\Customer\SubscriptionController::class, 'index'])->name('customer.subscription.index');
        Route::prefix('account')->group(function () {
            Route::put('/update', [\App\Http\Controllers\Customer\SubscriptionController::class, 'updateAccount'])->name('customer.subscription.update-account');
            Route::put('/mobility', [\App\Http\Controllers\Customer\SubscriptionController::class, 'mobility'])->name('customer.subscription.mobility');
            Route::put('/mobility/signate', [\App\Http\Controllers\Customer\SubscriptionController::class, 'mobilitySignate'])->name('customer.subscription.mobilitySignate');
        });
        Route::prefix('loan')->group(function (){
            Route::post('personnal', [\App\Http\Controllers\Customer\SubscriptionController::class, 'personnal'])->name('customer.subscription.personnal');
            Route::post('estate', [\App\Http\Controllers\Customer\SubscriptionController::class, 'estate'])->name('customer.subscription.estate');
            Route::post('facelia', [\App\Http\Controllers\Customer\SubscriptionController::class, 'facelia'])->name('customer.subscription.facelia');
        });
        Route::prefix('saving')->group(function (){
            Route::post('passbook', [\App\Http\Controllers\Customer\SubscriptionController::class, 'passbook'])->name('customer.subscription.passbook');
        });
        Route::get('mobility/{mobility_id}/document', [\App\Http\Controllers\Customer\MobilityController::class, 'showDocument'])->name('customer.subscription.mobility.document');
        Route::post('mobility/{mobility_id}/document/signate', [\App\Http\Controllers\Customer\MobilityController::class, 'signateDocument'])->name('customer.subscription.mobility.document.signate');
    });
});
