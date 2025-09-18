<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'users/',
        'as'     => 'users.',
        'middleware' => ['auth'],
    ],
    function () {

        Route::get('index', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create')->middleware('isAdmin');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit')->middleware('isAdmin');
        Route::put('update/{id}', [UserController::class, 'update'])->name('update');
    }
);
