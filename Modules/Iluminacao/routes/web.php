<?php

use Illuminate\Support\Facades\Route;
use Modules\Iluminacao\App\Http\Controllers\IluminacaoController;
use Modules\Iluminacao\App\Http\Controllers\Admin\PostesAdminController;

Route::middleware(['auth', 'module.enabled:Iluminacao'])->group(function () {
    Route::resource('iluminacao', IluminacaoController::class)->names('iluminacao');
    
    // Admin Routes
    Route::prefix('admin/iluminacao')->name('admin.iluminacao.')->group(function() {
        Route::get('postes/export', [PostesAdminController::class, 'export'])->name('postes.export');
        Route::resource('postes', PostesAdminController::class);
    });
});
