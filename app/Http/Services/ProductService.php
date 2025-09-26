<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo){
        $this->productRepo = $productRepo;
    }

    public function listProduct(){
        return $this->productRepo->getAll();
    }

    public function createProduct(array $data){
        return $this->productRepo->create($data);
    }

    public function updateProduct($id, array $data){
        $product = $this->productRepo->findById($id);
        return $this->productRepo->update($product, $data);
    }

    public function deleteProduct($id){
        $product = $this->productRepo->findById($id);

        if($product->image && Storage::disk('public')->exists($product->image)){
            Storage::disk('public')->delete($product->image);
        }
        return $product->delete();
    }

    public function getProductById($id){
        return $this->productRepo->findById($id);
    }

    public function getReport($startDate, $endDate){
        return [
            'details' => $this->productRepo->getProductMovement($startDate, $endDate),
            'summary' => $this->productRepo->getSummary($startDate, $endDate),
            'periode' => [$startDate, $endDate]
        ];
    }

    public function getReportByProduct($productId, $start, $end){
        return [
            'details' => $this->productRepo->getProductMovementByProduct($productId,$start, $end),
            'summary' => $this->productRepo->getSummaryByProduct($productId,$start, $end),
            'periode' => [$start, $end]
        ];
    }


}
