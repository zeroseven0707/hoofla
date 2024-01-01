<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::all();
        return view('bank', compact('banks'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:banks'
        ]);

        Bank::create($request->all());

        return redirect()->route('banks.index')->with('success', 'Bank name created successfully.');
    }


    public function update(Request $request, Bank $bank)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $bank->update($request->all());

        return redirect()->route('banks.index')->with('success', 'Bank name updated successfully.');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();

        return redirect()->route('banks.index')->with('success', 'Bank name deleted successfully.');
    }
}
