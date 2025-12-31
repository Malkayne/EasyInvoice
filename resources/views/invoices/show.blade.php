<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invoice') }} #{{ $invoice->invoice_number }}
            </h2>
            <div class="space-x-4 flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">Back to Dashboard</a>
                
                <!-- Copy Link Button (Alpine) -->
                <div x-data="{ copied: false }">
                    <button @click="navigator.clipboard.writeText('{{ route('invoices.public', $invoice->public_token) }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                            class="text-indigo-600 hover:text-indigo-900 text-sm font-medium mr-4">
                        <span x-show="!copied">Copy Public Link</span>
                        <span x-show="copied" class="text-green-600">Copied!</span>
                    </button>
                </div>

                <a href="{{ route('invoices.download', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Download PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8">
                    <!-- Invoice Header -->
                    <div class="flex justify-between items-start border-b pb-8">
                        <div>
                            <h1 class="text-4xl font-bold text-gray-800">INVOICE</h1>
                            <p class="text-gray-500 mt-2">#{{ $invoice->invoice_number }}</p>
                            <div class="mt-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                                    {{ $invoice->status }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            @if(auth()->user()->businessProfile->logo)
                                <img src="{{ asset('storage/' . auth()->user()->businessProfile->logo) }}" alt="Logo" class="h-16 w-auto mb-4 object-contain ml-auto">
                            @endif
                            <h3 class="font-bold text-lg">{{ auth()->user()->businessProfile->name }}</h3>
                            <p class="text-gray-600 whitespace-pre-line">{{ auth()->user()->businessProfile->address }}</p>
                            <p class="text-gray-600">{{ auth()->user()->businessProfile->email }}</p>
                        </div>
                    </div>

                    <!-- Bill To & Details -->
                    <div class="flex justify-between py-8">
                        <div>
                            <h4 class="font-bold text-gray-600 uppercase text-xs mb-2">Bill To</h4>
                            <p class="font-bold text-lg">{{ $invoice->customer->name }}</p>
                            <p class="text-gray-600">{{ $invoice->customer->email }}</p>
                            <p class="text-gray-600 whitespace-pre-line">{{ $invoice->customer->address }}</p>
                        </div>
                        <div class="text-right space-y-2">
                            <div>
                                <span class="font-bold text-gray-600 uppercase text-xs">Date:</span>
                                <span class="text-gray-800 ml-2">{{ $invoice->date->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="font-bold text-gray-600 uppercase text-xs">Due Date:</span>
                                <span class="text-gray-800 ml-2">{{ $invoice->due_date->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="py-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                    <th class="py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($invoice->items as $item)
                                <tr>
                                    <td class="py-4 text-sm text-gray-900">{{ $item->description }}</td>
                                    <td class="py-4 text-right text-sm text-gray-500">{{ $item->quantity }}</td>
                                    <td class="py-4 text-right text-sm text-gray-500">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="py-4 text-right text-sm text-gray-900 font-medium">{{ number_format($item->amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="py-4 border-t border-gray-200">
                        <div class="flex justify-end space-y-2">
                            <div class="w-64">
                                <div class="flex justify-between py-2 text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span>{{ number_format($invoice->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between py-2 text-sm text-gray-600">
                                    <span>Tax</span>
                                    <span>{{ number_format($invoice->tax_total, 2) }}</span>
                                </div>
                                <div class="flex justify-between py-2 text-lg font-bold text-gray-900 border-t border-gray-200 mt-2 pt-2">
                                    <span>Total</span>
                                    <span>{{ auth()->user()->businessProfile->currency }} {{ number_format($invoice->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
