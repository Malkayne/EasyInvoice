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
        
        $recentInvoices = $user->invoices()->with('customer')->latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentInvoices'));
    }
}
