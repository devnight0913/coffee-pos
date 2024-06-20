<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResourceCollection;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Expense;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class InventoryController extends Controller
{
    public function show() {
        $payouts = Expense::sum('amount');
        $amount = Inventory::sum('amount');
        $count = Inventory::whereNotNull('order_id')->count();
        $customer_count = Inventory::whereNotNull('customer_id')->count();
        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
        $date = now(Settings::getValue(Settings::TIMEZONE))->format("{$dateFormat}");

        $todayInvoices = DB::table('inventories')
                                ->leftJoin('customers', 'inventories.customer_id', '=', 'customers.id')
                                ->join('orders', 'inventories.order_id', '=', 'orders.id')->get();
            // ->take(12)->get()->each(function ($order) {
            //     $order->setAppends([]);
            // });
        $inventoryHistories = InventoryHistory::latest()->paginate(20);

        return view('inventory.show', [
            'amount' => $amount,
            'payouts' => $payouts,
            'count' => $count,
            'customer_count' => $customer_count,
            'date' => $date,
            'todayInvoices' => $todayInvoices,
            'inventoryHistories' => $inventoryHistories,
            'currency' => Settings::getDefaultCurrency(),
            'startingCash' => (float)Settings::getValue(Settings::STARTING_CASH),
        ]);
    }

    public function print(InventoryHistory $inventoryHistory)
    {
        $storeName = Settings::getValue(Settings::STORE_NAME);
        $view = 'inventory.print';
        $settings = Settings::getValues();

        if ($settings->lang == 'ar') {
            $view = 'inventory.print-ar';
        }

        return view($view, [
            'inventoryHistory' => $inventoryHistory,
            'storeName' => $storeName,
        ]);
    }

    public function close() {
        $oldest = Inventory::oldest()->first();
        $oldest = Inventory::orderBy('created_at', 'asc')->first();
        $create_at = $oldest ? $oldest->created_at : now();
        $ended_at = now();

        $count = Inventory::whereNotNull('order_id')->count();
        $customer_count = Inventory::whereNotNull('customer_id')->count();
        $cash_sales = Inventory::sum('amount');

        $inventoryHistory = new InventoryHistory();
        $inventoryHistory->created_at = $create_at;
        $inventoryHistory->ended_at = $ended_at;
        $inventoryHistory->customers = $customer_count;
        $inventoryHistory->invoices = $count;
        $inventoryHistory->cash_sales = $cash_sales;

        $inventoryHistory->save();
        Inventory::truncate();

        return Redirect::back()->with("success", __("Inventory has been closed."));
    }
    /**
     * Show resources.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecipes()
    {
        return Recipe::all();
    }

    public function getCategories(): JsonResponse
    {
        $categories = Category::with(['items' => function ($query) {
            $query->where('is_active', 1);
        }])->orderBy('sort_order', 'ASC')->get();
        return response() -> json([
            'categories' => $categories
        ]);
        // return $this->jsonResponse(["data" => new CategoryResourceCollection(
        //     Category::with(['items' =>  function ($query) {
        //         $query->active()->orderBy("created_at", "ASC");
        //     }])->active()->orderBy("sort_order", "ASC")->latest()->get()
        // )]);
    }

}
