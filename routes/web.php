<?php

use Illuminate\Support\Facades\Route;
use Nwidart\Modules\Facades\Module;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\DocumentationController;

/*
|--------------------------------------------------------------------------
| Web Routes - Main Router
|--------------------------------------------------------------------------
*/

// =========================================================================
// Section 1: Core & Auth
// =========================================================================

// Authentication Routes (Login, Register, Password Reset, etc.)
require __DIR__.'/auth.php';

// Authenticated General Routes
Route::middleware(['auth'])->group(function () {
    // Standard Dashboard (for users without specific roles)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Global Profile Management (if applicable)
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

// =========================================================================
// Section 2: Public & API Docs
// =========================================================================

// API Documentation
Route::get('/api/documentation', [DocumentationController::class, 'index'])->name('api.documentation');
Route::get('/api/documentation.json', [DocumentationController::class, 'json'])->name('api.documentation.json');

// =========================================================================
// Section 3: Domain Routes (Role-Based Panels)
// =========================================================================

require __DIR__.'/admin.php';
require __DIR__.'/co-admin.php';
require __DIR__.'/campo.php';
require __DIR__.'/consulta.php';
require __DIR__.'/comunidade.php';

// =========================================================================
// Section 4: Module Dynamic Routes (Theme & Extensions)
// =========================================================================

// Módulo Homepage
if (Module::isEnabled('Homepage')) {
    $homepageRoutes = module_path('Homepage', '/routes/web.php');
    if (file_exists($homepageRoutes)) {
        require $homepageRoutes;
    }
}

// Módulo CAF
if (Module::isEnabled('CAF')) {
    $cafRoutes = module_path('CAF', '/routes/web.php');
    if (file_exists($cafRoutes)) {
        require $cafRoutes;
    }
}

// Módulo Chat
if (Module::isEnabled('Chat')) {
    $chatRoutes = module_path('Chat', '/routes/web.php');
    if (file_exists($chatRoutes)) {
        require $chatRoutes;
    }
}
