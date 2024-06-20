<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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

        $totalRecords = Category::select('count(*) as allcount')->count();   // Total records
        $iTotalDisplayRecords = Category::select('count(*) as allcount')->search($searchValue)->count();

        // Fetch records
        $records = Category::search($searchValue)
            ->orderBy($columnName == 'sort_number' ? 'sort_order' : $columnName, $columnSortOrder)
            ->skip($start)
            ->take($length)
            ->get();

        $aaData = array();

        foreach ($records as $record) {
            $aaData[] = array(
                "id" => $record->id,
                "image" => $record->image_url,
                "name" => $record->name,
                "sort_number" => $record->sort_order,
                "is_active" => $record->is_active,
                "status" => $record->status,
                "status_badge_bg_color" => $record->status_badge_bg_color,
                "created_at" => $record->created_at,
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
