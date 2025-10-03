<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Http\Repositories\StockTransactionRepository;

class StockTransactionService{

    protected $stockTransactionRepo;

    public function __construct(StockTransactionRepository $stockTransactionRepo){
        $this->stockTransactionRepo = $stockTransactionRepo;
    }

    public function listStockTransaction(){
        return $this->stockTransactionRepo->getAll();
    }

    public function createStockTransaction(array $dataStockTransaction){
        $product = Product::findOrFail($dataStockTransaction['product_id']);

        if ($dataStockTransaction['type'] === 'keluar'){
            if($product->current_stock <= 0 || $product->current_stock < $dataStockTransaction['quantity']) {
                $dataStockTransaction['status'] = 'ditolak';
            }
        }
        return StockTransaction::create($dataStockTransaction);
    }

    public function updateStockTransaction($id, array $dataStockTransaction){
        $stockTransaction = $this->stockTransactionRepo->findById($id);
        return $this->stockTransactionRepo->update($stockTransaction, $dataStockTransaction);
    }

    public function deleteStockTransaction($id){
        $stockTransaction = $this->stockTransactionRepo->findById($id);
        return $this->stockTransactionRepo->delete($stockTransaction);
    }

    public function getStockTransactionById($id){
        return $this->stockTransactionRepo->findById($id);
    }

    public function updateStatus(int $id, string $status){
        $stokTransaction = $this->stockTransactionRepo->findById($id);
        return $this->stockTransactionRepo->updateStatus($stokTransaction,$status);
    }

}
