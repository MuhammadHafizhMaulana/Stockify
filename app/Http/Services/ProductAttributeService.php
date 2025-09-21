<?php

namespace App\Http\Services;

use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\ProductAttributeRepository;
use App\Models\ProductAttribute;

class ProductAttributeService{

    protected $productAttributeRepo;

    public function __construct(ProductAttributeRepository $productAttributeRepo){
        $this->productAttributeRepo = $productAttributeRepo;
    }

    public function listProductAttribute(){
        return $this->productAttributeRepo->getAll();
    }

    public function createProductAttribute(array $dataProductAttributeRepo){
        return $this->productAttributeRepo->create($dataProductAttributeRepo);
    }

    public function updateProductAttribute($id, array $dataProductAttributeRepo){
        $productAttribute = $this->productAttributeRepo->findById($id);
        return $this->productAttributeRepo->update($productAttribute, $dataProductAttributeRepo);
    }

    public function deleteProductAttribute($id){
        $productAttribute = $this->productAttributeRepo->findById($id);
        return $this->productAttributeRepo->delete($productAttribute);
    }

    public function getProductAttributeById($id){
        return $this->productAttributeRepo->findById($id);
    }
}
