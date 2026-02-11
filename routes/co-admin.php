<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoAdmin\CoAdminDashboardController;
use App\Http\Controllers\CoAdmin\CoAdminProfileController;
use Nwidart\Modules\Facades\Module;

/*
|--------------------------------------------------------------------------
| Co-Admin Explicit Routes (Anti-Resource Pattern)
|--------------------------------------------------------------------------
|
| SEGURANÇA CRÍTICA: O uso de 'Route::resource' é estritamente PROIBIDO neste
| arquivo para evitar a exposição acidental de verbos destrutivos (destroy)
| ou métodos não auditados. Todas as rotas devem ser definidas manualmente.
|
*/

Route::prefix('co-admin')->name('co-admin.')->middleware(['auth', 'co-admin-or-admin'])->group(function () {

    // ============================================
    // CORE SYSTEM
    // ============================================

    // Dashboard
    Route::get('/', [CoAdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [CoAdminDashboardController::class, 'index'])->name('dashboard.index');

    // Perfil do usuário autenticado
    Route::get('/profile', [CoAdminProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [CoAdminProfileController::class, 'update'])->name('profile.update');

    // ============================================
    // MÓDULOS - Rotas Co-Admin (Explicit Only)
    // ============================================

    // 1. Demandas
    if (Module::isEnabled('Demandas')) {
        Route::prefix('demandas')->name('demandas.')->group(function () {
            // Utilitários e Relatórios
            Route::get('/buscar-pessoa', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'buscarPessoa'])->name('buscar-pessoa');
            Route::get('/pessoa/{id}', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'obterPessoa'])->name('obter-pessoa');
            Route::get('/relatorio/abertas/pdf', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'relatorioAbertasPdf'])->name('relatorio.abertas.pdf');
            Route::post('/verificar-similares', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'verificarSimilares'])->name('verificar-similares');

            // CRUD Manual (Read/Write)
            Route::get('/', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'update'])->name('update');

            // Ações Específicas
            Route::get('/{id}/print', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'print'])->name('print');
            Route::post('/{demanda}/reenviar-email', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'reenviarEmail'])->name('reenviar-email');

            // Gestão de Interessados
            Route::get('/{id}/interessados', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'interessados'])->name('interessados');
            Route::delete('/{demandaId}/interessados/{interessadoId}', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'removerInteressado'])->name('remover-interessado');
        });
    }

    // 2. Ordens de Serviço
    if (Module::isEnabled('Ordens')) {
        Route::prefix('ordens')->name('ordens.')->group(function () {
            // Relatórios
            Route::get('/relatorio/demandas-dia/pdf', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'relatorioDemandasDiaPdf'])->name('relatorio.demandas-dia.pdf');

            // CRUD Manual
            Route::get('/', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'update'])->name('update');

            // Fluxo de Trabalho
            Route::get('/{id}/print', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'print'])->name('print');
            Route::post('/{id}/iniciar', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'iniciar'])->name('iniciar');
            Route::post('/{id}/concluir', [\Modules\Ordens\App\Http\Controllers\OrdensController::class, 'concluir'])->name('concluir');
        });
    }

    // 3. Localidades
    if (Module::isEnabled('Localidades')) {
        Route::prefix('localidades')->name('localidades.')->group(function () {
            Route::get('/', [\Modules\Localidades\App\Http\Controllers\LocalidadesController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Localidades\App\Http\Controllers\LocalidadesController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Localidades\App\Http\Controllers\LocalidadesController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Localidades\App\Http\Controllers\LocalidadesController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Localidades\App\Http\Controllers\LocalidadesController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Localidades\App\Http\Controllers\LocalidadesController::class, 'update'])->name('update');
        });
    }

    // 4. Pessoas
    if (Module::isEnabled('Pessoas')) {
        Route::prefix('pessoas')->name('pessoas.')->group(function () {
            Route::get('/', [\Modules\Pessoas\App\Http\Controllers\PessoasController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Pessoas\App\Http\Controllers\PessoasController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Pessoas\App\Http\Controllers\PessoasController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Pessoas\App\Http\Controllers\PessoasController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Pessoas\App\Http\Controllers\PessoasController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Pessoas\App\Http\Controllers\PessoasController::class, 'update'])->name('update');
        });
    }

    // 5. Equipes
    if (Module::isEnabled('Equipes')) {
        Route::prefix('equipes')->name('equipes.')->group(function () {
            Route::get('/', [\Modules\Equipes\App\Http\Controllers\EquipesController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Equipes\App\Http\Controllers\EquipesController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Equipes\App\Http\Controllers\EquipesController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Equipes\App\Http\Controllers\EquipesController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Equipes\App\Http\Controllers\EquipesController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Equipes\App\Http\Controllers\EquipesController::class, 'update'])->name('update');
        });
    }

    // 6. Estradas
    if (Module::isEnabled('Estradas')) {
        Route::prefix('estradas')->name('estradas.')->group(function () {
            Route::get('/', [\Modules\Estradas\App\Http\Controllers\EstradasController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Estradas\App\Http\Controllers\EstradasController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Estradas\App\Http\Controllers\EstradasController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Estradas\App\Http\Controllers\EstradasController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Estradas\App\Http\Controllers\EstradasController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Estradas\App\Http\Controllers\EstradasController::class, 'update'])->name('update');
        });
    }

    // 7. Funcionários
    if (Module::isEnabled('Funcionarios')) {
        Route::prefix('funcionarios')->name('funcionarios.')->group(function () {
            // Monitoramento
            Route::prefix('status')->name('status.')->group(function () {
                Route::get('/', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'index'])->name('index');
                Route::get('/atualizar', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'atualizar'])->name('atualizar');
                Route::get('/{id}/detalhes', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'detalhes'])->name('detalhes');
            });

            // CRUD Manual
            Route::get('/', [\Modules\Funcionarios\App\Http\Controllers\FuncionariosController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Funcionarios\App\Http\Controllers\FuncionariosController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Funcionarios\App\Http\Controllers\FuncionariosController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Funcionarios\App\Http\Controllers\FuncionariosController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Funcionarios\App\Http\Controllers\FuncionariosController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Funcionarios\App\Http\Controllers\FuncionariosController::class, 'update'])->name('update');
        });
    }

    // 8. Iluminação
    if (Module::isEnabled('Iluminacao')) {
        Route::prefix('iluminacao')->name('iluminacao.')->group(function () {
            Route::get('/', [\Modules\Iluminacao\App\Http\Controllers\IluminacaoController::class, 'index'])->name('index');
            Route::get('/export-neoenergia', [\Modules\Iluminacao\App\Http\Controllers\IluminacaoController::class, 'exportNeoenergia'])->name('export-neoenergia');
            Route::post('/import-neoenergia', [\Modules\Iluminacao\App\Http\Controllers\IluminacaoController::class, 'importNeoenergia'])->name('import-neoenergia');
            Route::get('/create', [\Modules\Iluminacao\App\Http\Controllers\IluminacaoController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Iluminacao\App\Http\Controllers\IluminacaoController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Iluminacao\App\Http\Controllers\IluminacaoController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Iluminacao\App\Http\Controllers\IluminacaoController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Iluminacao\App\Http\Controllers\IluminacaoController::class, 'update'])->name('update');
        });
    }

    // 9. Água
    if (Module::isEnabled('Agua')) {
        Route::prefix('agua')->name('agua.')->group(function () {
            Route::get('/', [\Modules\Agua\App\Http\Controllers\AguaController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Agua\App\Http\Controllers\AguaController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Agua\App\Http\Controllers\AguaController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Agua\App\Http\Controllers\AguaController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Agua\App\Http\Controllers\AguaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Agua\App\Http\Controllers\AguaController::class, 'update'])->name('update');
        });
    }

    // 10. Poços
    if (Module::isEnabled('Pocos')) {
        Route::prefix('pocos')->name('pocos.')->group(function () {
            Route::get('/', [\Modules\Pocos\App\Http\Controllers\PocosController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Pocos\App\Http\Controllers\PocosController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Pocos\App\Http\Controllers\PocosController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Pocos\App\Http\Controllers\PocosController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Pocos\App\Http\Controllers\PocosController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Pocos\App\Http\Controllers\PocosController::class, 'update'])->name('update');
            Route::post('/{id}/reportar-problema', [\Modules\Pocos\App\Http\Controllers\PocosController::class, 'reportarProblema'])->name('reportar-problema');
        });
    }

    // 11. Materiais
    if (Module::isEnabled('Materiais')) {
        Route::prefix('materiais')->name('materiais.')->group(function () {
            // CRUD Manual
            Route::get('/', [\Modules\Materiais\App\Http\Controllers\MateriaisController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Materiais\App\Http\Controllers\MateriaisController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Materiais\App\Http\Controllers\MateriaisController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Materiais\App\Http\Controllers\MateriaisController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Materiais\App\Http\Controllers\MateriaisController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Materiais\App\Http\Controllers\MateriaisController::class, 'update'])->name('update');
        });
    }

    // 12. Relatórios (Somente Leitura para Co-Admin)
    if (Module::isEnabled('Relatorios')) {
        Route::prefix('relatorios')->name('relatorios.')->group(function () {
            Route::get('/', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'index'])->name('index');
            Route::get('/demandas', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'relatorioDemandas'])->name('demandas');
            Route::get('/ordens', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'relatorioOrdens'])->name('ordens');
            Route::get('/materiais', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'relatorioMateriais'])->name('materiais');
            Route::get('/equipes', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'relatorioEquipes'])->name('equipes');
            Route::get('/infraestrutura', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'relatorioInfraestrutura'])->name('infraestrutura');
            Route::get('/geral', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'relatorioGeral'])->name('geral');
            Route::get('/notificacoes', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'relatorioNotificacoes'])->name('notificacoes');
            Route::get('/solicitacoes-materiais', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'relatorioSolicitacoesMateriais'])->name('solicitacoes_materiais');
            Route::get('/movimentacoes-materiais', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'relatorioMovimentacoesMateriais'])->name('movimentacoes_materiais');
        });
    }

    // 13. Notificações
    if (Module::isEnabled('Notificacoes')) {
        Route::prefix('notificacoes')->name('notificacoes.')->group(function () {
            Route::get('/', [\Modules\Notificacoes\App\Http\Controllers\NotificacoesController::class, 'index'])->name('index');
            Route::get('/{id}', [\Modules\Notificacoes\App\Http\Controllers\NotificacoesController::class, 'show'])->name('show');
        });
    }

    // 14. Chat
    if (Module::isEnabled('Chat')) {
        Route::prefix('chat')->name('chat.')->group(function () {
            // Páginas principais
            Route::get('/', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'index'])->name('index');
            Route::get('/realtime', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'realtime'])->name('realtime');
            Route::get('/statistics', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'statistics'])->name('statistics');

            // Ações em sessões específicas
            Route::get('/{id}', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'show'])->name('show')->where('id', '[0-9]+');
            Route::post('/{id}/assign', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'assign'])->name('assign');
            Route::post('/{id}/transfer', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'transfer'])->name('transfer');
            Route::post('/{id}/close', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'close'])->name('close');
            Route::post('/{id}/reopen', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'reopen'])->name('reopen');

            // API interna (auth web)
            Route::get('/api/sessions', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'apiGetSessions'])->name('api.sessions');
            Route::get('/{id}/api/messages', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'apiGetMessages'])->name('api.messages');
            Route::post('/{id}/api/message', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'apiSendMessage'])->name('api.message');
            Route::post('/{id}/api/read', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'apiMarkAsRead'])->name('api.read');
            Route::post('/{id}/api/typing', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'apiTyping'])->name('api.typing');
            Route::put('/{id}/api/status', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'apiUpdateStatus'])->name('api.status');
        });
    }

    // 15. Programas de Agricultura
    if (Module::isEnabled('ProgramasAgricultura')) {
        Route::prefix('programas')->name('programas.')->group(function () {
            Route::get('/', [\Modules\ProgramasAgricultura\App\Http\Controllers\ProgramasAgriculturaController::class, 'index'])->name('index');
            Route::get('/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\ProgramasAgriculturaController::class, 'show'])->name('show');
        });

        Route::prefix('eventos')->name('eventos.')->group(function () {
            Route::get('/', [\Modules\ProgramasAgricultura\App\Http\Controllers\EventosController::class, 'index'])->name('index');
            Route::get('/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\EventosController::class, 'show'])->name('show');
        });

        Route::prefix('beneficiarios')->name('beneficiarios.')->group(function () {
            Route::get('/', [\Modules\ProgramasAgricultura\App\Http\Controllers\BeneficiariosController::class, 'index'])->name('index');
            Route::get('/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\BeneficiariosController::class, 'show'])->name('show');
        });
    }

    // 16. CAF (Controle de Aptidão)
    if (Module::isEnabled('CAF')) {
        Route::prefix('caf')->name('caf.')->group(function () {
            Route::get('/', [\Modules\CAF\App\Http\Controllers\AdminCAFController::class, 'index'])->name('index');
            Route::get('/{cadastro}', [\Modules\CAF\App\Http\Controllers\AdminCAFController::class, 'show'])->name('show');
        });
    }
});
