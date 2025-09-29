<?php

namespace App\Http\Controllers;

use App\Http\Services\ActivityLogService;
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
    public function store(Request $request, ActivityLogService $logService)
    {
        $dataCategory = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $this->categoryService->createCategory($dataCategory);

        $logService->log(
            'create_category',
            "Menambahkan transaksi {$dataCategory['name']}"
        );

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
    public function update(Request $request, string $id, ActivityLogService $logService)
    {
        $dataCategory = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $old = $this->categoryService->getCategoryById($id);

        $oldData = [
            'nama' => $old->name
        ];

        // mengedit data
        $this->categoryService->updateCategory($id, $dataCategory);

        // Membandingkan field yang berubah
        $changed = [];
        foreach($dataCategory as $key => $newValue){
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
                if($field === 'category_id'){
                    $oldName = optional($old->product)->name ?? '-';
                    $newName = optional(Product::find($values['new']))->name ?? '-';
                    $parts[] = "category: {$oldName} → {$newName}";
                } else {
                    $parts[] = "{$field}: {$values['old']} → {$values['new']}}";
                }
            }

            $description = "Mengubah Category ID {$old->id} (" .
                implode(', ', $parts) . ")";

            $logService->log('edit_category', $description);
        }

        // Membuat deskripsi log
        $description = sprintf(
            'Mengubah category'
        );

        $logService->log(
            'edit_category'
        );
        return redirect()
        ->route('category.index')
        ->with('success', 'category updated succsessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ActivityLogService $logService)
    {
        // Ambil data
        $category = $this->categoryService->getCategoryById($id);
        if($category){
            return redirect()
            ->route('category.index')
            ->with('error', 'Category tidak ditemukan');
        }
        // Hapus Category
        $this->categoryService->deleteCategory($id);

        // Buat log
        $logService->log(
            'delete_category',
            "Menghapus category ID {$category->id}, ".
            "Nama {$category->product}, ".
            "Deskripsi {$category->description}, "
        );
        return redirect()->route('category.index');
    }
}
