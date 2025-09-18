<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExternalMovieController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // 📌 Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 📌 CRUD de películas LOCALES
    Route::resource('movies', MovieController::class);

    // 📌 Películas desde OMDb API (cambiar el prefijo para no chocar con el CRUD)
    Route::get('/external-movies', [ExternalMovieController::class, 'searchForm'])->name('external-movies.index');
    Route::get('/external-movies/search', [ExternalMovieController::class, 'search'])->name('external-movies.search');

    // 📌 Favoritos
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // 📌 Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
