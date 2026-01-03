@extends('layouts.business.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-12 mb-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 text-white">Welcome back, {{ auth()->user()->name }}! 👋</h4>
                            <p class="mb-0 opacity-75">Here's what's happening with your business today.</p>
                        </div>
                        <a href="{{ route('invoices.create') }}" class="btn btn-white text-primary fw-bold">
                            <i class="ti ti-plus me-1"></i> New Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-4">
        <!-- Total Invoices -->
        <div class="col-sm-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-muted text-uppercase fs-7 fw-bold mb-3">Total Invoices</h6>
                        <h3 class="mb-1 fw-bold">{{ $stats['total_invoices'] }}</h3>
                        <small class="text-muted">All time</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="ti ti-file-invoice fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-sm-6 col-md-3">
            <div class="card h-100 bg-label-secondary border-0">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-secondary text-uppercase fs-7 fw-bold mb-3">Total Revenue</h6>
                        @php
                            $mainCurrency = $revenueByCurrency->first();
                            $secondaryCurrencies = $revenueByCurrency->skip(1)->take(2);
                        @endphp
                        @if($mainCurrency)
                            <h3 class="fw-bold text-secondary mb-1">
                                {{ currency_symbol($mainCurrency->currency) }} {{ number_format($mainCurrency->total_amount, 2) }}
                            </h3>
                            @if($secondaryCurrencies->count() > 0)
                                <div class="d-flex gap-2 flex-wrap mb-1">
                                    @foreach($secondaryCurrencies as $currency)
                                        <span class="badge bg-label-secondary text-secondary fs-7">
                                            {{ currency_symbol($currency->currency) }} {{ number_format($currency->total_amount, 0) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            <small class="text-secondary opacity-75">
                                @if($revenueByCurrency->count() > 1)
                                    {{ $revenueByCurrency->count() }} currencies
                                @else
                                    Gross income
                                @endif
                            </small>
                        @else
                            <h3 class="mb-1 fw-bold text-secondary">{{ currency_symbol(auth()->user()->businessProfile->currency) }} 0.00</h3>
                            <small class="text-secondary opacity-75">Gross income</small>
                        @endif
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-secondary text-white">
                            <i class="ti ti-currency-dollar fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paid -->
        <div class="col-sm-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-muted text-uppercase fs-7 fw-bold mb-3">Paid</h6>
                        <h3 class="mb-1 fw-bold text-success">{{ $stats['paid_count'] }}</h3>
                        <small class="text-success fw-semibold">Completed</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="ti ti-check fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="col-sm-6 col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-muted text-uppercase fs-7 fw-bold mb-3">Pending</h6>
                        <h3 class="mb-1 fw-bold text-warning">{{ $stats['unpaid_count'] }}</h3>
                        <small class="text-warning fw-semibold">Action Needed</small>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="ti ti-clock fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mini Analytics -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Revenue Overview</h5>
                    <a href="{{ route('analytics.index') }}" class="btn btn-sm btn-label-primary">View Analytics</a>
                </div>
                <div class="card-body">
                    @if($stats['total_invoices'] > 0)
                        <canvas id="dashboardRevenueChart" height="80"></canvas>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="ti ti-chart-line text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-muted mb-2">No revenue data yet</h5>
                            <p class="text-muted small mb-0">Start creating invoices to see your revenue trends here</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted d-block">This Month</small>
                            <strong class="text-dark">Revenue</strong>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">vs last</small>
                            @if($quickStats['revenue_growth'] > 0)
                                <strong class="text-success">+{{ number_format($quickStats['revenue_growth'], 1) }}%</strong>
                            @elseif($quickStats['revenue_growth'] < 0)
                                <strong class="text-danger">{{ number_format($quickStats['revenue_growth'], 1) }}%</strong>
                            @else
                                <strong class="text-muted">0%</strong>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted d-block">Total</small>
                            <strong class="text-dark">Invoices</strong>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">This month</small>
                            <strong class="text-primary">{{ $quickStats['this_month_invoices'] }}</strong>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block">Payment</small>
                            <strong class="text-dark">Rate</strong>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">On time</small>
                            <strong class="text-success">{{ number_format($quickStats['payment_rate'], 1) }}%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Invoices -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom">
            <h5 class="card-title mb-0 fw-bold">Recent Activity</h5>
            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-label-primary">View All</a>
        </div>
        
        @if(isset($recentInvoices) && count($recentInvoices) > 0)
            <div class="table-responsive">
                <table class="table table-hover border-top" id="recentInvoicesTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-bold text-uppercase fs-7 text-muted">Number</th>
                            <th class="fw-bold text-uppercase fs-7 text-muted">Customer</th>
                            <th class="fw-bold text-uppercase fs-7 text-muted">Date</th>
                            <th class="fw-bold text-uppercase fs-7 text-muted">Amount</th>
                            <th class="fw-bold text-uppercase fs-7 text-muted">Status</th>
                            <th class="fw-bold text-uppercase fs-7 text-muted text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($recentInvoices as $invoice)
                        <tr>
                            <td>
                                <a href="{{ route('invoices.show', $invoice) }}" class="fw-bold text-primary">
                                    #{{ $invoice->invoice_number }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xs me-2">
                                        <span class="avatar-initial rounded-circle bg-label-secondary">{{ substr($invoice->customer->name, 0, 1) }}</span>
                                    </div>
                                    <a href="{{ route('customers.show', $invoice->customer) }}" class="fw-medium text-decoration-none text-primary">{{ $invoice->customer->name }}</a>
                                </div>
                            </td>
                            <td class="text-muted">{{ $invoice->date->format('M d, Y') }}</td>
                            <td class="fw-bold">{{ currency_symbol($invoice->currency) }} {{ number_format($invoice->total, 2) }}</td>
                            <td>
                                @if($invoice->status === 'paid')
                                    <span class="badge bg-label-success">Paid</span>
                                @elseif($invoice->status === 'sent')
                                    <span class="badge bg-label-info">Sent</span>
                                @else
                                    <span class="badge bg-label-secondary">Draft</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-icon btn-sm btn-text-secondary rounded-pill" data-bs-toggle="tooltip" title="View details">
                                    <i class="ti ti-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="card-body text-center p-5">
                <div class="mb-3">
                    <span class="avatar avatar-xl rounded bg-label-secondary">
                        <i class="ti ti-file-invoice fs-1"></i>
                    </span>
                </div>
                <h4 class="mb-1 text-dark">No invoices generated yet</h4>
                <p class="text-muted mb-4">Get started by creating your first invoice to track your business finances.</p>
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Create First Invoice
                </a>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart defaults
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#6c757d';
    
    // Only initialize chart if there's data
    @if($stats['total_invoices'] > 0)
        // Dashboard Revenue Chart
        const dashboardCtx = document.getElementById('dashboardRevenueChart').getContext('2d');
        new Chart(dashboardCtx, {
            type: 'line',
            data: {
                labels: @json($revenueChartData['labels']),
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenueChartData['data']),
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
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#7367f0',
                        borderWidth: 1,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                const currency = '{{ auth()->user()->businessProfile->currency }}';
                                return 'Revenue: ' + currency + ' ' + context.parsed.y.toLocaleString(undefined, {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000) {
                                    return '$' + (value / 1000).toFixed(1) + 'k';
                                }
                                return '$' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    @endif
});
</script>
@endpush
@endsection

