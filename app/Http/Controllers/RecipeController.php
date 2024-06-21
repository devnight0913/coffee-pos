<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResourceCollection;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\RecipeDetail;
use App\Models\Item;
use App\Models\Settings;
use App\Traits\Availability;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Log;

class RecipeController extends Controller
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

        return view("recipe.index", [
            'categories' => $categories,
        ]);
    }


    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view("recipe.create");
    }
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function edit(Recipe $recipe): View
    {
        $items = Recipe::with("recipe_details.item.category")->where('id', $recipe->id)->first();
        // dd($items);
        return view("recipe.edit", [
            'recipe' => $recipe,
            'items' => $items
        ]);
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        Log::info("delete");
        $recipe->delete();
        return Redirect::back()->with("success", __("Deleted"));
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageDestroy(Recipe $recipe): RedirectResponse
    {
        $recipe->deleteImage();
        return Redirect::back()->with("success", __("Image Removed"));
    }

    /**
     * Show resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string'],
        ]);

        $items = (object)$request->items;

        $recipe = Recipe::create([
            'name' => $request->name,
            'price' => $request->price ?? 0,
            'description' => $request->description,
            'is_active' => $this->isAvailable($request->status),
        ]);

        if ($request->has('image')) {
            $recipe->updateImage($request->image);
        }

        foreach ($items as $titem) {
            $titem = (object)$titem;
            $item = Item::where('id', $titem->item_id)->first(); // check item if valid
            if ($item) {
                $item_detail = new RecipeDetail();

                $item_detail->quantity = $titem->amount;
                $item_detail->item()->associate($item);
                $item_detail->recipe()->associate($recipe);
                $item_detail->save();
            }
        }
        return Redirect::back()->with("success", __("Created"));
    }

    /**
     * update resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string'],
        ]);

        // dd($request->status);
        $items = (object)$request->items;

        $recipe->update([
            'name' => $request->name,
            'price' => $request->price ?? 0,
            'description' => $request->description,
            'is_active' => $this->isAvailable($request->status),
        ]);

        if ($request->has('image')) {
            $recipe->updateImage($request->image);
        }

        $recipe->recipe_details()->delete();

        foreach ($items as $titem) {
            $titem = (object)$titem;
            $item = Item::where('id', $titem->item_id)->first(); // check item if valid
            if ($item) {
                $item_detail = new RecipeDetail();

                $item_detail->quantity = $titem->amount;
                $item_detail->item()->associate($item);
                $item_detail->recipe()->associate($recipe);
                $item_detail->save();
            }
        }
        return Redirect::back()->with("success", __("Updated"));
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
    public function getRecipes()
    {
        // return Recipe::all();
        return $this->jsonResponse(["data" => new RecipeResourceCollection(
            Recipe::all()->where('is_active', 1)
        )]);
    }
}
