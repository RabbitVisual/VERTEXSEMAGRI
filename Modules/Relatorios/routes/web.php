<?php

use Illuminate\Support\Facades\Route;
use Modules\Relatorios\App\Http\Controllers\RelatoriosController;

Route::middleware(['auth', 'module.enabled:Relatorios'])->prefix('relatorios')->name('relatorios.')->group(function () {
    // Dashboard principal
    Route::get('/', [RelatoriosController::class, 'index'])->name('index');

    // Relatórios específicos
    Route::get('/pessoas', [RelatoriosController::class, 'relatorioPessoas'])->name('pessoas');
    Route::get('/localidades', [RelatoriosController::class, 'relatorioLocalidades'])->name('localidades');
    Route::get('/demandas', [RelatoriosController::class, 'relatorioDemandas'])->name('demandas');
    Route::get('/ordens', [RelatoriosController::class, 'relatorioOrdens'])->name('ordens');
    Route::get('/materiais', [RelatoriosController::class, 'relatorioMateriais'])->name('materiais');
    Route::get('/infraestrutura', [RelatoriosController::class, 'relatorioInfraestrutura'])->name('infraestrutura');
    Route::get('/equipes', [RelatoriosController::class, 'relatorioEquipes'])->name('equipes');
    Route::get('/geral', [RelatoriosController::class, 'relatorioGeral'])->name('geral');

    // Novos relatórios
    Route::get('/notificacoes', [RelatoriosController::class, 'relatorioNotificacoes'])->name('notificacoes');
    Route::get('/auditoria', [RelatoriosController::class, 'relatorioAuditoria'])->name('auditoria');
    Route::get('/solicitacoes-materiais', [RelatoriosController::class, 'relatorioSolicitacoesMateriais'])->name('solicitacoes_materiais');
    Route::get('/movimentacoes-materiais', [RelatoriosController::class, 'relatorioMovimentacoesMateriais'])->name('movimentacoes_materiais');
    Route::get('/usuarios', [RelatoriosController::class, 'relatorioUsuarios'])->name('usuarios');

    // Análises
    Route::get('/analise/temporal', [RelatoriosController::class, 'analiseTemporal'])->name('analise.temporal');
    Route::get('/analise/geografica', [RelatoriosController::class, 'analiseGeografica'])->name('analise.geografica');
    Route::get('/analise/performance', [RelatoriosController::class, 'analisePerformance'])->name('analise.performance');
    Route::get('/analise/tendencias', [RelatoriosController::class, 'analiseTendencias'])->name('analise.tendencias');
});
