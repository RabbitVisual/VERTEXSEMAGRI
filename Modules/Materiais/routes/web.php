<?php

use Illuminate\Support\Facades\Route;
use Modules\Materiais\App\Http\Controllers\MateriaisController;

Route::middleware(['auth', 'module.enabled:Materiais'])->group(function () {
    /**
     * Public/User Panel Routes for Materiais
     */
    Route::resource('materiais', MateriaisController::class)->names('materiais');

    // Rotas para movimentação de estoque
    Route::post('materiais/{id}/adicionar-estoque', [MateriaisController::class, 'adicionarEstoque'])
        ->name('materiais.adicionar-estoque');

    Route::post('materiais/{id}/remover-estoque', [MateriaisController::class, 'removerEstoque'])
        ->name('materiais.remover-estoque');

    /**
     * NOTE: Admin routes for Materiais are centralized in routes/admin.php
     * to ensure security hardening and avoid naming collisions during route caching.
     */
});
