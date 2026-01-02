<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $invoice->invoice_number }} - {{ $invoice->user->businessProfile->name }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-4xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            
            <!-- Public Header -->
            <div class="flex justify-between items-center border-b pb-6 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">INVOICE</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize mt-2">
                        {{ $invoice->status }}
                    </span>
                </div>
                <!-- Download Action -->
                <div>
                    <a href="{{ route('invoices.download', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150">
                        Download PDF
                    </a>
                </div>
            </div>

            <!-- Business & Customer Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">From</h3>
                    <div class="font-bold text-lg">{{ $invoice->user->businessProfile->name }}</div>
                    <div class="text-gray-600 whitespace-pre-line">{{ $invoice->user->businessProfile->address }}</div>
                    <div class="text-gray-600">{{ $invoice->user->businessProfile->email }}</div>
                </div>
                <div class="text-right">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Bill To</h3>
                    <div class="font-bold text-lg">{{ $invoice->customer->name }}</div>
                    <div class="text-gray-600 whitespace-pre-line">{{ $invoice->customer->address }}</div>
                    <div class="text-gray-600">{{ $invoice->customer->email }}</div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="grid grid-cols-2 gap-4 mb-4 bg-gray-50 p-4 rounded-lg">
                <div>
                    <span class="block text-xs font-bold text-gray-500 uppercase">Invoice Number</span>
                    <span class="block text-gray-900 font-medium">#{{ $invoice->invoice_number }}</span>
                </div>
                <div class="text-right">
                    <span class="block text-xs font-bold text-gray-500 uppercase">Due Date</span>
                    <span class="block text-gray-900 font-medium">{{ $invoice->due_date->format('M d, Y') }}</span>
                </div>
            </div>

            @if($invoice->note)
                <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-400 rounded-r-lg">
                    <span class="block text-xs font-bold text-blue-500 uppercase mb-1">Note</span>
                    <div class="text-gray-700 text-sm whitespace-pre-line">{{ $invoice->note }}</div>
                </div>
            @endif

            <!-- Items -->
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($invoice->items as $item)
                        <tr>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->description }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ $item->quantity }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right text-gray-500">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-3 py-4 whitespace-nowrap text-sm text-right font-medium text-gray-900">{{ number_format($item->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="flex justify-end border-t pt-4">
                <div class="w-64 space-y-2">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span>{{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Tax</span>
                        <span>{{ number_format($invoice->tax_total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t">
                        <span>Total</span>
                        <span>{{ $invoice->user->businessProfile->currency }} {{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-12 text-center text-sm text-gray-500">
                <p>Powered by EasyInvoice</p>
            </div>
        </div>
    </div>
</body>
</html>
