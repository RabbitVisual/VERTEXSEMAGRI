<?php

use Illuminate\Support\Facades\Route;
use Modules\Pocos\App\Http\Controllers\MoradorPocoController;

Route::middleware(['web'])->group(function () {
    // Portal do Morador (Acesso Público com Código)
    Route::prefix('morador-poco')->name('morador-poco.')->group(function () {
        Route::get('/', [MoradorPocoController::class, 'index'])->name('index');
        Route::post('/autenticar', [MoradorPocoController::class, 'autenticar'])->name('autenticar');

        // Rotas do painel (proteção de sessão via Controller)
        Route::get('/dashboard', [MoradorPocoController::class, 'dashboard'])->name('dashboard');
        Route::get('/historico', [MoradorPocoController::class, 'historico'])->name('historico');
        Route::post('/logout', [MoradorPocoController::class, 'logout'])->name('logout');

        // Faturas
        Route::prefix('fatura/{id}')->name('fatura.')->group(function () {
            Route::get('/', [MoradorPocoController::class, 'faturaShow'])->name('show');
            Route::get('/segunda-via', [MoradorPocoController::class, 'segundaVia'])->name('segunda-via');
            Route::get('/view', [MoradorPocoController::class, 'boletoView'])->name('view');
            Route::get('/comprovante', [MoradorPocoController::class, 'comprovante'])->name('comprovante');
        });

        // Solicitações
        Route::post('/solicitacao-baixa', [MoradorPocoController::class, 'solicitacoesBaixaStore'])->name('solicitacao-baixa.store');
    });
});
