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
// Ahora la ruta principal apunta al formulario de login.
Route::get('/', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('welcome');


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

require __DIR__.'/auth.php';
