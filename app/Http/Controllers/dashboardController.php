<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\cutomer;

class dashboardController extends Controller
{
    //

    public function index()
    {
        $customers = cutomer::withSum('item', 'total')->with('item')->orderBy('id', 'desc')->get();
        return view('layouts.dashboard', compact('customers'));
    }
}
