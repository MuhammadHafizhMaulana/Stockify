<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductAttributeService;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    protected $productAttributeService;

    public function __construct(ProductAttributeService $productAttributeService){
        $this->productAttributeService = $productAttributeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productAttributes = $this->productAttributeService->listProductAttribute();
        $product = Product::all();
        return view('productAttribute.index', compact('productAttributes', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'value' => 'required',
            'product_id' => 'required|exists:products,id',
        ]);

        $this->productAttributeService->createProductAttribute($data);
        return redirect()->route('productAttribute.index');
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
        $productAttribute = $this->productAttributeService->getProductAttributeById($id);
        $products = Product::all();
        return view('productAttribute.edit', compact('productAttribute', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'value' => 'required',
            'product_id' => 'required|exists:products,id'
        ]);

        $this->productAttributeService->updateProductAttribute($id, $data);
        return redirect()
        ->route('productAttribute.index')
        ->with('success', 'Product Attribute updated succsessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productAttributeService->deleteProductAttribute($id);
        return redirect()->route('productAttribute.index');
    }
}
