<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sosmed;
use Illuminate\Http\Request;

class SosmedController extends Controller
{
    public function index()
    {
        $sosmed = Sosmed::all();
        return view('sosmed', compact('sosmed'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        Sosmed::create($request->all());

        return redirect()->route('sosmeds.index')->with('success', 'created successfully.');
    }


    public function update(Request $request, Sosmed $sosmed)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        $sosmed->update($request->all());

        return redirect()->route('sosmeds.index')->with('success', 'updated successfully.');
    }

    public function destroy(Sosmed $sosmed)
    {
        $sosmed->delete();

        return redirect()->route('sosmeds.index')->with('success', 'deleted successfully.');
    }
}
