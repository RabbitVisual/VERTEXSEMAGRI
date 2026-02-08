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

// Webhook PIX (sem autenticação, mas com validação de assinatura)
Route::post('/api/webhook/pix', [WebhookPixController::class, 'webhook'])->name('webhook.pix');
