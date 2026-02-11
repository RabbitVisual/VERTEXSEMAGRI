<?php

use Illuminate\Support\Facades\Route;
use Modules\Agua\App\Http\Controllers\AguaController;

Route::middleware(['auth', 'module.enabled:Agua'])->group(function () {
    Route::resource('agua', AguaController::class)->names('agua');

    // Admin Dashboard Routes
    Route::prefix('admin/agua')->name('admin.agua.')->group(function () {
        Route::get('/', [Modules\Agua\App\Http\Controllers\Admin\AguaAdminController::class, 'index'])->name('index');
        Route::get('/{id}', [Modules\Agua\App\Http\Controllers\Admin\AguaAdminController::class, 'show'])->name('show');
    });
});
