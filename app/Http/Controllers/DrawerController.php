<?php

namespace App\Http\Controllers;

use App\Models\Drawer;
use App\Models\DrawerHistory;
use App\Models\Expense;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DrawerController extends Controller
{
    public function show()
    {
        $payouts = Expense::sum('amount');
        $amount = Drawer::sum('amount');
        $count = Drawer::whereNotNull('order_id')->count();
        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
        $date = now(Settings::getValue(Settings::TIMEZONE))->format("{$dateFormat}");

        $drawerHistories = DrawerHistory::latest()->paginate(20);

        return view('drawer.show', [
            'amount' => $amount,
            'payouts' => $payouts,
            'count' => $count,
            'date' => $date,
            'drawerHistories' => $drawerHistories,
            'currency' => Settings::getDefaultCurrency(),
            'startingCash' => (float)Settings::getValue(Settings::STARTING_CASH),
        ]);
    }
    public function print(DrawerHistory $drawerHistory)
    {
        $storeName = Settings::getValue(Settings::STORE_NAME);
        $view = 'drawer.print';
        $settings = Settings::getValues();

        if ($settings->lang == 'ar') {
            $view = 'drawer.print-ar';
        }

        return view($view, [
            'drawerHistory' => $drawerHistory,
            'storeName' => $storeName,
        ]);
    }


    public function close(Request $request)
    {
        $request->validate([
            'in_drawer_cash' => ['nullable', 'numeric', 'min:0'],

        ]);

        // $oldest = Drawer::oldest()->first();
        $oldest = Drawer::orderBy('created_at', 'asc')->first();
        $create_at = $oldest ? $oldest->created_at : now();
        $ended_at = now();


        $starting_cash =  (float)Settings::getValue(Settings::STARTING_CASH) ?? 0.00;
        $cash_sales = Drawer::sum('amount');
        //$paid_out =  Expense::whereDate('created_at', Carbon::today())->sum('amount');
        $paid_out =  0;
        $expected = $starting_cash + $cash_sales - $paid_out;
        $actual = $request->in_drawer_cash ?? 0;
        $difference = $actual - $expected;

        $drawerHistory = new DrawerHistory();

        $drawerHistory->created_at = $create_at;
        $drawerHistory->ended_at = $ended_at;
        $drawerHistory->starting_cash = $starting_cash;
        $drawerHistory->cash_sales = $cash_sales;
        $drawerHistory->expected = $expected;
        $drawerHistory->actual = $actual;
        $drawerHistory->difference = $difference;
        $drawerHistory->paid_out = $paid_out;
        $drawerHistory->save();
        Settings::updateValue(Settings::STARTING_CASH, 0.00);
        // Payout::notArchived()->update(['archived_at' => now()]);
        Drawer::truncate();

        return Redirect::back()->with("success", __("Drawer has been closed."));
    }
}
