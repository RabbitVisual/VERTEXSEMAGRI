<?php

use Illuminate\Support\Facades\Route;
use Modules\ProgramasAgricultura\Http\Controllers\ProgramasAgriculturaController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('programasagriculturas', ProgramasAgriculturaController::class)->names('programasagricultura');
});
