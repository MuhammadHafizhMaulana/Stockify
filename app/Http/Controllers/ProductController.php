<?php

namespace App\Http\Controllers;

use App\Http\Services\ActivityLogService;
use App\Models\Product;
use App\Http\Services\ProductService;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $product_service)
    {
        // Dependency Injection
        $this->productService = $product_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        $categories = Category::all();
        $productAttributes = ProductAttribute::all();
        return view('product.index', compact('products', 'suppliers', 'categories', 'productAttributes'));
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
    public function store(Request $request, ActivityLogService $logService)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'sku' => 'required|string|unique:products,sku',
            'supplier_id' => 'required',
            'category_id' => 'required',
            'description' => 'required|string',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'minimum_stock' => 'required|integer|min:1',
        ]);

        $product = $this->productService->createProduct($data);
        $supplierName = Supplier::find($data['supplier_id'])->name;
        $categoryName = Category::find($data['category_id'])->name;

        $logService->log(
            'create_transaction',
            "Menambahkan product {$data['name']} , sku : {$data['sku']}, supplier :$supplierName, category : $categoryName"
        );

        if($request->hasFile('image')){
            $file = $request->file('image');

            $filename = $product->id. '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('products',$filename,'public');

            $logService->log(
            'Add_image',
            "Menambahkan image ke product {$data['name']}"
        );

            $this->productService->updateProduct( $product->id,['image'=> $path]);
        }

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('product.detail', compact('product', 'suppliers', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->productService->getProductById($id);
        $supplier = Supplier::all();
        $category = Category::all();
        return view('product.edit', compact('product', 'supplier', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ActivityLogService $logService)
    {
        $product = $this->productService->getProductById($id);

        $data = $request->validate([
            'name' => 'required|string',
            'sku' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'description' => 'required',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'minimum_stock' => 'required|integer',
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');

            //hapus file lama
            if($product->image && Storage::disk('public')->exists($product->image)){
                Storage::disk('public')->delete($product->image);
            }

            $file = $request->file('image');

            $filename = $product->id. '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('products',$filename,'public');
            $data['image'] = $path;

            $product->update(['image' => $path]);
        }

        $old = $this->productService->getProductById($id);
        $oldData = [
            'name' => $old->name,
            'sku' => $old->sku,
            'category_id' => $old->category_id,
            'supplier_id' => $old->supplier_id,
            'description' => $old->description,
            'purchase_price' => $old->purchase_price,
            'selling_price' => $old->selling_price,
            'image' => $old->image,
            'minimum_stock' => $old->minimum_stock,
        ];

        $this->productService->updateProduct($id, $data);

        // Membandingkan field yang berubah
        $changed = [];
        foreach($data as $key => $newValue){
            if (array_key_exists($key,$oldData) && $oldData[$key] != $newValue){
                $changed[$key] = [
                    'old' => $oldData[$key],
                    'new' => $newValue
                ];
            }
        }

        // Membuat deskripsi data yang berubah
        if (!empty($changed)){
            $parts = [];
            foreach ($changed as $field => $values){
                // Menampilkan nama produk
                if($field === 'product_id'){
                    $oldName = optional($old->product)->name ?? '-';
                    $newName = optional(Product::find($values['new']))->name ?? '-';
                    $parts[] = "produk: {$oldName} → {$newName}";
                } else {
                    $parts[] = "{$field}: {$values['old']} → {$values['new']}}";
                }
            }

            $description = "Mengubah product ID {$old->id} (" .
                implode(', ', $parts) . ")";

            $logService->log('edit_product', $description);
        }

        // Membuat deskripsi log
        $description = sprintf(
            'Mengubah product'
        );

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ActivityLogService $logService)
    {
        $product = $this->productService->getProductById($id);
        if(!$product){
            return redirect()
            ->route('product.index')
            ->with('error', 'Transaksi tidak ditemukan');
        }

        // hapus product
        $this->productService->deleteProduct($id);

        // Buat log
        $logService->log(
            'delete_product',
            "Menghapus transaksi product ID {$product->id}, ".
            "Produk {$product->name}, ".
            "SKU {$product->sku}, ".
            "Supplier {$product->supplier}, ".
            "Category {$product->category}, "
        );
        return redirect()->route('product.index');
    }
}
