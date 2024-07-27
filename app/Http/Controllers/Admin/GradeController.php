<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();
        return view('admin.grades.index', compact('grades'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => ''
        ]);

        Grade::create([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        return redirect()->route('grades.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => ''
        ]);

        $grade->update([
            'name' => $request->name,
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        return redirect()->route('grades.index');
    }
    public function create()
    {
        return view('admin.grades.create');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index');
    }
}
