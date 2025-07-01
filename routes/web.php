<?php

use App\Livewire\ConfiguracionMain;
use App\Livewire\ConveniosMain;
use App\Livewire\DetalleConv;
use App\Livewire\EntidadesMain;
use App\Livewire\InstitucionesMain;
use App\Livewire\ReportesMain;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ClausulaController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Route::get('convenios', ConveniosMain::class)->name('convenios-main');
    Route::get('entidades', EntidadesMain::class)->name('entidades-main');
    Route::get('reportes', ReportesMain::class)->name('reportes-main');
    Route::get('instituciones', InstitucionesMain::class)->name('instituciones-main');
    Route::get('configuracion', ConfiguracionMain::class)->name('configuracion-main');
    Route::get('clausulas/descargar/{id}', [ClausulaController::class, 'descargar'])->name('clausulas.descargar');
    Route::delete('/clausulas/eliminar/{id}', [ClausulaController::class, 'eliminar'])->name('clausulas.eliminar');
    Route::get('/convenios/crear', \App\Livewire\CRUDConv::class)->name('convenios.create');
    Route::get('/convenios/{id}/editar', \App\Livewire\CRUDConv::class)->name('convenios.edit');
    Route::get('/convenios/{id}/detalle', DetalleConv::class)->name('convenios.detalle');
});

require __DIR__.'/auth.php';
