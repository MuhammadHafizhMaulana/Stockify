<?php

namespace App\Http\Controllers;

use App\Http\Services\ActivityLogService;
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
    public function store(Request $request, ActivityLogService $logService)
    {
        $data = $request->validate([
            'name' => 'required',
            'value' => 'required',
            'product_id' => 'required|exists:products,id',
        ]);

        $data['name'] = strtolower($data['name']);

        $this->productAttributeService->createProductAttribute($data);

        $productName = Product::find($data['product_id'])->name;

        $logService->log(
            'create_transaction',
            "Menambahkan product attribute nama attribute :{$data['name']}, value : {$data['value']}, produk : $productName  "
        );

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
    public function update(Request $request, string $id, ActivityLogService $logService)
    {
        $data = $request->validate([
            'name' => 'required',
            'value' => 'required',
            'product_id' => 'required|exists:products,id'
        ]);

        $old = $this->productAttributeService->getProductAttributeById($id);
        $oldData = [
            'name' => $old->name,
            'value' => $old->value,
            'product_id' => $old->product_id,
        ];

        $data['name'] = strtolower($data['name']);

        // Mengupdate product attribute
        $this->productAttributeService->updateProductAttribute($id, $data);

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
                if($field === 'productAttribute_id'){
                    $oldName = optional($old->product)->name ?? '-';
                    $newName = optional(Product::find($values['new']))->name ?? '-';
                    $parts[] = "productAttribute: {$oldName} → {$newName}";
                } else {
                    $parts[] = "{$field}: {$values['old']} → {$values['new']}}";
                }
            }

            $description = "Mengubah product attribute ID {$old->id} (" .
                implode(', ', $parts) . ")";

            $logService->log('edit_productAtrribute', $description);
        }

        // Membuat deskripsi log
        $description = sprintf(
            'Mengubah transaksi attribute'
        );

        return redirect()
        ->route('productAttribute.index')
        ->with('success', 'Product Attribute updated succsessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ActivityLogService $logService)
    {
        // Ambil attribute
        $attribute = $this->productAttributeService->getProductAttributeById($id);

        if(!$attribute){
            return redirect()
            ->route('stockTransaction.index')
            ->with('error', 'Transaksi tidak ditemukan');
        }

        $productName = Product::find($attribute['product_id']);

         // Buat log
        $logService->log(
            'delete_attribute',
            "Menghapus transaksi attribute product ID {$attribute->id} untuk product $productName, ".
            "value {$attribute->value}, "
        );

        $this->productAttributeService->deleteProductAttribute($id);
        return redirect()->route('productAttribute.index');
    }
}
