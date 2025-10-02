<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\ActivityLogService;
use App\Http\Services\StockTransactionService;

class StockTransactionController extends Controller
{
    protected $stockTransactionService;
    public function __construct( StockTransactionService $stockTransactionService ){
        $this->stockTransactionService = $stockTransactionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockTransactions = $this->stockTransactionService->listStockTransaction();
        $product = Product::all();
        return view('stockTransaction.index', compact('stockTransactions', 'product'));
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
        //dd($request->all()); // hentikan proses dan tampilkan semua data POS
        $data = $request->validate([
            'type' => 'required',
            'quantity' => 'required',
            'status' => 'required',
            'notes' => 'required',
            'product_id' => 'required',
        ]);

        $user_id = Auth::user()->id;

        $data['user_id'] = $user_id;

        $stockTransaction = $this->stockTransactionService->createStockTransaction($data);

        $product = Product::find($data['product_id']);

        $logService->log(
            'create_transaction',
            "Menambahkan transaksi {$data['type']} untuk produk {$product->name} " .
            "(Transaksi ID: {$stockTransaction->id}, sebanyak: {$data['quantity']})"
        );

        return redirect()->route('stockTransaction.index');
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
    public function edit(string $id, ActivityLogService $logService)
    {
        $stockTransaction = $this->stockTransactionService->getStockTransactionById($id);
        $product = Product::all();

        $logService->log(
            'view edit trasaction',
            "User membuka halaman edit transaksi stok (ID: {'$stockTransaction->id'}, Produk: 1stockTransaction->product->name})"
        );

        return view('stockTransaction.edit', compact('stockTransaction', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, ActivityLogService $logService)
    {
        $data = $request->validate([
            'type' => 'required',
            'quantity' => 'required|integer',
            'status' => 'required',
            'notes' => 'required',
            'product_id' => 'required|exists:products,id',
        ]);

        // Mengambil transaksi lama
        $old = $this->stockTransactionService->getStockTransactionById($id);

        $oldData = [
            'type' => $old->type,
            'quantity' => $old->quantity,
            'status' => $old->status,
            'notes' => $old->notes,
            'product_id' => $old->product_id,
        ];

        // Update data transaksi
        $this->stockTransactionService->updateStockTransaction($id, $data);

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

            $description = "Mengubah transaksi stok ID {$old->id} (" .
                implode(', ', $parts) . ")";

            $logService->log('edit_transaction', $description);
        }

        // Membuat deskripsi log
        $description = sprintf(
            'Mengubah transaksi stok'
        );


        return redirect()
        ->route('stockTransaction.index')
        ->with('success', 'Stock Transaction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ActivityLogService $logService)
    {
        // Ambil transaksi
        $transaction = $this->stockTransactionService->getStockTransactionById($id);

        if(!$transaction){
            return redirect()
            ->route('stockTransaction.index')
            ->with('error', 'Transaksi tidak ditemukan');
        }

        // Hapus Transaksi
        $this->stockTransactionService->deleteStockTransaction($id);

        // Buat log
        $logService->log(
            'delete_trasaction',
            "Menghapus transaksi stok ID {$transaction->id}, ".
            "Produk {$transaction->product}, ".
            "Jumlah {$transaction->quantity}, ".
            "Tipe {$transaction->type}, "
        );

        return redirect()
        ->route('stockTransaction.index')
        ->with('success', 'Stock Transaction deleted successfully');
    }

    public function countPending()
    {
        return \App\Models\StockTransaction::where('status', 'pending')->count();
    }

    public function approve($id, ActivityLogService $logService)
    {
        // Ambil data
        $transaction = $this->stockTransactionService->getStockTransactionById($id);

        // Setujui
        $this->stockTransactionService->updateStatus($id, 'diterima');

        // Buat log
        $logService->log(
            'approve_trasaction',
            "Approve transaksi stok ID {$transaction->id}, ".
            "Produk {$transaction->product->name}, ".
            "Jumlah {$transaction->quantity}, ".
            "Tipe {$transaction->type}, "
        );

        return redirect()->back()->with('success', 'Transaction Successfully Accepted');
    }
    public function reject($id, ActivityLogService $logService)
    {
        // Ambil data
        $transaction = $this->stockTransactionService->getStockTransactionById($id);

        // Tolak
        $this->stockTransactionService->updateStatus($id, 'ditolak');

        // Buat log
        $logService->log(
            'reject_trasaction',
            "Reject transaksi stok ID {$transaction->id}, ".
            "Produk {$transaction->product}, ".
            "Jumlah {$transaction->quantity}, ".
            "Tipe {$transaction->type}, "
        );

        return redirect()->back()->with('success', 'Transaction Successfully Rejected');
    }

}
