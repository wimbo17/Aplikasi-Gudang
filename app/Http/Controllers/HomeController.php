<?php

namespace App\Http\Controllers;

use App\Models\LaporanKenaikanHarga;
use App\Models\Transaksi;
use App\Models\TransaksiItems;
use App\Models\VarianProduk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. Summary Cards
        $totalTransactionsIn = Transaksi::where('jenis_transaksi', 'pemasukan')->count();
        $totalTransactionsOut = Transaksi::where('jenis_transaksi', 'pengeluaran')->count();
        
        // Calculate total items quantity
        $totalItemsIn = TransaksiItems::whereHas('transaksi', function ($q) {
            $q->where('jenis_transaksi', 'pemasukan');
        })->sum('qty');
        
        $totalItemsOut = TransaksiItems::whereHas('transaksi', function ($q) {
            $q->where('jenis_transaksi', 'pengeluaran');
        })->sum('qty');

        $totalExpenses = Transaksi::where('jenis_transaksi', 'pemasukan')->sum('total_harga');
        $totalRevenue = Transaksi::where('jenis_transaksi', 'pengeluaran')->sum('total_harga');
        $margin = $totalRevenue - $totalExpenses;

        // 2. Income vs Expense Chart (Monthly for Current Year)
        $monthlyData = Transaksi::selectRaw('MONTH(created_at) as month, SUM(total_harga) as total, jenis_transaksi')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at), jenis_transaksi')
            ->get();

        $incomeData = array_fill(0, 12, 0);
        $expenseData = array_fill(0, 12, 0);

        foreach ($monthlyData as $data) {
            if ($data->jenis_transaksi == 'pengeluaran') {
                $incomeData[$data->month - 1] = (int) $data->total;
            } else {
                $expenseData[$data->month - 1] = (int) $data->total;
            }
        }

        // 3. Minimum Stock (Low Stock)
        $lowStockProducts = VarianProduk::with('produk')
            ->where('stok_varian', '<=', 10)
            ->orderBy('stok_varian', 'asc')
            ->limit(5)
            ->get();

        // 4. Best Selling Products
        // Get list of active SKUs (only from products that still exist)
        $activeSKUs = VarianProduk::whereHas('produk')
            ->pluck('nomor_sku')
            ->toArray();

        $bestSellingProducts = TransaksiItems::selectRaw('produk, varian, SUM(qty) as total_qty')
            ->whereHas('transaksi', function ($q) {
                $q->where('jenis_transaksi', 'pengeluaran');
            })
            ->whereIn('nomor_sku', $activeSKUs) // Only include items with active SKUs
            ->groupBy('produk', 'varian')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // 5. Product Price Increase
        $priceIncreaseData = LaporanKenaikanHarga::with('varian.produk')
            ->whereHas('varian.produk') // Only include items where product still exists
            ->latest()
            ->limit(5)
            ->get();

        // Check if charts have data to display
        $hasIncomeExpenseData = array_sum($incomeData) > 0 || array_sum($expenseData) > 0;
        $hasBestSellingData = $bestSellingProducts->isNotEmpty();
        $hasPriceIncreaseData = $priceIncreaseData->isNotEmpty();

        return view('home', compact(
            'totalTransactionsIn',
            'totalTransactionsOut',
            'totalItemsIn',
            'totalItemsOut',
            'totalExpenses',
            'totalRevenue',
            'margin',
            'incomeData',
            'expenseData',
            'lowStockProducts',
            'bestSellingProducts',
            'priceIncreaseData',
            'hasIncomeExpenseData',
            'hasBestSellingData',
            'hasPriceIncreaseData'
        ));
    }
}
