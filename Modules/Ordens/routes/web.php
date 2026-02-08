<?php

use Illuminate\Support\Facades\Route;
use Modules\Ordens\App\Http\Controllers\OrdensController;

Route::middleware(['auth', 'module.enabled:Ordens'])->group(function () {
    // Rotas específicas devem vir ANTES da rota resource para evitar conflitos
    Route::get('/ordens/{id}/print', [OrdensController::class, 'print'])->name('ordens.print');
    Route::post('/ordens/{id}/iniciar', [OrdensController::class, 'iniciar'])->name('ordens.iniciar');
    Route::post('/ordens/{id}/concluir', [OrdensController::class, 'concluir'])->name('ordens.concluir');
    Route::get('/ordens/relatorio/demandas-dia/pdf', [OrdensController::class, 'relatorioDemandasDiaPdf'])->name('ordens.relatorio.demandas-dia.pdf');
    
    // Rota resource deve vir por último
    Route::resource('ordens', OrdensController::class)->names('ordens');
});

