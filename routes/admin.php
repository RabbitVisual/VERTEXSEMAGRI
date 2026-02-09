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

    // Roles
    Route::resource('roles', RoleController::class);

    // Permissões
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');

    // Configurações
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

    // Updates
    Route::get('/updates', [\App\Http\Controllers\Admin\UpdateController::class, 'index'])->name('updates.index');
    Route::get('/updates/create', [\App\Http\Controllers\Admin\UpdateController::class, 'create'])->name('updates.create');
    Route::post('/updates/upload', [\App\Http\Controllers\Admin\UpdateController::class, 'upload'])->name('updates.upload');
    Route::get('/updates/{id}', [\App\Http\Controllers\Admin\UpdateController::class, 'show'])->name('updates.show');
    Route::post('/updates/{id}/apply', [\App\Http\Controllers\Admin\UpdateController::class, 'apply'])->name('updates.apply');
    Route::post('/updates/{id}/rollback', [\App\Http\Controllers\Admin\UpdateController::class, 'rollback'])->name('updates.rollback');
    Route::delete('/updates/{id}', [\App\Http\Controllers\Admin\UpdateController::class, 'destroy'])->name('updates.destroy');
    Route::get('/updates/{id}/backup/download', [\App\Http\Controllers\Admin\UpdateController::class, 'downloadBackup'])->name('updates.download-backup');

    // Carousel
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

    // Formulários Manuais (para manutenção)
    Route::prefix('formularios')->name('formularios.')->group(function () {
        Route::get('/demanda', [FormularioManualController::class, 'gerarFormularioDemanda'])->name('demanda');
        Route::get('/ordem', [FormularioManualController::class, 'gerarFormularioOrdem'])->name('ordem');
    });

    // Homepage Management (apenas se o módulo estiver ativo)
    if (\Nwidart\Modules\Facades\Module::isEnabled('Homepage')) {
        Route::get('/homepage', [\Modules\Homepage\App\Http\Controllers\Admin\HomepageAdminController::class, 'index'])->name('homepage.index');
        Route::put('/homepage', [\Modules\Homepage\App\Http\Controllers\Admin\HomepageAdminController::class, 'update'])->name('homepage.update');
        Route::post('/homepage/toggle-section', [\Modules\Homepage\App\Http\Controllers\Admin\HomepageAdminController::class, 'toggleSection'])->name('homepage.toggle-section');
    }

    // Blog Management (apenas se o módulo estiver ativo)
    if (\Nwidart\Modules\Facades\Module::isEnabled('Blog')) {
        // Rotas específicas primeiro (antes do resource para evitar conflitos)
        // Categorias
        Route::prefix('blog/categorias')->name('blog.categories.')->group(function () {
            Route::get('/', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'update'])->name('update');
            Route::delete('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'destroy'])->name('destroy');
        });
        Route::post('/blog/categorias/{id}/toggle-status', [\Modules\Blog\App\Http\Controllers\Admin\BlogCategoriesAdminController::class, 'toggleStatus'])->name('blog.categories.toggle-status');

        // Tags
        Route::prefix('blog/tags')->name('blog.tags.')->group(function () {
            Route::get('/', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'index'])->name('index');
            Route::get('/create', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'create'])->name('create');
            Route::post('/', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'store'])->name('store');
            Route::get('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'edit'])->name('edit');
            Route::put('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'update'])->name('update');
            Route::delete('/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'destroy'])->name('destroy');
        });
        Route::post('/blog/tags/clean-unused', [\Modules\Blog\App\Http\Controllers\Admin\BlogTagsAdminController::class, 'cleanUnused'])->name('blog.tags.clean-unused');

        // Comentários
        Route::get('/blog/comentarios', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'index'])->name('blog.comments.index');
        Route::get('/blog/comentarios/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'show'])->name('blog.comments.show');
        Route::post('/blog/comentarios/{id}/aprovar', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'approve'])->name('blog.comments.approve');
        Route::post('/blog/comentarios/{id}/rejeitar', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'reject'])->name('blog.comments.reject');
        Route::delete('/blog/comentarios/{id}', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'destroy'])->name('blog.comments.destroy');
        Route::post('/blog/comentarios/bulk/aprovar', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'bulkApprove'])->name('blog.comments.bulk.approve');
        Route::post('/blog/comentarios/bulk/rejeitar', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'bulkReject'])->name('blog.comments.bulk.reject');
        Route::delete('/blog/comentarios/bulk/excluir', [\Modules\Blog\App\Http\Controllers\Admin\BlogCommentsAdminController::class, 'bulkDelete'])->name('blog.comments.bulk.delete');

        // Integração e relatórios automáticos
        Route::post('/blog/generate-monthly-report', [\Modules\Blog\App\Http\Controllers\BlogIntegrationController::class, 'generateMonthlyReport'])->name('blog.generate-monthly-report');

        // Upload de imagens para o editor
        Route::post('/blog/upload-image', [\Modules\Blog\App\Http\Controllers\Admin\BlogAdminController::class, 'uploadEditorImage'])->name('blog.upload-image');

        // Posts - Route::resource deve vir POR ÚLTIMO para evitar conflitos
        // Importar Demanda
        Route::get('/blog/import-demanda', [\Modules\Blog\App\Http\Controllers\Admin\BlogAdminController::class, 'importDemanda'])->name('blog.import-demanda');

        // Redact Image
        Route::post('/blog/redact-image', [\Modules\Blog\App\Http\Controllers\Admin\BlogAdminController::class, 'redactImage'])->name('blog.redact-image');

        Route::resource('blog', \Modules\Blog\App\Http\Controllers\Admin\BlogAdminController::class);
    }


    // Notificações
    Route::get('/notificacoes', [\Modules\Notificacoes\App\Http\Controllers\Admin\NotificacoesAdminController::class, 'index'])->name('notificacoes.index');
    Route::get('/notificacoes/create', [\Modules\Notificacoes\App\Http\Controllers\Admin\NotificacoesAdminController::class, 'create'])->name('notificacoes.create');
    Route::post('/notificacoes', [\Modules\Notificacoes\App\Http\Controllers\Admin\NotificacoesAdminController::class, 'store'])->name('notificacoes.store');
    Route::get('/notificacoes/{id}', [\Modules\Notificacoes\App\Http\Controllers\Admin\NotificacoesAdminController::class, 'show'])->name('notificacoes.show');
    Route::delete('/notificacoes/{id}', [\Modules\Notificacoes\App\Http\Controllers\Admin\NotificacoesAdminController::class, 'destroy'])->name('notificacoes.destroy');

// Chat (apenas se o módulo estiver ativo)
if (\Nwidart\Modules\Facades\Module::isEnabled('Chat')) {
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'index'])->name('index');
        Route::get('/config', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'config'])->name('config');
        Route::put('/config', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'updateConfig'])->name('config.update');
        Route::get('/{id}', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'show'])->name('show');
        Route::post('/{id}/assign', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'assign'])->name('assign');
        Route::post('/{id}/close', [\Modules\Chat\App\Http\Controllers\Admin\ChatAdminController::class, 'close'])->name('close');

        // Rotas AJAX para chat (usando autenticação web)
        Route::prefix('api')->name('api.')->group(function () {
            Route::get('/session/{sessionId}/messages', [\Modules\Chat\App\Http\Controllers\Api\ChatApiController::class, 'getMessages'])->name('session.messages');
            Route::post('/session/{sessionId}/message', [\Modules\Chat\App\Http\Controllers\Api\ChatApiController::class, 'sendMessage'])->name('session.message');
            Route::post('/session/{sessionId}/typing', [\Modules\Chat\App\Http\Controllers\Api\ChatApiController::class, 'sendTypingIndicator'])->name('session.typing');
            Route::post('/session/{sessionId}/read', [\Modules\Chat\App\Http\Controllers\Api\ChatApiController::class, 'markAsRead'])->name('session.read');
        });
    });
}

    // Módulos - Rotas Admin
    // Demandas
    Route::get('/demandas', [\Modules\Demandas\App\Http\Controllers\Admin\DemandasAdminController::class, 'index'])->name('demandas.index');
    Route::get('/demandas/{id}', [\Modules\Demandas\App\Http\Controllers\Admin\DemandasAdminController::class, 'show'])->name('demandas.show');
    Route::get('/demandas/{id}/interessados', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'interessados'])->name('demandas.interessados');
    Route::delete('/demandas/{demandaId}/interessados/{interessadoId}', [\Modules\Demandas\App\Http\Controllers\DemandasController::class, 'removerInteressado'])->name('demandas.remover-interessado');

    // Ordens
    Route::get('/ordens', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'index'])->name('ordens.index');
    Route::get('/ordens/{id}', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'show'])->name('ordens.show');
    Route::post('/ordens/{id}/materiais', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'adicionarMaterial'])->name('ordens.materiais.adicionar');
    Route::delete('/ordens/{id}/materiais/{materialId}', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'removerMaterial'])->name('ordens.materiais.remover');
    Route::post('/ordens/{id}/finalizar', [\Modules\Ordens\App\Http\Controllers\Admin\OrdensAdminController::class, 'finalizar'])->name('ordens.finalizar');

    // Localidades
    Route::get('/localidades', [\Modules\Localidades\App\Http\Controllers\Admin\LocalidadesAdminController::class, 'index'])->name('localidades.index');
    Route::get('/localidades/{id}', [\Modules\Localidades\App\Http\Controllers\Admin\LocalidadesAdminController::class, 'show'])->name('localidades.show');

    // Pessoas
    Route::get('/pessoas', [\Modules\Pessoas\App\Http\Controllers\Admin\PessoasAdminController::class, 'index'])->name('pessoas.index');
    Route::get('/pessoas/{id}', [\Modules\Pessoas\App\Http\Controllers\Admin\PessoasAdminController::class, 'show'])->name('pessoas.show');

    // Equipes
    Route::get('/equipes', [\Modules\Equipes\App\Http\Controllers\Admin\EquipesAdminController::class, 'index'])->name('equipes.index');
    Route::get('/equipes/{id}', [\Modules\Equipes\App\Http\Controllers\Admin\EquipesAdminController::class, 'show'])->name('equipes.show');

    // Estradas
    Route::get('/estradas', [\Modules\Estradas\App\Http\Controllers\Admin\EstradasAdminController::class, 'index'])->name('estradas.index');
    Route::get('/estradas/{id}', [\Modules\Estradas\App\Http\Controllers\Admin\EstradasAdminController::class, 'show'])->name('estradas.show');

    // Funcionários
    Route::get('/funcionarios', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionariosAdminController::class, 'index'])->name('funcionarios.index');
    Route::get('/funcionarios/{id}', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionariosAdminController::class, 'show'])->name('funcionarios.show');

    // Monitoramento de Status em Tempo Real
    Route::prefix('funcionarios/status')->name('funcionarios.status.')->group(function () {
        Route::get('/', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'index'])->name('index');
        Route::get('/atualizar', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'atualizar'])->name('atualizar');
        Route::post('/{id}/forcar-liberacao', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'forcarLiberacao'])->name('forcar-liberacao');
        Route::post('/{id}/status', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'atualizarStatus'])->name('atualizar-status');
        Route::get('/{id}/detalhes', [\Modules\Funcionarios\App\Http\Controllers\Admin\FuncionarioStatusAdminController::class, 'detalhes'])->name('detalhes');
    });

    // Gerenciamento de Senhas de Funcionários
    Route::get('/funcionarios/{id}/senha', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'show'])->name('funcionarios.senha.show');
    Route::post('/funcionarios/{id}/senha/gerar', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'gerarSenha'])->name('funcionarios.senha.gerar');
    Route::post('/funcionarios/{id}/senha/alterar', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'alterarSenha'])->name('funcionarios.senha.alterar');
    Route::get('/funcionarios/{id}/senha/comprovante', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'comprovante'])->name('funcionarios.senha.comprovante');
    Route::post('/funcionarios/{id}/senha/visualizada', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'marcarVisualizada'])->name('funcionarios.senha.visualizada');
    Route::get('/funcionarios/{id}/login-as', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'loginAs'])->name('funcionarios.login-as');
    // Rota stop-impersonation movida para fora do grupo role:admin abaixo

    // Iluminação (apenas se o módulo estiver ativo)
    if (\Nwidart\Modules\Facades\Module::isEnabled('Iluminacao')) {
        Route::prefix('iluminacao')->name('iluminacao.')->group(function () {
            Route::get('/', [\Modules\Iluminacao\App\Http\Controllers\Admin\IluminacaoAdminController::class, 'index'])->name('index');
            Route::get('/export', [\Modules\Iluminacao\App\Http\Controllers\Admin\IluminacaoAdminController::class, 'export'])->name('export');

            // Postes management
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
    Route::get('/materiais', [\Modules\Materiais\App\Http\Controllers\Admin\MateriaisAdminController::class, 'index'])->name('materiais.index');

    // Solicitação de Materiais (deve vir antes de /materiais/{id} para evitar conflito)
    Route::get('/materiais/solicitar', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'create'])->name('materiais.solicitar.create');
    Route::post('/materiais/solicitar/gerar-pdf', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'gerarPdf'])->name('materiais.solicitar.gerar-pdf');
    Route::post('/materiais/solicitar/visualizar-pdf', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'visualizarPdf'])->name('materiais.solicitar.visualizar-pdf');

    // Lista e visualização de solicitações registradas
    Route::get('/materiais/solicitacoes', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'index'])->name('materiais.solicitacoes.index');
    Route::get('/materiais/solicitacoes/{id}', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitarMaterialController::class, 'show'])->name('materiais.solicitacoes.show');

    // Rotas para gerenciar solicitações do campo
    Route::get('/materiais/solicitacoes-campo', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitacoesCampoController::class, 'index'])->name('materiais.solicitacoes-campo.index');
    Route::get('/materiais/solicitacoes-campo/{id}/processar', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitacoesCampoController::class, 'processar'])->name('materiais.solicitacoes-campo.processar');
    Route::post('/materiais/solicitacoes-campo/{id}/cancelar', [\Modules\Materiais\App\Http\Controllers\Admin\SolicitacoesCampoController::class, 'cancelar'])->name('materiais.solicitacoes-campo.cancelar');

    // Categorias de Materiais (DEVE VIR ANTES de /materiais/{id} para evitar conflito)
    Route::get('/materiais/categorias', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'index'])->name('materiais.categorias.index');
    Route::get('/materiais/categorias/create', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'create'])->name('materiais.categorias.create');
    Route::post('/materiais/categorias', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'store'])->name('materiais.categorias.store');
    Route::get('/materiais/categorias/{categoria}/edit', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'edit'])->name('materiais.categorias.edit');
    Route::put('/materiais/categorias/{categoria}', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'update'])->name('materiais.categorias.update');
    Route::delete('/materiais/categorias/{categoria}', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'destroy'])->name('materiais.categorias.destroy');

    // Subcategorias de Materiais
    Route::get('/materiais/categorias/{categoriaId}/subcategorias', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'subcategoriasIndex'])->name('materiais.categorias.subcategorias.index');
    Route::get('/materiais/categorias/{categoriaId}/subcategorias/create', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'subcategoriasCreate'])->name('materiais.categorias.subcategorias.create');
    Route::post('/materiais/categorias/{categoriaId}/subcategorias', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'subcategoriasStore'])->name('materiais.categorias.subcategorias.store');
    Route::get('/materiais/categorias/{categoriaId}/subcategorias/{subcategoria}/edit', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'subcategoriasEdit'])->name('materiais.categorias.subcategorias.edit');
    Route::put('/materiais/categorias/{categoriaId}/subcategorias/{subcategoria}', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'subcategoriasUpdate'])->name('materiais.categorias.subcategorias.update');
    Route::delete('/materiais/categorias/{categoriaId}/subcategorias/{subcategoria}', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'subcategoriasDestroy'])->name('materiais.categorias.subcategorias.destroy');

    // Campos de Categorias de Materiais
    Route::get('/materiais/categorias/{categoriaId}/subcategorias/{subcategoriaId}/campos', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'camposIndex'])->name('materiais.categorias.campos.index');
    Route::get('/materiais/categorias/{categoriaId}/subcategorias/{subcategoriaId}/campos/create', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'camposCreate'])->name('materiais.categorias.campos.create');
    Route::post('/materiais/categorias/{categoriaId}/subcategorias/{subcategoriaId}/campos', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'camposStore'])->name('materiais.categorias.campos.store');
    Route::get('/materiais/categorias/{categoriaId}/subcategorias/{subcategoriaId}/campos/{campo}/edit', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'camposEdit'])->name('materiais.categorias.campos.edit');
    Route::put('/materiais/categorias/{categoriaId}/subcategorias/{subcategoriaId}/campos/{campo}', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'camposUpdate'])->name('materiais.categorias.campos.update');
    Route::delete('/materiais/categorias/{categoriaId}/subcategorias/{subcategoriaId}/campos/{campo}', [\Modules\Materiais\App\Http\Controllers\Admin\CategoriasAdminController::class, 'camposDestroy'])->name('materiais.categorias.campos.destroy');

    // Esta rota DEVE VIR POR ÚLTIMO para não capturar outras rotas
    Route::get('/materiais/{id}', [\Modules\Materiais\App\Http\Controllers\Admin\MateriaisAdminController::class, 'show'])->name('materiais.show');

    // Poços
    Route::get('/pocos', [\Modules\Pocos\App\Http\Controllers\Admin\PocosAdminController::class, 'index'])->name('pocos.index');
    Route::get('/pocos/{id}', [\Modules\Pocos\App\Http\Controllers\Admin\PocosAdminController::class, 'show'])->name('pocos.show');

    // Água
    Route::get('/agua', [\Modules\Agua\App\Http\Controllers\Admin\AguaAdminController::class, 'index'])->name('agua.index');
    Route::get('/agua/{id}', [\Modules\Agua\App\Http\Controllers\Admin\AguaAdminController::class, 'show'])->name('agua.show');

    // Portal do Agricultor - Programas (apenas se o módulo estiver ativo)
    if (\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura')) {
        Route::get('/programas', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\ProgramasAdminController::class, 'index'])->name('programas.index');
        Route::get('/programas/create', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\ProgramasAdminController::class, 'create'])->name('programas.create');
        Route::post('/programas', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\ProgramasAdminController::class, 'store'])->name('programas.store');
        Route::get('/programas/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\ProgramasAdminController::class, 'show'])->name('programas.show');
        Route::get('/programas/{id}/edit', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\ProgramasAdminController::class, 'edit'])->name('programas.edit');
        Route::put('/programas/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\ProgramasAdminController::class, 'update'])->name('programas.update');
        Route::delete('/programas/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\ProgramasAdminController::class, 'destroy'])->name('programas.destroy');

        // Portal do Agricultor - Eventos
        Route::get('/eventos', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\EventosAdminController::class, 'index'])->name('eventos.index');
        Route::get('/eventos/create', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\EventosAdminController::class, 'create'])->name('eventos.create');
        Route::post('/eventos', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\EventosAdminController::class, 'store'])->name('eventos.store');
        Route::get('/eventos/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\EventosAdminController::class, 'show'])->name('eventos.show');
        Route::get('/eventos/{id}/edit', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\EventosAdminController::class, 'edit'])->name('eventos.edit');
        Route::put('/eventos/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\EventosAdminController::class, 'update'])->name('eventos.update');
        Route::delete('/eventos/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\EventosAdminController::class, 'destroy'])->name('eventos.destroy');

        // Portal do Agricultor - Beneficiários
        Route::get('/beneficiarios', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\BeneficiariosAdminController::class, 'index'])->name('beneficiarios.index');
        Route::get('/beneficiarios/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\BeneficiariosAdminController::class, 'show'])->name('beneficiarios.show');
        Route::post('/beneficiarios/{id}/status', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\BeneficiariosAdminController::class, 'updateStatus'])->name('beneficiarios.update-status');
        Route::delete('/beneficiarios/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\BeneficiariosAdminController::class, 'destroy'])->name('beneficiarios.destroy');

        // Portal do Agricultor - Inscrições em Eventos
        Route::get('/inscricoes', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\InscricoesEventosAdminController::class, 'index'])->name('inscricoes.index');
        Route::get('/inscricoes/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\InscricoesEventosAdminController::class, 'show'])->name('inscricoes.show');
        Route::post('/inscricoes/{id}/status', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\InscricoesEventosAdminController::class, 'updateStatus'])->name('inscricoes.update-status');
        Route::delete('/inscricoes/{id}', [\Modules\ProgramasAgricultura\App\Http\Controllers\Admin\InscricoesEventosAdminController::class, 'destroy'])->name('inscricoes.destroy');
    }
});

// Rota para parar a personificação - disponível para qualquer usuário autenticado
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/stop-impersonation', [\App\Http\Controllers\Admin\FuncionarioSenhaController::class, 'stopImpersonating'])->name('stop-impersonation');
});
