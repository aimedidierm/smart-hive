<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\TrainingRequest;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainings = Training::paginate(10);
        if (Auth::user()->role == UserRole::ADMIN->value) {
            return view('admin.training', compact('trainings'));
        } else {
            return view('client.training', compact('trainings'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrainingRequest $request)
    {
        $uniqueid = uniqid();
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;

        $path = $request->file('file')->storeAs('files', $filename, 'public');
        $fileUrl = Storage::url($path);

        Training::create([
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            "src" => $fileUrl,
        ]);

        return redirect('/admin/trainings')->with('success', 'Training created');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $training = Training::find($id);
        if ($training) {
            $training->delete();
            return redirect('/admin/training')->with('success', 'Training deleted successfully.');
        } else {
            return redirect('/admin/training')->withErrors('Training not found');
        }
    }
}
