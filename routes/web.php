<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// Rotas do Módulo Homepage (apenas se o módulo estiver ativo)
if (\Nwidart\Modules\Facades\Module::isEnabled('Homepage')) {
    $homepageRoutesPath = module_path('Homepage', '/routes/web.php');
    if ($homepageRoutesPath && file_exists($homepageRoutesPath)) {
        require $homepageRoutesPath;
    }
}

// Rotas públicas (sem autenticação)

// Rotas autenticadas gerais (para usuários sem role específica)
Route::middleware(['auth'])->group(function () {
    // Dashboard padrão (apenas para usuários sem role específica)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';

// Documentação da API
Route::get('/api/documentation', [\App\Http\Controllers\Api\DocumentationController::class, 'index'])->name('api.documentation');
Route::get('/api/documentation.json', [\App\Http\Controllers\Api\DocumentationController::class, 'json'])->name('api.documentation.json');
require __DIR__.'/admin.php';
require __DIR__.'/co-admin.php';
require __DIR__.'/campo.php';
require __DIR__.'/consulta.php';
require __DIR__.'/comunidade.php';

// Rotas do Módulo CAF (apenas se o módulo estiver ativo)
if (\Nwidart\Modules\Facades\Module::isEnabled('CAF')) {
    $cafRoutesPath = module_path('CAF', '/routes/web.php');
    if ($cafRoutesPath && file_exists($cafRoutesPath)) {
        require $cafRoutesPath;
    }
}

// Rotas do Módulo Chat (apenas se o módulo estiver ativo)
if (\Nwidart\Modules\Facades\Module::isEnabled('Chat')) {
    $chatRoutesPath = module_path('Chat', '/routes/web.php');
    if ($chatRoutesPath && file_exists($chatRoutesPath)) {
        require $chatRoutesPath;
    }
}
