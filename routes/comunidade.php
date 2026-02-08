<?php

use Illuminate\Support\Facades\Route;
use Modules\Pocos\App\Http\Controllers\LiderComunidadeController;
use Modules\Pocos\App\Http\Controllers\MoradorPocoController;

/*
|--------------------------------------------------------------------------
| Rotas do Módulo de Gestão de Poços - Líderes de Comunidade
|--------------------------------------------------------------------------
*/

// Rotas do Líder de Comunidade (autenticado)
Route::prefix('lider-comunidade')->name('lider-comunidade.')->middleware(['auth', 'role:lider-comunidade'])->group(function () {

    // Dashboard
    Route::get('/', [LiderComunidadeController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [LiderComunidadeController::class, 'dashboard'])->name('dashboard.index');

    // Usuários do Poço
    Route::get('/usuarios', [LiderComunidadeController::class, 'usuariosIndex'])->name('usuarios.index');
    Route::get('/usuarios/create', [LiderComunidadeController::class, 'usuariosCreate'])->name('usuarios.create');
    Route::post('/usuarios', [LiderComunidadeController::class, 'usuariosStore'])->name('usuarios.store');
    Route::get('/usuarios/{id}', [LiderComunidadeController::class, 'usuariosShow'])->name('usuarios.show');
    Route::get('/usuarios/{id}/edit', [LiderComunidadeController::class, 'usuariosEdit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [LiderComunidadeController::class, 'usuariosUpdate'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [LiderComunidadeController::class, 'usuariosDestroy'])->name('usuarios.destroy');

    // Busca de pessoas do CadÚnico (AJAX)
    Route::get('/usuarios/pessoas/buscar', [LiderComunidadeController::class, 'buscarPessoas'])->name('usuarios.pessoas.buscar');
    Route::get('/usuarios/pessoa/{id}', [LiderComunidadeController::class, 'obterPessoa'])->name('usuarios.pessoa');

    // Mensalidades
    Route::get('/mensalidades', [LiderComunidadeController::class, 'mensalidadesIndex'])->name('mensalidades.index');
    Route::get('/mensalidades/create', [LiderComunidadeController::class, 'mensalidadesCreate'])->name('mensalidades.create');
    Route::post('/mensalidades', [LiderComunidadeController::class, 'mensalidadesStore'])->name('mensalidades.store');
    Route::get('/mensalidades/{id}', [LiderComunidadeController::class, 'mensalidadesShow'])->name('mensalidades.show');
    Route::put('/mensalidades/{id}/recebimento', [LiderComunidadeController::class, 'mensalidadesUpdateRecebimento'])->name('mensalidades.update-recebimento');
    Route::put('/mensalidades/{id}/fechar', [LiderComunidadeController::class, 'mensalidadesFechar'])->name('mensalidades.fechar');

    // Pagamentos
    Route::post('/pagamentos', [LiderComunidadeController::class, 'pagamentosStore'])->name('pagamentos.store');
    Route::put('/pagamentos/{id}', [LiderComunidadeController::class, 'pagamentosUpdate'])->name('pagamentos.update');
    Route::delete('/pagamentos/{id}', [LiderComunidadeController::class, 'pagamentosDestroy'])->name('pagamentos.destroy');

    // Solicitações de Baixa
    Route::get('/solicitacoes-baixa', [LiderComunidadeController::class, 'solicitacoesBaixaIndex'])->name('solicitacoes-baixa.index');
    Route::get('/solicitacoes-baixa/{id}', [LiderComunidadeController::class, 'solicitacoesBaixaShow'])->name('solicitacoes-baixa.show');
    Route::post('/solicitacoes-baixa/{id}/aprovar', [LiderComunidadeController::class, 'solicitacoesBaixaAprovar'])->name('solicitacoes-baixa.aprovar');
    Route::post('/solicitacoes-baixa/{id}/rejeitar', [LiderComunidadeController::class, 'solicitacoesBaixaRejeitar'])->name('solicitacoes-baixa.rejeitar');

    // Relatórios
    Route::get('/relatorios', [LiderComunidadeController::class, 'relatorios'])->name('relatorios.index');
    Route::get('/relatorios/export', [LiderComunidadeController::class, 'relatoriosExport'])->name('relatorios.export');

    // PIX
    Route::get('/pix', [\Modules\Pocos\App\Http\Controllers\LiderComunidade\PixController::class, 'edit'])->name('pix.edit');
    Route::put('/pix', [\Modules\Pocos\App\Http\Controllers\LiderComunidade\PixController::class, 'update'])->name('pix.update');
    Route::post('/pix/desativar', [\Modules\Pocos\App\Http\Controllers\LiderComunidade\PixController::class, 'desativar'])->name('pix.desativar');

    // Pagamentos PIX
    Route::prefix('mensalidades/{mensalidade}')->name('mensalidades.')->group(function () {
        Route::post('/gerar-qrcode-pix', [\Modules\Pocos\App\Http\Controllers\LiderComunidade\PagamentoPixController::class, 'gerarQrCode'])->name('gerar-qrcode-pix');
        Route::get('/pagamentos-pix', [\Modules\Pocos\App\Http\Controllers\LiderComunidade\PagamentoPixController::class, 'index'])->name('pagamentos-pix.index');
        Route::get('/pagamentos-pix/{pagamentoPix}/status', [\Modules\Pocos\App\Http\Controllers\LiderComunidade\PagamentoPixController::class, 'consultarStatus'])->name('pagamentos-pix.status');
    });
});

/*
|--------------------------------------------------------------------------
| Rotas Públicas - Área do Morador
|--------------------------------------------------------------------------
*/

Route::prefix('morador-poco')->name('morador-poco.')->group(function () {

    // Tela inicial (solicita código de acesso)
    Route::get('/', [MoradorPocoController::class, 'index'])->name('index');
    Route::post('/autenticar', [MoradorPocoController::class, 'autenticar'])->name('autenticar');

    // Área autenticada do morador
    Route::middleware([\App\Http\Middleware\EnsureMoradorPocoAuthenticated::class])->group(function () {
        Route::get('/dashboard', [MoradorPocoController::class, 'dashboard'])->name('dashboard');
        Route::get('/historico', [MoradorPocoController::class, 'historico'])->name('historico');
        Route::get('/fatura/{id}', [MoradorPocoController::class, 'faturaShow'])->name('fatura.show');
        Route::get('/fatura/{id}/segunda-via', [MoradorPocoController::class, 'segundaVia'])->name('fatura.segunda-via');
        Route::get('/fatura/{id}/comprovante', [MoradorPocoController::class, 'comprovante'])->name('fatura.comprovante');
        Route::get('/fatura/{id}/view', [MoradorPocoController::class, 'boletoView'])->name('fatura.view');
        Route::post('/solicitacoes-baixa', [MoradorPocoController::class, 'solicitacoesBaixaStore'])->name('solicitacoes-baixa.store');
        Route::post('/logout', [MoradorPocoController::class, 'logout'])->name('logout');
    });
});
