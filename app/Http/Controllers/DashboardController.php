<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Total pengeluaran hari ini
        $todayTotal = Transaction::forUser($user->id)
            ->whereDate('date', Carbon::today())
            ->sum('amount');
        
        // 5 transaksi terakhir
        $recentTransactions = Transaction::forUser($user->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Data untuk grafik 7 hari terakhir
        $last7Days = [];
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $total = Transaction::forUser($user->id)
                ->whereDate('date', $date)
                ->sum('amount');
            
            $chartLabels[] = $date->format('d/m');
            $chartData[] = $total;
        }
        
        // Kategori untuk dropdown
        $categories = Transaction::CATEGORIES;
        
        return view('dashboard', compact(
            'todayTotal',
            'recentTransactions',
            'chartLabels',
            'chartData',
            'categories'
        ));
    }
}
