<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\SaleRequest;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == UserRole::ADMIN->value) {
            $sales = Sales::latest()->get();
            $sales->load('user');
            return view('admin.sales', compact('sales'));
        } else {
            $sales = Sales::latest()->where('user_id', Auth::id())->get();
            return view('client.sales', compact('sales'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaleRequest $request)
    {
        Sales::create([
            "title" => $request->input('title'),
            "amount" => $request->input('amount'),
            "user_id" => Auth::id(),
        ]);

        return redirect('/client/sales')->with('success', 'Sale created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sales::find($id);
        if ($sale) {
            $sale->delete();
            return redirect('/client/sales')->with('success', 'Sale deleted successfully.');
        } else {
            return redirect('/client/sales')->withErrors('Sale not found');
        }
    }
}
