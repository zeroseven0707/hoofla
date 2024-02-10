<?php

namespace App\Http\Controllers;

use App\Models\CategoryCustomer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {
        $data['customers'] = CategoryCustomer::all();
        return view('customer', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'persentase' => 'required'
        ]);

       CategoryCustomer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'created successfully.');
    }

    public function update(Request $request,CategoryCustomer $CategoryCustomer)
    {
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'persentase' => 'required'
        ]);

        $CategoryCustomer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'updated successfully.');
    }

    public function destroy(CategoryCustomer $CategoryCustomer)
    {
        $CategoryCustomer->delete();

        return redirect()->route('customers.index')->with('success', 'deleted successfully.');
    }
}
