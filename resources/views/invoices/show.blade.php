@extends('layouts.business.app')

@section('title', 'Invoice #' . $invoice->invoice_number)

@push('styles')
<style>
.invoice-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
}
.invoice-logo {
    max-height: 80px;
    max-width: 200px;
    object-fit: contain;
}
.invoice-status {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    font-weight: 600;
}
.invoice-table {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.invoice-table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    color: #6c757d;
}
.invoice-amount {
    font-family: 'Courier New', monospace;
    font-weight: 600;
}
.invoice-total-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-left: 4px solid #667eea;
}
.invoice-actions {
    position: sticky;
    top: 1rem;
}
@media print {
    .invoice-actions {
        display: none;
    }
}
</style>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-8">
            <div class="card invoice-card">
                <div class="card-header invoice-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                @if(auth()->user()->businessProfile->logo)
                                    <img src="{{ asset('storage/' . auth()->user()->businessProfile->logo) }}" 
                                         alt="{{ auth()->user()->businessProfile->name }}" 
                                         class="invoice-logo me-3">
                                @endif
                                <div>
                                    <h1 class="mb-1 fw-bold">INVOICE</h1>
                                    <p class="mb-0 opacity-75">#{{ $invoice->invoice_number }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <span class="invoice-status 
                                {{ $invoice->status === 'paid' ? 'bg-success text-white' : 
                                   ($invoice->status === 'sent' ? 'bg-info text-white' : 'bg-secondary text-white') }}">
                                <i class="ti ti-circle-filled me-1"></i>
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Business & Customer Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="border rounded p-3 bg-light">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">From</h6>
                                <h5 class="fw-bold mb-2">{{ auth()->user()->businessProfile->name }}</h5>
                                <div class="text-muted">
                                    @if(auth()->user()->businessProfile->address)
                                        <p class="mb-2" style="white-space: pre-line;">{{ auth()->user()->businessProfile->address }}</p>
                                    @endif
                                    @if(auth()->user()->businessProfile->email)
                                        <p class="mb-2">{{ auth()->user()->businessProfile->email }}</p>
                                    @endif
                                    @if(auth()->user()->businessProfile->phone)
                                        <p class="mb-0">{{ auth()->user()->businessProfile->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 bg-light">
                                <h6 class="text-muted text-uppercase small fw-bold mb-3">Bill To</h6>
                                <h5 class="fw-bold mb-2">{{ $invoice->customer->name }}</h5>
                                <div class="text-muted">
                                    @if($invoice->customer->address)
                                        <p class="mb-2" style="white-space: pre-line;">{{ $invoice->customer->address }}</p>
                                    @endif
                                    @if($invoice->customer->email)
                                        <p class="mb-2">{{ $invoice->customer->email }}</p>
                                    @endif
                                    @if($invoice->customer->phone)
                                        <p class="mb-0">{{ $invoice->customer->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="me-4">
                                    <small class="text-muted text-uppercase d-block">Invoice Date</small>
                                    <strong>{{ $invoice->date->format('M d, Y') }}</strong>
                                </div>
                                <div>
                                    <small class="text-muted text-uppercase d-block">Due Date</small>
                                    <strong>{{ $invoice->due_date->format('M d, Y') }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            @if($invoice->notes)
                                <div>
                                    <small class="text-muted text-uppercase d-block">Notes</small>
                                    <span class="text-muted">{{ $invoice->notes }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="table-responsive mb-4">
                        <table class="table invoice-table mb-0">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th class="text-end" style="width: 100px;">Quantity</th>
                                    <th class="text-end" style="width: 120px;">Unit Price</th>
                                    <th class="text-end" style="width: 120px;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->items as $item)
                                <tr>
                                    <td class="fw-medium">{{ $item->description }}</td>
                                    <td class="text-end">{{ number_format($item->quantity, 2) }}</td>
                                    <td class="text-end invoice-amount">{{ auth()->user()->businessProfile->currency }} {{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-end fw-bold invoice-amount">{{ auth()->user()->businessProfile->currency }} {{ number_format($item->amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="card invoice-total-card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal</span>
                                        <span class="fw-semibold invoice-amount">{{ auth()->user()->businessProfile->currency }} {{ number_format($invoice->subtotal, 2) }}</span>
                                    </div>
                                    @if($invoice->tax_total > 0)
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted">Tax</span>
                                        <span class="fw-semibold invoice-amount">{{ auth()->user()->businessProfile->currency }} {{ number_format($invoice->tax_total, 2) }}</span>
                                    </div>
                                    @endif
                                    <div class="d-flex justify-content-between pt-3 border-top">
                                        <span class="h5 mb-0 fw-bold">Total</span>
                                        <span class="h5 mb-0 text-primary fw-bold invoice-amount">{{ auth()->user()->businessProfile->currency }} {{ number_format($invoice->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card invoice-actions">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#emailInvoiceModal">
                            <i class="ti ti-mail me-2"></i> Send Invoice
                        </button>
                        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-dark">
                            <i class="ti ti-download me-2"></i> Download PDF
                        </a>
                        <button type="button" class="btn btn-outline-secondary" onclick="copyPublicLink()">
                            <i class="ti ti-link me-2"></i> Copy Public Link
                        </button>
                        @if($invoice->status !== 'paid')
                        <button type="button" class="btn btn-success" onclick="markAsPaid()">
                            <i class="ti ti-check me-2"></i> Mark as Paid
                        </button>
                        @endif
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="text-center">
                        <small class="text-muted">Invoice Status</small><br>
                        <span class="badge 
                            {{ $invoice->status === 'paid' ? 'bg-success' : 
                               ($invoice->status === 'sent' ? 'bg-info' : 'bg-secondary') }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Invoice Modal -->
<div class="modal fade" id="emailInvoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="emailInvoiceForm" method="POST" action="{{ route('invoices.email', $invoice) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient_email" class="form-label">Recipient Email</label>
                        <input type="email" class="form-control" id="recipient_email" name="recipient_email" 
                               value="{{ $invoice->customer->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" 
                               value="Invoice #{{ $invoice->invoice_number }} from {{ auth()->user()->businessProfile->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required>Dear {{ $invoice->customer->name }},

Please find attached invoice #{{ $invoice->invoice_number }} for {{ auth()->user()->businessProfile->currency }} {{ number_format($invoice->total, 2) }}.

The invoice is due on {{ $invoice->due_date->format('M d, Y') }}.

You can view the invoice online at: {{ route('invoices.public', $invoice->public_token) }}

Thank you for your business!

Best regards,
{{ auth()->user()->businessProfile->name }}</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="attach_pdf" name="attach_pdf" checked>
                            <label class="form-check-label" for="attach_pdf">
                                Attach PDF to email
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-mail me-1"></i> Send Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function copyPublicLink() {
    const publicLink = '{{ route('invoices.public', $invoice->public_token) }}';
    navigator.clipboard.writeText(publicLink).then(() => {
        showToast('Public link copied to clipboard!', 'success');
    }).catch(() => {
        showToast('Failed to copy link', 'danger');
    });
}

function markAsPaid() {
    if (confirm('Are you sure you want to mark this invoice as paid?')) {
        fetch('{{ route('invoices.mark-paid', $invoice) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Invoice marked as paid!', 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showToast('Failed to update invoice status', 'danger');
            }
        })
        .catch(() => {
            showToast('Error updating invoice', 'danger');
        });
    }
}

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

// Handle email form submission
document.getElementById('emailInvoiceForm').addEventListener('submit', function(e) {
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
            bootstrap.Modal.getInstance(document.getElementById('emailInvoiceModal')).hide();
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
</script>
@endsection
