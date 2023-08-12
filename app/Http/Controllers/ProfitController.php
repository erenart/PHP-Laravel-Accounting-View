<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profit;

class ProfitController extends Controller
{

    public function index() {
        
        $profits = Profit::all();
        return response()->json($profits, 200);
    }

    public function profitPage()
    {
        return view('accounting');
    }
}
