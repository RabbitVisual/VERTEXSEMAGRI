<?php

use Illuminate\Support\Facades\Route;
use Modules\Avisos\App\Http\Controllers\Admin\AvisosAdminController;
use Modules\Avisos\App\Http\Controllers\AvisosPublicController;

/*
|--------------------------------------------------------------------------
| Web Routes - Módulo Avisos
|--------------------------------------------------------------------------
*/

// Rotas públicas (API para componentes)
Route::prefix('api/avisos')->name('avisos.api.')->group(function () {
    Route::get('/posicao/{posicao}', [AvisosPublicController::class, 'obterPorPosicao'])->name('posicao');
    Route::post('/{id}/visualizar', [AvisosPublicController::class, 'registrarVisualizacao'])->name('visualizar');
    Route::post('/{id}/clique', [AvisosPublicController::class, 'registrarClique'])->name('clique');
});

// Rotas admin
Route::prefix('admin/avisos')->name('admin.avisos.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [AvisosAdminController::class, 'index'])->name('index');
    Route::get('/create', [AvisosAdminController::class, 'create'])->name('create');
    Route::post('/', [AvisosAdminController::class, 'store'])->name('store');
    Route::get('/{aviso}', [AvisosAdminController::class, 'show'])->name('show');
    Route::get('/{aviso}/edit', [AvisosAdminController::class, 'edit'])->name('edit');
    Route::put('/{aviso}', [AvisosAdminController::class, 'update'])->name('update');
    Route::delete('/{aviso}', [AvisosAdminController::class, 'destroy'])->name('destroy');
    Route::post('/{aviso}/toggle-ativo', [AvisosAdminController::class, 'toggleAtivo'])->name('toggle-ativo');
});
