@extends('layouts.business.app')

@section('title', 'Invoices')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Invoices</h5>
            <div class="d-flex gap-2">
                <div class="input-group" style="width: 300px;">
                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search invoices...">
                </div>
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Create Invoice
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="invoicesTable">
                <thead class="table-light">
                    <tr>
                        <th class="fw-bold sortable" data-sort="invoice_number">
                            <div class="d-flex align-items-center">
                                Number
                                <i class="ti ti-chevron-down ms-1"></i>
                            </div>
                        </th>
                        <th class="fw-bold sortable" data-sort="customer_name">
                            <div class="d-flex align-items-center">
                                Customer
                                <i class="ti ti-chevron-down ms-1"></i>
                            </div>
                        </th>
                        <th class="fw-bold sortable" data-sort="date">
                            <div class="d-flex align-items-center">
                                Date
                                <i class="ti ti-chevron-down ms-1"></i>
                            </div>
                        </th>
                        <th class="fw-bold sortable" data-sort="due_date">
                            <div class="d-flex align-items-center text-nowrap">
                                Due Date
                                <i class="ti ti-chevron-down ms-1"></i>
                            </div>
                        </th>
                        <th class="fw-bold sortable" data-sort="total">
                            <div class="d-flex align-items-center">
                                Total
                                <i class="ti ti-chevron-down ms-1"></i>
                            </div>
                        </th>
                        <th class="fw-bold">Note</th>
                        <th class="fw-bold sortable" data-sort="status">
                            <div class="d-flex align-items-center">
                                Status
                                <i class="ti ti-chevron-down ms-1"></i>
                            </div>
                        </th>
                        <th class="fw-bold text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="invoicesTableBody">
                    <!-- Invoices will be loaded here -->
                </tbody>
            </table>
        </div>
        
        <div class="card-footer py-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small" id="showingInfo">
                    Showing 0 to 0 of 0 entries
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <select class="form-select form-select-sm" id="perPageSelect" style="width: auto;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <div id="pagination" class="pagination pagination-sm mb-0">
                        <!-- Pagination will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let perPage = 10;
    let sortColumn = 'created_at';
    let sortDirection = 'desc';
    let searchQuery = '';
    
    const invoices = @json($invoices->items());
    
    function renderInvoices() {
        const tbody = document.getElementById('invoicesTableBody');
        tbody.innerHTML = '';
        
        let filteredInvoices = invoices;
        
        // Apply search filter
        if (searchQuery) {
            filteredInvoices = invoices.filter(invoice => {
                return invoice.invoice_number.toLowerCase().includes(searchQuery.toLowerCase()) ||
                       invoice.customer.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
                       invoice.customer.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
                       (invoice.note && invoice.note.toLowerCase().includes(searchQuery.toLowerCase()));
            });
        }
        
        // Apply sorting
        filteredInvoices.sort((a, b) => {
            let aVal = a[sortColumn];
            let bVal = b[sortColumn];
            
            if (sortColumn === 'customer_name') {
                aVal = a.customer.name;
                bVal = b.customer.name;
            }
            
            if (sortDirection === 'asc') {
                return aVal > bVal ? 1 : -1;
            } else {
                return aVal < bVal ? 1 : -1;
            }
        });
        
        // Apply pagination
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = startIndex + perPage;
        const paginatedInvoices = filteredInvoices.slice(startIndex, endIndex);
        
        if (paginatedInvoices.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center p-5">
                        <div class="d-flex flex-column align-items-center justify-content-center">
                            <div class="avatar avatar-xl rounded bg-label-secondary mb-3">
                                <i class="ti ti-file-off fs-1"></i>
                            </div>
                            <h5 class="text-body mb-2">${searchQuery ? 'No invoices found matching your search' : 'No invoices found'}</h5>
                            <p class="text-muted">${searchQuery ? 'Try adjusting your search terms' : 'Start creating invoices to see them here.'}</p>
                            <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary mt-2">Create your first invoice</a>
                        </div>
                    </td>
                </tr>
            `;
            updatePaginationInfo(0, 0, filteredInvoices.length);
            return;
        }
        
        paginatedInvoices.forEach(invoice => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="text-nowrap">
                    <a href="/invoices/${invoice.id}" class="fw-bold text-primary text-decoration-none">
                        #${invoice.invoice_number}
                    </a>
                </td>
                <td class="text-nowrap">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-2">
                            <span class="avatar-initial rounded-circle bg-label-secondary">${invoice.customer.name.charAt(0)}</span>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-medium">${invoice.customer.name}</span><br>
                            <span class="text-primary fs-6">${invoice.customer.email}</span>
                        </div>
                    </div>
                </td>
                <td class="text-nowrap">${new Date(invoice.date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</td>
                <td class="text-nowrap">${new Date(invoice.due_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</td>
                <td class="fw-bold text-end text-nowrap">${getCurrencySymbol(invoice.currency)} ${parseFloat(invoice.total).toFixed(2)}</td>
                <td class="small text-nowrap text-truncate" style="max-width: 150px;" title="${invoice.note || ''}">${invoice.note ? invoice.note.substring(0, 30) + (invoice.note.length > 30 ? '...' : '') : ''}</td>
                <td class="text-nowrap text-center">
                    ${getStatusBadge(invoice.status)}
                </td>
                <td class="text-end">
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/invoices/${invoice.id}">
                                <i class="ti ti-eye me-1"></i> View
                            </a>
                            <a class="dropdown-item" href="/invoices/${invoice.id}/edit">
                                <i class="ti ti-pencil me-1"></i> Edit
                            </a>
                            <a class="dropdown-item" href="/invoices/${invoice.id}/download">
                                <i class="ti ti-download me-1"></i> PDF
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/invoices/${invoice.id}">
                                <i class="ti ti-mail me-1"></i> Send Email
                            </a>
                        </div>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        updatePaginationInfo(startIndex + 1, Math.min(endIndex, filteredInvoices.length), filteredInvoices.length);
        updatePagination(filteredInvoices.length);
    }
    
    function getCurrencySymbol(currency) {
        const symbols = {
            'USD': '$',
            'EUR': '€',
            'GBP': '£',
            'JPY': '¥',
            'CAD': 'C$',
            'AUD': 'A$',
            'CHF': 'CHF',
            'CNY': '¥',
            'INR': '₹',
            'NGN': '₦'
        };
        return symbols[currency] || currency;
    }
    
    function getStatusBadge(status) {
        const badges = {
            'paid': '<span class="badge bg-label-success">Paid</span>',
            'sent': '<span class="badge bg-label-info">Sent</span>',
            'draft': '<span class="badge bg-label-secondary">Draft</span>'
        };
        return badges[status] || '<span class="badge bg-label-secondary">Unknown</span>';
    }
    
    function updatePaginationInfo(start, end, total) {
        document.getElementById('showingInfo').textContent = `Showing ${start} to ${end} of ${total} entries`;
    }
    
    function updatePagination(totalItems) {
        const totalPages = Math.ceil(totalItems / perPage);
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';
        
        if (totalPages <= 1) return;
        
        // Previous button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage - 1}">Previous</a>`;
        pagination.appendChild(prevLi);
        
        // Page numbers
        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, currentPage + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
            pagination.appendChild(li);
        }
        
        // Next button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>`;
        pagination.appendChild(nextLi);
    }
    
    // Event listeners
    document.getElementById('searchInput').addEventListener('input', function(e) {
        searchQuery = e.target.value;
        currentPage = 1;
        renderInvoices();
    });
    
    document.getElementById('perPageSelect').addEventListener('change', function(e) {
        perPage = parseInt(e.target.value);
        currentPage = 1;
        renderInvoices();
    });
    
    document.getElementById('pagination').addEventListener('click', function(e) {
        e.preventDefault();
        if (e.target.classList.contains('page-link') && !e.target.parentElement.classList.contains('disabled')) {
            currentPage = parseInt(e.target.dataset.page);
            renderInvoices();
        }
    });
    
    // Sorting
    document.querySelectorAll('.sortable').forEach(th => {
        th.addEventListener('click', function() {
            const column = this.dataset.sort;
            if (sortColumn === column) {
                sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                sortColumn = column;
                sortDirection = 'asc';
            }
            
            // Update sort icons
            document.querySelectorAll('.sortable i').forEach(icon => {
                icon.className = 'ti ti-chevron-down ms-1';
            });
            
            const icon = this.querySelector('i');
            icon.className = sortDirection === 'asc' ? 'ti ti-chevron-up ms-1' : 'ti ti-chevron-down ms-1';
            
            renderInvoices();
        });
    });
    
    // Initial render
    renderInvoices();
});
</script>
@endsection

