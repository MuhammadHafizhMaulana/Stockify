<?php

namespace App\Http\Controllers;

use App\Http\Services\ActivityLogService;
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
    public function store(Request $request, ActivityLogService $logService)
    {
        $dataSupplier = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $dataSupplier['name'] = strtolower($dataSupplier['name']);

        // Membuat data supplier
        $this->supplierService->createSupplier($dataSupplier);

        $logService->log(
            'create_supplier',
            "Menambahkan supplier {$dataSupplier['name']} "
        );
        return redirect()->route('supplier.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = $this->supplierService->getSupplierById($id);
        $products = $supplier->product;
        $category = Category::with('product')->findOrFail($id);

        return view('supplier.detail', compact('supplier', 'products', 'category'));


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
    public function update(Request $request, string $id, ActivityLogService $logService)
    {
        $dataSupplier = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $old = $this->supplierService->getSupplierById($id);

        $oldData = [
            'Nama' => $old->name,
            'Email' => $old->email
        ];

        $dataSupplier['name'] = strtolower($dataSupplier['name']);

        // Edit supplier
        $this->supplierService->updateSupplier($id, $dataSupplier);

        // Membandingkan field yang berubah
        $changed = [];
        foreach($dataSupplier as $key => $newValue){
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
                if($field === 'supplier_id'){
                    $oldName = optional($old->supplier)->name ?? '-';
                    $newName = optional(Product::find($values['new']))->name ?? '-';
                    $parts[] = "supplier: {$oldName} → {$newName}";
                } else {
                    $parts[] = "{$field}: {$values['old']} → {$values['new']}}";
                }
            }

            $description = "Mengubah data supplier ID {$old->id} (" .
                implode(', ', $parts) . ")";

            $logService->log('edit_supplier', $description);
        }

        // Membuat deskripsi log
        $description = sprintf(
            'Mengubah data supplier'
        );

        $logService->log(
            'edit_supplier'
        );

        return redirect()
        ->route('supplier.index')
        ->with('success', 'supplier updated succsessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ActivityLogService $logService)
    {
        // ambil data
        $supplier = $this->supplierService->getSupplierById($id);

        // Buat log
        $logService->log(
            'delete_supplier',
            "Menghapus Supplier ID {$supplier->id}, ".
            "Supplier {$supplier->name}, ".
            "Email {$supplier->email}, ".
            "Phone {$supplier->phone}, "
        );

        // hapus supplier
        $this->supplierService->deleteSupplier($id);
        return redirect()
        ->route('supplier.index')
        ->with('success', 'supplier deleted');
    }
}
