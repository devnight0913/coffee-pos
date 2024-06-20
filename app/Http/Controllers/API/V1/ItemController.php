<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
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
        
        $columnIndex = $order[0]['column']; // Column index
        $columnName = $columns[$columnIndex]['data']; // Column name
        $columnSortOrder = $order[0]['dir']; // asc or desc
        $searchValue = $search['value']; // Search value

        $totalRecords = Item::select('count(*) as allcount')->count();   // Total records
        $iTotalDisplayRecords = Item::select('count(*) as allcount')->search($searchValue)->count();

        // Fetch records
        $records = Item::with('category', 'supplier')
            ->search($searchValue)
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($length)
            ->get();

            // dd($records);
        $aaData = array();
        foreach ($records as $record) {
            $aaData[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "image" => $record->image_url,
                "cost" => $record->table_view_cost,
                "in_stock" => $record->view_in_stock,
                "description" => $record->description,
                "is_active" => $record->is_active,
                "status" => $record->status,
                "status_badge_bg_color" => $record->status_badge_bg_color,
                "category" => $record->category->name,
                "supplier" => $record->supplier->name,
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
