<?php

namespace App\Http\Repositories;

use App\Models\Supplier;

class SupplierRepository
{
    public function getAll(){
        return Supplier::all();
    }

    public function findById($id){
        return Supplier::findOrFail($id);
    }

    public function create(array $data){
        return Supplier::create($data);
    }

    public function update(Supplier $supplier, array $data){
        return $supplier->update($data);
    }

    public function delete(Supplier $supplier){
        return $supplier->delete();
    }
}

