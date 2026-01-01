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
                        <h3 class="mb-1 fw-bold text-secondary">{{ auth()->user()->businessProfile->currency }} {{ number_format($stats['total_revenue'], 2) }}</h3>
                        <small class="text-secondary opacity-75">Gross income</small>
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
                                    <span class="fw-medium">{{ $invoice->customer->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted">{{ $invoice->date->format('M d, Y') }}</td>
                            <td class="fw-bold">{{ auth()->user()->businessProfile->currency }} {{ number_format($invoice->total, 2) }}</td>
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
@endsection

