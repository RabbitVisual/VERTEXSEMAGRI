<?php

use Illuminate\Support\Facades\Route;
use Modules\Pocos\App\Http\Controllers\PocosController;
use Modules\Pocos\App\Http\Controllers\LiderComunidade\PixController;
use Modules\Pocos\App\Http\Controllers\LiderComunidade\PagamentoPixController;
use Modules\Pocos\App\Http\Controllers\WebhookPixController;

Route::middleware(['auth', 'module.enabled:Pocos'])->group(function () {
    Route::resource('pocos', PocosController::class)->names('pocos');
    Route::get('/pocos/{id}/print', [PocosController::class, 'print'])->name('pocos.print');
    Route::post('/pocos/{id}/reportar-problema', [PocosController::class, 'reportarProblema'])->name('pocos.reportar-problema');

    // Rotas PIX para líder comunitário
    Route::prefix('lider-comunidade')->name('lider-comunidade.')->middleware(['auth'])->group(function () {
        Route::get('/pix', [PixController::class, 'edit'])->name('pix.edit');
        Route::put('/pix', [PixController::class, 'update'])->name('pix.update');
        Route::post('/pix/desativar', [PixController::class, 'desativar'])->name('pix.desativar');

        Route::prefix('mensalidades/{mensalidade}')->name('mensalidades.')->group(function () {
            Route::post('/gerar-qrcode-pix', [PagamentoPixController::class, 'gerarQrCode'])->name('gerar-qrcode-pix');
            Route::get('/pagamentos-pix', [PagamentoPixController::class, 'index'])->name('pagamentos-pix.index');
            Route::get('/pagamentos-pix/{pagamentoPix}/status', [PagamentoPixController::class, 'consultarStatus'])->name('pagamentos-pix.status');
        });
    });
});

// Rotas da Área do Morador (Acesso Público via Código)
Route::prefix('morador-poco')->name('morador-poco.')->group(function () {
    Route::get('/', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'index'])->name('index');
    Route::post('/autenticar', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'autenticar'])->name('autenticar');
    Route::get('/dashboard', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'dashboard'])->name('dashboard');
    Route::get('/historico', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'historico'])->name('historico');
    Route::get('/fatura/{id}', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'faturaShow'])->name('fatura.show');
    Route::get('/fatura/{id}/segunda-via', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'segundaVia'])->name('fatura.segunda-via');
    Route::get('/fatura/{id}/comprovante', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'comprovante'])->name('fatura.comprovante');
    Route::get('/fatura/{id}/view', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'boletoView'])->name('fatura.view');
    Route::post('/logout', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'logout'])->name('logout');
    Route::post('/solicitacao-baixa', [\Modules\Pocos\App\Http\Controllers\MoradorPocoController::class, 'solicitacoesBaixaStore'])->name('solicitacao-baixa.store');
});

// Webhook PIX (sem autenticação, mas com validação de assinatura)
Route::post('/api/webhook/pix', [WebhookPixController::class, 'webhook'])->name('webhook.pix');
