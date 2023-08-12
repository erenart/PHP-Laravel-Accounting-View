<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;

class IncomeController extends Controller
{
    public function index() {
        
        $incomes = Income::all();
        return response()->json($incomes, 200);
    }

    public function incomesPage()
    {
        return view('accounting');
    }
}
