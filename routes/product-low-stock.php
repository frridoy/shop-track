<?php

use App\Http\Controllers\Admin\ProductLowStockController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'product-low-stock/',
        'as'     => 'product-low-stock.',
        'middleware' => ['auth'],
    ],
    function () {

        Route::get('index', [ProductLowStockController::class, 'lowStock'])->name('lowStock');
    }
);
