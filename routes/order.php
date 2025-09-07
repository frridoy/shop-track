<?php

use App\Http\Controllers\Admin\CustomerContoller;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'orders/',
        'as'     => 'orders.',
        'middleware' => ['auth'],
    ],
    function () {

        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('create', [OrderController::class, 'create'])->name('create');
        Route::post('store',        [OrderController::class, 'store'])->name('store');
        Route::get('products/by-code/{code}', [OrderController::class, 'getProductByBarcode'])
            ->where('code', '.*')
            ->name('products.byCode');
    }
);
