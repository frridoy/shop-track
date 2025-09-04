<?php

use App\Http\Controllers\Admin\CustomerContoller;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'customers/',
        'as'     => 'customers.',
        'middleware' => ['auth'],
    ],
    function () {

        Route::get('index', [CustomerContoller::class, 'index'])->name('index');
        Route::get('create', [CustomerContoller::class, 'create'])->name('create');
        Route::post('store', [CustomerContoller::class, 'store'])->name('store');
        Route::get('edit/{id}', [CustomerContoller::class, 'edit'])->name('edit');
        Route::put('update/{id}', [CustomerContoller::class, 'update'])->name('update');
    }
);
