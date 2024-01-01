<?php

namespace App\Http\Controllers;

use App\Models\Kupon;
use Illuminate\Http\Request;

class KuponController extends Controller
{
    public function index()
    {
        $kupons = Kupon::all();
        return view('kupon', compact('kupons'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:kupons|max:255',
            'value' => 'required'
        ]);

        Kupon::create($request->all());

        return redirect()->route('kupons.index')->with('success', 'Kupon created successfully.');
    }


    public function update(Request $request, Kupon $kupon)
    {
        $kupon->update($request->all());

        return redirect()->route('kupons.index')->with('success', 'Kupon updated successfully.');
    }

    public function destroy(Kupon $kupon)
    {
        $kupon->delete();

        return redirect()->route('kupons.index')->with('success', 'Kupon deleted successfully.');
    }
}
