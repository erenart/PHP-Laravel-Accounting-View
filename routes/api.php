<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('profits', [ProfitController::class, 'index']);
Route::get('accounting', [ProfitController::class, 'profitPage']);

Route::get('incomes', [IncomeController::class, 'index'])->name('incomes');
//Route::get('accounting', [IncomeController::class, 'incomesPage']);

Route::get('expenses', [ExpenseController::class, 'index'])->name('expenses');

//Route::get('accounting', [ExpenseController::class, 'expensePage']);

