<?php

use Illuminate\Support\Facades\Route;
use Modules\Materiais\App\Http\Controllers\MateriaisController;
use Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController;

Route::middleware(['auth', 'module.enabled:Materiais'])->group(function () {
    Route::resource('materiais', MateriaisController::class)->names('materiais');

    // Rotas para movimentação de estoque
    Route::post('materiais/{id}/adicionar-estoque', [MateriaisController::class, 'adicionarEstoque'])
        ->name('materiais.adicionar-estoque');
    Route::post('materiais/{id}/remover-estoque', [MateriaisController::class, 'removerEstoque'])
        ->name('materiais.remover-estoque');
});

