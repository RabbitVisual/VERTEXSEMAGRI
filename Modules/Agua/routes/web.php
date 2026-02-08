<?php

use Illuminate\Support\Facades\Route;
use Modules\Agua\App\Http\Controllers\AguaController;

Route::middleware(['auth', 'module.enabled:Agua'])->group(function () {
    Route::resource('agua', AguaController::class)->names('agua');
});
