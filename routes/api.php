<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/geo/countries', function () {
    $result = \App\Helper\GeoHelper::getAllCountries();
    $json = [];
    foreach ($result as $item) {
        $json[] = [
            'id' => $item->iso,
            'name' => $item->name
        ];
    }

    return response()->json($json);
});

Route::post('/geo/cities', [\App\Http\Controllers\Api\GeoController::class, 'cities']);
Route::get('/geo/cities/{postal}', [\App\Http\Controllers\Api\GeoController::class, 'citiesByPostal']);

Route::get('stats', [\App\Http\Controllers\Api\Agent\StatController::class, 'stat']);

Route::prefix('customer')->group(function () {
    Route::post('/', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'info']);
    Route::post('verifSecure/{code}', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'verifSecure']);
    Route::get('{customer_id}/verifAllSolde', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'verifAllSolde']);
    Route::get('{customer_id}/verifUser', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'verifUser']);
});

Route::prefix('wallet')->group(function () {
    Route::get('{id}/chartSummary', [\App\Http\Controllers\Api\Agent\CustomerWalletController::class, 'chartSummary']);
    Route::get('{id}', [\App\Http\Controllers\Api\Agent\CustomerWalletController::class, 'info']);
    Route::get('{id}/rib', [\App\Http\Controllers\Api\Agent\CustomerWalletController::class, 'rib']);
    Route::post('{id}/exportAccount', [\App\Http\Controllers\Api\Agent\CustomerWalletController::class, 'export']);
});

Route::prefix('transaction')->group(function () {
    Route::get('{id}', [\App\Http\Controllers\Api\Agent\TransactionController::class, 'info']);
    Route::delete('{id}', [\App\Http\Controllers\Api\Agent\TransactionController::class, 'delete']);
});

Route::prefix('transfer')->group(function () {
    Route::get('{id}', [\App\Http\Controllers\Api\Agent\TransferController::class, 'info']);
});

Route::prefix('beneficiaire')->group(function () {
    Route::post('/search', [\App\Http\Controllers\Api\Agent\BeneficiaireController::class, 'search']);
    Route::get('{beneficiaire_id}', [\App\Http\Controllers\Api\Agent\BeneficiaireController::class, 'info']);
});

Route::prefix('bank')->group(function () {
    Route::get('{bank_id}', [\App\Http\Controllers\Api\Agent\BankController::class, 'info']);
});

Route::prefix('epargne')->group(function () {
    Route::get('{plan_id}', [\App\Http\Controllers\Api\Agent\EpargneController::class, 'info']);
});

Route::prefix('pret')->group(function () {
    Route::post('simulate', [\App\Http\Controllers\Api\Agent\PretController::class, 'simulate']);
    Route::get('{plan_id}', [\App\Http\Controllers\Api\Agent\PretController::class, 'info']);
});


Route::get('beneficiaire/{id}', [\App\Http\Controllers\Api\Agent\CustomerWalletController::class, 'getBeneficiaire']);
