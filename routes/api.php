<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\DemandasApiController;
use App\Http\Controllers\Api\OrdensApiController;
use App\Http\Controllers\Api\LocalidadesApiController;
use App\Http\Controllers\Api\MateriaisApiController;
use App\Http\Controllers\Api\EquipesApiController;
use App\Http\Controllers\Api\CampoApiController;
use App\Http\Controllers\Api\SystemApiController;

/*
|--------------------------------------------------------------------------
| API Routes (Security Hardened & Modular)
|--------------------------------------------------------------------------
|
| Aqui são registradas as rotas da API v1.
| Estrutura: Público -> Autenticação -> Protegido -> Módulos.
|
*/

Route::prefix('v1')->group(function () {

    // =========================================================================
    // 1. ROTAS PÚBLICAS & DIAGNÓSTICO
    // =========================================================================

    // Documentação
    Route::get('/docs', function () {
        return redirect()->route('api.documentation');
    })->name('api.docs');

    // Health & Info
    Route::get('/info', function () {
        return response()->json([
            'name' => 'VERTEXSEMAGRI API',
            'version' => '1.0.26',
            'status' => 'stable',
            'documentation' => route('api.documentation'),
        ]);
    });

    Route::get('/health', [SystemApiController::class, 'health'])->name('api.health');
    Route::post('/log-error', [SystemApiController::class, 'logError'])->name('api.log-error');

    // Localidades (Público - Leitura)
    if (Module::isEnabled('Localidades')) {
        Route::prefix('localidades')->group(function () {
            Route::get('/', [LocalidadesApiController::class, 'index'])->name('api.localidades.index');
            Route::get('/{id}', [LocalidadesApiController::class, 'show'])->name('api.localidades.public.show');
        });
    }

    // =========================================================================
    // 2. AUTENTICAÇÃO (Rate Limited)
    // =========================================================================

    Route::prefix('auth')->group(function () {
        // Anti-brute-force protection
        Route::post('/login', [AuthApiController::class, 'login'])
            ->middleware('throttle:login')
            ->name('api.auth.login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.auth.logout');
            Route::get('/me', [AuthApiController::class, 'me'])->name('api.auth.me');
            Route::post('/revoke-all', [AuthApiController::class, 'revokeAllTokens'])->name('api.auth.revoke-all');
        });
    });

    // =========================================================================
    // 3. ROTAS PROTEGIDAS (Sanctum)
    // =========================================================================

    Route::middleware('auth:sanctum')->group(function () {

        // Demandas
        if (Module::isEnabled('Demandas')) {
            Route::prefix('demandas')->group(function () {
                Route::get('/', [DemandasApiController::class, 'index'])->name('api.demandas.index');
                Route::get('/stats', [DemandasApiController::class, 'stats'])->name('api.demandas.stats');
                Route::get('/{id}', [DemandasApiController::class, 'show'])->name('api.demandas.show');
                Route::post('/', [DemandasApiController::class, 'store'])->name('api.demandas.store');
                Route::put('/{id}', [DemandasApiController::class, 'update'])->name('api.demandas.update');
                Route::delete('/{id}', [DemandasApiController::class, 'destroy'])->name('api.demandas.destroy');
            });
        }

        // Ordens de Serviço
        if (Module::isEnabled('Ordens')) {
            Route::prefix('ordens')->group(function () {
                Route::get('/', [OrdensApiController::class, 'index'])->name('api.ordens.index');
                Route::get('/stats', [OrdensApiController::class, 'stats'])->name('api.ordens.stats');
                Route::get('/{id}', [OrdensApiController::class, 'show'])->name('api.ordens.show');
                Route::post('/', [OrdensApiController::class, 'store'])->name('api.ordens.store');
                Route::put('/{id}', [OrdensApiController::class, 'update'])->name('api.ordens.update');
                Route::delete('/{id}', [OrdensApiController::class, 'destroy'])->name('api.ordens.destroy');
            });
        }

        // Materiais
        if (Module::isEnabled('Materiais')) {
            Route::prefix('materiais')->group(function () {
                Route::get('/', [MateriaisApiController::class, 'index'])->name('api.materiais.index');
                Route::get('/{id}', [MateriaisApiController::class, 'show'])->name('api.materiais.show');
            });
        }

        // Equipes
        if (Module::isEnabled('Equipes')) {
            Route::prefix('equipes')->group(function () {
                Route::get('/', [EquipesApiController::class, 'index'])->name('api.equipes.index');
                Route::get('/{id}', [EquipesApiController::class, 'show'])->name('api.equipes.show');
            });
        }

        // =====================================================================
        // 4. OPERAÇÕES DE CAMPO (Mobile Sync)
        // =====================================================================
        Route::prefix('campo')->middleware('role:campo')->group(function () {
            Route::get('/ordens', [CampoApiController::class, 'ordens'])->name('api.campo.ordens');
            Route::get('/materiais', [CampoApiController::class, 'materiais'])->name('api.campo.materiais');
            Route::get('/localidades', [CampoApiController::class, 'localidades'])->name('api.campo.localidades');
            Route::get('/equipes', [CampoApiController::class, 'equipes'])->name('api.campo.equipes');
            Route::post('/sync', [CampoApiController::class, 'sync'])->name('api.campo.sync');
            Route::get('/sync-history', [CampoApiController::class, 'syncHistory'])->name('api.campo.sync-history');
        });

    });

    // =========================================================================
    // 5. EXTENSÕES DINÂMICAS DE MÓDULOS
    // =========================================================================

    // Chat
    if (Module::isEnabled('Chat')) {
        $chatApiRoutesPath = module_path('Chat', '/routes/api.php');
        if ($chatApiRoutesPath && file_exists($chatApiRoutesPath)) {
            require $chatApiRoutesPath;
        }
    }
});
