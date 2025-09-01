<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
return redirect()->route('admin.dashboard');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/branch.php';
require __DIR__ . '/product.php';
require __DIR__ . '/lookup.php';
