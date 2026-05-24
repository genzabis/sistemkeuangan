<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the report page.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Default ke bulan dan tahun saat ini
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        
        // Total pengeluaran per bulan
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        
        $monthlyTotal = Transaction::forUser($user->id)
            ->byDateRange($startDate, $endDate)
            ->sum('amount');
        
        // Data per kategori untuk pie chart
        $categoryData = Transaction::forUser($user->id)
            ->byDateRange($startDate, $endDate)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();
        
        $chartLabels = $categoryData->pluck('category')->toArray();
        $chartData = $categoryData->pluck('total')->toArray();
        
        // Warna untuk pie chart
        $chartColors = [
            '#ef4444', // red
            '#f59e0b', // amber
            '#10b981', // green
            '#3b82f6', // blue
            '#8b5cf6', // violet
            '#ec4899', // pink
            '#6b7280', // gray
        ];
        
        // List tahun untuk dropdown (5 tahun terakhir)
        $years = range(Carbon::now()->year, Carbon::now()->year - 4);
        
        return view('reports.index', compact(
            'monthlyTotal',
            'chartLabels',
            'chartData',
            'chartColors',
            'month',
            'year',
            'years',
            'categoryData'
        ));
    }
}
