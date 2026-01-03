@extends('layouts.business.app')

@section('title', 'Analytics')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white">Business Analytics</h3>
                            <p class="mb-0 opacity-75">Track your business performance and gain insights</p>
                        </div>
                        <div class="d-flex gap-2">
                            <select class="form-select bg-white text-primary" style="width: auto;">
                                <option value="12">Last 12 Months</option>
                                <option value="6">Last 6 Months</option>
                                <option value="3">Last 3 Months</option>
                                <option value="1">This Month</option>
                            </select>
                            <button class="btn btn-white text-primary">
                                <i class="ti ti-download me-1"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="row g-4 mb-4">
        <!-- Revenue This Month -->
        <div class="col-md-3">
            <div class="card h-100 border-0 bg-label-success">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-success text-uppercase fs-7 fw-bold mb-3">Revenue This Month</h6>
                        <h3 class="mb-1 fw-bold text-success">{{ currency_symbol(auth()->user()->businessProfile->currency) }} {{ number_format($analytics['recentPerformance']['this_month'], 2) }}</h3>
                        <div class="d-flex align-items-center">
                            @if($analytics['recentPerformance']['last_month'] > 0)
                                @php
                                    $growth = (($analytics['recentPerformance']['this_month'] - $analytics['recentPerformance']['last_month']) / $analytics['recentPerformance']['last_month']) * 100;
                                @endphp
                                @if($growth > 0)
                                    <i class="ti ti-trending-up text-success me-1"></i>
                                    <small class="text-success fw-semibold">+{{ number_format($growth, 1) }}%</small>
                                @else
                                    <i class="ti ti-trending-down text-danger me-1"></i>
                                    <small class="text-danger fw-semibold">{{ number_format($growth, 1) }}%</small>
                                @endif
                            @else
                                <i class="ti ti-trending-up text-success me-1"></i>
                                <small class="text-success fw-semibold">New</small>
                            @endif
                            <small class="text-muted ms-1">vs last month</small>
                        </div>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-success text-white">
                            <i class="ti ti-currency-dollar fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Invoices -->
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-muted text-uppercase fs-7 fw-bold mb-3">Total Invoices</h6>
                        <h3 class="mb-1 fw-bold">{{ $analytics['monthlyTrends']->sum('count') }}</h3>
                        <div class="d-flex align-items-center">
                            <i class="ti ti-file-invoice text-primary me-1"></i>
                            <small class="text-muted fw-semibold">Last 12 months</small>
                        </div>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="ti ti-file-invoice fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Invoice Value -->
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-muted text-uppercase fs-7 fw-bold mb-3">Avg Invoice Value</h6>
                        @php
                            $totalInvoices = $analytics['monthlyTrends']->sum('count');
                            $avgValue = $totalInvoices > 0 ? $analytics['monthlyTrends']->sum('revenue') / $totalInvoices : 0;
                        @endphp
                        <h3 class="mb-1 fw-bold">{{ currency_symbol(auth()->user()->businessProfile->currency) }} {{ number_format($avgValue, 2) }}</h3>
                        <div class="d-flex align-items-center">
                            <i class="ti ti-chart-bar text-info me-1"></i>
                            <small class="text-muted fw-semibold">Per invoice</small>
                        </div>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="ti ti-chart-bar fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid Rate -->
        <div class="col-md-3">
            <div class="card h-100 border-0 bg-label-warning">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-warning text-uppercase fs-7 fw-bold mb-3">Paid Rate</h6>
                        @php
                            $paidCount = $analytics['statusBreakdown']->where('status', 'paid')->sum('count');
                            $totalCount = $analytics['statusBreakdown']->sum('count');
                            $paidRate = $totalCount > 0 ? ($paidCount / $totalCount) * 100 : 0;
                        @endphp
                        <h3 class="mb-1 fw-bold text-warning">{{ number_format($paidRate, 1) }}%</h3>
                        <div class="d-flex align-items-center">
                            <i class="ti ti-percentage text-warning me-1"></i>
                            <small class="text-muted fw-semibold">{{ $paidCount }} of {{ $totalCount }} paid</small>
                        </div>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-warning text-white">
                            <i class="ti ti-percentage fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row g-4 mb-4">
        <!-- Revenue Over Time -->
        <!-- <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Revenue Over Time</h5>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-primary active">Revenue</button>
                        <button type="button" class="btn btn-outline-primary">Invoices</button>
                        <button type="button" class="btn btn-outline-primary">Profit</button>
                    </div>
                </div>
                <div class="card-body">
                    @if($analytics['monthlyTrends']->count() > 0)
                        <canvas id="revenueChart" height="100"></canvas>
                    @else
                        <div class="text-center py-5">
                            <i class="ti ti-chart-line text-muted" style="font-size: 3rem;"></i>
                            <h5 class="text-muted mt-3">No revenue data yet</h5>
                            <p class="text-muted">Start creating invoices to see your revenue trends</p>
                        </div>
                    @endif
                </div>
            </div>
        </div> -->

        <!-- Invoice Status Breakdown -->
        {{-- <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Invoice Status</h5>
                </div>
                <div class="card-body">
                    @if($analytics['statusBreakdown']->count() > 0)
                        <canvas id="statusChart" height="200"></canvas>
                        <div class="mt-3" id="statusLegend">
                            <!-- Legend will be populated by JavaScript -->
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-chart-pie text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">No invoice data yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Charts Row 2 -->
    <div class="row g-4 mb-4">
        <!-- Revenue by Currency -->
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Revenue by Currency</h5>
                </div>
                <div class="card-body">
                    @if($analytics['revenueByCurrency']->count() > 0)
                        <canvas id="currencyChart" height="150"></canvas>
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-chart-bar text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">No currency data yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Top Customers</h5>
                    <a href="{{ route('customers.index') }}" class="btn btn-sm btn-label-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($analytics['topCustomers']->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-bold text-uppercase fs-7 text-muted">Customer</th>
                                        <th class="fw-bold text-uppercase fs-7 text-muted">Invoices</th>
                                        <th class="fw-bold text-uppercase fs-7 text-muted text-end">Revenue</th>
                                        <th class="fw-bold text-uppercase fs-7 text-muted text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($analytics['topCustomers']->take(5) as $customer)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <span class="avatar-initial rounded-circle bg-label-primary">{{ substr($customer->name, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $customer->name }}</div>
                                                        <small class="text-muted">{{ $customer->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $customer->invoices_count }}</td>
                                            <td class="fw-bold text-end">{{ currency_symbol(auth()->user()->businessProfile->currency) }} {{ number_format($customer->total_revenue, 2) }}</td>
                                            <td class="text-end">
                                                <span class="badge bg-label-success">Active</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-users text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">No customer data yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Monthly Performance</h5>
                </div>
                <div class="card-body">
                    @if($analytics['monthlyTrends']->count() > 0)
                        <canvas id="performanceChart" height="80"></canvas>
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-chart-line text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">No performance data yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                <div>
                                    <small class="text-muted d-block">Best Month</small>
                                    @php
                                        $bestMonth = $analytics['monthlyTrends']->sortByDesc('revenue')->first();
                                    @endphp
                                    <strong class="text-dark">{{ $bestMonth ? $bestMonth->month : 'N/A' }}</strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Revenue</small>
                                    <strong class="text-success">{{ currency_symbol(auth()->user()->businessProfile->currency) }} {{ number_format($bestMonth->revenue ?? 0, 0) }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                <div>
                                    <small class="text-muted d-block">Growth Rate</small>
                                    <strong class="text-dark">Quarterly</strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Average</small>
                                    @php
                                        $recentMonths = $analytics['monthlyTrends']->take(3);
                                        $growthRate = $recentMonths->count() > 1 ? 
                                            (($recentMonths->last()->revenue - $recentMonths->first()->revenue) / $recentMonths->first()->revenue) * 100 : 0;
                                    @endphp
                                    <strong class="text-success">{{ number_format($growthRate, 1) }}%</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                <div>
                                    <small class="text-muted d-block">Total Clients</small>
                                    <strong class="text-dark">Active</strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">This Month</small>
                                    <strong class="text-primary">{{ $analytics['topCustomers']->count() }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                <div>
                                    <small class="text-muted d-block">Avg Payment</small>
                                    <strong class="text-dark">Time</strong>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Days</small>
                                    <strong class="text-warning">14</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart defaults
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#6c757d';
    
    // Prepare data once to avoid loops
    const analyticsData = {
        monthlyTrends: @json($analytics['monthlyTrends']->toArray()),
        statusBreakdown: @json($analytics['statusBreakdown']->toArray()),
        revenueByCurrency: @json($analytics['revenueByCurrency']->toArray()),
        currency: '{{ auth()->user()->businessProfile->currency }}'
    };
    
    // Revenue Over Time Chart
    if (analyticsData.monthlyTrends.length > 0) {
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: analyticsData.monthlyTrends.map(t => t.month),
                    datasets: [{
                        label: 'Revenue',
                        data: analyticsData.monthlyTrends.map(t => t.revenue),
                        borderColor: '#7367f0',
                        backgroundColor: 'rgba(115, 103, 240, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#7367f0',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: ' + analyticsData.currency + ' ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.05)' },
                            ticks: {
                                callback: function(value) {
                                    return value >= 1000 ? '$' + (value / 1000).toFixed(1) + 'k' : '$' + value;
                                }
                            }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    }

    // Status Breakdown Chart
    if (analyticsData.statusBreakdown.length > 0) {
        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            const statusColors = {
                'paid': '#71dd37',
                'sent': '#03c3ec',
                'draft': '#6c757d'
            };
            
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: analyticsData.statusBreakdown.map(s => s.status.charAt(0).toUpperCase() + s.status.slice(1)),
                    datasets: [{
                        data: analyticsData.statusBreakdown.map(s => s.count),
                        backgroundColor: analyticsData.statusBreakdown.map(s => statusColors[s.status] || '#6c757d'),
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12
                        }
                    },
                    cutout: '70%'
                }
            });
            
            // Populate legend
            const legendContainer = document.getElementById('statusLegend');
            if (legendContainer) {
                let legendHtml = '';
                analyticsData.statusBreakdown.forEach((status, index) => {
                    legendHtml += `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge rounded-circle me-2" style="width: 12px; height: 12px; background-color: ${statusColors[status.status] || '#6c757d'};"></span>
                                <small class="fw-medium">${status.status.charAt(0).toUpperCase() + status.status.slice(1)}</small>
                            </div>
                            <small class="text-muted">${status.count} invoices</small>
                        </div>
                    `;
                });
                legendContainer.innerHTML = legendHtml;
            }
        }
    }

    // Revenue by Currency Chart
    if (analyticsData.revenueByCurrency.length > 0) {
        const currencyCtx = document.getElementById('currencyChart');
        if (currencyCtx) {
            new Chart(currencyCtx, {
                type: 'bar',
                data: {
                    labels: analyticsData.revenueByCurrency.map(c => c.currency),
                    datasets: [{
                        label: 'Revenue',
                        data: analyticsData.revenueByCurrency.map(c => c.total),
                        backgroundColor: ['#7367f0', '#03c3ec', '#71dd37', '#ffab00'],
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            callbacks: {
                                label: function(context) {
                                    return analyticsData.currency + ' ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.05)' },
                            ticks: {
                                callback: function(value) {
                                    return value >= 1000 ? '$' + (value / 1000).toFixed(1) + 'k' : '$' + value;
                                }
                            }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    }

    // Monthly Performance Chart
    if (analyticsData.monthlyTrends.length > 0) {
        const performanceCtx = document.getElementById('performanceChart');
        if (performanceCtx) {
            new Chart(performanceCtx, {
                type: 'bar',
                data: {
                    labels: analyticsData.monthlyTrends.map(t => t.month),
                    datasets: [{
                        label: 'Invoices',
                        data: analyticsData.monthlyTrends.map(t => t.count),
                        backgroundColor: '#7367f0',
                        borderRadius: 4,
                        borderSkipped: false,
                    }, {
                        label: 'Revenue',
                        data: analyticsData.monthlyTrends.map(t => t.revenue),
                        backgroundColor: '#03c3ec',
                        borderRadius: 4,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true, position: 'top' },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0, 0, 0, 0.05)' }
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    }
});
</script>
@endpush
@endsection
