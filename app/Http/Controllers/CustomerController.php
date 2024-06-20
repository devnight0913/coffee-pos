<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerResourceCollection;
use App\Models\Customer;
use App\Models\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $customers = Customer::search($request->search_query)->latest()->paginate(10);
        return view('customers.index', [
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function show(Customer $customer): View
    {
        $owe  = $customer->owed_amount;
        $payments_sum  = $customer->payments->sum('amount');
        return view('customers.show', [
            'customer' => $customer,
            'owed_amount' => $owe,
            'payments_sum' => currency_format($payments_sum),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function printInfo(Customer $customer): View
    {
        return view('customers.print.info', [
            'customer' => $customer,
            'settings' => Settings::getValues(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('customers.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validateRequest($request);
        Customer::create($request->all());
        return Redirect::back()->with("success", __("Created"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $this->validateRequest($request);
        $customer->update($request->all());
        return Redirect::route('customers.show', $customer)->with("success", __("Updated"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();
        return Redirect::route('customers.index')->with("success", __("Deleted"));
    }


    public function validateRequest(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'birthday' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:150'],
            'nationality' => ['nullable', 'string', 'max:150'],
            'civil_status' => ['nullable', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'telephone' => ['nullable', 'string', 'max:150'],
            'mobile' => ['nullable', 'string', 'max:150'],
            'fax' => ['nullable', 'string', 'max:150'],
            'street_address' => ['nullable', 'string', 'max:150'],
            'city' => ['nullable', 'string', 'max:150'],
            'state' => ['nullable', 'string', 'max:150'],
            'country' => ['nullable', 'string', 'max:150'],
            'zip_code' => ['nullable', 'string', 'max:6'],
            'tax_identification_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:3000'],
            'company_name' => ['nullable', 'string', 'max:100'],
            'company_street_address' => ['nullable', 'string', 'max:100'],
            'company_city' => ['nullable', 'string', 'max:100'],
            'company_state' => ['nullable', 'string', 'max:100'],
            'company_country' => ['nullable', 'string', 'max:100'],
            'company_zip_code' => ['nullable', 'string', 'max:6'],
        ]);
    }


    public function search(Request $request): JsonResponse
    {
        $query = trim($request->get('query'));
        if (is_null($query)) {
            return $this->jsonResponse(['data' => []]);
        }
        $customers = Customer::with('order_details')->where('name',  'LIKE', "%{$query}%")
            ->take(10)->get();
        return $this->jsonResponse(['data' => new CustomerResourceCollection($customers)]);
    }
    public function createNew(Request $request): JsonResponse
    {
        $this->validateRequest($request);
        $customer = Customer::create($request->all());
        return $this->jsonResponse(['data' => new CustomerResource($customer)]);
    }
}
