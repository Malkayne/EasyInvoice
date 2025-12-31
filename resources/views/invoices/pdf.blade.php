<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; font-size: 16px; line-height: 24px; color: #555; }
        .header { margin-bottom: 20px; }
        .header td { vertical-align: top; }
        .header-title { font-size: 32px; font-weight: bold; color: #333; }
        .invoice-details { text-align: right; }
        .invoice-details span { font-weight: bold; }
        .bill-to { margin-top: 20px; margin-bottom: 20px; }
        .bill-to h3 { margin-bottom: 5px; font-size: 14px; text-transform: uppercase; color: #777; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table td { padding: 5px; vertical-align: top; }
        table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        table tr.item td { border-bottom: 1px solid #eee; }
        table tr.item.last td { border-bottom: none; }
        table tr.total td { border-top: 2px solid #eee; font-weight: bold; }
        .text-right { text-align: right; }
        .logo { max-height: 60px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table style="width: 100%;">
                        <tr>
                            <td class="title">
                                <div class="header-title">INVOICE</div>
                                @if($invoice->user->businessProfile->logo)
                                    <!-- Assume logo is accessible via public path for PDF -->
                                    <!-- For dompdf, sometimes real-path is needed: public_path('storage/...') -->
                                @endif
                                <div>{{ $invoice->user->businessProfile->name }}</div>
                            </td>
                            <td class="invoice-details">
                                Invoice #: {{ $invoice->invoice_number }}<br>
                                Created: {{ $invoice->date->format('M d, Y') }}<br>
                                Due: {{ $invoice->due_date->format('M d, Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="4">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 50%;">
                                <strong>From:</strong><br>
                                {{ $invoice->user->businessProfile->name }}<br>
                                {!! nl2br(e($invoice->user->businessProfile->address)) !!}<br>
                                {{ $invoice->user->businessProfile->email }}
                            </td>
                            <td style="width: 50%; text-align: right;">
                                <strong>Bill To:</strong><br>
                                {{ $invoice->customer->name }}<br>
                                {!! nl2br(e($invoice->customer->address)) !!}<br>
                                {{ $invoice->customer->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <div style="margin-top: 20px;"></div>

        <table>
            <tr class="heading">
                <td>Item</td>
                <td class="text-right">Price</td>
                <td class="text-right">Quantity</td>
                <td class="text-right">Total</td>
            </tr>
            
            @foreach($invoice->items as $item)
            <tr class="item">
                <td>{{ $item->description }}</td>
                <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->amount, 2) }}</td>
            </tr>
            @endforeach
            
            <tr class="total">
                <td colspan="3" class="text-right">Subtotal:</td>
                <td class="text-right">{{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            <tr class="total">
                <td colspan="3" class="text-right">Tax:</td>
                <td class="text-right">{{ number_format($invoice->tax_total, 2) }}</td>
            </tr>
            <tr class="total">
                <td colspan="3" class="text-right">Total:</td>
                <td class="text-right">{{ $invoice->user->businessProfile->currency }} {{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>

        <!-- Payment Info or Notes if needed -->
        <div style="margin-top: 40px; color: #777; font-size: 12px; text-align: center;">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
