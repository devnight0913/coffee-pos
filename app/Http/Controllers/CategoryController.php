<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResourceCollection;
use App\Models\Category;
use App\Traits\Availability;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{

    use Availability;
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {

        return view("categories.index");
    }

    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view("categories.create");
    }
    /**
     * Show resources.
     * 
     * @return \Illuminate\View\View
     */
    public function edit(Category $category): View
    {
        return view("categories.edit", [
            'category' => $category
        ]);
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return Redirect::back()->with("success", __("Deleted"));
    }
    /**
     * Delete resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function imageDestroy(Category $category): RedirectResponse
    {
        $category->deleteImage();
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
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'status' => ['required', 'string'],
        ]);

        $category = Category::create([
            'name' => $request->name,
            'sort_order' => $request->sort_order ?? 1,
            'is_active' => $this->isAvailable($request->status),
        ]);

        if ($request->has('image')) {
            $category->updateImage($request->image);
        }
        return Redirect::back()->with("success", __("Created"));
    }

    /**
     * update resources.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'sort_order' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'mimes:jpeg,jpg,png', 'max:2024'],
            'status' => ['required', 'string'],
        ]);

        $category->update([
            'name' => $request->name,
            'sort_order' => $request->sort_order,
            'is_active' => $this->isAvailable($request->status),
        ]);
        if ($request->has('image')) {
            $category->updateImage($request->image);
        }
        return Redirect::back()->with("success", __("Updated"));
    }

    /**
     * Show resources.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        return $this->jsonResponse(["data" => new CategoryResourceCollection(
            Category::with(['items' =>  function ($query) {
                $query->active()->orderBy("sort_order", "ASC")->orderBy("created_at", "ASC");
            }])->active()->orderBy("sort_order", "ASC")->latest()->get()
        )]);
    }
}
