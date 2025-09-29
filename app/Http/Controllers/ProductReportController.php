<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ProductSingleExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Services\ProductService;
use App\Exports\ProductFullReportExport;

class ProductReportController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('report.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function productList(){
        $products = Product::orderBy('name')->get();
        return view('report.product.index', compact('products'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportPdf(Request $request){

        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->productService->getReport($start, $end);
        $pdf  = PDF::loadView('report.products.pdf', compact('data'));

        return $pdf->download("laporan-produk-{$start}-{$end}.pdf");
    }

    public function productsReport(Request $request){
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->productService->getReport($start, $end);

        return view('report.products.index', compact('data'));
    }

    public function exportExcel(Request $request){
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->productService->getReport($start, $end);

        return Excel::download(new ProductFullReportExport($data['summary'], $data['details']),
    "laporan-produk-{$start}-{$end}.xlsx");
    }

    public function productReport(Request $request, $productId){
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->productService->getReportByProduct($productId,$start, $end);
        $product = Product::findOrFail($productId);

        return view('report.product.show', compact('data','product'));
    }

    public function exportProductPdf(Request $request, $productId){
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->productService->getReportByProduct($productId,$start, $end);
        $product = Product::findOrFail($productId);

        $pdf  = PDF::loadView('report.product.pdf', compact('data', 'product'));

        $productName = Str::slug($data['summary']->product->name);

        return $pdf->download("$productName-{$start}-{$end}.pdf");
    }

    public function exportProductExcel(Request $request, $productId){
        $start = $request->input('start_date', now()->startOfMonth()->toDateString());
        $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

        $data = $this->productService->getReportByProduct($productId,$start, $end);

        $productName = Str::slug($data['summary']->product->name);

        return Excel::download(
            new ProductSingleExport($data),
            "laporan-produk-{$productName}-{$start}-{$end}.xlsx"
        );
    }

}
