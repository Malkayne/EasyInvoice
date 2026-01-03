<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_invoices' => $user->invoices()->count(),
            'total_revenue' => $user->invoices()->sum('total'),
            'paid_count' => $user->invoices()->where('status', 'paid')->count(),
            'unpaid_count' => $user->invoices()->whereIn('status', ['draft', 'sent', 'overdue'])->count(),
        ];
        
        // Calculate revenue by currency
        $revenueByCurrency = $user->invoices()
            ->selectRaw('currency, SUM(total) as total_amount, COUNT(*) as count')
            ->groupBy('currency')
            ->orderBy('total_amount', 'desc')
            ->get()
            ->keyBy('currency');
        
        // Get revenue data for dashboard chart (last 6 months)
        $revenueChartData = $this->getRevenueChartData($user);
        
        // Get quick stats
        $quickStats = $this->getQuickStats($user);
        
        $recentInvoices = $user->invoices()->with('customer')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentInvoices', 'revenueByCurrency', 'revenueChartData', 'quickStats'));
    }
    
    private function getRevenueChartData($user)
    {
        // Get last 6 months of data
        $months = [];
        $revenueData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthKey = $month->format('M');
            $months[] = $monthKey;
            
            $revenue = $user->invoices()
                ->whereMonth('date', $month->month)
                ->whereYear('date', $month->year)
                ->sum('total');
            
            $revenueData[] = $revenue;
        }
        
        return [
            'labels' => $months,
            'data' => $revenueData
        ];
    }
    
    private function getQuickStats($user)
    {
        $currentMonth = now();
        $lastMonth = now()->subMonth();
        
        // This month revenue
        $thisMonthRevenue = $user->invoices()
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->sum('total');
            
        $lastMonthRevenue = $user->invoices()
            ->whereMonth('date', $lastMonth->month)
            ->whereYear('date', $lastMonth->year)
            ->sum('total');
        
        // Calculate growth percentage
        $revenueGrowth = 0;
        if ($lastMonthRevenue > 0) {
            $revenueGrowth = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } elseif ($thisMonthRevenue > 0) {
            $revenueGrowth = 100; // First month with revenue
        }
        
        // This month invoices
        $thisMonthInvoices = $user->invoices()
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->count();
        
        // Payment rate (paid invoices / total invoices)
        $totalInvoices = $user->invoices()->count();
        $paidInvoices = $user->invoices()->where('status', 'paid')->count();
        $paymentRate = $totalInvoices > 0 ? ($paidInvoices / $totalInvoices) * 100 : 0;
        
        return [
            'this_month_revenue' => $thisMonthRevenue,
            'last_month_revenue' => $lastMonthRevenue,
            'revenue_growth' => $revenueGrowth,
            'this_month_invoices' => $thisMonthInvoices,
            'payment_rate' => $paymentRate
        ];
    }
}
