<?php

use App\Http\Controllers\Api\ChatbotController;
use Illuminate\Support\Facades\Route;

Route::prefix('chatbot')->group(function () {
    Route::get('projects', [ChatbotController::class, 'projects']);
    Route::get('sectors', [ChatbotController::class, 'sectors']);
    Route::get('testimonials', [ChatbotController::class, 'testimonials']);
    Route::get('vacancies', [ChatbotController::class, 'vacancies']);
    Route::get('stats', [ChatbotController::class, 'stats']);
    Route::get('why-choose-us', [ChatbotController::class, 'whyChooseUs']);
    Route::get('posts', [ChatbotController::class, 'posts']);
    Route::get('company', [ChatbotController::class, 'company']);

    Route::post('prospects', [ChatbotController::class, 'storeProspect'])
        ->middleware('throttle:10,1');
});
