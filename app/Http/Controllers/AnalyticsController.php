<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get analytics data
        $analytics = $this->getAnalyticsData($user);
        
        return view('analytics.index', compact('analytics'));
    }
    
    private function getAnalyticsData($user)
    {
        // Revenue over time (last 12 months)
        $revenueOverTime = $user->invoices()
            ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month, currency, SUM(total) as revenue')
            ->where('date', '>=', now()->subMonths(12))
            ->groupBy('month', 'currency')
            ->orderBy('month')
            ->get()
            ->groupBy('month');
        
        // Invoice status breakdown
        $statusBreakdown = $user->invoices()
            ->selectRaw('status, COUNT(*) as count, SUM(total) as total')
            ->groupBy('status')
            ->get();
        
        // Top customers by revenue - FIXED QUERY
        $topCustomers = $user->customers()
            ->with(['invoices' => function($query) {
                $query->select('customer_id', 'total');
            }])
            ->get()
            ->map(function($customer) {
                $customer->invoices_count = $customer->invoices->count();
                $customer->total_revenue = $customer->invoices->sum('total');
                return $customer;
            })
            ->sortByDesc('total_revenue')
            ->take(10);
        
        // Revenue by currency
        $revenueByCurrency = $user->invoices()
            ->selectRaw('currency, SUM(total) as total, COUNT(*) as count')
            ->groupBy('currency')
            ->orderBy('total', 'desc')
            ->get();
        
        // Monthly invoice trends
        $monthlyTrends = $user->invoices()
            ->selectRaw('DATE_FORMAT(date, "%Y-%m") as month, COUNT(*) as count, SUM(total) as revenue')
            ->where('date', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Recent performance
        $recentPerformance = [
            'this_month' => $user->invoices()
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->sum('total'),
            'last_month' => $user->invoices()
                ->whereMonth('date', now()->subMonth()->month)
                ->whereYear('date', now()->subMonth()->year)
                ->sum('total'),
            'this_year' => $user->invoices()
                ->whereYear('date', now()->year)
                ->sum('total'),
        ];
        
        return [
            'revenueOverTime' => $revenueOverTime,
            'statusBreakdown' => $statusBreakdown,
            'topCustomers' => $topCustomers,
            'revenueByCurrency' => $revenueByCurrency,
            'monthlyTrends' => $monthlyTrends,
            'recentPerformance' => $recentPerformance,
        ];
    }
}
