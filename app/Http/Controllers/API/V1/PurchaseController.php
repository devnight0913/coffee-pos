<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function getOptions(Request $request) 
    {
        $supplier_id = $request->supplier_id;
        $categories = Category::with('items')->where('supplier_id', $supplier_id)->orderBy('sort_order', 'ASC')->get();
        return response()->json($categories);
    }
}
