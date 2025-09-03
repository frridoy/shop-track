<?php

use App\Http\Controllers\Admin\BranchController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'branches/',
        'as'     => 'branches.',
        'middleware' => ['auth'],
    ],
    function () {

        Route::get('index', [BranchController::class, 'index'])->name('index');
        Route::get('create', [BranchController::class, 'create'])->name('create');
        Route::post('store', [BranchController::class, 'store'])->name('store');
        Route::get('edit/{id}', [BranchController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [BranchController::class, 'update'])->name('update');
    }
);
