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

Route::get('/customer/{customer_id}/verifAllSolde', [\App\Http\Controllers\Api\Agent\CustomerController::class, 'verifAllSolde']);
