<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::search(trim($request->search_query))->latest()->paginate(20);

        return view('suppliers.index', [
            'suppliers' => $suppliers,
        ]);
    }


    public function create(Request $request)
    {
        return view('suppliers.create');
    }

    public function edit(Request $request, Supplier $supplier)
    {
        return view('suppliers.edit', [
            'supplier' => $supplier
        ]);
    }

    public function show(Request $request, Supplier $supplier)
    {
        return view('suppliers.show', [
            'supplier' => $supplier
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'address' => ['nullable', 'string', 'max:200'],
            'phone' => ['nullable', 'string', 'max:150'],
            'email' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string'],
        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->notes = $request->notes;
        $supplier->save();

        return back()->with('success', __('Created'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'address' => ['nullable', 'string', 'max:200'],
            'phone' => ['nullable', 'string', 'max:150'],
            'email' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string'],
        ]);

        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->email = $request->email;
        $supplier->notes = $request->notes;
        $supplier->save();

        return back()->with('success', __('Updated'));
    }


    public function destroy(Request $request, Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', __('Deleted'));
    }
}
