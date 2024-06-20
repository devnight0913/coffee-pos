<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Payment;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::search(trim($request->search_query))->orderBy('date', 'DESC')->paginate(20);

        return view('expenses.index', [
            'expenses' => $expenses
        ]);
    }
    public function archive(Request $request)
    {
        $expenses = Expense::archived()->search(trim($request->search_query))->orderBy('date', 'DESC')->paginate(20);

        return view('expenses.archive', [
            'expenses' => $expenses
        ]);
    }
    public function create()
    {

        return view('expenses.create', [
            'currency' => Settings::getDefaultCurrency(),
            'modes' => Payment::$modes,

        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['nullable', 'numeric', 'min:0'],
            'reason' => ['nullable', 'string'],
            'comments' => ['nullable', 'string'],
        ]);

        $expense = new Expense();
        $expense->amount = $request->amount ?? 0;
        $expense->reason = $request->reason;
        $expense->comments = $request->comments;
        $expense->mode = $request->mode;
        $expense->date = $request->date ?? now();
        $expense->save();
        if ($request->hasFile('receipt')) {
            $expense->storeReceipt($request->file('receipt'));
        }

        return Redirect::back()->with("success", __("Created"));
    }

    /**
     * Archive resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateArchive(Expense $expense)
    {
        $expense->archived_at = now();
        $expense->save();
        return Redirect::back()->with("success", __("Expense has been archived"));
    }

    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return Redirect::back()->with("success", __("Deleted"));
    }

    /**
     * print resources.
     * 
     */
    public function print(Expense $expense)
    {

        return view('expenses.print', [
            'expense' => $expense,
            'settings' => Settings::getValues(),
        ]);
    }



    public function filter(Request $request)
    {
        $now = Carbon::now()->toDateString();
        $fromDate =  is_null($request->start_date) ? $now : $request->start_date;
        $toDate =  is_null($request->end_date) ? $now : $request->end_date;
        $startDate = "{$fromDate} 00:00:00";
        $endDate = "{$toDate} 23:59:59";


        $expenses = Expense::orderBy('date', 'DESC')->whereBetween('date', [$startDate, $endDate])->paginate(20);


        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);

        return view('expenses.filter', [
            'expenses' => $expenses,
            'expenses_sum' => currency_format($expenses->sum('amount')),
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
        
        $expenses = Expense::orderBy('date', 'DESC')->whereBetween('date', [$startDate, $endDate])->get();
        $settings = Settings::getValues();

        $dateFormat = $settings->dateFormat;
        $timeFormat = $settings->timeFormat;
        $date = now()->timezone($settings->timezone)->format($dateFormat);
        $time = now()->timezone($settings->timezone)->format($timeFormat);

        return view('expenses.filter-print', [
            'expenses' => $expenses,
            'expenses_sum' => currency_format($expenses->sum('amount')),
            'fromDate' =>  Carbon::parse($startDate)->format($dateFormat),
            'toDate' =>  Carbon::parse($endDate)->format($dateFormat),
            'settings' => $settings,
            'date' => $date,
            'time' => $time,
        ]);
    }
}
