<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductSummaryExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data){
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    public function map($data):array{
        return [
            $data->product->name,
            $data->total_masuk,
            $data->total_keluar,
        ];
    }

    public function headings(): array{
        return ['Produk', 'Total Masuk', 'Total Keluar'];
    }
}
