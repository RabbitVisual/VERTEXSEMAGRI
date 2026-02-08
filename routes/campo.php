<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Funcionario\CampoDashboardController;
use App\Http\Controllers\Funcionario\CampoProfileController;
use Modules\Ordens\App\Http\Controllers\Campo\CampoOrdensController;
use Modules\Materiais\App\Http\Controllers\Campo\SolicitarMaterialCampoController;

Route::prefix('campo')->name('campo.')->middleware(['auth', 'role:campo', \App\Http\Middleware\EnsureUserIsFuncionario::class, 'module.enabled:Ordens'])->group(function() {
    Route::get('/dashboard', [CampoDashboardController::class, 'index'])->name('dashboard');

    // Perfil
    Route::get('/profile', [CampoProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [CampoProfileController::class, 'update'])->name('profile.update');

    Route::resource('ordens', CampoOrdensController::class)->only(['index', 'show']);

    Route::post('/ordens/{id}/iniciar', [CampoOrdensController::class, 'iniciar'])->name('ordens.iniciar');
    Route::post('/ordens/{id}/fotos', [CampoOrdensController::class, 'uploadFotos'])->name('ordens.fotos');
    Route::delete('/ordens/{id}/fotos', [CampoOrdensController::class, 'removerFoto'])->name('ordens.fotos.remover');
    Route::post('/ordens/{id}/relatorio', [CampoOrdensController::class, 'atualizarRelatorio'])->name('ordens.relatorio');
    Route::post('/ordens/{id}/materiais', [CampoOrdensController::class, 'adicionarMaterial'])->name('ordens.materiais');
    Route::delete('/ordens/{id}/materiais/{materialId}', [CampoOrdensController::class, 'removerMaterial'])->name('ordens.materiais.remover');
    Route::post('/ordens/{id}/sem-material', [CampoOrdensController::class, 'semMaterial'])->name('ordens.sem-material');
    Route::post('/ordens/{id}/concluir', [CampoOrdensController::class, 'concluir'])->name('ordens.concluir');

    // Solicitações de Materiais
    Route::get('/materiais/solicitacoes', [SolicitarMaterialCampoController::class, 'index'])->name('materiais.solicitacoes.index');
    Route::post('/materiais/solicitar', [SolicitarMaterialCampoController::class, 'store'])->name('materiais.solicitar.store');

    // Chat Interno
    Route::prefix('chat')->name('chat.')->group(function() {
        Route::get('/', [\App\Http\Controllers\Funcionario\CampoChatController::class, 'index'])->name('index');
        Route::get('/page', function() { return view('campo.chat.index'); })->name('page');
        Route::post('/', [\App\Http\Controllers\Funcionario\CampoChatController::class, 'store'])->name('store');
        Route::get('/users', [\App\Http\Controllers\Funcionario\CampoChatController::class, 'getAvailableUsers'])->name('users');
        Route::get('/session/{sessionId}/messages', [\App\Http\Controllers\Funcionario\CampoChatController::class, 'getMessages'])->name('messages');
        Route::post('/session/{sessionId}/message', [\App\Http\Controllers\Funcionario\CampoChatController::class, 'sendMessage'])->name('send');
    });

    // Relatórios e Exportação
    Route::prefix('relatorios')->name('relatorios.')->group(function() {
        Route::get('/pdf', [\App\Http\Controllers\Funcionario\CampoRelatorioController::class, 'pdf'])->name('pdf');
        Route::get('/excel', [\App\Http\Controllers\Funcionario\CampoRelatorioController::class, 'excel'])->name('excel');
    });

    // Filtros e Estatísticas
    Route::get('/dashboard/filtros', [CampoDashboardController::class, 'filtros'])->name('dashboard.filtros');
    Route::get('/dashboard/estatisticas', [CampoDashboardController::class, 'estatisticas'])->name('dashboard.estatisticas');
});

