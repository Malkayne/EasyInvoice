@extends('layouts.business.app')

@section('title', 'Customers')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Customers</h5>
            <div class="d-flex gap-2">
                <div class="input-group input-group-merge">
                    <span class="input-group-text">
                        <i class="ti ti-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search customers...">
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomerModal">
                    <i class="ti ti-user-plus me-1"></i> 
                    <span>Add</span>
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($customers->isEmpty())
            <div class="card-body text-center p-5">
                <div class="mb-3">
                    <span class="avatar avatar-xl rounded bg-label-secondary">
                        <i class="ti ti-users fs-1"></i>
                    </span>
                </div>
                <h4 class="mb-1 text-dark">No customers yet</h4>
                <p class="text-muted mb-4">Add your first customer to start creating invoices.</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustomerModal">
                    Add New Customer
                </button>
            </div>
        @else
            <div class="card-body p-0">
                <!-- DataTable -->
                <div class="table-responsive">
                    <table class="table table-hover" id="customersTable">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <span>Name</span>
                                        <button class="btn btn-sm btn-icon ms-2" onclick="sortTable('name')">
                                            <i class="ti ti-arrows-up-down"></i>
                                        </button>
                                    </div>
                                </th>
                                <th class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <span>Email</span>
                                        <button class="btn btn-sm btn-icon ms-2" onclick="sortTable('email')">
                                            <i class="ti ti-arrows-up-down"></i>
                                        </button>
                                    </div>
                                </th>
                                <th class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <span>Phone</span>
                                        <button class="btn btn-sm btn-icon ms-2" onclick="sortTable('phone')">
                                            <i class="ti ti-arrows-up-down"></i>
                                        </button>
                                    </div>
                                </th>
                                <th class="text-nowrap text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span>Invoices</span>
                                        <button class="btn btn-sm btn-icon ms-2" onclick="sortTable('invoices_count')">
                                            <i class="ti ti-arrows-up-down"></i>
                                        </button>
                                    </div>
                                </th>
                                <th class="text-nowrap text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($customers as $customer)
                            <tr data-customer-id="{{ $customer->id }}">
                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-label-primary">{{ substr($customer->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <span class="fw-medium">{{ $customer->name }}</span>
                                            @if($customer->address)
                                                <small class="text-muted d-block">{{ \Illuminate\Support\Str::limit($customer->address, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    @if($customer->email)
                                        <a href="mailto:{{ $customer->email }}" class="text-primary text-decoration-none">
                                            {{ $customer->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">No email</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    @if($customer->phone)
                                        <a href="tel:{{ $customer->phone }}" class="text-muted text-decoration-none">
                                            {{ $customer->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">No phone</span>
                                    @endif
                                </td>
                                <td class="text-nowrap text-center">
                                    <span class="badge bg-label-primary rounded-pill">
                                        {{ $customer->invoices_count }} {{ $customer->invoices_count == 1 ? 'Invoice' : 'Invoices' }}
                                    </span>
                                </td>
                                <td class="text-nowrap text-center">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="ti ti-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('invoices.create') }}?customer={{ $customer->id }}" class="dropdown-item">
                                                <i class="ti ti-file-invoice me-1"></i> Create Invoice
                                            </a>
                                            <a href="javascript:void(0);" 
                                                class="dropdown-item"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editCustomerModal"
                                                data-id="{{ $customer->id }}"
                                                data-name="{{ $customer->name }}"
                                                data-email="{{ $customer->email }}"
                                                data-phone="{{ $customer->phone }}"
                                                data-address="{{ $customer->address }}">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="ti ti-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($customers->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4 px-3">
                        <div class="text-muted">
                            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} customers
                        </div>
                        <div>
                            {{ $customers->links() }}
                        </div>
                    </div>
                @endif
            </div>
        @endif
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
            <form method="POST" action="{{ route('customers.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Company or Person Name" value="{{ old('name') }}" required />
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="email@example.com" value="{{ old('email') }}" />
                            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="+1 (555) 000-0000" value="{{ old('phone') }}" />
                            @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea id="address" name="address" class="form-control" rows="3" placeholder="Billing Address">{{ old('address') }}</textarea>
                            @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Customer</button>
                </div>
            </form>
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
            <form id="editCustomerForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="edit_name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_name" name="name" class="form-control" required />
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" id="edit_email" name="email" class="form-control" />
                            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label">Phone</label>
                            <input type="text" id="edit_phone" name="phone" class="form-control" />
                            @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="edit_address" class="form-label">Address</label>
                            <textarea id="edit_address" name="address" class="form-control" rows="3"></textarea>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentSort = { field: 'name', direction: 'asc' };
    let originalData = [];

    // Store original data for sorting
    const rows = document.querySelectorAll('#customersTable tbody tr');
    rows.forEach(row => {
        originalData.push({
            name: row.querySelector('td:nth-child(1)').textContent.trim(),
            email: row.querySelector('td:nth-child(2)').textContent.trim(),
            phone: row.querySelector('td:nth-child(3)').textContent.trim(),
            invoices_count: parseInt(row.querySelector('td:nth-child(4) .badge').textContent),
            element: row
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterTable(searchTerm);
        });
    }

    function filterTable(searchTerm) {
        const rows = document.querySelectorAll('#customersTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Sort functionality
    window.sortTable = function(field) {
        if (currentSort.field === field) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.field = field;
            currentSort.direction = 'asc';
        }

        originalData.sort((a, b) => {
            let aVal = a[field];
            let bVal = b[field];

            if (typeof aVal === 'string') {
                aVal = aVal.toLowerCase();
                bVal = bVal.toLowerCase();
            }

            if (currentSort.direction === 'asc') {
                return aVal > bVal ? 1 : -1;
            } else {
                return aVal < bVal ? 1 : -1;
            }
        });

        // Re-render table
        const tbody = document.querySelector('#customersTable tbody');
        tbody.innerHTML = '';
        
        originalData.forEach(item => {
            tbody.appendChild(item.element);
        });
    };

    // Edit customer modal functionality
    var editCustomerModal = document.getElementById('editCustomerModal');
    editCustomerModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var name = button.getAttribute('data-name');
        var email = button.getAttribute('data-email');
        var phone = button.getAttribute('data-phone');
        var address = button.getAttribute('data-address');
        
        var form = document.getElementById('editCustomerForm');
        form.action = '/customers/' + id;
        
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('edit_address').value = address;
    });

    @if($errors->any() && !old('_method'))
        var createModal = new bootstrap.Modal(document.getElementById('createCustomerModal'));
        createModal.show();
    @endif

    @if($errors->any() && old('_method') === 'PATCH')
        var editModal = new bootstrap.Modal(document.getElementById('editCustomerModal'));
        editModal.show();
    @endif
});
</script>
@endpush
@endsection
