<?php

namespace App\Http\Repositories;

use App\Models\Product;

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
}

