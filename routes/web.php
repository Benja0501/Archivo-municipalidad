<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DocumentSeriesController;
use App\Http\Controllers\Admin\TomoController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\DocumentController;


Route::get('/', function () {
    return view('welcome');
});

// Rutas autenticadas
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas de perfil (las que pide navigation.blade.php)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas solo para el super-admin (panel admin)
    // Route::middleware('role:super-admin')->group(function () {
    //     Route::get('/admin', function () {
    //         return view('admin.index');
    //     })->name('admin.index');
    // });
    Route::middleware('role:super-admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/', function () {
                return view('admin.index');
            })->name('index');

            // CRUD de usuarios
            Route::resource('users', UserController::class);

            // CRUD de series documentales
            Route::resource('series', DocumentSeriesController::class)->names('series');
            // Route::resource('series-documentales', DocumentSeriesController::class)
            //     ->parameters(['series-documentales' => 'series'])
            //     ->names('series');

            // Catálogo simple de áreas (opcional pero recomendable)
            Route::resource('areas', AreaController::class)->names('areas');

            // Tomos
            Route::resource('tomos', TomoController::class)->names('tomos');

            //Areas
            Route::resource('areas', AreaController::class)->names('areas');

            //Documento

            Route::resource('documents', DocumentController::class)->names('documents');
        });
});


require __DIR__ . '/auth.php';
