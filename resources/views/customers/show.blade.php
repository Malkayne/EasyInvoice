@extends('layouts.business.app')

@section('title', $customer->name)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl me-3">
                                <span class="avatar-initial rounded-circle bg-white text-primary fs-3">
                                    {{ substr($customer->name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="mb-1 text-white">{{ $customer->name }}</h3>
                                <p class="mb-0 opacity-75">
                                    @if($customer->email)
                                        <i class="ti ti-mail me-1"></i>{{ $customer->email }}
                                    @endif
                                    @if($customer->email && $customer->phone)
                                        <span class="mx-2">•</span>
                                    @endif
                                    @if($customer->phone)
                                        <i class="ti ti-phone me-1"></i>{{ $customer->phone }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('invoices.create') }}?customer={{ $customer->id }}" class="btn btn-white text-primary">
                                <i class="ti ti-file-invoice me-1"></i> Create Invoice
                            </a>
                            <a href="{{ route('customers.index') }}" class="btn btn-label-white">
                                <i class="ti ti-arrow-left me-1"></i> Back to Customers
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-muted text-uppercase fs-7 fw-bold mb-3">Total Invoices</h6>
                        <h3 class="mb-1 fw-bold">{{ $customer->invoices->count() }}</h3>
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

        <div class="col-md-3">
            <div class="card h-100 bg-label-secondary border-0">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-secondary text-uppercase fs-7 fw-bold mb-3">Total Revenue</h6>
                        <h3 class="mb-1 fw-bold text-secondary">
                            @php
                                $totalRevenue = $customer->invoices->sum('total');
                                $currency = $customer->invoices->first()?->currency ?? auth()->user()->businessProfile->currency ?? 'USD';
                            @endphp
                            {{ currency_symbol($currency) }} {{ number_format($totalRevenue, 2) }}
                        </h3>
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

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-muted text-uppercase fs-7 fw-bold mb-3">Paid Invoices</h6>
                        <h3 class="mb-1 fw-bold text-success">{{ $customer->invoices->where('status', 'paid')->count() }}</h3>
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

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="card-title text-muted text-uppercase fs-7 fw-bold mb-3">Pending</h6>
                        <h3 class="mb-1 fw-bold text-warning">{{ $customer->invoices->whereIn('status', ['draft', 'sent'])->count() }}</h3>
                        <small class="text-warning fw-semibold">Action needed</small>
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

    <!-- Customer Details & Invoices -->
    <div class="row">
        <!-- Customer Information -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted text-uppercase small fw-bold mb-3">Contact Details</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar avatar-sm me-3">
                                <span class="avatar-initial rounded-circle bg-label-primary">{{ substr($customer->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $customer->name }}</h6>
                                <small class="text-muted">Customer since {{ $customer->created_at->format('M Y') }}</small>
                            </div>
                        </div>
                        
                        @if($customer->email)
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti ti-mail me-2 text-primary"></i>
                                <a href="mailto:{{ $customer->email }}" class="text-primary text-decoration-none">{{ $customer->email }}</a>
                            </div>
                        @endif
                        
                        @if($customer->phone)
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti ti-phone me-2 text-primary"></i>
                                <a href="tel:{{ $customer->phone }}" class="text-muted text-decoration-none">{{ $customer->phone }}</a>
                            </div>
                        @endif
                        
                        @if($customer->address)
                            <div class="d-flex align-items-start">
                                <i class="ti ti-map-pin me-2 text-primary mt-1"></i>
                                <span class="text-muted" style="white-space: pre-line;">{{ $customer->address }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary flex-grow-1" data-bs-toggle="modal" data-bs-target="#editCustomerModal">
                            <i class="ti ti-pencil me-1"></i> Edit Customer
                        </button>
                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Invoices -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recent Invoices</h5>
                    <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-label-primary">View All</a>
                </div>
                
                @if($customer->invoices->isEmpty())
                    <div class="card-body text-center p-5">
                        <div class="mb-3">
                            <span class="avatar avatar-xl rounded bg-label-secondary">
                                <i class="ti ti-file-invoice fs-1"></i>
                            </span>
                        </div>
                        <h4 class="mb-1 text-dark">No invoices yet</h4>
                        <p class="text-muted mb-4">Create your first invoice for this customer.</p>
                        <a href="{{ route('invoices.create') }}?customer={{ $customer->id }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Create First Invoice
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="fw-bold text-uppercase fs-7 text-muted">Invoice #</th>
                                    <th class="fw-bold text-uppercase fs-7 text-muted">Date</th>
                                    <th class="fw-bold text-uppercase fs-7 text-muted">Due Date</th>
                                    <th class="fw-bold text-uppercase fs-7 text-muted">Amount</th>
                                    <th class="fw-bold text-uppercase fs-7 text-muted">Status</th>
                                    <th class="fw-bold text-uppercase fs-7 text-muted text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach($customer->invoices as $invoice)
                                <tr>
                                    <td>
                                        <a href="{{ route('invoices.show', $invoice) }}" class="fw-bold text-primary text-decoration-none">
                                            #{{ $invoice->invoice_number }}
                                        </a>
                                    </td>
                                    <td class="text-muted">{{ $invoice->date->format('M d, Y') }}</td>
                                    <td class="text-muted">{{ $invoice->due_date->format('M d, Y') }}</td>
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
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="dropdown-item">
                                                    <i class="ti ti-eye me-1"></i> View
                                                </a>
                                                <a href="{{ route('invoices.edit', $invoice) }}" class="dropdown-item">
                                                    <i class="ti ti-pencil me-1"></i> Edit
                                                </a>
                                                <a href="{{ route('invoices.download', $invoice) }}" class="dropdown-item">
                                                    <i class="ti ti-download me-1"></i> Download
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#emailModal" data-invoice-id="{{ $invoice->id }}" data-invoice-number="{{ $invoice->invoice_number }}">
                                                    <i class="ti ti-mail me-1"></i> Send Email
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('customers.update', $customer) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="edit_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_name" name="name" class="form-control" value="{{ $customer->name }}" required />
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" id="edit_email" name="email" class="form-control" value="{{ $customer->email }}" />
                            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label">Phone</label>
                            <input type="text" id="edit_phone" name="phone" class="form-control" value="{{ $customer->phone }}" />
                            @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="edit_address" class="form-label">Address</label>
                            <textarea id="edit_address" name="address" class="form-control" rows="3">{{ $customer->address }}</textarea>
                            @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#" id="emailForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient_email" class="form-label">Recipient Email</label>
                        <input type="email" class="form-control" id="recipient_email" name="recipient_email" value="{{ $customer->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle email modal
    const emailModal = document.getElementById('emailModal');
    emailModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const invoiceId = button.getAttribute('data-invoice-id');
        const invoiceNumber = button.getAttribute('data-invoice-number');
        
        const form = document.getElementById('emailForm');
        form.action = '/invoices/' + invoiceId + '/email';
        
        document.getElementById('subject').value = 'Invoice #' + invoiceNumber + ' from ' + '{{ auth()->user()->businessProfile->name }}';
        
        document.getElementById('message').value = `Dear {{ $customer->name }},

Please find attached invoice #${invoiceNumber}.

The invoice is due on the specified date.

You can view the invoice online.

Thank you for your business!

Best regards,
{{ auth()->user()->businessProfile->name }}`;
    });

    // Handle email form submission
    document.getElementById('emailForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="ti ti-loader me-1"></i> Sending...';
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Invoice sent successfully!', 'success');
                bootstrap.Modal.getInstance(document.getElementById('emailModal')).hide();
                this.reset();
            } else {
                showToast(data.message || 'Failed to send invoice', 'danger');
            }
        })
        .catch(() => {
            showToast('Error sending invoice', 'danger');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    function showToast(message, type) {
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        const toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'position-fixed top-0 end-0 p-3';
            container.style.zIndex = '11000';
            document.body.appendChild(container);
        }
        document.getElementById('toastContainer').innerHTML = toastHtml;
        const toastElement = document.querySelector('.toast');
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }

    @if($errors->any())
        var editModal = new bootstrap.Modal(document.getElementById('editCustomerModal'));
        editModal.show();
    @endif
});
</script>
@endpush
@endsection
