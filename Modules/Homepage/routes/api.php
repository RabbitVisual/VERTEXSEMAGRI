<?php

use Illuminate\Support\Facades\Route;
use Modules\Homepage\App\Http\Controllers\HomepageController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('homepages', HomepageController::class)->names('homepage');
});
