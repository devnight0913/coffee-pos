<?php

namespace App\Http\Controllers;

// use App\Models\AccountStatement;
use App\Models\Customer;
use App\Models\Settings;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;

class CustomerAccountStatementController extends Controller
{
    public function index(Customer $customer)
    {
        $query =  $customer->transactions;
        $statements = $customer->transactions()->latest()->paginate(20);

        $debit_sum = $query->sum('debit');
        $credit_sum = $query->sum('credit');
        $balance_sum = $credit_sum - $debit_sum;
        return view('customers.statements.index', [
            'statements' => $statements,
            'customer' => $customer,
            'debit_sum' => currency_format(abs($debit_sum)),
            'credit_sum' => currency_format(abs($credit_sum)),
            'balance_sum' => $this->getBalance($balance_sum),
        ]);
    }

    public function filter(Request $request, Customer $customer)
    {
        $now = Carbon::now()->toDateString();
        $fromDate =  is_null($request->start_date) ? $now : $request->start_date;
        $toDate =  is_null($request->end_date) ? $now : $request->end_date;
        $startDate = "{$fromDate} 00:00:00";
        $endDate = "{$toDate} 23:59:59";
        $statements = $customer->transactions()->latest()->whereBetween('created_at', [$startDate, $endDate])->get();

        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
        $debit_sum = $statements->sum('debit');
        $credit_sum = $statements->sum('credit');
        $balance_sum = $credit_sum - $debit_sum;
        return view('customers.statements.filter', [
            'statements' => $statements,
            'customer' => $customer,
            'debit_sum' => currency_format(abs($debit_sum)),
            'credit_sum' => currency_format(abs($credit_sum)),
            'balance_sum' => $this->getBalance($balance_sum),
            'toDate' =>  Carbon::parse($toDate)->format($dateFormat),
            'fromDate' =>  Carbon::parse($fromDate)->format($dateFormat),


            'startDate' =>  $startDate,
            'endDate' =>  $endDate,
        ]);
    }


    public function filterPrint(Request $request, Customer $customer)
    {
        $now = Carbon::now()->toDateString();

        $startDate =  $request->get('start_date', $now);
        $endDate =  $request->get('end_date', $now);

        $statements = $customer->transactions()->oldest()->whereBetween('created_at', [$startDate, $endDate])->get();
        $settings = Settings::getValues();

        $dateFormat = $settings->dateFormat;
        $timeFormat = $settings->timeFormat;
        $date = now()->timezone($settings->timezone)->format($dateFormat);
        $time = now()->timezone($settings->timezone)->format($timeFormat);
        $debit_sum = $statements->sum('debit');
        $credit_sum = $statements->sum('credit');
        $balance_sum = $credit_sum - $debit_sum;

        return view('customers.statements.filter-print', [
            'statements' => $statements,
            'customer' => $customer,
            'debit_sum' => currency_format(abs($debit_sum)),
            'credit_sum' => currency_format(abs($credit_sum)),
            'balance_sum' => $this->getBalance($balance_sum),
            'balance_sum_raw' => $this->numberToWord(abs($balance_sum)),
            'fromDate' =>  Carbon::parse($startDate)->format($dateFormat),
            'toDate' =>  Carbon::parse($endDate)->format($dateFormat),
            'settings' => $settings,
            'date' => $date,
            'time' => $time,
        ]);
    }






    public function print(Customer $customer, Transaction $statement)
    {

        return view('customers.statements.print', [
            'statement' => $statement,
            'customer' => $customer,
            'settings' => Settings::getValues(),
        ]);
    }


    private function getBalance(float $balance = 0)
    {
        if ($balance < 0) return "(" . currency_format(abs($balance)) . ")";
        if ($balance == 0) return currency_format(0);
        return currency_format(abs($balance));
    }


    private function numberToWord(float $value = 0): string
    {
        $currency = Settings::getValue(Settings::CURRENCY_SYMBOL);
        if ($currency == "$" || $currency == "€") {
            return ucwords(NumberToWords::transformCurrency('en', (int)number_format($value, 2, '', ''), 'USD'));
        }
        return "-";
    }
}
