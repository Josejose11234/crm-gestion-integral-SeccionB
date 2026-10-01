<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

// Redirige la raíz al reporte 1
Route::get('/', function () {
    return redirect()->route('reportes.zonas');
});

// Rutas de reportes
Route::prefix('reportes')->name('reportes.')->group(function () {
    Route::get('/zonas',         [ReportController::class, 'clientesPorZona'])->name('zonas');
    Route::get('/interacciones', [ReportController::class, 'interaccionesPorAsesor'])->name('interacciones');
});