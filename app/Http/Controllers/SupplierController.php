<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryService;
use Illuminate\Http\Request;
use App\Http\Services\SupplierService;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService){
        $this->supplierService = $supplierService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = $this->supplierService->listSupplier();
        $products = Product::all();
        $categories = Category::all();
        return view('supplier.index', compact('suppliers','products', 'categories'));
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
        $dataSupplier = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $this->supplierService->createSupplier($dataSupplier);
        return redirect()->route('supplier.index');
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
        $supplier = $this->supplierService->getSupplierById($id);
        return view('supplier.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataSupplier = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $this->supplierService->updateSupplier($id, $dataSupplier);
        return redirect()
        ->route('supplier.index')
        ->with('success', 'supplier updated succsessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->supplierService->deleteSupplier($id);
        return redirect()
        ->route('category.index')
        ->with('success', 'supplier deleted');
    }
}
