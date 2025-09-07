<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
return redirect()->route('login');
});


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/lookup.php';
require __DIR__ . '/branch.php';
require __DIR__ . '/user.php';
require __DIR__ . '/product.php';
require __DIR__ . '/customer.php';
require __DIR__ . '/order.php';
