<?php

use Illuminate\Support\Facades\Route;
use Modules\Funcionarios\App\Http\Controllers\FuncionariosController;

Route::middleware(['auth', 'module.enabled:Funcionarios'])->group(function () {
    Route::get('/funcionarios/export', [FuncionariosController::class, 'export'])->name('funcionarios.export');
    Route::post('/funcionarios/{funcionario}/reenviar-email', [FuncionariosController::class, 'reenviarEmail'])->name('funcionarios.reenviar-email');
    Route::resource('funcionarios', FuncionariosController::class)->names('funcionarios');
});
