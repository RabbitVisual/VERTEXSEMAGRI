<?php

use Illuminate\Support\Facades\Route;
use Modules\Estradas\App\Http\Controllers\EstradasController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('estradas', EstradasController::class)->names('estradas');
});
