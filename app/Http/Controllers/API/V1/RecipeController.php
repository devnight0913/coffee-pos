<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
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

        $totalRecords = Recipe::select('count(*) as allcount')->count();   // Total records
        $iTotalDisplayRecords = Recipe::select('count(*) as allcount')->search($searchValue)->count();

        // Fetch records
        $records = Recipe::with("recipe_details.item")
            ->search($searchValue)
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($length)
            ->get();

        $aaData = array();
        foreach ($records as $record) {
            $recipe_details = $record -> recipe_details;
            $cost = 0;
            foreach($recipe_details as $recipe_detail) {
                $cost = $cost + $recipe_detail->quantity * $recipe_detail->item->cost;
            }
            $aaData[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "image" => $record->image_url,
                "cost" => Recipe::getCost($cost),
                "price" => $record->table_view_price,
                "description" => $record->description,
                "is_active" => $record->is_active,
                "status" => $record->status,
                "status_badge_bg_color" => $record->status_badge_bg_color
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
