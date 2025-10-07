<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if($user->role === 'admin'){

            $start = $request->input('start_date', now()->startOfMonth()->toDateString());
            $end = $request->input('end_date', now()->endOfMonth()->toDateString());
            $lowStock = Product::where('current_stock', '<=', DB::raw('minimum_stock + 20'))->get();

            $totalProduct = Product::count();

            $transaksiMasuk = StockTransaction::where('type', 'masuk')
                ->whereBetween('created_at', [$start, $end])
                ->count();
            $transaksiKeluar = StockTransaction::where('type', 'keluar')
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $productStock = Product::select('name', 'current_stock')
                ->orderByDesc('current_stock')
                ->take(10)
                ->get();

            $activity = ActivityLog::latest()->take(5)->get();
            $pendingTransactions = StockTransaction::where('status', 'pending')->count();

            $productLabels = Product::pluck('name');
            $productStock  = Product::pluck('current_stock');

            return view('dashboard', compact('totalProduct', 'transaksiMasuk', 'transaksiKeluar', 'productStock', 'activity', 'pendingTransactions', 'lowStock', 'productLabels', 'productStock', 'start', 'end'));
        }

        if($user->role === 'manajer'){

            $dangerStock = Product::where('current_stock', '<=', DB::raw('minimum_stock + 20'))->get();

            $totalProduct = Product::count();

            $barangMasuk = StockTransaction::where('type', 'masuk')
                ->whereDate('created_at', now())
                ->get();

            $barangKeluar = StockTransaction::where('type', 'keluar')
                ->whereDate('created_at', now())
                ->get();

            $productLabels = Product::pluck('name');
            $productStock  = Product::pluck('current_stock');

            $pendingProduct = StockTransaction::where('status', 'pending')->get();

            return view('dashboard', compact('totalProduct','dangerStock','barangMasuk', 'barangKeluar', 'pendingProduct', 'productLabels', 'productStock'));
        }

        if($user->role === 'staff'){

            $barangMasuk = StockTransaction::where('type','masuk')
                ->where('user_id', $user->id)
                ->whereDate('created_at', now())
                ->get();

            $barangKeluar = StockTransaction::where('type','keluar')
                ->where('user_id', $user->id)
                ->whereDate('created_at', now())
                ->get();

            $dangerStock = Product::where('current_stock', '<=', DB::raw('minimum_stock + 20'))->get();

            $pending = StockTransaction::where('status', 'pending')
                ->where('user_id', $user->id)
                ->get();

            return view('dashboard', compact('barangMasuk', 'barangKeluar', 'dangerStock', 'pending'));
        }
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
