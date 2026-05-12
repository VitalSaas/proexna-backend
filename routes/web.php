<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\ServiceController;
use App\Http\Controllers\Web\ContactController;

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
