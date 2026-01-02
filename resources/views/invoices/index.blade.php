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
                        <th class="fw-bold text-nowrap">Due Date</th>
                        <th class="fw-bold">Total</th>
                        <th class="fw-bold">Note</th>
                        <th class="fw-bold">Status</th>
                        <th class="fw-bold text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($invoices as $invoice)
                    <tr>
                        <td class="text-nowrap">
                            <a href="{{ route('invoices.show', $invoice) }}" class="fw-bold text-primary">
                                #{{ $invoice->invoice_number }}
                            </a>
                        </td>
                        <td class="text-nowrap">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-2">
                                    <span class="avatar-initial rounded-circle bg-label-secondary">{{ substr($invoice->customer->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-medium">{{ $invoice->customer->name }}</span><br>
                                    <span class="text-primary fs-6">{{ $invoice->customer->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-nowrap">{{ $invoice->date->format('M d, Y') }}</td>
                        <td class="text-nowrap">{{ $invoice->due_date->format('M d, Y') }}</td>
                        <td class="fw-bold text-end text-nowrap">{{ auth()->user()->businessProfile->currency }} {{ number_format($invoice->total, 2) }}</td>
                        <td class="small text-nowrap text-truncate" style="max-width: 150px;" title="{{ $invoice->note }}">{{ \Illuminate\Support\Str::limit($invoice->note, 30, '...') }}</td>
                        <td class="text-nowrap text-center">
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
                        <td colspan="8" class="text-center p-5">
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

