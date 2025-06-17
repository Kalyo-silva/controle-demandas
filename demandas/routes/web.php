<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DemandaController;
use App\Http\Controllers\DemandaTramitesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/clientes/search', [ClienteController::class, 'search'])->name('clientes.search');
Route::resource('/clientes', ClienteController::class);

Route::get('/demandas/search', [DemandaController::class, 'search'])->name('demandas.search');
Route::resource('/demandas', DemandaController::class);
Route::get('/demandas/{id_demanda}/complemento', [DemandaTramitesController::class, 'complemento'])->name('demandas.complemento');
Route::get('/demandas/{id_demanda}/tramitar', [DemandaTramitesController::class, 'tramitar'])->name('demandas.tramitar');
Route::put('/demandas/{id_demanda}/concluir', [DemandaController::class, 'concluir'])->name('demandas.concluir');

Route::post('/tramites', [DemandaTramitesController::class, 'store'])->name('tramites.store');
Route::delete('/tramites/{id_tramite}', [DemandaTramitesController::class, 'destroy'])->name('tramites.destroy');
Route::get('/tramites/{id_tramite}/editar', [DemandaTramitesController::class, 'edit'])->name('tramites.edit');
Route::put('/tramites/{id_tramite}', [DemandaTramitesController::class, 'update'])->name('tramites.update');


require __DIR__.'/auth.php';
