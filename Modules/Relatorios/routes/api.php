<?php

use Illuminate\Support\Facades\Route;
use Modules\Relatorios\App\Http\Controllers\RelatoriosController;

Route::middleware(['auth'])->prefix('relatorios/api')->name('api.relatorios.')->group(function () {
    // Endpoints de dados JSON para gráficos
    Route::get('/demandas', [RelatoriosController::class, 'apiDemandas'])->name('demandas');
    Route::get('/ordens', [RelatoriosController::class, 'apiOrdens'])->name('ordens');
    Route::get('/materiais', [RelatoriosController::class, 'apiMateriais'])->name('materiais');
});
