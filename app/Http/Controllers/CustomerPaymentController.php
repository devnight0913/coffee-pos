<?php

namespace App\Http\Controllers;

// use App\Models\AccountStatement;
use App\Models\Customer;
use App\Models\Drawer;
use App\Models\Payment;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CustomerPaymentController extends Controller
{
    public function index(Request $request, Customer $customer)
    {
        $payments = $customer->payments()->search(trim($request->search_query))->orderBy('date', 'DESC')->paginate(20);

        return view('customers.payments.index', [
            'payments' => $payments,
            'customer' => $customer,
        ]);
    }


    public function create(Customer $customer)
    {
        return view('customers.payments.create', [
            'customer' => $customer,
            'modes' => Payment::$modes,
            'currency' => Settings::getValue(Settings::CURRENCY_SYMBOL),
        ]);
    }
    public function print(Customer $customer, Payment $payment)
    {
        return view('customers.payments.print', [
            'customer' => $customer,
            'payment' => $payment,
            'settings' => Settings::getValues(),
        ]);
    }

    public function edit(Customer $customer, Payment $payment)
    {
        return view('customers.payments.edit', [
            'customer' => $customer,
            'payment' => $payment,
            'modes' => Payment::$modes,
            'currency' => Settings::getValue(Settings::CURRENCY_SYMBOL),
        ]);
    }

    public function destroy(Customer $customer, Payment $payment)
    {
        // $customerAccount = AccountStatement::where('customer_id',  $customer->id)->where('reference_number', $payment->number)->first();
        // if ($customerAccount) {
        //     $customerAccount->delete();
        // }
        $payment->delete();
        return Redirect::back()->with("success", __("Deleted"));
    }

    public function store(Request $request, Customer $customer)
    {

        $request->validate([
            'amount' => ['nullable', 'numeric', 'min:0'],
            'comments' => ['nullable', 'string'],
            'date' => ['required', 'date'],
        ]);
        $payment = new Payment();
        $payment->customer_id = $customer->id;
        $payment->amount = $request->amount ?? 0;
        $payment->mode = $request->mode;
        $payment->comments = $request->comments;
        $payment->date = $request->date ?? now();
        $payment->save();

        // $latestStatement = AccountStatement::where('customer_id',  $customer->id)->latest()->first();
        // $latesBalance = $latestStatement ? $latestStatement->balance : 0;
        // $customerAccount = new AccountStatement();
        // $customerAccount->credit = $payment->amount;
        // $customerAccount->debit = 0;
        // $customerAccount->balance = $latesBalance + $payment->amount;

        // $customerAccount->customer_id = $customer->id;
        // $customerAccount->description = $payment->comments;
        // $customerAccount->reference_number = $payment->number;
        // $customerAccount->save();

        return Redirect::route('customers.payments.index', $customer)->with('success', __('Created'));
    }

    public function update(Request $request, Customer $customer, Payment $payment)
    {
        $request->validate([
            'amount' => ['nullable', 'numeric', 'min:0'],
            'comments' => ['nullable', 'string'],
            'date' => ['required', 'date'],
        ]);
        $oldCreatedAt = $payment->date ?? now();
        $payment->amount = $request->amount ?? 0;
        $payment->comments = $request->comments;
        $payment->mode = $request->mode;
        $payment->date = $request->date ?? $oldCreatedAt;
        $payment->save();



        // $latestStatement = AccountStatement::where('customer_id',  $customer->id)->where('reference_number', '!=', $payment->number)->latest()->first();
        // $latesBalance = $latestStatement ? $latestStatement->balance : 0;
        // $customerAccount = AccountStatement::where('customer_id',  $customer->id)->where('reference_number', $payment->number)->first();
        // $customerAccount->credit = $payment->amount;
        // $customerAccount->debit = 0;
        // $customerAccount->balance = $latesBalance + $payment->amount;
        // $customerAccount->description = $payment->comments;
        // $customerAccount->save();

        // if ($this->hasCashDrawer()) {
        //     $drawer = Drawer::where('payment_id', $payment->id)->first();
        //     if ($drawer) {
        //         $drawer->amount = $payment->amount;
        //         $drawer->save();
        //     }
        // }
        return Redirect::route('customers.payments.index', $customer->id)->with('success', __('Updated'));
    }


    private function hasCashDrawer(): bool
    {
        return (bool)Settings::getValue(Settings::ENABLE_CASH_DRAWER);
    }
    public function filter(Request $request, Customer $customer)
    {
        $now = Carbon::now()->toDateString();
        $fromDate =  is_null($request->start_date) ? $now : $request->start_date;
        $toDate =  is_null($request->end_date) ? $now : $request->end_date;
        $startDate = "{$fromDate} 00:00:00";
        $endDate = "{$toDate} 23:59:59";
        $payments = $customer->payments()->orderBy('date', 'DESC')->whereBetween('date', [$startDate, $endDate])->paginate(20);

        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);

        return view('customers.payments.filter', [
            'payments' => $payments,
            'payments_sum' => currency_format($payments->sum('amount')),
            'toDate' =>  Carbon::parse($toDate)->format($dateFormat),
            'fromDate' =>  Carbon::parse($fromDate)->format($dateFormat),
            'startDate' =>  $startDate,
            'endDate' =>  $endDate,
            'customer' => $customer,
        ]);
    }



    public function filterPrint(Request $request, Customer $customer)
    {
        $now = Carbon::now()->toDateString();

        $startDate =  $request->get('start_date', $now);
        $endDate =  $request->get('end_date', $now);

        $payments = $customer->payments()->orderBy('date', 'DESC')->whereBetween('date', [$startDate, $endDate])->get();
        $settings = Settings::getValues();

        $dateFormat = $settings->dateFormat;
        $timeFormat = $settings->timeFormat;
        $date = now()->timezone($settings->timezone)->format($dateFormat);
        $time = now()->timezone($settings->timezone)->format($timeFormat);

        return view('customers.payments.filter-print', [
            'payments' => $payments,
            'payments_sum' => currency_format($payments->sum('amount')),
            'fromDate' =>  Carbon::parse($startDate)->format($dateFormat),
            'toDate' =>  Carbon::parse($endDate)->format($dateFormat),
            'settings' => $settings,
            'date' => $date,
            'time' => $time,
            'customer' => $customer,
        ]);
    }
}
