@extends('layouts.business.app')

@section('title', 'New Invoice')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y" id="invoiceForm">
    <!-- Toast Container -->
    <div id="toastContainer" class="position-fixed top-0 end-0 p-3" style="z-index: 11000;"></div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Create New Invoice</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('invoices.store') }}">
                @csrf
                <input type="hidden" name="tax_rate" id="taxRateHidden">

                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <label for="invoice_number" class="form-label">Invoice Number</label>
                        <input type="text" name="invoice_number_display" value="{{ $nextInvoiceNumber }}" class="form-control" readonly>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="customer_id" class="form-label">Customer</label>
                        <div class="d-flex gap-2">
                            <select id="customer_id" name="customer_id" class="form-select flex-grow-1" required>
                                <option value="" disabled>Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomerModal">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                        @error('customer_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="date" class="form-label">Invoice Date</label>
                        <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="form-control" required>
                    </div>
                </div>
                
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="form-control" required>
                    </div>
                    
                    <div class="col-md-9">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="1" placeholder="Additional notes for the customer..."></textarea>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Items</h6>
                    <button type="button" id="addItemBtn" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus me-1"></i> Add Item
                    </button>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 40%;">Description</th>
                                <th style="width: 15%;">Qty</th>
                                <th style="width: 20%;">Price</th>
                                <th style="width: 20%;">Amount</th>
                                <th style="width: 5%;"></th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody">
                            <!-- Items will be dynamically added here -->
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Subtotal</span>
                                            <span class="fw-semibold" id="subtotal">{{ auth()->user()->businessProfile->currency ?? '$' }} 0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2 align-items-center">
                                            <div class="d-flex align-items-center">
                                                <span class="me-2">Tax Rate</span>
                                                <input type="number" id="taxRate" class="form-control form-control-sm" style="width: 70px;" step="0.01" value="{{ auth()->user()->businessProfile->tax_rate ?? 0 }}">
                                                <span class="ms-1">%</span>
                                            </div>
                                            <span class="fw-semibold" id="taxTotal">{{ auth()->user()->businessProfile->currency ?? '$' }} 0.00</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span class="h5 mb-0">Total</span>
                                            <span class="h5 mb-0 text-primary" id="grandTotal">{{ auth()->user()->businessProfile->currency ?? '$' }} 0.00</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3">
                                            <a href="{{ route('dashboard') }}" class="btn btn-label-secondary">Cancel</a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ti ti-device-floppy me-1"></i> Save Invoice
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Customer Modal -->
<div class="modal fade" id="createCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createCustomerForm" onsubmit="return false;">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="modal_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="modal_name" name="name" class="form-control" placeholder="Company or Person Name" required />
                            <div class="text-danger small mt-1"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_email" class="form-label">Email</label>
                            <input type="email" id="modal_email" name="email" class="form-control" placeholder="email@example.com" />
                            <div class="text-danger small mt-1"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="modal_phone" class="form-label">Phone</label>
                            <input type="text" id="modal_phone" name="phone" class="form-control" placeholder="+1 (555) 000-0000" />
                            <div class="text-danger small mt-1"></div>
                        </div>
                        <div class="col-12">
                            <label for="modal_address" class="form-label">Address</label>
                            <textarea id="modal_address" name="address" class="form-control" rows="3" placeholder="Billing Address"></textarea>
                            <div class="text-danger small mt-1"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i> Save Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currency = '{{ auth()->user()->businessProfile->currency ?? "$" }}';
    let items = [{
        description: '',
        quantity: 1,
        unit_price: 0,
        amount: 0
    }];
    
    // Initialize
    renderItems();
    calculateTotals();
    
    // Event listeners
    document.getElementById('addItemBtn').addEventListener('click', addItem);
    document.getElementById('taxRate').addEventListener('input', calculateTotals);
    document.getElementById('createCustomerForm').addEventListener('submit', createCustomer);
    
    // Add form submission validation
    document.querySelector('form[method="POST"]').addEventListener('submit', function(e) {
        // Validate that at least one item has valid data
        let hasValidItem = false;
        for (let i = 0; i < items.length; i++) {
            if (items[i].description.trim() && 
                parseFloat(items[i].quantity) > 0 && 
                parseFloat(items[i].unit_price) >= 0) {
                hasValidItem = true;
                break;
            }
        }
        
        if (!hasValidItem) {
            e.preventDefault();
            showToast('Please add at least one valid item with description, quantity, and price.', 'danger');
            return false;
        }
        
        // Ensure tax rate is synced
        calculateTotals();
    });
    
    function addItem() {
        items.push({
            description: '',
            quantity: 1,
            unit_price: 0,
            amount: 0
        });
        renderItems();
    }
    
    function removeItem(index) {
        if (items.length > 1) {
            items.splice(index, 1);
            renderItems();
            calculateTotals();
        }
    }
    
    function calculateRow(index) {
        const qty = parseFloat(items[index].quantity) || 0;
        const price = parseFloat(items[index].unit_price) || 0;
        items[index].amount = (qty * price).toFixed(2);
        calculateTotals();
    }
    
    function calculateTotals() {
        const subtotal = items.reduce((sum, item) => sum + parseFloat(item.amount || 0), 0);
        const taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
        const taxTotal = subtotal * (taxRate / 100);
        const grandTotal = subtotal + taxTotal;
        
        // Update display
        document.getElementById('subtotal').textContent = formatMoney(subtotal);
        document.getElementById('taxTotal').textContent = formatMoney(taxTotal);
        document.getElementById('grandTotal').textContent = formatMoney(grandTotal);
        
        // Update hidden tax rate field for form submission
        document.getElementById('taxRateHidden').value = taxRate;
    }
    
    function formatMoney(amount) {
        return currency + ' ' + Number(amount).toFixed(2);
    }
    
    function renderItems() {
        const tbody = document.getElementById('itemsTableBody');
        tbody.innerHTML = '';
        
        items.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <input type="text" 
                           name="items[${index}][description]" 
                           value="${item.description}"
                           placeholder="Item description" 
                           class="form-control form-control-sm" 
                           required>
                </td>
                <td>
                    <input type="number" 
                           name="items[${index}][quantity]" 
                           value="${item.quantity}"
                           min="1" 
                           class="form-control form-control-sm text-end" 
                           required>
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">${currency}</span>
                        <input type="number" 
                               name="items[${index}][unit_price]" 
                               value="${item.unit_price}"
                               min="0" 
                               step="0.01" 
                               class="form-control text-end" 
                               required>
                    </div>
                </td>
                <td class="text-end align-middle fw-bold">
                    <span>${formatMoney(item.quantity * item.unit_price)}</span>
                </td>
                <td class="text-center">
                    <button type="button" onclick="removeItem(${index})" class="btn btn-sm btn-icon btn-text-danger" ${items.length <= 1 ? 'style="display:none;"' : ''}>
                        <i class="ti ti-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
            
            // Add event listeners to the new inputs
            const qtyInput = row.querySelector(`input[name="items[${index}][quantity]"]`);
            const priceInput = row.querySelector(`input[name="items[${index}][unit_price]"]`);
            const descInput = row.querySelector(`input[name="items[${index}][description]"]`);
            
            qtyInput.addEventListener('input', () => {
                items[index].quantity = qtyInput.value;
                calculateRow(index);
                updateRowDisplay(index);
            });
            
            priceInput.addEventListener('input', () => {
                items[index].unit_price = priceInput.value;
                calculateRow(index);
                updateRowDisplay(index);
            });
            
            descInput.addEventListener('input', () => {
                items[index].description = descInput.value;
            });
        });
    }
    
    function updateRowDisplay(index) {
        const rows = document.querySelectorAll('#itemsTableBody tr');
        const amountSpan = rows[index].querySelector('td:nth-child(4) span');
        amountSpan.textContent = formatMoney(items[index].quantity * items[index].unit_price);
    }
    
    async function createCustomer(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        
        try {
            const response = await fetch('{{ route("customers.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                // Add new customer to the select dropdown
                const select = document.getElementById('customer_id');
                const option = document.createElement('option');
                option.value = data.customer.id;
                option.textContent = data.customer.name;
                select.appendChild(option);
                select.value = data.customer.id;
                
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('createCustomerModal')).hide();
                
                // Reset form
                form.reset();
                
                // Show success message
                showToast('Customer added successfully!', 'success');
            } else {
                // Handle validation errors
                if (data.errors) {
                    // Clear previous errors
                    form.querySelectorAll('.text-danger').forEach(el => el.textContent = '');
                    
                    Object.keys(data.errors).forEach(key => {
                        const input = form.querySelector(`[name="${key}"]`);
                        if (input) {
                            const errorElement = input.parentNode.querySelector('.text-danger');
                            if (errorElement) {
                                errorElement.textContent = data.errors[key][0];
                            }
                        }
                    });
                }
            }
        } catch (error) {
            console.error('Error creating customer:', error);
            showToast('Error creating customer', 'danger');
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
        toastContainer.innerHTML = toastHtml;
        const toastElement = toastContainer.querySelector('.toast');
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
    }
    
    // Make removeItem globally accessible
    window.removeItem = removeItem;
});
</script>
@endsection
