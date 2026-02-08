<?php

use Illuminate\Support\Facades\Route;
use Modules\Iluminacao\App\Http\Controllers\IluminacaoController;

Route::middleware(['auth', 'module.enabled:Iluminacao'])->group(function () {
    Route::resource('iluminacao', IluminacaoController::class)->names('iluminacao');
});
