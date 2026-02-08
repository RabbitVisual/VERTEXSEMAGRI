<?php

use Illuminate\Support\Facades\Route;
use Modules\Localidades\App\Http\Controllers\LocalidadesController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('localidades', LocalidadesController::class)->names('localidades');
});
