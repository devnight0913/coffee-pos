<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $employees = Employee::search($request->search_query)->latest()->paginate(20);
        return view('employees.index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'date' => ['nullable', 'string', 'max:100'],
        ]);
        $employee = Employee::create([
            'name' => $request->name,
            'price' => $request->price,
            'date' => $request->date,
        ]);
        return Redirect::back()->with("success", __("Created"));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        if ($employee->role == Role::SUPER_ADMIN) {
            return Redirect::back()->with("warning", "This employee cannot be deleted");
        }
        $employee->delete();
        return Redirect::back()->with("success", __("Deleted"));
    }

    public function edit(Employee $employee): View
    {
        return view("employees.edit", [
            'employee' => $employee,
        ]);
    }
    
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'date' => ['nullable', 'string', 'max:100'],
        ]);


        $employee->name = $request->name;
        $employee->price = $request->price;
        $employee->date = $request->date;
        $employee->save();

        return back()->with('success', __('Created'));
    }
}
