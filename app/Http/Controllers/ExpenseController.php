<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index() {
        
        $expenses = Expense::all();
        return response()->json($expenses, 200);
    }

    public function expensePage()
    {
        return view('accounting');
    }
}
