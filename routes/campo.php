<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\Funcionario\CampoDashboardController;
use App\Http\Controllers\Funcionario\CampoProfileController;
use App\Http\Controllers\Funcionario\CampoChatController;
use App\Http\Controllers\Funcionario\CampoRelatorioController;
use Modules\Ordens\App\Http\Controllers\Campo\CampoOrdensController;
use Modules\Materiais\App\Http\Controllers\Campo\SolicitarMaterialCampoController;

/*
|--------------------------------------------------------------------------
| Campo (Field Worker) Explicit Routes
|--------------------------------------------------------------------------
|
| Rotas destinadas ao aplicativo mobile/PWA dos técnicos de campo.
| Foco em operações atômicas (iniciar, pausar, concluir) e upload de evidências.
|
*/

Route::prefix('campo')->name('campo.')->middleware(['auth', 'role:campo', \App\Http\Middleware\EnsureUserIsFuncionario::class])->group(function() {

    // ============================================
    // CORE SYSTEM (Dashboard & Perfil)
    // ============================================

    // Dashboard e Estatísticas
    Route::get('/', [CampoDashboardController::class, 'index'])->name('dashboard'); // Alias para root
    Route::get('/dashboard', [CampoDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/filtros', [CampoDashboardController::class, 'filtros'])->name('dashboard.filtros');
    Route::get('/dashboard/estatisticas', [CampoDashboardController::class, 'estatisticas'])->name('dashboard.estatisticas');

    // Perfil do Técnico
    Route::get('/profile', [CampoProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [CampoProfileController::class, 'update'])->name('profile.update');

    // Relatórios Gerais e Exportação
    Route::prefix('relatorios')->name('relatorios.')->group(function() {
        Route::get('/pdf', [CampoRelatorioController::class, 'pdf'])->name('pdf');
        Route::get('/excel', [CampoRelatorioController::class, 'excel'])->name('excel');
    });

    // ============================================
    // MÓDULO ORDENS DE SERVIÇO (Core Operation)
    // ============================================
    if (Module::isEnabled('Ordens')) {
        Route::prefix('ordens')->name('ordens.')->group(function () {
            // Leitura
            Route::get('/', [CampoOrdensController::class, 'index'])->name('index');
            Route::get('/{id}', [CampoOrdensController::class, 'show'])->name('show');

            // Fluxo de Execução (Máquina de Estados)
            Route::post('/{id}/iniciar', [CampoOrdensController::class, 'iniciar'])->name('iniciar');
            Route::post('/{id}/concluir', [CampoOrdensController::class, 'concluir'])->name('concluir');
            Route::post('/{id}/relatorio', [CampoOrdensController::class, 'atualizarRelatorio'])->name('relatorio');

            // Gestão de Evidências (Fotos)
            Route::post('/{id}/fotos', [CampoOrdensController::class, 'uploadFotos'])->name('fotos');
            Route::delete('/{id}/fotos', [CampoOrdensController::class, 'removerFoto'])->name('fotos.remover');

            // Gestão de Materiais na Ordem (Consumo)
            Route::post('/{id}/materiais', [CampoOrdensController::class, 'adicionarMaterial'])->name('materiais');
            Route::delete('/{id}/materiais/{materialId}', [CampoOrdensController::class, 'removerMaterial'])->name('materiais.remover');
            Route::post('/{id}/sem-material', [CampoOrdensController::class, 'semMaterial'])->name('sem-material');
        });
    }

    // ============================================
    // MÓDULO MATERIAIS (Solicitações ao Almoxarifado)
    // ============================================
    if (Module::isEnabled('Materiais')) {
        Route::prefix('materiais')->name('materiais.')->group(function () {
            Route::get('/solicitacoes', [SolicitarMaterialCampoController::class, 'index'])->name('solicitacoes.index');
            Route::post('/solicitar', [SolicitarMaterialCampoController::class, 'store'])->name('solicitar.store');
        });
    }

    // ============================================
    // MÓDULO CHAT (Comunicação Interna)
    // ============================================
    if (Module::isEnabled('Chat')) {
        Route::prefix('chat')->name('chat.')->group(function() {
            Route::get('/', [CampoChatController::class, 'index'])->name('index');
            Route::get('/page', function() { return view('campo.chat.index'); })->name('page');

            // Ações de Chat
            Route::post('/', [CampoChatController::class, 'store'])->name('store');
            Route::get('/users', [CampoChatController::class, 'getAvailableUsers'])->name('users');

            // Sessão e Mensagens
            Route::get('/session/{sessionId}/messages', [CampoChatController::class, 'getMessages'])->name('messages');
            Route::post('/session/{sessionId}/message', [CampoChatController::class, 'sendMessage'])->name('send');
        });
    }
});
