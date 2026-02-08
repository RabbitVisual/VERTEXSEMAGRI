<?php

use Illuminate\Support\Facades\Route;
use Modules\Homepage\App\Http\Controllers\HomepageController;
use Modules\Homepage\App\Http\Controllers\PublicPortalController;
use Modules\Homepage\App\Http\Controllers\PortalAgricultorController;

// Homepage principal
Route::get('/', [HomepageController::class, 'index'])->name('homepage');

// Páginas Legais
Route::get('/privacidade', [HomepageController::class, 'privacidade'])->name('privacidade');
Route::get('/termos', [HomepageController::class, 'termos'])->name('termos');
Route::get('/sobre', [HomepageController::class, 'sobre'])->name('sobre');
Route::get('/desenvolvedor', [HomepageController::class, 'desenvolvedor'])->name('desenvolvedor');

// Rotas públicas do Portal de Transparência (Infraestrutura)
Route::prefix('portal')->name('portal.')->group(function () {
    Route::get('/', [PublicPortalController::class, 'index'])->name('index');
    Route::get('/localidade/{id}', [PublicPortalController::class, 'localidade'])->name('localidade');
    Route::get('/api/infraestrutura', [PublicPortalController::class, 'apiInfraestrutura'])->name('api.infraestrutura');
    Route::get('/api/estatisticas', [PublicPortalController::class, 'apiEstatisticas'])->name('api.estatisticas');
});

// Rotas públicas do Portal do Agricultor (apenas se o módulo ProgramasAgricultura estiver ativo)
if (\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura')) {
    Route::prefix('portal-agricultor')->name('portal.agricultor.')->group(function () {
        Route::get('/', [PortalAgricultorController::class, 'index'])->name('index');
        Route::get('/consultar', function () {
            return redirect(route('portal.agricultor.index') . '#consultar', 301);
        })->name('consultar.get');
        Route::post('/consultar', [PortalAgricultorController::class, 'consultar'])->name('consultar');
        Route::get('/programas', [PortalAgricultorController::class, 'programas'])->name('programas');
        Route::get('/programa/{id}', [PortalAgricultorController::class, 'programa'])->name('programa');
        Route::get('/eventos', [PortalAgricultorController::class, 'eventos'])->name('eventos');
        Route::get('/evento/{id}', [PortalAgricultorController::class, 'evento'])->name('evento');
        Route::get('/calendario', [PortalAgricultorController::class, 'calendario'])->name('calendario');
        Route::get('/api/programas', [PortalAgricultorController::class, 'apiProgramas'])->name('api.programas');
        Route::get('/api/eventos', [PortalAgricultorController::class, 'apiEventos'])->name('api.eventos');
    });
}
