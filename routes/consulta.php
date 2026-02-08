<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Consulta\ConsultaDashboardController;
use App\Http\Middleware\EnsureUserIsConsulta;

Route::prefix('consulta')->name('consulta.')->middleware(['auth', 'role:consulta', EnsureUserIsConsulta::class])->group(function () {

    // Dashboard
    Route::get('/', [ConsultaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [ConsultaDashboardController::class, 'index'])->name('dashboard.index');

    // Perfil do usuário autenticado
    Route::get('/profile', [\App\Http\Controllers\Consulta\ConsultaProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Consulta\ConsultaProfileController::class, 'update'])->name('profile.update');

    // Módulos - Rotas de Consulta (somente visualização)
    // Demandas
    Route::get('/demandas', [\App\Http\Controllers\Consulta\DemandasConsultaController::class, 'index'])->name('demandas.index');
    Route::get('/demandas/{id}', [\App\Http\Controllers\Consulta\DemandasConsultaController::class, 'show'])->name('demandas.show');

    // Ordens
    Route::get('/ordens', [\App\Http\Controllers\Consulta\OrdensConsultaController::class, 'index'])->name('ordens.index');
    Route::get('/ordens/{id}', [\App\Http\Controllers\Consulta\OrdensConsultaController::class, 'show'])->name('ordens.show');

    // Localidades
    Route::get('/localidades', [\App\Http\Controllers\Consulta\LocalidadesConsultaController::class, 'index'])->name('localidades.index');
    Route::get('/localidades/{id}', [\App\Http\Controllers\Consulta\LocalidadesConsultaController::class, 'show'])->name('localidades.show');

    // Pessoas
    Route::get('/pessoas', [\App\Http\Controllers\Consulta\PessoasConsultaController::class, 'index'])->name('pessoas.index');
    Route::get('/pessoas/{id}', [\App\Http\Controllers\Consulta\PessoasConsultaController::class, 'show'])->name('pessoas.show');

    // Equipes
    Route::get('/equipes', [\App\Http\Controllers\Consulta\EquipesConsultaController::class, 'index'])->name('equipes.index');
    Route::get('/equipes/{id}', [\App\Http\Controllers\Consulta\EquipesConsultaController::class, 'show'])->name('equipes.show');

    // Estradas
    Route::get('/estradas', [\App\Http\Controllers\Consulta\EstradasConsultaController::class, 'index'])->name('estradas.index');
    Route::get('/estradas/{id}', [\App\Http\Controllers\Consulta\EstradasConsultaController::class, 'show'])->name('estradas.show');

    // Funcionários
    Route::get('/funcionarios', [\App\Http\Controllers\Consulta\FuncionariosConsultaController::class, 'index'])->name('funcionarios.index');
    Route::get('/funcionarios/{id}', [\App\Http\Controllers\Consulta\FuncionariosConsultaController::class, 'show'])->name('funcionarios.show');

    // Iluminação
    Route::get('/iluminacao', [\App\Http\Controllers\Consulta\IluminacaoConsultaController::class, 'index'])->name('iluminacao.index');
    Route::get('/iluminacao/{id}', [\App\Http\Controllers\Consulta\IluminacaoConsultaController::class, 'show'])->name('iluminacao.show');

    // Materiais
    Route::get('/materiais', [\App\Http\Controllers\Consulta\MateriaisConsultaController::class, 'index'])->name('materiais.index');
    Route::get('/materiais/{id}', [\App\Http\Controllers\Consulta\MateriaisConsultaController::class, 'show'])->name('materiais.show');

    // Poços
    Route::get('/pocos', [\App\Http\Controllers\Consulta\PocosConsultaController::class, 'index'])->name('pocos.index');
    Route::get('/pocos/{id}', [\App\Http\Controllers\Consulta\PocosConsultaController::class, 'show'])->name('pocos.show');

    // Água
    Route::get('/agua', [\App\Http\Controllers\Consulta\AguaConsultaController::class, 'index'])->name('agua.index');
    Route::get('/agua/{id}', [\App\Http\Controllers\Consulta\AguaConsultaController::class, 'show'])->name('agua.show');

    // Notificações
    Route::get('/notificacoes', [\App\Http\Controllers\Consulta\NotificacoesConsultaController::class, 'index'])->name('notificacoes.index');
    Route::get('/notificacoes/{id}', [\App\Http\Controllers\Consulta\NotificacoesConsultaController::class, 'show'])->name('notificacoes.show');

    // Portal do Agricultor - Programas (apenas se o módulo estiver ativo)
    if (\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura')) {
        Route::get('/programas', [\App\Http\Controllers\Consulta\ProgramasAgriculturaConsultaController::class, 'index'])->name('programas.index');
        Route::get('/programas/{id}', [\App\Http\Controllers\Consulta\ProgramasAgriculturaConsultaController::class, 'show'])->name('programas.show');
    }

    // Relatórios (apenas se o módulo estiver ativo)
    if (\Nwidart\Modules\Facades\Module::isEnabled('Relatorios')) {
        Route::get('/relatorios', [\App\Http\Controllers\Consulta\RelatoriosConsultaController::class, 'index'])->name('relatorios.index');
    }
});

