<?php

use Illuminate\Support\Facades\Route;
use Modules\Agua\App\Http\Controllers\AguaController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('agua', AguaController::class)->names('agua');
});
