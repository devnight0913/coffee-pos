<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $length = $request->get("length"); // Rows display per page

        $order = $request->get('order');
        $columns = $request->get('columns');
        $search = $request->get('search');
        //dd($request->get('category'));
        $columnIndex = $order[0]['column']; // Column index
        $columnName = $columns[$columnIndex]['data']; // Column name
        $columnSortOrder = $order[0]['dir']; // asc or desc
        $searchValue = $search['value']; // Search value

        $totalRecords = Order::select('count(*) as allcount')->count();   // Total records
        $iTotalDisplayRecords = Order::select('count(*) as allcount')->search($searchValue)->count();

        // Fetch records
        $records = Order::with('customer', 'user', 'order_details')
            ->search($searchValue)
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($length)
            ->get();


            //  dd($records);
        $aaData = array();
        foreach ($records as $record) {
            $aaData[] = array(
                "id" => $record->id,
                "number" => $record->number,
                "has_customer" => $record->has_customer,
                "customer_name" => $record->customer_name,
                "discount" => $record->discount_view,
                "delivery_charge" => $record->delivery_charge_view,
                "subtotal" => $record->subtotal_view,
                "total" => $record->total_view,
                "tender_amount" => $record->tender_amount_view,
                "owe" => $record->owe_view,
                "created_at" => $record->created_at_view,
                "author_name" => $record->author_name,
                "is_paid" => $record->paid
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $iTotalDisplayRecords,
            "aaData" => $aaData
        );
        
        return response()->json($response);
    }
}
