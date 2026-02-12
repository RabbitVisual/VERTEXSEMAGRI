<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;
use App\Http\Middleware\EnsureUserIsConsulta;
use App\Http\Controllers\Consulta\ConsultaDashboardController;
use App\Http\Controllers\Consulta\ConsultaProfileController;

/*
|--------------------------------------------------------------------------
| Rotas do Painel de Consulta
|--------------------------------------------------------------------------
|
| Estas rotas são acessíveis apenas por usuários com a role 'consulta'.
| O acesso é estritamente de leitura (GET) para a maioria dos módulos.
|
*/

Route::prefix('consulta')->name('consulta.')->middleware(['auth', 'role:consulta', EnsureUserIsConsulta::class])->group(function () {

    // =========================================================================
    // Core (Dashboard, Profile, Notifications)
    // =========================================================================

    // Dashboard
    Route::get('/', [ConsultaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [ConsultaDashboardController::class, 'index'])->name('dashboard.index');

    // Profile
    Route::get('/profile', [ConsultaProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ConsultaProfileController::class, 'update'])->name('profile.update');

    // Notificacoes
    if (Module::isEnabled('Notificacoes')) {
        Route::get('/notificacoes', [\App\Http\Controllers\Consulta\NotificacoesConsultaController::class, 'index'])->name('notificacoes.index');
        Route::get('/notificacoes/{id}', [\App\Http\Controllers\Consulta\NotificacoesConsultaController::class, 'show'])->name('notificacoes.show');
    }

    // =========================================================================
    // Operacional (Demandas, Ordens, Equipes, Funcionarios)
    // =========================================================================

    // Demandas
    if (Module::isEnabled('Demandas')) {
        Route::get('/demandas', [\App\Http\Controllers\Consulta\DemandasConsultaController::class, 'index'])->name('demandas.index');
        Route::get('/demandas/{id}', [\App\Http\Controllers\Consulta\DemandasConsultaController::class, 'show'])->name('demandas.show');
    }

    // Ordens
    if (Module::isEnabled('Ordens')) {
        Route::get('/ordens', [\App\Http\Controllers\Consulta\OrdensConsultaController::class, 'index'])->name('ordens.index');
        Route::get('/ordens/{id}', [\App\Http\Controllers\Consulta\OrdensConsultaController::class, 'show'])->name('ordens.show');
    }

    // Equipes
    if (Module::isEnabled('Equipes')) {
        Route::get('/equipes', [\App\Http\Controllers\Consulta\EquipesConsultaController::class, 'index'])->name('equipes.index');
        Route::get('/equipes/{id}', [\App\Http\Controllers\Consulta\EquipesConsultaController::class, 'show'])->name('equipes.show');
    }

    // Funcionarios
    if (Module::isEnabled('Funcionarios')) {
        Route::get('/funcionarios', [\App\Http\Controllers\Consulta\FuncionariosConsultaController::class, 'index'])->name('funcionarios.index');
        Route::get('/funcionarios/{id}', [\App\Http\Controllers\Consulta\FuncionariosConsultaController::class, 'show'])->name('funcionarios.show');
    }

    // =========================================================================
    // Infraestrutura (Iluminacao, Agua, Pocos, Estradas, Localidades)
    // =========================================================================

    // Iluminacao
    if (Module::isEnabled('Iluminacao')) {
        Route::get('/iluminacao', [\App\Http\Controllers\Consulta\IluminacaoConsultaController::class, 'index'])->name('iluminacao.index');
        Route::get('/iluminacao/{id}', [\App\Http\Controllers\Consulta\IluminacaoConsultaController::class, 'show'])->name('iluminacao.show');
    }

    // Agua
    if (Module::isEnabled('Agua')) {
        Route::get('/agua', [\App\Http\Controllers\Consulta\AguaConsultaController::class, 'index'])->name('agua.index');
        Route::get('/agua/{id}', [\App\Http\Controllers\Consulta\AguaConsultaController::class, 'show'])->name('agua.show');
    }

    // Pocos
    if (Module::isEnabled('Pocos')) {
        Route::get('/pocos', [\App\Http\Controllers\Consulta\PocosConsultaController::class, 'index'])->name('pocos.index');
        Route::get('/pocos/{id}', [\App\Http\Controllers\Consulta\PocosConsultaController::class, 'show'])->name('pocos.show');
    }

    // Estradas
    if (Module::isEnabled('Estradas')) {
        Route::get('/estradas', [\App\Http\Controllers\Consulta\EstradasConsultaController::class, 'index'])->name('estradas.index');
        Route::get('/estradas/{id}', [\App\Http\Controllers\Consulta\EstradasConsultaController::class, 'show'])->name('estradas.show');
    }

    // Localidades
    if (Module::isEnabled('Localidades')) {
        Route::get('/localidades', [\App\Http\Controllers\Consulta\LocalidadesConsultaController::class, 'index'])->name('localidades.index');
        Route::get('/localidades/{id}', [\App\Http\Controllers\Consulta\LocalidadesConsultaController::class, 'show'])->name('localidades.show');
    }

    // =========================================================================
    // Suprimentos (Materiais)
    // =========================================================================

    // Materiais
    if (Module::isEnabled('Materiais')) {
        Route::get('/materiais', [\App\Http\Controllers\Consulta\MateriaisConsultaController::class, 'index'])->name('materiais.index');
        Route::get('/materiais/{id}', [\App\Http\Controllers\Consulta\MateriaisConsultaController::class, 'show'])->name('materiais.show');
    }

    // =========================================================================
    // Social (Pessoas, Programas)
    // =========================================================================

    // Pessoas
    if (Module::isEnabled('Pessoas')) {
        Route::get('/pessoas', [\App\Http\Controllers\Consulta\PessoasConsultaController::class, 'index'])->name('pessoas.index');
        Route::get('/pessoas/{id}', [\App\Http\Controllers\Consulta\PessoasConsultaController::class, 'show'])->name('pessoas.show');
    }

    // ProgramasAgricultura
    if (Module::isEnabled('ProgramasAgricultura')) {
        Route::get('/programas', [\App\Http\Controllers\Consulta\ProgramasAgriculturaConsultaController::class, 'index'])->name('programas.index');
        Route::get('/programas/{id}', [\App\Http\Controllers\Consulta\ProgramasAgriculturaConsultaController::class, 'show'])->name('programas.show');
    }

    // =========================================================================
    // BI & Relatórios
    // =========================================================================

    // Relatorios
    if (Module::isEnabled('Relatorios')) {
        Route::get('/relatorios', [\App\Http\Controllers\Consulta\RelatoriosConsultaController::class, 'index'])->name('relatorios.index');
    }
});
