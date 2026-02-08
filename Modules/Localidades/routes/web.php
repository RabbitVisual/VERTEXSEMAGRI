<?php

use Illuminate\Support\Facades\Route;
use Modules\Localidades\App\Http\Controllers\LocalidadesController;

Route::middleware(['auth', 'module.enabled:Localidades'])->group(function () {
    // Rotas específicas devem vir ANTES da rota resource para evitar conflitos
    Route::get('/localidades/{id}/dados', [LocalidadesController::class, 'getDados'])->name('localidades.dados');
    Route::resource('localidades', LocalidadesController::class)->names('localidades');
});
