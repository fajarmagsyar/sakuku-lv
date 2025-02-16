<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiController::class, 'logout']);

    // User Routes
    Route::get('/users', [ApiController::class, 'getUsers']);
    Route::post('/users', [ApiController::class, 'createUser']);
    Route::put('/users/{user}', [ApiController::class, 'updateUser']);
    Route::delete('/users/{user}', [ApiController::class, 'deleteUser']);

    // Category Routes
    Route::get('/categories', [ApiController::class, 'getCategories']);
    Route::post('/categories', [ApiController::class, 'createCategory']);
    Route::put('/categories/{category}', [ApiController::class, 'updateCategory']);
    Route::delete('/categories/{category}', [ApiController::class, 'deleteCategory']);

    // Income Routes
    Route::get('/income', [ApiController::class, 'getIncome']);
    Route::post('/income', [ApiController::class, 'createIncome']);
    Route::put('/income/{income}', [ApiController::class, 'updateIncome']);
    Route::delete('/income/{income}', [ApiController::class, 'deleteIncome']);

    // Expense Routes
    Route::get('/expenses', [ApiController::class, 'getExpenses']);
    Route::post('/expenses', [ApiController::class, 'createExpense']);
    Route::put('/expenses/{expense}', [ApiController::class, 'updateExpense']);
    Route::delete('/expenses/{expense}', [ApiController::class, 'deleteExpense']);

    // Transaction Routes
    Route::get('/transactions', [ApiController::class, 'getTransactions']);
    Route::post('/transactions', [ApiController::class, 'createTransaction']);
    Route::put('/transactions/{transaction}', [ApiController::class, 'updateTransaction']);
    Route::delete('/transactions/{transaction}', [ApiController::class, 'deleteTransaction']);
});
