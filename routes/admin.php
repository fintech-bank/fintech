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

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('agences', AgenceController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('banks', BanksController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('documents', DocumentCategoryController::class)->names([
        'index' => "document.category.index",
        'store' => "document.category.store",
        'show' => "document.category.show",
        'update' => "document.category.update",
        'destroy' => "document.category.destroy",
    ])->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::resource('epargnes', EpargneController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('prets', PretController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('packages', PackageController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('services', ServiceController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::prefix('cms')->group(function () {
        Route::resource('category', CmsCategoryController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::resource('pages', CmsPagesController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    });
});

