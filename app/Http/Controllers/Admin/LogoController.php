<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::all();
        return view('logo', compact('logos'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);
        $images = $request->file('image')->store('logo');
        Logo::create([
            'image'=>$images,
            'status'=>'non active'
        ]);

        return redirect()->route('logos.index')->with('success', 'Merk created successfully.');
    }
    public function update(Request $request, Logo $logo)
    {
        Logo::query()->update(['status' => 'non active']);

        $logo->update([
            'status'=>'active'
        ]);

        return redirect()->route('logos.index')->with('success', 'Merk updated successfully.');
    }

    public function destroy(Logo $logo)
    {
        $logo->delete();

        return redirect()->route('faqs.index')->with('success', 'Merk deleted successfully.');
    }
}
