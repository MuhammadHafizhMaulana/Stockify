<?php

namespace App\Http\Services;

use App\Http\Repositories\SupplierRepository;


class SupplierService{

    protected $supplierRepo;

    public function __construct(SupplierRepository $supplierRepo){
        $this->supplierRepo = $supplierRepo;
    }

    public function listSupplier(){
        return $this->supplierRepo->getAll();
    }

    public function createSupplier(array $dataSupplier){
        return $this->supplierRepo->create($dataSupplier);
    }

    public function updateSupplier($id, array $dataSupplier){
        $supplier = $this->supplierRepo->findById($id);
        return $this->supplierRepo->update($supplier, $dataSupplier);
    }

    public function deleteSupplier($id){
        $supplier = $this->supplierRepo->findById($id);
        return $this->supplierRepo->delete($supplier);
    }

    public function getSupplierById($id){
        return $this->supplierRepo->findById($id);
    }
}
