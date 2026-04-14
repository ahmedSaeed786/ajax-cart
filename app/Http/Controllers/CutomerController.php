<?php

namespace App\Http\Controllers;

use App\Models\cutomer;
use App\Models\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DevSarfo\Laraphone\Rules\PhoneNumberRule;
use App\Models\order;
use Illuminate\Support\Facades\Validator;

class CutomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show($id)
    {

        $customer = cutomer::withSum('item', 'total')->with('item')->where('id', $id)->first();

        return view('layouts.invoice', compact('customer'));


        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function validateField(Request $request)
    {
        $rules = [
            'customer_name' => 'alpha|required|string|max:255',
            'name' => 'alpha|required|string|max:255',
            'qty' => 'required|integer|min:1',
            'amount' => 'required|integer|min:1',
            'total' => 'required|integer|min:1',
            'phone' =>  ['required', 'regex:/^\+?[0-9]+( [0-9]+)*$/'],
        ];

        $field = $request->field;

        if (!isset($rules[$field])) {
            return response()->json(['success' => true]);
        }

        $validator = Validator::make(
            [$field => $request->value],
            [$field => $rules[$field]]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first($field)
            ], 422);
        }

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        //

        $customer = cutomer::create([
            "name" => $request->customer_name,
            "date" => $request->date,
            "phone" => $request->phone,

        ]);
        $items = json_decode($request->items);

        foreach ($items as $item) {
            $order = order::create([

                'name' => $item->name,
                'qty' =>  $item->qty,
                'amount' =>  $item->amount,
                'total' =>  $item->total,
                'c_id' =>  $customer->id,
            ]);
        }


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function add(Request $request) {}


    public function edit(cutomer $cutomer) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $customer = cutomer::where('id', $request->id)->update([

            "name" => $request->c_name,
            "phone" => $request->phone,
            "date" => $request->date,
        ]);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        cutomer::where('id', $id)->delete();
        order::where('c_id', $id)->delete();

        return back();
    }
}
