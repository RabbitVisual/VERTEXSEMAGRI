<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\DemandasApiController;
use App\Http\Controllers\Api\OrdensApiController;
use App\Http\Controllers\Api\LocalidadesApiController;
use App\Http\Controllers\Api\MateriaisApiController;
use App\Http\Controllers\Api\EquipesApiController;
use App\Http\Controllers\Api\CampoApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// ============================================
// ROTAS PÚBLICAS (Sem autenticação)
// ============================================

Route::prefix('v1')->group(function () {
    // Documentação da API
    Route::get('/docs', function () {
        return redirect()->route('api.documentation');
    })->name('api.docs');

    // Informações da API e Monitoramento
    Route::get('/info', function () {
        return response()->json([
            'name' => 'VERTEXSEMAGRI API',
            'version' => '1.0.0',
            'description' => 'API RESTful para o Sistema Municipal de Gestão',
            'base_url' => url('/api/v1'),
            'documentation' => route('api.documentation'),
        ]);
    });

    Route::get('/health', [\App\Http\Controllers\Api\SystemApiController::class, 'health'])->name('api.health');
    Route::post('/log-error', [\App\Http\Controllers\Api\SystemApiController::class, 'logError'])->name('api.log-error');

    // ============================================
    // AUTENTICAÇÃO
    // ============================================
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthApiController::class, 'login'])->name('api.auth.login');
        Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum')->name('api.auth.logout');
        Route::get('/me', [AuthApiController::class, 'me'])->middleware('auth:sanctum')->name('api.auth.me');
        Route::post('/revoke-all', [AuthApiController::class, 'revokeAllTokens'])->middleware('auth:sanctum')->name('api.auth.revoke-all');
    });

    // ============================================
    // ROTAS PÚBLICAS (Apenas leitura)
    // ============================================

    // Localidades (público - apenas leitura)
    Route::prefix('localidades')->group(function () {
        Route::get('/', [LocalidadesApiController::class, 'index'])->name('api.localidades.index');
        Route::get('/{id}', [LocalidadesApiController::class, 'show'])->name('api.localidades.public.show');
    });

    // ============================================
    // ROTAS PROTEGIDAS (Requer autenticação)
    // ============================================
    Route::middleware('auth:sanctum')->group(function () {

        // Demandas
        Route::prefix('demandas')->group(function () {
            Route::get('/', [DemandasApiController::class, 'index'])->name('api.demandas.index');
            Route::get('/stats', [DemandasApiController::class, 'stats'])->name('api.demandas.stats');
            Route::get('/{id}', [DemandasApiController::class, 'show'])->name('api.demandas.show');
            Route::post('/', [DemandasApiController::class, 'store'])->name('api.demandas.store');
            Route::put('/{id}', [DemandasApiController::class, 'update'])->name('api.demandas.update');
            Route::delete('/{id}', [DemandasApiController::class, 'destroy'])->name('api.demandas.destroy');
        });

        // Ordens de Serviço
        Route::prefix('ordens')->group(function () {
            Route::get('/', [OrdensApiController::class, 'index'])->name('api.ordens.index');
            Route::get('/stats', [OrdensApiController::class, 'stats'])->name('api.ordens.stats');
            Route::get('/{id}', [OrdensApiController::class, 'show'])->name('api.ordens.show');
            Route::post('/', [OrdensApiController::class, 'store'])->name('api.ordens.store');
            Route::put('/{id}', [OrdensApiController::class, 'update'])->name('api.ordens.update');
            Route::delete('/{id}', [OrdensApiController::class, 'destroy'])->name('api.ordens.destroy');
        });

        // Materiais
        Route::prefix('materiais')->group(function () {
            Route::get('/', [MateriaisApiController::class, 'index'])->name('api.materiais.index');
            Route::get('/{id}', [MateriaisApiController::class, 'show'])->name('api.materiais.show');
        });

        // Equipes
        Route::prefix('equipes')->group(function () {
            Route::get('/', [EquipesApiController::class, 'index'])->name('api.equipes.index');
            Route::get('/{id}', [EquipesApiController::class, 'show'])->name('api.equipes.show');
        });
    });

    // ============================================
    // ROTAS DO CAMPO (Middleware específico)
    // ============================================
    Route::prefix('campo')->middleware(['web', 'auth'])->group(function () {
        Route::get('/ordens', [CampoApiController::class, 'ordens'])->name('api.campo.ordens');
        Route::get('/materiais', [CampoApiController::class, 'materiais'])->name('api.campo.materiais');
        Route::get('/localidades', [CampoApiController::class, 'localidades'])->name('api.campo.localidades');
        Route::get('/equipes', [CampoApiController::class, 'equipes'])->name('api.campo.equipes');
        Route::post('/sync', [CampoApiController::class, 'sync'])->name('api.campo.sync');
        Route::get('/sync-history', [CampoApiController::class, 'syncHistory'])->name('api.campo.sync-history');
    });

    // Rotas do Módulo Chat (apenas se o módulo estiver ativo)
    if (\Nwidart\Modules\Facades\Module::isEnabled('Chat')) {
        $chatApiRoutesPath = module_path('Chat', '/routes/api.php');
        if ($chatApiRoutesPath && file_exists($chatApiRoutesPath)) {
            require $chatApiRoutesPath;
        }
    }
});
