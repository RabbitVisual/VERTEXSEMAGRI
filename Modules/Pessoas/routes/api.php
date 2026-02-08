<?php

use Illuminate\Support\Facades\Route;
use Modules\Pessoas\App\Http\Controllers\PessoasController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('pessoas', PessoasController::class)->names('pessoas');
});
