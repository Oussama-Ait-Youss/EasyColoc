<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\InvitationsController;
use App\Http\Controllers\MembershipsController;
use App\Http\Controllers\PaymentsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ======================================================================================

    
    // --- Colocations ---
    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocation.index');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocation.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocation.store');
    Route::get('/colocations/{colocation}/edit', [ColocationController::class, 'edit'])->name('colocation.edit');
    Route::put('/colocations/{colocation}', [ColocationController::class, 'update'])->name('colocation.update');
    Route::delete('/colocations/{colocation}', [ColocationController::class, 'destroy'])->name('colocation.destroy');

    // --- Categories ---
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');

    // --- Expenses
    Route::get('/expenses', [ExpensesController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpensesController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpensesController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{expense}/edit', [ExpensesController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}', [ExpensesController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [ExpensesController::class, 'destroy'])->name('expenses.destroy');

    // --- Invitations ---
    Route::get('/invitations', [InvitationsController::class, 'index'])->name('invitations.index');
    Route::post('/invitations', [InvitationsController::class, 'store'])->name('invitations.store');
    Route::delete('/invitations/{invitation}', [InvitationsController::class, 'destroy'])->name('invitations.destroy');

    // --- Memberships 
    Route::get('/members', [MembershipsController::class, 'index'])->name('memberships.index');
    Route::post('/members/join', [MembershipsController::class, 'store'])->name('memberships.store');
    Route::delete('/members/{membership}', [MembershipsController::class, 'destroy'])->name('memberships.destroy');

    // --- Paiements 
    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments.index');
    Route::get('/payments/create', [PaymentsController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentsController::class, 'store'])->name('payments.store');
    Route::delete('/payments/{payment}', [PaymentsController::class, 'destroy'])->name('payments.destroy');
});

require __DIR__.'/auth.php';
