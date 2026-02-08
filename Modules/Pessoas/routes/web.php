<?php

use Illuminate\Support\Facades\Route;
use Modules\Pessoas\App\Http\Controllers\PessoasController;

Route::middleware(['auth', 'module.enabled:Pessoas'])->group(function () {
    Route::get('/pessoas', [PessoasController::class, 'index'])->name('pessoas.index');
    Route::get('/pessoas/create', [PessoasController::class, 'create'])->name('pessoas.create');
    Route::post('/pessoas', [PessoasController::class, 'store'])->name('pessoas.store');
    Route::get('/pessoas/localidade/{localidadeId}/estatisticas', [PessoasController::class, 'estatisticasPorLocalidade'])->name('pessoas.estatisticas.localidade');
    Route::get('/pessoas/export/{format?}', [PessoasController::class, 'export'])->name('pessoas.export');
    Route::get('/pessoas/{id}', [PessoasController::class, 'show'])->name('pessoas.show');
    Route::get('/pessoas/{id}/edit', [PessoasController::class, 'edit'])->name('pessoas.edit');
    Route::put('/pessoas/{id}', [PessoasController::class, 'update'])->name('pessoas.update');
    Route::delete('/pessoas/{id}', [PessoasController::class, 'destroy'])->name('pessoas.destroy');
});
