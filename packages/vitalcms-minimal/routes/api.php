<?php

use Illuminate\Support\Facades\Route;
use VitalSaaS\VitalCMSMinimal\Http\Controllers\Api\HeroSectionController;
use VitalSaaS\VitalCMSMinimal\Http\Controllers\Api\ServiceController;
use VitalSaaS\VitalCMSMinimal\Http\Controllers\Api\ContactController;

/*
|--------------------------------------------------------------------------
| VitalCMS Minimal API Routes
|--------------------------------------------------------------------------
|
| API routes for frontend integration (Next.js, Vue, React, etc.)
|
*/

Route::prefix('cms')->group(function () {

    // Hero Sections API
    Route::get('hero-sections', [HeroSectionController::class, 'index'])
        ->name('cms.hero-sections.index');

    Route::get('hero-sections/{heroSection}', [HeroSectionController::class, 'show'])
        ->name('cms.hero-sections.show');

    // Services API
    Route::get('services', [ServiceController::class, 'index'])
        ->name('cms.services.index');

    // Specific routes BEFORE parameterized routes
    Route::get('services/featured', [ServiceController::class, 'featured'])
        ->name('cms.services.featured');

    Route::get('services/category/{category}', [ServiceController::class, 'byCategory'])
        ->name('cms.services.by-category');

    // Parameterized route LAST
    Route::get('services/{service}', [ServiceController::class, 'show'])
        ->name('cms.services.show');

    // Contact Form API
    Route::get('contact/config', [ContactController::class, 'config'])
        ->name('cms.contact.config'); // Configuration for frontend

    Route::post('contact', [ContactController::class, 'store'])
        ->name('cms.contact.store')
        ->middleware(['throttle:5,1']); // 5 submissions per minute

    // Contact Submissions (for admin)
    Route::get('contact/submissions', [ContactController::class, 'index'])
        ->name('cms.contact.index')
        ->middleware(['auth:sanctum']); // Requires authentication

});