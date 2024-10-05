<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\ClientRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = User::latest()->where('role', UserRole::CLIENT->value)->get();
        return view('admin.clients', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        User::create([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "password" => bcrypt('password'),
            "role" => UserRole::CLIENT->value,
        ]);

        return redirect('/admin/clients')->with('success', 'Client created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = User::find($id);
        if ($client) {
            $client->delete();
            return redirect('/admin/clients')->with('success', 'Client deleted successfully.');
        } else {
            return redirect('/admin/clients')->withErrors('Client not found');
        }
    }
}
