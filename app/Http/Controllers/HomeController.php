<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;
use App\Models\order;
use App\Models\cutomer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $orders = order::with('customer')->get();
        $orders = cutomer::withSum('item', 'total')->with('item')->get();

        $items = item::get();
        return view('home', compact('items', 'orders'));
    }
}
