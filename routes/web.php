<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\ProfileController;

// Strona Główna
Route::get('/', function () {
    return view('welcome', ['showResults' => false]);
})->name('home');

// Trasy autoryzacji
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/generate-plan', [TravelController::class, 'generate'])->name('travel.generate');

// Gdy middleware 'auth' wykryje gościa, odeśle go tutaj, a my przekierujemy go na główną.
Route::get('/login', function() {
    return redirect()->route('home')->with('show_login', true);
})->name('login');

// Trasy zabezpieczone dla zalogowanych użytkowników
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profil/haslo', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/save-plan', [TravelController::class, 'savePlan'])->name('save-plan');
    Route::get('/moje-plany', [TravelController::class, 'myPlans'])->name('my-plans');
    Route::get('/moje-plany/{id}', [TravelController::class, 'showPlan'])->name('show-plan');
    Route::delete('/moje-plany/{id}', [TravelController::class, 'destroyPlan'])->name('delete-plan');
});

