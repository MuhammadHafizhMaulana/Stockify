<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductFullReportExport implements WithMultipleSheets
{
    protected $summary;
    protected $details;

    public function __construct($summary,$details){
        $this->summary = $summary;
        $this->details = $details;
    }

    public function sheets(): array{

        return[
            'summary' => new ProductSummaryExport($this->summary),
            'details' => new ProductDetailExport($this->details)
        ];
    }


}
