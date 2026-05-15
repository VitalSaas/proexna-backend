<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\ProjectController;
use App\Http\Controllers\Web\CareerController;
use App\Http\Controllers\Web\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// Homepage
Route::get("/", [HomeController::class, "index"])->name("home");

// Services Routes
Route::prefix("servicios")->name("services.")->group(function () {
    Route::get("/", [ServiceController::class, "index"])->name("index");
    Route::get("/categoria/{category}", [ServiceController::class, "category"])->name("category");
    Route::get("/{service:slug}", [ServiceController::class, "show"])->name("show");
});

// Projects Routes
Route::prefix("proyectos")->name("projects.")->group(function () {
    Route::get("/", [ProjectController::class, "index"])->name("index");
    Route::get("/{project:slug}", [ProjectController::class, "show"])->name("show");
});

// Blog
Route::prefix("blog")->name("blog.")->group(function () {
    Route::get("/", [BlogController::class, "index"])->name("index");
    Route::get("/{post:slug}", [BlogController::class, "show"])->name("show");
});

// Careers / Bolsa de Trabajo
Route::prefix("trabajos")->name("careers.")->group(function () {
    Route::get("/", [CareerController::class, "index"])->name("index");
    Route::post("/postularse", [CareerController::class, "storeOpen"])->name("storeOpen");
    Route::get("/{vacancy:slug}", [CareerController::class, "show"])->name("show");
    Route::post("/{vacancy:slug}/postular", [CareerController::class, "apply"])->name("apply");
});

// Contact Routes
Route::prefix("contacto")->name("contact.")->group(function () {
    Route::get("/", [ContactController::class, "index"])->name("index");
    Route::post("/", [ContactController::class, "store"])->name("store");
});

// Additional pages (for future expansion)
Route::view("/nosotros", "pages.about")->name("about");
Route::view("/privacidad", "pages.privacy")->name("privacy");
Route::view("/terminos", "pages.terms")->name("terms");
Route::view("/test", "test")->name("test");
