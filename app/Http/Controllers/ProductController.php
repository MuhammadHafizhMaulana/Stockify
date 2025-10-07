<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Imports\ProductStockImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Services\ProductService;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\ActivityLogService;

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
        // $products = Product::with('supplier', 'category');
        // $suppliers = Supplier::all();
        // $categories = Category::all();
        // $productAttributes = ProductAttribute::all();

        $products = Product::with(['supplier','category','productAttribute','stockTransaction'])->get();

        // Kalau butuh dropdown supplier/category
        $suppliers = Supplier::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        return view('product.index', compact('products', 'suppliers', 'categories'));
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

        // ubah ke lower case
        $data['name'] = strtolower($data['name']);
        $data['sku'] = strtolower($data['sku']);
        $data['description'] = strtolower($data['description']);

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


        // ubah ke lower case
        $data['name'] = strtolower($data['name']);
        $data['sku'] = strtolower($data['sku']);
        $data['description'] = strtolower($data['description']);

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

        // hapus foto
        if ($product->image && Storage::disk('public')->exists($product->image)){
            Storage::disk('public')->delete($product->image);
        }

        // hapus attribute yang terkait
        $product->productAttribute()->delete();

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

    public function formInput(){
        return view('product.import.form');
    }

    public function previewImport(Request $request){

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $collection = Excel::ToCollection(null, $request->file('file'))->first();

        $rows = $collection->skip(1)->map(function($row,$index){
            $supplier = Supplier::where('name', $row[2])->first();
            $category = Category::where('name', $row[3])->first();

            if(!$supplier){
                throw new \Exception("Supplier '{$row[2]}' tidak ditemukan pada baris ke- " . ($index + 2));
            }

            if(!$category){
                throw new \Exception("Category '{$row[3]}' tidak ditemukan pada baris ke- " . ($index + 2));
            }

            return [
            'name'              => $row['0'],
            'sku'               => $row['1'],
            'supplier_id'       => Supplier::where('name',$row['2'])->value('id'),
            'category_id'       => Category::where('name', $row['3'])->value('id'),
            'description'       => $row['4'],
            'purchase_price'    => $row['5'],
            'selling_price'     => $row['6'],
            'minimum_stock'     => $row['7'],
            'current_stock'     => $row['8'] ?? 0,
            ];
        });

        session(['import_data' => $rows]);

        return view('product.import.preview', compact('rows'));
    }

    public function import(Request $request, ActivityLogService $logService){
        $rows = session('import_data');

        if (!$rows || $rows->isEmpty()){
            return redirect()->route('product.import.form')->with('eror','File not found');
        }

        foreach($rows as $row){
            $product = Product ::where('sku', $row['sku'])
                        ->where('supplier_id', $row['supplier_id'])
                        ->first();

            if($product){
                $product->current_stock += $row['current_stock'];
                $product->save();

                $logService->log(
                    'update_stock(import)',
                    "Import produk baru {$product->name}"
                );
            } else{

                $newProduct = Product::create($row);
                $logService->log(
                    'create_transaction(import)',
                    "Import produk baru {$newProduct->name}"
                );
            }
        }

        session()->forget('import_data');

        return redirect()->route('product.index')
                         ->with('success', 'Data has been imported');
    }
}
