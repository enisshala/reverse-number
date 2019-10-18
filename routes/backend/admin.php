<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RequestController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('cancellation-requests', [RequestController::class, 'requests'])->name('cancellation-requests');
Route::post('approve-request', [RequestController::class, 'approveRequest'])->name('approve-request');
