<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTA DE BIENVENIDA PÚBLICA ---
// ANTES: Apuntaba al controlador de login.
// AHORA: Apuntará a la vista 'welcome.blade.php'. Esta será nuestra nueva página de inicio.
Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name('welcome');


// --- RUTAS PROTEGIDAS (SOLO PARA USUARIOS AUTENTICADOS) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('productos', ProductController::class);
    Route::get('/productos/{id}/descargar', [ProductController::class, 'showDischargeForm'])->name('productos.showDischargeForm');
    Route::post('/productos/{id}/descargar', [ProductController::class, 'dischargeStock'])->name('productos.dischargeStock');
    Route::get('/trazabilidad', [ProductController::class, 'showTraceability'])->name('trazabilidad.index');

});

// Este archivo ya contiene las rutas para /login, /register, etc.
require __DIR__.'/auth.php';