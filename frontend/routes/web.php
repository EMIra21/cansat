<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorDataController;



Route::get('/', [SensorDataController::class, 'index'])->name('sensores.index');
Route::get('/sensores/estadisticas', [SensorDataController::class, 'estadisticas'])->name('sensores.estadisticas');
Route::get('/sensores/rango', [SensorDataController::class, 'datosRango'])->name('sensores.rango');