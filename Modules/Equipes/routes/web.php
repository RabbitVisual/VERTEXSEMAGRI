<?php

use Illuminate\Support\Facades\Route;
use Modules\Equipes\App\Http\Controllers\EquipesController;

Route::middleware(['auth', 'module.enabled:Equipes'])->group(function () {
    Route::resource('equipes', EquipesController::class)->names('equipes');
});

