<?php

use Illuminate\Support\Facades\Route;
use Modules\Avisos\App\Http\Controllers\AvisosController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('avisos', AvisosController::class)->names('avisos');
});
