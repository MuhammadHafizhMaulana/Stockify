<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductDetailExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $details;

    public function __construct($details){
        $this->details = $details;
    }
    public function collection()
    {
        return $this->details->map(function($trx){
            return [
                'Tanggal' => $trx->created_at,
                'Produk' => ucwords($trx->product->name),
                'Jenis' => ucfirst($trx->type),
                'Quantity' => $trx->quantity,
                'Status' => ucfirst($trx->status),
                'User' => ucwords($trx->user->name) . '/' . $trx->user->role,
            ];
        });
    }

    public function headings(): array{
        return ['Tanggal','Produk', 'Jenis', 'Quantity','Status', 'User Inputor'];
    }
}
