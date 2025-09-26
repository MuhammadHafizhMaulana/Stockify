<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductSingleExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function array(): array{

        $rows =[];

        $rows[] = ['Name', $this->data['summary']->product->name];
        $rows[] = ['Total Masuk', $this->data['summary']->total_masuk];
        $rows[] = ['Total Keluar', $this->data['summary']->total_keluar];
        $rows[] = [];
        $rows[] = ['Date', 'Type', 'Quantity', 'User'];

        foreach ($this->data['details'] as $trx){
            $rows[] = [
                $trx->created_at->format('Y-m-d'),
                ucfirst($trx->type),
                $trx->quantity,
                $trx->user->name . '/' . $trx->user->role,
            ];
        }

        return $rows;

    }

    public function headings(): array{
        return ['Laporan Produk Periode ' . implode('-' , $this->data['periode'])];
    }
}
