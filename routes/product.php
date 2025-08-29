<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'products/',
        'as'     => 'products.',
    ],
    function () {

        Route::get('index', [ProductController::class, 'index'])->name('index');
        Route::get('create', [ProductController::class, 'create'])->name('create');
        Route::post('store', [ProductController::class, 'store'])->name('store');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [ProductController::class, 'update'])->name('update');

    }
);
