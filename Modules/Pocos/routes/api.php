<?php

use Illuminate\Support\Facades\Route;
use Modules\Pocos\App\Http\Controllers\PocosController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('pocos', PocosController::class)->names('pocos');
});
