<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        @page {
            margin: 20px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background: #fff;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #667eea;
        }
        .invoice-title {
            font-size: 48px;
            font-weight: 700;
            color: #667eea;
            margin: 0;
            line-height: 1;
        }
        .invoice-number {
            font-size: 18px;
            color: #6c757d;
            margin-top: 5px;
        }
        .business-info {
            text-align: right;
            max-width: 300px;
        }
        .business-logo {
            max-height: 80px;
            max-width: 200px;
            margin-bottom: 15px;
            object-fit: contain;
        }
        .business-name {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 10px 0;
            color: #333;
        }
        .business-details {
            font-size: 14px;
            color: #6c757d;
            line-height: 1.5;
        }
        .addresses-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 40px;
        }
        .address-box {
            flex: 1;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .address-label {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }
        .address-content h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: #333;
        }
        .address-content p {
            font-size: 14px;
            color: #6c757d;
            margin: 4px 0;
            line-height: 1.5;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 15px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-item {
            text-align: center;
        }
        .detail-label {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c757d;
            display: block;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: 0.5px;
        }
        .items-table td {
            border: 1px solid #dee2e6;
            padding: 15px;
            vertical-align: top;
        }
        .items-table .text-right {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }
        .items-table .description {
            font-weight: 500;
        }
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }
        .totals-box {
            width: 300px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 20px;
            border-bottom: 1px solid #dee2e6;
        }
        .total-row:last-child {
            border-bottom: none;
            background: #f8f9fa;
            font-weight: 700;
            font-size: 18px;
            color: #667eea;
        }
        .total-label {
            font-weight: 600;
            color: #333;
        }
        .total-value {
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }
        .notes-section {
            margin-top: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .notes-label {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 8px;
        }
        .notes-content {
            font-size: 14px;
            color: #6c757d;
            line-height: 1.5;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-draft { background: #e9ecef; color: #6c757d; }
        .status-sent { background: #d1ecf1; color: #0c5460; }
        .status-paid { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div>
                <h1 class="invoice-title">INVOICE</h1>
                <div class="invoice-number">#{{ $invoice->invoice_number }}</div>
                <span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span>
            </div>
            <div class="business-info">
                @if($invoice->user->businessProfile->logo)
                    <img src="{{ asset('storage/' . $invoice->user->businessProfile->logo) }}" 
                         alt="{{ $invoice->user->businessProfile->name }}" 
                         class="business-logo">
                @endif
                <h2 class="business-name">{{ $invoice->user->businessProfile->name }}</h2>
                <div class="business-details">
                    @if($invoice->user->businessProfile->address)
                        <p style="white-space: pre-line;">{!! nl2br(e($invoice->user->businessProfile->address)) !!}</p>
                    @endif
                    @if($invoice->user->businessProfile->email)
                        <p>{{ $invoice->user->businessProfile->email }}</p>
                    @endif
                    @if($invoice->user->businessProfile->phone)
                        <p>{{ $invoice->user->businessProfile->phone }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Addresses -->
        <div class="addresses-section">
            <div class="address-box">
                <div class="address-label">Bill To</div>
                <div class="address-content">
                    <h3>{{ $invoice->customer->name }}</h3>
                    @if($invoice->customer->address)
                        <p style="white-space: pre-line;">{!! nl2br(e($invoice->customer->address)) !!}</p>
                    @endif
                    @if($invoice->customer->email)
                        <p>{{ $invoice->customer->email }}</p>
                    @endif
                    @if($invoice->customer->phone)
                        <p>{{ $invoice->customer->phone }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="detail-item">
                <span class="detail-label">Invoice Date</span>
                <span class="detail-value">{{ $invoice->date->format('M d, Y') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Due Date</span>
                <span class="detail-value">{{ $invoice->due_date->format('M d, Y') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Amount Due</span>
                <span class="detail-value">{{ currency_symbol($invoice->currency) }} {{ number_format($invoice->total, 2) }}</span>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Description</th>
                    <th style="width: 15%;" class="text-right">Quantity</th>
                    <th style="width: 20%;" class="text-right">Unit Price</th>
                    <th style="width: 15%;" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td class="description">{{ $item->description }}</td>
                    <td class="text-right">{{ number_format($item->quantity, 2) }}</td>
                    <td class="text-right">{{ currency_symbol($invoice->currency) }} {{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ currency_symbol($invoice->currency) }} {{ number_format($item->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <div class="totals-box">
                <div class="total-row">
                    <span class="total-label">Subtotal</span>
                    <span class="total-value">{{ currency_symbol($invoice->currency) }} {{ number_format($invoice->subtotal, 2) }}</span>
                </div>
                @if($invoice->tax_total > 0)
                <div class="total-row">
                    <span class="total-label">Tax</span>
                    <span class="total-value">{{ currency_symbol($invoice->currency) }} {{ number_format($invoice->tax_total, 2) }}</span>
                </div>
                @endif
                <div class="total-row">
                    <span class="total-label">Total</span>
                    <span class="total-value">{{ currency_symbol($invoice->currency) }} {{ number_format($invoice->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($invoice->notes)
        <div class="notes-section">
            <div class="notes-label">Notes</div>
            <div class="notes-content">{{ $invoice->notes }}</div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This invoice was generated on {{ now()->format('M d, Y') }}</p>
        </div>
    </div>
</body>
</html>
