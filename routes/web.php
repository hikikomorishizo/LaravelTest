<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('/', function () {
    return view('welcome');
});

// Route for displaying list of pets
Route::get('/pets', [PetController::class, 'index'])->name('pets.index');

// Route for displaying a single pet
Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');

// Route for creating a new pet (optional)
Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');

// Route for storing a new pet (optional)
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

// Route for editing an existing pet (optional)
Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');

// Route for updating an existing pet (optional)
Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update');

// Route for deleting a pet (optional)
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');

Route::get('/pets/search/name', [PetController::class, 'searchByName'])->name('pets.searchByName');

Route::post('/pets/{petId}/order', [PetController::class, 'createOrder'])->name('pets.createOrder');



// Store
use App\Http\Controllers\StoreController;
Route::get('/store/inventory', [StoreController::class, 'inventory'])->name('store.inventory');



// User routes
use App\Http\Controllers\UserController;
Route::get('/users', [UserController::class, 'index'])->name('users.index'); 
Route::post('/users', [UserController::class, 'create'])->name('users.create');
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
Route::delete('/users/{username}', [UserController::class, 'destroy'])->name('users.destroy');
Route::put('/users/{username}', [UserController::class, 'update'])->name('users.update');