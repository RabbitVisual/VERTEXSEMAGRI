<?php

use Illuminate\Support\Facades\Route;
use Modules\Demandas\App\Http\Controllers\DemandasController;
use Modules\Demandas\App\Http\Controllers\PublicDemandaController;

// Rotas públicas (sem autenticação)
Route::middleware(['module.enabled:Demandas'])->prefix('consulta-demanda')->name('demandas.public.')->group(function () {
    Route::get('/', [PublicDemandaController::class, 'index'])->name('consulta');
    Route::post('/consultar', [PublicDemandaController::class, 'consultar'])->name('consultar');
    Route::get('/status/{codigo}', [PublicDemandaController::class, 'status'])->name('status');
    Route::get('/{codigo}', [PublicDemandaController::class, 'show'])->name('show');
});

// Rotas protegidas (com autenticação)
Route::middleware(['auth', 'module.enabled:Demandas'])->group(function () {
    // Rotas específicas devem vir ANTES da rota resource para evitar conflitos
    Route::get('/demandas/buscar-pessoa', [DemandasController::class, 'buscarPessoa'])->name('demandas.buscar-pessoa');
    Route::get('/demandas/pessoa/{id}', [DemandasController::class, 'obterPessoa'])->name('demandas.obter-pessoa');
    Route::get('/demandas/{id}/print', [DemandasController::class, 'print'])->name('demandas.print');
    Route::get('/demandas/relatorio/abertas/pdf', [DemandasController::class, 'relatorioAbertasPdf'])->name('demandas.relatorio.abertas.pdf');
    Route::post('/demandas/{demanda}/reenviar-email', [DemandasController::class, 'reenviarEmail'])->name('demandas.reenviar-email');

    // Rotas para sistema de detecção de duplicatas e interessados
    Route::post('/demandas/verificar-similares', [DemandasController::class, 'verificarSimilares'])->name('demandas.verificar-similares');
    Route::get('/demandas/{id}/interessados', [DemandasController::class, 'interessados'])->name('demandas.interessados');
    Route::delete('/demandas/{demandaId}/interessados/{interessadoId}', [DemandasController::class, 'removerInteressado'])->name('demandas.remover-interessado');

    // Rota resource deve vir por último
    Route::resource('demandas', DemandasController::class)->names('demandas');
});

