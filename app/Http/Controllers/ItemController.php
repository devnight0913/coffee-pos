<?php

namespace App\Http\Controllers;

use App\Http\Resources\itemselectResourceCollection;
use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Settings;
use App\Traits\Availability;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Log;

class ItemController extends Controller
{
    use Availability;
    /**
     * Show resources. 
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {

        $categories = Category::orderBy('sort_order', 'ASC')->get();

        return view("items.index", [
            'categories' => $categories,
            'suppliers' => Supplier::all(),
        ]);
    }


    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function create(): View
    {

        return view("items.create", [
            'categories' => Category::orderBy('sort_order', 'ASC')->get(),
            'suppliers' => Supplier::all(),
        ]);
    }
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function edit(Item $item): View
    {
        return view("items.edit", [
            'item' => $item,
            'categories' => Category::orderBy('sort_order', 'ASC')->get(),
            'suppliers' => Supplier::all(),
        ]);
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Item $item): RedirectResponse
    {
        Log::info("delete");
        $item->delete();
        return Redirect::back()->with("success", __("Deleted"));
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageDestroy(Item $item): RedirectResponse
    {
        $item->deleteImage();
        return Redirect::back()->with("success", __("Image Removed"));
    }

    /**
     * Show resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info($request);
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'unit' => ['required', 'numeric', 'min:1', 'max:4'],
            'cost' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'in_stock' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'string'],
            'category' => ['required', 'string'],
            'supplier' => ['required', 'string'],
        ]);

        $item = Item::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'price' => $request->price,
            'in_stock' => $request->in_stock,
            'description' => $request->description,
            'is_active' => $this->isAvailable($request->status),
            'category_id' => $request->category,
            'supplier_id' => $request->supplier,
            'unit' => $request->unit,
        ]);

        if ($request->has('image')) {
            $item->updateImage($request->image);
        }
        return Redirect::back()->with("success", __("Created"));
    }

    /**
     * update resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Item $item): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'unit' => ['required', 'numeric', 'min:1', 'max:4'],
            'cost' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'in_stock' => ['required', 'numeric'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'string'],
            'category' => ['required', 'string'],
            'supplier' => ['required', 'string'],
        ]);

        $item->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'price' => $request->price,
            'in_stock' => $request->in_stock,
            'description' => $request->description,
            'is_active' => $this->isAvailable($request->status),
            'category_id' => $request->category,
            'supplier_id' => $request->supplier,
            'unit' => $request->unit,
        ]);

        if ($request->has('image')) {
            $item->updateImage($request->image);
        }
        // return Redirect::back()->with("success", __("Updated"));
        return Redirect::route('items.index')->with("success", __("Updated"));
    }


    public function search(Request $request)
    {
        $query = trim($request->get('query'));
        if (is_null($query)) {
            return $this->jsonResponse(['data' => []]);
        }
        $items = Item::search($query)->latest()->take(10)->get();
        return $this->jsonResponse(['data' => new itemselectResourceCollection($items)]);
    }
    
    /**
     * Show resources.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItems()
    {
        return Item::all();
    }
}
