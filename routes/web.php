<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventEquipmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('history', [EventController::class, 'history'])->name('events.history');
    Route::resource('events', EventController::class);
    Route::post('events/{event}/equipment', [EventEquipmentController::class, 'store'])->name('events.equipment.store');
    Route::patch('events/{event}/equipment/{item}', [ChecklistController::class, 'updateEquipment'])->name('events.equipment.checklist.update');
    Route::patch('events/{event}/custom-items/{item}', [ChecklistController::class, 'updateCustomItem'])->name('events.custom-items.checklist.update');
    Route::post('events/{event}/release', [ChecklistController::class, 'release'])->name('events.release');
    Route::resource('equipment', EquipmentController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class)->except('show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
