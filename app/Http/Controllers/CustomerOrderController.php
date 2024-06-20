<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    public function index(Customer $customer)
    {
        $orders = $customer->orders()->latest()->paginate(10);
        $totalDiscount = $customer->orders()->sum('discount');
        $totalCost =  $customer->order_details->sum('total_cost');
        $totalSold =  $customer->order_details->sum('total')  - $totalDiscount;


        $totalDiscountPerMonth = $customer->orders()->select(
            DB::raw('strftime("%m %Y", created_at) as date'),
            DB::raw('SUM(discount) as sum_discount'),
            DB::raw('max(created_at) as createdAt')
        )->groupBy('date')->orderBy(DB::raw("createdAt"), 'ASC')->get()
            ->each(function ($order) {
                $order->setAppends([]);
            });


        $totalPerMonth = $customer->orders()->select(
            DB::raw('strftime("%m %Y", created_at) as date'),
            DB::raw('SUM(total) as total'),
            DB::raw('max(created_at) as createdAt')
        )->groupBy('date')->orderBy(DB::raw("createdAt"), 'ASC')
            ->get()->each(function ($order) {
                $order->setAppends([]);
            });

        $totalOrdersPerMonth = $customer->orders()->select(
            DB::raw('strftime("%m %Y", created_at) as date'),
            DB::raw('count(*) as total'),
            DB::raw('max(created_at) as createdAt')
        )->groupBy('date')
            ->orderBy(DB::raw("createdAt"), 'ASC')->get()->each(function ($order) {
                $order->setAppends([]);
            });
        $totalProfit = $totalSold - $totalCost;

        return view('customers.orders', [
            'orders' => $orders,
            'totalOrders' => $orders->total(),
            'totalCost' => currency_format($totalCost),
            'totalSold' => currency_format($totalSold),
            'totalProfit' => currency_format($totalProfit),

            'totalPerMonth' => $totalPerMonth,
            'totalOrdersPerMonth' => $totalOrdersPerMonth,

            'totalDiscountPerMonth' => $totalDiscountPerMonth,
            'totalDiscountSum' => $totalDiscountPerMonth->sum('sum_discount'),
            'customer' => $customer,
        ]);
    }
}
