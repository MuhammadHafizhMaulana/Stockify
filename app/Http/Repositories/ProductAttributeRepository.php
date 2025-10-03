<?php

namespace App\Http\Repositories;

use App\Models\ProductAttribute;

class ProductAttributeRepository{
    public function getAll(){
        return ProductAttribute::all();
    }

    public function findById($id){
        return ProductAttribute::findOrFail($id);
    }

    public function create(array $data){
        return ProductAttribute::create($data);
    }

    public function update(ProductAttribute $productAttribute, array $data){
        return $productAttribute->update($data);
    }

    public function delete(ProductAttribute $productAttribute){
        return $productAttribute->delete();
    }

    public function findByProduct($product_id){
        return ProductAttribute::where('product_id', $product_id)->first();
    }
}
