<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::latest()->get();
        return view('client.orders', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        Order::create([
            "sale_id" => $request->input("sale_id"),
            "name" => $request->input("names"),
            "phone" => $request->input("phone"),
            "comment" => $request->input("request_details"),
        ]);

        return redirect('/')->with('success', 'Client deleted successfully.');
    }
}
