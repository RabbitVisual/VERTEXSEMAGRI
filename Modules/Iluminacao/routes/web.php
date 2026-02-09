<?php

use Illuminate\Support\Facades\Route;
use Modules\Iluminacao\App\Http\Controllers\IluminacaoController;

Route::middleware(['auth', 'module.enabled:Iluminacao'])->group(function () {
    Route::get('iluminacao/export-neoenergia', [IluminacaoController::class, 'exportNeoenergia'])->name('iluminacao.export-neoenergia');
    Route::post('iluminacao/import-neoenergia', [IluminacaoController::class, 'importNeoenergia'])->name('iluminacao.import-neoenergia');
    Route::resource('iluminacao', IluminacaoController::class)->names('iluminacao');
});
