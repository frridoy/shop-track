<?php

use App\Http\Controllers\Admin\LookupController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'lookup/',
        'as'     => 'lookup.',
        'middleware' => ['auth'],
    ],
    function () {

        Route::get('index', [LookupController::class, 'index'])->name('index');
        Route::get('create', [LookupController::class, 'create'])->name('create');
        Route::post('store', [LookupController::class, 'store'])->name('store');
        Route::get('edit/{id}', [LookupController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [LookupController::class, 'update'])->name('update');
    }
);
