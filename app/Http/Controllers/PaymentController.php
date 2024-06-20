<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Payment;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::search(trim($request->search_query))->orderBy('date', 'DESC')->paginate(20);

        return view('payments.index', [
            'payments' => $payments,
        ]);
    }


    public function create()
    {
        $customers = Customer::oldest()->take(200)->get();
        $employees = Employee::oldest()->take(200)->get();
        return view('payments.create', [
            'customers' => $customers,
            'employees' => $employees,
            'modes' => Payment::$modes,
            'currency' => Settings::getValue(Settings::CURRENCY_SYMBOL),
        ]);
    }

    public function edit(Payment $payment)
    {
        $customers = Customer::oldest()->take(200)->get();
        $employees = Employee::oldest()->take(200)->get();
        return view('payments.edit', [
            'payment' => $payment,
            'customers' => $customers,
            'employees' => $employees,
            'modes' => Payment::$modes,
            'currency' => Settings::getValue(Settings::CURRENCY_SYMBOL),
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'customer' => ['nullable', 'string'],
            'employee' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
            'comments' => ['nullable', 'string'],
            'date' => ['required', 'date'],
        ]);
        $customerId = $request->customer;
        $employeeId = $request->employee;

        $payment = new Payment();
        $payment->customer_id = $customerId;
        $payment->employee_id = $employeeId;
        $payment->amount = $request->amount ?? 0;
        $payment->mode = $request->mode;
        $payment->comments = $request->comments;
        $payment->date = $request->date ?? now();
        $payment->save();

        if($request->customer) {
            $latestStatement = Transaction::where('customer_id',  $customerId)->latest()->first();
            $customerAccount = new Transaction();
            $customerAccount->credit = $payment->amount;
            $customerAccount->debit = 0;
    
            $customerAccount->customer_id = $customerId;
            $customerAccount->description = $payment->comments;
            $customerAccount->reference_number = $payment->number;
            $customerAccount->save();
        }

        return back()->with('success', __('Created'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'customer' => ['nullable', 'string'],
            'employee' => ['nullable', 'string'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'comments' => ['nullable', 'string'],
            'date' => ['required', 'date'],
        ]);
        $customerId = $request->customer;
        $employeeId = $request->employee;

        $payment->customer_id = $customerId;
        $payment->employee_id = $employeeId;
        $payment->amount = $request->amount ?? 0;
        $payment->mode = $request->mode;
        $payment->comments = $request->comments;
        $payment->date = $request->date ?? now();
        $payment->save();

        if($request->customer) {
            $latestStatement = Transaction::where('customer_id',  $customerId)->latest()->first();
            $customerAccount = new Transaction();
            $customerAccount->credit = $payment->amount;
            $customerAccount->debit = 0;

            $customerAccount->customer_id = $customerId;
            $customerAccount->description = $payment->comments;
            $customerAccount->reference_number = $payment->number;
            $customerAccount->save();
        }

        return back()->with('success', __('Created'));
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return back()->with('success', __('Deleted'));
    }

    public function filter(Request $request)
    {
        $now = Carbon::now()->toDateString();
        $fromDate =  is_null($request->start_date) ? $now : $request->start_date;
        $toDate =  is_null($request->end_date) ? $now : $request->end_date;
        $startDate = "{$fromDate} 00:00:00";
        $endDate = "{$toDate} 23:59:59";
        $payments = Payment::orderBy('date', 'DESC')->whereBetween('date', [$startDate, $endDate])->paginate(20);

        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);

        return view('payments.filter', [
            'payments' => $payments,
            'payments_sum' => currency_format($payments->sum('amount')),
            'toDate' =>  Carbon::parse($toDate)->format($dateFormat),
            'fromDate' =>  Carbon::parse($fromDate)->format($dateFormat),
            'startDate' =>  $startDate,
            'endDate' =>  $endDate,
        ]);
    }



    public function filterPrint(Request $request)
    {
        $now = Carbon::now()->toDateString();

        $startDate =  $request->get('start_date', $now);
        $endDate =  $request->get('end_date', $now);

        $payments = Payment::orderBy('date', 'DESC')->whereBetween('date', [$startDate, $endDate])->get();
        $settings = Settings::getValues();

        $dateFormat = $settings->dateFormat;
        $timeFormat = $settings->timeFormat;
        $date = now()->timezone($settings->timezone)->format($dateFormat);
        $time = now()->timezone($settings->timezone)->format($timeFormat);

        return view('payments.filter-print', [
            'payments' => $payments,
            'payments_sum' => currency_format($payments->sum('amount')),
            'fromDate' =>  Carbon::parse($startDate)->format($dateFormat),
            'toDate' =>  Carbon::parse($endDate)->format($dateFormat),
            'settings' => $settings,
            'date' => $date,
            'time' => $time,
        ]);
    }
}
