<?php

namespace App\Http\Repositories;

use App\Models\StockTransaction;

class StockTransactionRepository{
    public function getAll(){
        return StockTransaction::all();
    }

    public function findById($id){
        return StockTransaction::findOrFail($id);
    }

    public function create(array $data){
        return StockTransaction::create($data);
    }

    public function update(StockTransaction $stockTransaction, array $data){
        return $stockTransaction->update($data);
    }

    public function delete(StockTransaction $stockTransaction){
        return $stockTransaction->delete();
    }

    public function updateStatus(StockTransaction $stockTransaction, string $status):StockTransaction{
        $stockTransaction->update(['status' => $status]);
        return $stockTransaction;
    }
}
