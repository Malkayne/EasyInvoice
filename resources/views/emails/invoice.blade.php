<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .email-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .email-body {
            padding: 30px;
        }
        .invoice-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .invoice-summary h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-size: 18px;
        }
        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
        }
        .detail-label {
            font-weight: 600;
            color: #6c757d;
        }
        .detail-value {
            font-weight: 700;
            color: #333;
        }
        .total-amount {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
            text-align: center;
            margin: 20px 0;
        }
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin: 0 10px;
            transition: all 0.2s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
        }
        .business-info {
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .business-info h4 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .business-info p {
            margin: 5px 0;
            color: #6c757d;
        }
        .message-content {
            white-space: pre-line;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        @media (max-width: 600px) {
            .invoice-details {
                grid-template-columns: 1fr;
            }
            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            .btn {
                display: block;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>
            <p>{{ $businessName }}</p>
        </div>

        <div class="email-body">
            @if($customMessage)
            <div class="message-content">
                {{ $customMessage }}
            </div>
            @endif

            <div class="invoice-summary">
                <h3>Invoice Summary</h3>
                <div class="invoice-details">
                    <div class="detail-item">
                        <span class="detail-label">Invoice Number:</span>
                        <span class="detail-value">#{{ $invoice->invoice_number }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status:</span>
                        <span class="detail-value">{{ ucfirst($invoice->status) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Issue Date:</span>
                        <span class="detail-value">{{ $invoice->date->format('M d, Y') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Due Date:</span>
                        <span class="detail-value">{{ $invoice->due_date->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="total-amount">
                    <span class="h5 mb-0 text-primary fw-bold">{{ currency_symbol($invoice->currency) }} {{ number_format($invoice->total, 2) }}</span>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('invoices.public', $invoice->public_token) }}" class="btn btn-primary">
                    View Invoice Online
                </a>
                <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-secondary">
                    Download PDF
                </a>
            </div>

            <div class="business-info">
                <h4>{{ $invoice->user->businessProfile->name }}</h4>
                @if($invoice->user->businessProfile->address)
                    <p>{!! nl2br(e($invoice->user->businessProfile->address)) !!}</p>
                @endif
                @if($invoice->user->businessProfile->email)
                    <p><strong>Email:</strong> {{ $invoice->user->businessProfile->email }}</p>
                @endif
                @if($invoice->user->businessProfile->phone)
                    <p><strong>Phone:</strong> {{ $invoice->user->businessProfile->phone }}</p>
                @endif
            </div>
        </div>

        <div class="email-footer">
            <p>This invoice was sent via EasyInvoice. If you have any questions, please contact {{ $invoice->user->businessProfile->email }}.</p>
            <p>&copy; {{ date('Y') }} {{ $businessName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
