<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\StockTransactionService;
use App\Models\StockTransaction;

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
    public function store(Request $request)
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

        $this->stockTransactionService->createStockTransaction($data);
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
    public function edit(string $id)
    {
        $stockTransaction = $this->stockTransactionService->getStockTransactionById($id);
        $product = Product::all();
        return view('stockTransaction.edit', compact('stockTransaction', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'type' => 'required',
            'quantity' => 'required|integer',
            'status' => 'required',
            'notes' => 'required',
            'product_id' => 'required|exists:products,id',
        ]);

        $this->stockTransactionService->updateStockTransaction($id, $data);
        return redirect()
        ->route('stockTransaction.index')
        ->with('success', 'Stock Transaction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->stockTransactionService->deleteStockTransaction($id);
        return redirect()->route('stockTransaction.index');
    }

    public function countPending()
    {
        return \App\Models\StockTransaction::where('status', 'pending')->count();
    }

    public function approve($id)
    {
        $this->stockTransactionService->updateStatus($id, 'diterima');

        return redirect()->back()->with('success', 'Transaction Successfully Accepted');
    }
    public function reject($id)
    {
        $this->stockTransactionService->updateStatus($id, 'ditolak');

        return redirect()->back()->with('success', 'Transaction Successfully Rejected');
    }

}
