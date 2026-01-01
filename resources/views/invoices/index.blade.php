@extends('layouts.business.app')

@section('title', 'Invoices')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Invoices</h5>
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Create Invoice
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="fw-bold">Number</th>
                        <th class="fw-bold">Customer</th>
                        <th class="fw-bold">Date</th>
                        <th class="fw-bold">Due Date</th>
                        <th class="fw-bold">Total</th>
                        <th class="fw-bold">Status</th>
                        <th class="fw-bold text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($invoices as $invoice)
                    <tr>
                        <td>
                            <a href="{{ route('invoices.show', $invoice) }}" class="fw-bold text-primary">
                                #{{ $invoice->invoice_number }}
                            </a>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="avatar-initial rounded-circle bg-label-secondary me-2 p-1 text-xs">
                                    {{ substr($invoice->customer->name, 0, 1) }}
                                </span>
                                <span>{{ $invoice->customer->name }}</span>
                            </div>
                        </td>
                        <td>{{ $invoice->date->format('M d, Y') }}</td>
                        <td>{{ $invoice->due_date->format('M d, Y') }}</td>
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
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('invoices.show', $invoice) }}">
                                        <i class="ti ti-eye me-1"></i> View
                                    </a>
                                    <a class="dropdown-item" href="{{ route('invoices.download', $invoice) }}">
                                        <i class="ti ti-download me-1"></i> PDF
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center p-5">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <div class="avatar avatar-xl rounded bg-label-secondary mb-3">
                                    <i class="ti ti-file-off fs-1"></i>
                                </div>
                                <h5 class="text-body mb-2">No invoices found</h5>
                                <p class="text-muted">Start creating invoices to see them here.</p>
                                <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary mt-2">Create your first invoice</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($invoices->hasPages())
            <div class="card-footer py-4">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection

