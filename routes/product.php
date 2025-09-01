<?php

use App\Http\Controllers\Admin\ProductTypeController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'products/',
        'as'     => 'products.',
    ],
    function () {

        Route::get('types', [ProductTypeController::class, 'index'])->name('types.index');
        Route::get('types/create', [ProductTypeController::class, 'create'])->name('types.create');
        Route::post('types/store', [ProductTypeController::class, 'store'])->name('types.store');
        Route::get('types/edit/{id}', [ProductTypeController::class, 'edit'])->name('types.edit');
        Route::put('types/update/{id}', [ProductTypeController::class, 'update'])->name('types.update');

    }
);
