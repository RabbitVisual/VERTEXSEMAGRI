<?php

use Illuminate\Support\Facades\Route;
use Modules\Iluminacao\App\Http\Controllers\PontosLuzController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('iluminacao', PontosLuzController::class)->names('iluminacao');
});
