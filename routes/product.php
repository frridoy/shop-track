<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductTypeController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'products/',
        'as'     => 'products.',
        'middleware' => ['auth'],
    ],
    function () {

        Route::get('types', [ProductTypeController::class, 'index'])->name('types.index');
        Route::get('types/create', [ProductTypeController::class, 'create'])->name('types.create');
        Route::post('types/store', [ProductTypeController::class, 'store'])->name('types.store');
        Route::get('types/edit/{id}', [ProductTypeController::class, 'edit'])->name('types.edit');
        Route::put('types/update/{id}', [ProductTypeController::class, 'update'])->name('types.update');

        Route::get('index', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [ProductController::class, 'update'])->name('update');
        Route::get('products/{product}/barcode', [ProductController::class, 'singleProductBarcode'])->name('barcode');

    }
);
