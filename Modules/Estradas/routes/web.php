<?php

use Illuminate\Support\Facades\Route;
use Modules\Estradas\App\Http\Controllers\EstradasController;

Route::middleware(['auth', 'module.enabled:Estradas'])->group(function () {
    Route::resource('estradas', EstradasController::class)->names('estradas');
});
