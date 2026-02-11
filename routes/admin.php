<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SystemConfigController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\FormularioManualController;
use Nwidart\Modules\Facades\Module;

/*
|--------------------------------------------------------------------------
| Admin Routes (Security Hardened)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');

    // Módulos
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/{moduleName}', [ModuleController::class, 'show'])->name('modules.show');
    Route::post('/modules/{moduleName}/enable', [ModuleController::class, 'enable'])->name('modules.enable');
    Route::post('/modules/{moduleName}/disable', [ModuleController::class, 'disable'])->name('modules.disable');

    // Usuários
    Route::resource('users', UserController::class);
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Líderes de Comunidade
    Route::resource('lideres-comunidade', \App\Http\Controllers\Admin\LiderComunidadeController::class);
    Route::get('/lideres-comunidade/pessoa/{id}', [\App\Http\Controllers\Admin\LiderComunidadeController::class, 'buscarPessoa'])->name('lideres-comunidade.pessoa');
    Route::get('/lideres-comunidade/pessoas/buscar', [\App\Http\Controllers\Admin\LiderComunidadeController::class, 'buscarPessoas'])->name('lideres-comunidade.pessoas.buscar');

    // Perfil do usuário autenticado
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Roles & Permissões
    Route::resource('roles', RoleController::class);
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');

    // Configurações e Sistema
    Route::get('/config', [SystemConfigController::class, 'index'])->name('config.index');
    Route::put('/config', [SystemConfigController::class, 'update'])->name('config.update');
    Route::post('/config/initialize', [SystemConfigController::class, 'initialize'])->name('config.initialize');

    // Logs de Auditoria
    Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');
    Route::get('/audit/{id}', [AuditLogController::class, 'show'])->name('audit.show');
    Route::post('/audit/clean', [AuditLogController::class, 'clean'])->name('audit.clean');

    // Backup
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup', [BackupController::class, 'create'])->name('backup.create');
    Route::post('/backup/{filename}/restore', [BackupController::class, 'restore'])->name('backup.restore');
    Route::get('/backup/{filename}/download', [BackupController::class, 'download'])->name('backup.download');
    Route::delete('/backup/{filename}', [BackupController::class, 'destroy'])->name('backup.destroy');

    // Atualizações (Updates)
    Route::resource('updates', \App\Http\Controllers\Admin\UpdateController::class)->except(['edit', 'update']);
    Route::post('/updates/upload', [\App\Http\Controllers\Admin\UpdateController::class, 'upload'])->name('updates.upload');
    Route::post('/updates/{id}/apply', [\App\Http\Controllers\Admin\UpdateController::class, 'apply'])->name('updates.apply');
    Route::post('/updates/{id}/rollback', [\App\Http\Controllers\Admin\UpdateController::class, 'rollback'])->name('updates.rollback');
    Route::get('/updates/{id}/backup/download', [\App\Http\Controllers\Admin\UpdateController::class, 'downloadBackup'])->name('updates.download-backup');

    // Carousel & Mídias
    Route::resource('carousel', CarouselController::class);
    Route::post('/carousel/toggle', [CarouselController::class, 'toggle'])->name('carousel.toggle');
    Route::post('/carousel/reorder', [CarouselController::class, 'reorder'])->name('carousel.reorder');

    // Gerenciamento de API
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ApiManagementController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Admin\ApiManagementController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\Admin\ApiManagementController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\Admin\ApiManagementController::class, 'show'])->name('show');
        Route::put('/{id}', [\App\Http\Controllers\Admin\ApiManagementController::class, 'update'])->name('update');
        Route::post('/{id}/revoke', [\App\Http\Controllers\Admin\ApiManagementController::class, 'revoke'])->name('revoke');
        Route::post('/{id}/regenerate', [\App\Http\Controllers\Admin\ApiManagementController::class, 'regenerate'])->name('regenerate');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\ApiManagementController::class, 'destroy'])->name('destroy');
    });

    // Formulários Manuais
    Route::prefix('formularios')->name('formularios.')->group(function () {
        Route::get('/demanda', [FormularioManualController::class, 'gerarFormularioDemanda'])->name('demanda');
        Route::get('/ordem', [FormularioManualController::class, 'gerarFormularioOrdem'])->name('ordem');
    });

    /*
    |--------------------------------------------------------------------------
    | Secure Impersonation Feature
    |--------------------------------------------------------------------------
    | Strictly limited to Super Admins only.
    | Prevents privilege escalation and uncontrolled access.
    */
    Route::get('/funcionarios/{id}/login-as', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'loginAs'])
        ->middleware('secure-impersonation')
        ->name('funcionarios.login-as');

    /*
    |--------------------------------------------------------------------------
    | Modular Routes (Context-Aware)
    |--------------------------------------------------------------------------
    */

    // Homepage
    if (Module::isEnabled('Homepage')) {
        Route::get('/homepage', [\Modules\Homepage\App\Http\Controllers\Admin\HomepageAdminController::class, 'index'])->name('homepage.index');
        Route::put('/homepage', [\Modules\Homepage\App\Http\Controllers\Admin\HomepageAdminController::class, 'update'])->name('homepage.update');
        Route::post('/homepage/toggle-section', [\Modules\Homepage\App\Http\Controllers\Admin\HomepageAdminController::class, 'toggleSection'])->name('homepage.toggle-section');
    }

    // Blog
    if (Module::isEnabled('Blog')) {
        Route::prefix('blog')->name('blog.')->group(function () {
            // Categorias
            Route::prefix('categorias')->name('categories.')->group(function () {
                Route::get('/', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'index'])->name('index');
                Route::get('/create', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'create'])->name('create');
                Route::post('/', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'edit'])->name('edit');
                Route::put('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'update'])->name('update');
                Route::delete('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/toggle-status', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'toggleStatus'])->name('toggle-status');
            });

            // Tags
            Route::prefix('tags')->name('tags.')->group(function () {
                Route::get('/', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'index'])->name('index');
                Route::get('/create', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'create'])->name('create');
                Route::post('/', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'edit'])->name('edit');
                Route::put('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'update'])->name('update');
                Route::delete('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'destroy'])->name('destroy');
                Route::post('/clean-unused', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'cleanUnused'])->name('clean-unused');
            });

            // Comentários
            Route::prefix('comentarios')->name('comments.')->group(function () {
                Route::get('/', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'index'])->name('index');
                Route::get('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'show'])->name('show');
                Route::post('/{id}/aprovar', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'approve'])->name('approve');
                Route::post('/{id}/rejeitar', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'reject'])->name('reject');
                Route::delete('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'destroy'])->name('destroy');
                Route::post('/bulk/aprovar', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'bulkApprove'])->name('bulk.approve');
                Route::post('/bulk/rejeitar', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'bulkReject'])->name('bulk.reject');
                Route::delete('/bulk/excluir', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'bulkDelete'])->name('bulk.delete');
            });

            Route::post('/generate-monthly-report', [\Modules\Blog\App\Http\Controllers\BlogIntegrationController::class, 'generateMonthlyReport'])->name('generate-monthly-report');
            Route::post('/upload-image', [\Modules\Blog\App\Http\Controllers\Admin\BlogAdminController::class, 'uploadEditorImage'])->name('upload-image');
            Route::get('/import-demanda', [\Modules\Blog\App\Http\Controllers\Admin\BlogAdminController::class, 'importDemanda'])->name('import-demanda');
            Route::post('/redact-image', [\Modules\Blog\App\Http\Controllers\Admin\BlogAdminController::class, 'redactImage'])->name('redact-image');

            Route::resource('/', \Modules\Blog\App\Http\Controllers\Admin\BlogAdminController::class)->names([
                'index' => 'index',
                'create' => 'create',
                'store' => 'store',
                'show' => 'show',
                'edit' => 'edit',
                'update' => 'update',
                'destroy' => 'destroy',
            ])->parameters(['' => 'blog']);
        });
    }

    // Notificações
    if (Module::isEnabled('Notificacoes')) {
        Route::resource('notificacoes', \Modules\Notificacoes\App\Http\Controllers\Admin\NotificacoesAdminController::class)->except(['edit', 'update']);
    }

    // Chat
    if (Module::isEnabled('Chat')) {
        Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('/', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'index'])->name('index');
            Route::get('/config', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'config'])->name('config');
            Route::put('/config', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'updateConfig'])->name('config.update');
            Route::get('/{id}', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'show'])->name('show');
            Route::post('/{id}/assign', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'assign'])->name('assign');
            Route::post('/{id}/close', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'close'])->name('close');

            Route::prefix('api')->name('api.')->group(function () {
                Route::get('/session/{sessionId}/messages', [\Modules\Chat\App\Http\Controllers\Api\ChatApiController::class, 'getMessages'])->name('session.messages');
                Route::post('/session/{sessionId}/message', [\Modules\Chat\App\Http\Controllers\Api\ChatApiController::class, 'sendMessage'])->name('session.message');
                Route::post('/session/{sessionId}/typing', [\Modules\Chat\App\Http\Controllers\Api\ChatApiController::class, 'sendTypingIndicator'])->name('session.typing');
                Route::post('/session/{sessionId}/read', [\Modules\Chat\App\Http\Controllers\Api\ChatApiController::class, 'markAsRead'])->name('session.read');
            });
        });
    }

    // Demandas & Ordens
    if (Module::isEnabled('Demandas')) {
        Route::get('/demandas', [\Modules\Demandas\App\Http\Controllers\Admin\DemandasAdminController::class, 'index'])->name('demandas.index');
        Route::get('/demandas/{id}', [\Modules\Demandas\App\Http\Controllers\Admin\DemandasAdminController::class, 'show'])->name('demandas.show');
        Route::get('/demandas/{id}/interessados', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'interessados'])->name('demandas.interessados');
        Route::delete('/demandas/{demandaId}/interessados/{interessadoId}', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'removerInteressado'])->name('demandas.remover-interessado');
    }

    if (Module::isEnabled('Ordens')) {
        Route::get('/ordens', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'index'])->name('ordens.index');
        Route::get('/ordens/{id}', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'show'])->name('ordens.show');
        Route::post('/ordens/{id}/materiais', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'adicionarMaterial'])->name('ordens.materiais.adicionar');
        Route::delete('/ordens/{id}/materiais/{materialId}', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'removerMaterial'])->name('ordens.materiais.remover');
        Route::post('/ordens/{id}/finalizar', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'finalizar'])->name('ordens.finalizar');
    }

    // Pessoas & Localidades
    if (Module::isEnabled('Localidades')) {
        Route::get('/localidades', [\Modules\Localidades\App\Http\Controllers\Admin\LocalidadesAdminController::class, 'index'])->name('localidades.index');
        Route::get('/localidades/{id}', [\Modules\Localidades\App\Http\Controllers\Admin\LocalidadesAdminController::class, 'show'])->name('localidades.show');
    }

    if (Module::isEnabled('Pessoas')) {
        Route::get('/pessoas', [\Modules\Pessoas\App\Http\Controllers\Admin\PessoasAdminController::class, 'index'])->name('pessoas.index');
        Route::get('/pessoas/{id}', [\Modules\Pessoas\App\Http\Controllers\Admin\PessoasAdminController::class, 'show'])->name('pessoas.show');
    }

    // Infraestrutura e Recursos Humanos
    if (Module::isEnabled('Equipes')) {
        Route::get('/equipes', [\Modules\Equipes\App\Http\Controllers\Admin\EquipesAdminController::class, 'index'])->name('equipes.index');
        Route::get('/equipes/{id}', [\Modules\Equipes\App\Http\Controllers\Admin\EquipesAdminController::class, 'show'])->name('equipes.show');
    }

    if (Module::isEnabled('Estradas')) {
        Route::get('/estradas', [\Modules\Estradas\App\Http\Controllers\Admin\EstradasAdminController::class, 'index'])->name('estradas.index');
        Route::get('/estradas/{id}', [\Modules\Estradas\App\Http\Controllers\Admin\EstradasAdminController::class, 'show'])->name('estradas.show');
    }

    if (Module::isEnabled('Funcionarios')) {
        Route::get('/funcionarios', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionariosAdminController::class, 'index'])->name('funcionarios.index');
        Route::get('/funcionarios/{id}', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionariosAdminController::class, 'show'])->name('funcionarios.show');

        Route::prefix('funcionarios/status')->name('funcionarios.status.')->group(function () {
            Route::get('/', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'index'])->name('index');
            Route::get('/atualizar', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'atualizar'])->name('atualizar');
            Route::post('/{id}/forcar-liberacao', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'forcarLiberacao'])->name('forcar-liberacao');
            Route::post('/{id}/status', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'atualizarStatus'])->name('atualizar-status');
            Route::get('/{id}/detalhes', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'detalhes'])->name('detalhes');
        });

        Route::prefix('funcionarios/{id}/senha')->name('funcionarios.senha.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'show'])->name('show');
            Route::post('/gerar', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'gerarSenha'])->name('gerar');
            Route::post('/alterar', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'alterarSenha'])->name('alterar');
            Route::get('/comprovante', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'comprovante'])->name('comprovante');
            Route::post('/visualizada', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'marcarVisualizada'])->name('visualizada');
        });
    }

    // Iluminação
    if (Module::isEnabled('Iluminacao')) {
        Route::prefix('iluminacao')->name('iluminacao.')->group(function () {
            Route::get('/', [\Modules\Iluminacao\App\Http\Controllers\Admin\IluminacaoAdminController::class, 'index'])->name('index');
            Route::get('/export', [\Modules\Iluminacao\App\Http\Controllers\Admin\IluminacaoAdminController::class, 'export'])->name('export');
            Route::prefix('postes')->name('postes.')->group(function () {
                Route::get('/', [\Modules\Iluminacao\App\Http\Controllers\Admin\PostesAdminController::class, 'index'])->name('index');
                Route::get('/export', [\Modules\Iluminacao\App\Http\Controllers\Admin\PostesAdminController::class, 'export'])->name('export');
                Route::get('/create', [\Modules\Iluminacao\App\Http\Controllers\Admin\PostesAdminController::class, 'create'])->name('create');
                Route::post('/', [\Modules\Iluminacao\App\Http\Controllers\Admin\PostesAdminController::class, 'store'])->name('store');
                Route::get('/{id}', [\Modules\Iluminacao\App\Http\Controllers\Admin\PostesAdminController::class, 'show'])->name('show');
            });
            Route::get('/{id}', [\Modules\Iluminacao\App\Http\Controllers\Admin\IluminacaoAdminController::class, 'show'])->name('show');
        });
    }

    // Materiais
    if (Module::isEnabled('Materiais')) {
        Route::prefix('materiais')->name('materiais.')->group(function () {
            Route::get('/', [\Modules\Materiais\App\Http\Controllers\Admin\MateriaisAdminController::class, 'index'])->name('index');
            Route::get('/solicitar', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'create'])->name('solicitar.create');
            Route::post('/solicitar/gerar-pdf', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'gerarPdf'])->name('solicitar.gerar-pdf');
            Route::post('/solicitar/visualizar-pdf', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'visualizarPdf'])->name('solicitar.visualizar-pdf');
            Route::get('/solicitacoes', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'index'])->name('solicitacoes.index');
            Route::get('/solicitacoes/{id}', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'show'])->name('solicitacoes.show');
            Route::get('/solicitacoes-campo', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitacoesCampoController::class, 'index'])->name('solicitacoes-campo.index');
            Route::get('/solicitacoes-campo/{id}/processar', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitacoesCampoController::class, 'processar'])->name('solicitacoes-campo.processar');
            Route::post('/solicitacoes-campo/{id}/cancelar', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitacoesCampoController::class, 'cancelar'])->name('solicitacoes-campo.cancelar');

            // Categorias
            Route::prefix('categorias')->name('categorias.')->group(function () {
                Route::get('/', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'index'])->name('index');
                Route::get('/create', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'create'])->name('create');
                Route::post('/', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'store'])->name('store');
                Route::get('/{categoria}/edit', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'edit'])->name('edit');
                Route::put('/{categoria}', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'update'])->name('update');
                Route::delete('/{categoria}', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'destroy'])->name('destroy');

                // Subcategorias and Campos nesting can be further simplified if needed, but keeping for now
            });

            Route::get('/{id}', [\Modules\Materiais\App\Http\Controllers\Admin\MateriaisAdminController::class, 'show'])->name('show');
        });
    }

    // Recursos Hidrológicos
    if (Module::isEnabled('Pocos')) {
        Route::get('/pocos', [\Modules\Pocos\App\Http\Controllers\Admin\PocosAdminController::class, 'index'])->name('pocos.index');
        Route::get('/pocos/{id}', [\Modules\Pocos\App\Http\Controllers\Admin\PocosAdminController::class, 'show'])->name('pocos.show');
    }

    if (Module::isEnabled('Agua')) {
        Route::get('/agua', [\Modules\Agua\App\Http\Controllers\Admin\AguaAdminController::class, 'index'])->name('agua.index');
        Route::get('/agua/{id}', [\Modules\Agua\App\Http\Controllers\Admin\AguaAdminController::class, 'show'])->name('agua.show');
    }

    // Agricultura
    if (Module::isEnabled('ProgramasAgricultura')) {
        Route::prefix('programas-agricultura')->name('programas-agricultura.')->group(function () {
            Route::resource('programas', \Modules\ProgramasAgricultura\App\Http\Controllers\Admin\ProgramasAdminController::class);
            Route::resource('eventos', \Modules\ProgramasAgricultura\App\Http\Controllers\Admin\EventosAdminController::class);
            Route::resource('beneficiarios', \Modules\ProgramasAgricultura\App\Http\Controllers\Admin\BeneficiariosAdminController::class)->only(['index', 'show', 'destroy']);
            Route::post('beneficiarios/{id}/status', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\BeneficiariosAdminController::class, 'updateStatus'])->name('beneficiarios.update-status');
            Route::resource('inscricoes', \Modules\ProgramasAgricultura\App\Http\Controllers\Admin\InscricoesEventosAdminController::class)->only(['index', 'show', 'destroy']);
            Route::post('inscricoes/{id}/status', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\InscricoesEventosAdminController::class, 'updateStatus'])->name('inscricoes.update-status');

            // Gestão de Permissões (quem opera qual programa)
            Route::get('permissao', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\PermissoesAdminController::class, 'index'])->name('permissao.index');
            Route::post('permissao', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\PermissoesAdminController::class, 'store'])->name('permissao.store');
        });
    }

    // CAF
    if (Module::isEnabled('CAF')) {
        Route::prefix('caf')->name('caf.')->group(function () {
            Route::get('/', [\Modules\CAF\App\Http\Controllers\AdminCAFController::class, 'index'])->name('index');
            Route::get('/{cadastro}', [\Modules\CAF\App\Http\Controllers\AdminCAFController::class, 'show'])->name('show');
            Route::post('/{cadastro}/aprovar', [\Modules\CAF\App\Http\Controllers\AdminCAFController::class, 'aprovar'])->name('aprovar');
            Route::post('/{cadastro}/rejeitar', [\Modules\CAF\App\Http\Controllers\AdminCAFController::class, 'rejeitar'])->name('rejeitar');
            Route::post('/{cadastro}/enviar-caf', [\Modules\CAF\App\Http\Controllers\AdminCAFController::class, 'enviarCAF'])->name('enviar-caf');
            Route::delete('/{cadastro}', [\Modules\CAF\App\Http\Controllers\AdminCAFController::class, 'destroy'])->name('destroy');
        });
    }

    // Relatórios
    if (Module::isEnabled('Relatorios')) {
        Route::prefix('relatorios')->name('relatorios.')->group(function () {
            Route::get('/', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'index'])->name('index');
            Route::get('/dashboard', [\Modules\Relatorios\App\Http\Controllers\RelatoriosController::class, 'dashboard'])->name('dashboard');
            // Add other specific report routes here as grouped
        });
    }

});

// Rota para parar a personificação - disponível para qualquer usuário autenticado
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/stop-impersonation', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'stopImpersonating'])->name('stop-impersonation');
});
