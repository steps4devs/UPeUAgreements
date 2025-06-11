<?php

use App\Livewire\ConveniosMain;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Route::get('convenios', ConveniosMain::class)->name('convenios-main');
    Route::get('entidades', ConveniosMain::class)->name('entidades-main');
    Route::get('reportes', ConveniosMain::class)->name('reportes-main');
    Route::get('instituciones', ConveniosMain::class)->name('instituciones-main');
    Route::get('configuracion', ConveniosMain::class)->name('configuracion-main');



});

require __DIR__.'/auth.php';
