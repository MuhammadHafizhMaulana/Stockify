<?php

namespace App\Http\Repositories;

use App\Models\Product;
use App\Models\StockTransaction;

class ProductRepository
{
    public function getAll(){
        return Product::all();
    }

    public function findById($id){
        return Product::findOrFail($id);
    }

    public function create(array $data){
        return Product::create($data);
    }

    public function update(Product $product, array $data){
        return $product->update($data);
    }

    public function delete(Product $product){
        return $product->delete();
    }

    //report semua produk

    public function getProductMovement($startDate, $endDate){
        return StockTransaction::with('product')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getSummary($startDate, $endDate){
        return StockTransaction::selectRaw('product_id,
        SUM(CASE WHEN type="masuk" THEN quantity ELSE 0 END) AS total_masuk,
        SUM(CASE WHEN type ="keluar" THEN quantity ELSE 0 END) AS total_keluar')
        ->whereBetween('created_at',[$startDate, $endDate])
        ->groupBy('product_id')
        ->with('product')
        ->get();
    }

    //report per produk

    public function getSummaryByProduct($productId, $startDate, $endDate){

        return StockTransaction::selectRaw('product_id,
        SUM(CASE WHEN type="masuk" THEN quantity ELSE 0 END) AS total_masuk,
        SUM(CASE WHEN type ="keluar" THEN quantity ELSE 0 END) AS total_keluar')
        ->where('product_id', $productId)
        ->whereBetween('created_at',[$startDate, $endDate])
        ->groupBy('product_id')
        ->with('product')
        ->first();
    }

    public function getProductMovementByProduct($productId, $startDate, $endDate){
        return StockTransaction::with(['product'])
        ->where('product_id', $productId)
        ->whereBetween('created_at',[$startDate, $endDate])
        ->orderBy('created_at')
        ->get();
    }
}

