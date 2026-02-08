<?php

use Illuminate\Support\Facades\Route;
use Modules\CAF\App\Http\Controllers\CadastradorCAFController;
use Modules\CAF\App\Http\Controllers\AdminCAFController;

/*
|--------------------------------------------------------------------------
| Web Routes - Módulo CAF
|--------------------------------------------------------------------------
*/

// Rotas do Cadastrador CAF
Route::prefix('cadastrador/caf')->name('caf.cadastrador.')->middleware(['web', 'auth', 'module.enabled:CAF'])->group(function () {
    Route::get('/', [CadastradorCAFController::class, 'index'])->name('index');
    // Rotas de API para busca de pessoas (devem vir antes das rotas com parâmetros)
    Route::get('/buscar-pessoa', [CadastradorCAFController::class, 'buscarPessoa'])->name('buscar-pessoa');
    Route::get('/pessoa/{id}', [CadastradorCAFController::class, 'obterPessoa'])->name('obter-pessoa');
    Route::get('/novo', [CadastradorCAFController::class, 'create'])->name('create');
    Route::post('/etapa1', [CadastradorCAFController::class, 'storeEtapa1'])->name('store-etapa1');
    
    Route::get('/{cadastro}/etapa2', [CadastradorCAFController::class, 'etapa2'])->name('etapa2');
    Route::post('/{cadastro}/etapa2', [CadastradorCAFController::class, 'storeEtapa2'])->name('store-etapa2');
    
    Route::get('/{cadastro}/etapa3', [CadastradorCAFController::class, 'etapa3'])->name('etapa3');
    Route::post('/{cadastro}/etapa3', [CadastradorCAFController::class, 'storeEtapa3'])->name('store-etapa3');
    
    Route::get('/{cadastro}/etapa4', [CadastradorCAFController::class, 'etapa4'])->name('etapa4');
    Route::post('/{cadastro}/etapa4', [CadastradorCAFController::class, 'storeEtapa4'])->name('store-etapa4');
    
    Route::get('/{cadastro}/etapa5', [CadastradorCAFController::class, 'etapa5'])->name('etapa5');
    Route::post('/{cadastro}/etapa5', [CadastradorCAFController::class, 'storeEtapa5'])->name('store-etapa5');
    
    Route::get('/{cadastro}/etapa6', [CadastradorCAFController::class, 'etapa6'])->name('etapa6');
    
    Route::get('/{cadastro}', [CadastradorCAFController::class, 'show'])->name('show');
    Route::get('/{cadastro}/pdf', [CadastradorCAFController::class, 'pdf'])->name('pdf');
});

// Rotas do Admin CAF
Route::prefix('admin/caf')->name('admin.caf.')->middleware(['web', 'auth', 'module.enabled:CAF'])->group(function () {
    Route::get('/', [AdminCAFController::class, 'index'])->name('index');
    Route::get('/{cadastro}', [AdminCAFController::class, 'show'])->name('show');
    Route::post('/{cadastro}/aprovar', [AdminCAFController::class, 'aprovar'])->name('aprovar');
    Route::post('/{cadastro}/rejeitar', [AdminCAFController::class, 'rejeitar'])->name('rejeitar');
    Route::post('/{cadastro}/enviar-caf', [AdminCAFController::class, 'enviarCAF'])->name('enviar-caf');
    Route::delete('/{cadastro}', [AdminCAFController::class, 'destroy'])->name('destroy');
});
