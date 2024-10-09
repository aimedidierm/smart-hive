<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\HardwareStatusRequest;
use App\Models\Hardware;
use Illuminate\Support\Facades\Auth;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Hardware::latest()->get();
        if (Auth::user()->role == UserRole::ADMIN->value) {
            return view('admin.dashboard', compact('data'));
        } else {
            return view('client.dashboard', compact('data'));
        }
    }

    public function store(HardwareStatusRequest $request)
    {
        Hardware::create([
            "humidity" => $request->input("humidity"),
            "temperature" => $request->input("temperature"),
            "weight" => $request->input("weight")
        ]);
    }
}
