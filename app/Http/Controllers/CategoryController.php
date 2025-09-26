<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Services\CategoryService;
use App\Models\Supplier;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        // Dependency Injection
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->listCategory();
        $products = Product::all();
        $suppliers = Supplier::all();
        $title = 'Category';
        return view('category.index', compact('categories', 'title', 'products', 'suppliers' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataCategory = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->categoryService->createCategory($dataCategory);
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataCategory = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $this->categoryService->updateCategory($id, $dataCategory);
        return redirect()
        ->route('category.index')
        ->with('success', 'category updated succsessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categoryService->deleteCategory($id);
        return redirect()->route('category.index');
    }
}
