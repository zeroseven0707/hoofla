<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('faq', compact('faqs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|unique:faqs',
            'answer' => 'required|unique:faqs',
        ]);

        Faq::create($request->all());

        return redirect()->route('faqs.index')->with('success', 'Merk created successfully.');
    }


    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq->update($request->all());

        return redirect()->route('faqs.index')->with('success', 'Merk updated successfully.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('success', 'Merk deleted successfully.');
    }
}
