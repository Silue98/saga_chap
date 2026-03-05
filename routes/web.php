<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Détail d'un bétail
Route::get('/betails/{id}', [HomeController::class, 'show'])->name('betails.show');

// Panier (accessible sans connexion)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// Checkout et commande
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'placeOrder'])->name('order.place');
Route::get('/commande/confirmation/{id}', [CartController::class, 'confirmation'])->name('order.confirmation');

// Historique commandes (connecté)
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-commandes', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/mes-commandes/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Dashboard (authentifié)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

