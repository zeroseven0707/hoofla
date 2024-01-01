<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    public function index()
    {
        $merks = Merk::all();
        return view('merk', compact('merks'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:merks|max:255',
            'name' => 'required|unique:merks|max:255',
        ]);

        Merk::create($request->all());

        return redirect()->route('merks.index')->with('success', 'Merk created successfully.');
    }


    public function update(Request $request, Merk $merk)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
        ]);

        $merk->update($request->all());

        return redirect()->route('merks.index')->with('success', 'Merk updated successfully.');
    }

    public function destroy(Merk $merk)
    {
        $merk->delete();

        return redirect()->route('merks.index')->with('success', 'Merk deleted successfully.');
    }
}
