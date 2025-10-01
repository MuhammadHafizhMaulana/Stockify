<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductStockImport implements ToModel, WithHeadingRow
{
    /**
    *
    */
    public function model(array $row)
    {
        $row = array_change_key_case($row, CASE_LOWER);
        $row = collect($row)->except('#')->toArray();


        return new Product([
            'name'              => $row['name'],
            'sku'               => $row['sku'],
            'supplier_id'       => Supplier::where('name',$row['supplier_id'])->value('id'),
            'category_id'       => Category::where('name', $row['category_id'])->value('id'),
            'description'       => $row['description'],
            'purchase_price'    => $row['purchase_price'],
            'selling_price'     => $row['selling_price'],
            'minimum_stock'     => $row['minimum_stock'],
            'current_stock'     => $row['current_stock'] ?? 0,
        ]);
    }
}
