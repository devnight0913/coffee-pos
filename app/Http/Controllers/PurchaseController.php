<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Settings;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $purchases = Purchase::search(trim($request->search_query))->with('supplier')->orderBy('date', 'DESC')->paginate(20);

        return view('purchases.index', [
            'purchases' => $purchases
        ]);
    }

    public function create(Request $request)
    {
        $suppliers = Supplier::orderBy('name')->get();
        $categories = Category::with('items')->orderBy('sort_order', 'ASC')->get();

        return view('purchases.create', [
            'categories' => $categories,
            'suppliers' => $suppliers,
            'currency' => Settings::getValue(Settings::CURRENCY_SYMBOL),
        ]);
    }
    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::orderBy('name')->get();
        $categories = Category::with('items')->orderBy('sort_order', 'ASC')->get();

        return view('purchases.edit', [
            'purchase' => $purchase,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'currency' => Settings::getValue(Settings::CURRENCY_SYMBOL),
        ]);
    }

    public function show(Request $request, Purchase $purchase)
    {

        return view('purchases.show', [
            'purchase' => $purchase,
        ]);
    }
    public function print(Request $request, Purchase $purchase)
    {

        return view('purchases.print', [
            'purchase' => $purchase,
            'settings' => Settings::getValues(),
        ]);
    }

    public function destroy(Purchase $purchase)
    {

        foreach ($purchase->purchase_details as $detail) {
            $item = Item::find($detail->item_id);
            if (!$item) return back()->with('error', __('Item Not Found'));
            if($item->in_stock == $detail->quantity) $newCost = 0;
            else $newCost = (($item->in_stock * $item->cost) - ($detail->quantity * $detail->cost)) / ($item->in_stock - $detail->quantity);
            $item->in_stock -= $detail->quantity;
            $item->cost = round($newCost, 2);
            $item->save();
        }

        $purchase->delete();

        return back()->with('success', __('Deleted'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'item.*' => ['required', 'string'],
            'cost.*' => ['nullable', 'numeric', 'min:0.001'],
            'quantity.*' => ['nullable', 'numeric', 'min:0'],
            'supplier' => ['nullable', 'string'],
            'reference_number' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string'],
            'date' => ['required', 'date'],
        ]);
        $items = $request->item;
        if (!$items) {
            return back()->with('error', __('No item selected'));
        }
        $purchase = new Purchase();
        $purchase->supplier_id = $request->supplier;
        $purchase->reference_number = $request->reference_number;
        $purchase->notes = $request->notes;
        $purchase->date = $request->date ?? now();;
        $purchase->save();

        $costs = $request->cost;
        $quantities = $request->quantity;
        for ($count = 0; $count < count($items); $count++) {
            $item = Item::find($items[$count]);
            if (!$item) return back()->with('error', __('Item Not Found'));
            $newCost = (($item->in_stock * $item->cost) + $costs[$count]) / ($item->in_stock + $quantities[$count]);
            $item->in_stock += $quantities[$count];
            $item->cost = $newCost;
            $item->save();

            $purchaseDetails = new PurchaseDetail();
            $purchaseDetails->purchase_id = $purchase->id;
            $purchaseDetails->item_id = $item->id;
            $purchaseDetails->cost = $costs[$count];
            $purchaseDetails->quantity = $quantities[$count];
            $purchaseDetails->save();
        }

        return back()->with('success', __('Created'));
    }


    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'item.*' => ['required', 'string'],
            'cost.*' => ['nullable', 'numeric', 'min:0.001'],
            'quantity.*' => ['nullable', 'numeric', 'min:0'],
            'supplier' => ['nullable', 'string'],
            'reference_number' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string'],
            'date' => ['required', 'date'],
        ]);
        $items = $request->item;
        if (!$items) {
            return back()->with('error', __('No item selected'));
        }


        $purchase->supplier_id = $request->supplier;
        $purchase->reference_number = $request->reference_number;
        $purchase->notes = $request->notes;
        $purchase->date = $request->date ?? now();;
        $purchase->save();


        foreach ($purchase->purchase_details as $detail) {
            $item = Item::find($detail->item_id);
            if (!$item) return back()->with('error', __('Item Not Found'));
            $newCost = (($item->in_stock * $item->cost) - $detail->cost) / ($item->in_stock - $detail->quantity);
            $item->in_stock -= $detail->quantity;
            $item->cost = round($newCost, 2);
            $item->save();
            $detail->delete();
        }

        $costs = $request->cost;
        $quantities = $request->quantity;

        for ($count = 0; $count < count($items); $count++) {
            $item = Item::find($items[$count]);
            if (!$item) return back()->with('error', __('Item Not Found'));
            $newCost = (($item->in_stock * $item->cost) + $costs[$count]) / ($item->in_stock + $quantities[$count]);
            $item->in_stock += $quantities[$count];
            $item->cost = $newCost;
            $item->save();

            $purchaseDetails = new PurchaseDetail();
            $purchaseDetails->purchase_id = $purchase->id;
            $purchaseDetails->item_id = $item->id;
            $purchaseDetails->cost = $costs[$count];
            $purchaseDetails->quantity = $quantities[$count];
            $purchaseDetails->save();
        }


        return back()->with('success', __('Success'));
    }
}
