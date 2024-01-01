<?php

namespace App\Http\Controllers;

use App\Models\GradeReseller;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = GradeReseller::all();
        return view('grade-reseller', compact('grades'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:merks|max:255',
            'profit' => 'required',
            'description' => 'required'
        ]);

        GradeReseller::create($request->all());

        return redirect()->route('grades.index')->with('success', 'Merk created successfully.');
    }


    public function update(Request $request, GradeReseller $grade)
    {
        // dd($grade);
        $request->validate([
            'name' => 'required|unique:merks|max:255',
            'profit' => 'required',
            'description' => 'required'
        ]);

        $grade->update($request->all());

        return redirect()->route('grades.index')->with('success', 'Merk updated successfully.');
    }

    public function destroy(GradeReseller $grade)
    {
        // dd(json_decode($grade));

        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Merk deleted successfully.');
    }
}
