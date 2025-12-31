<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12" 
         x-data="{
            items: [{
                description: '',
                quantity: 1,
                unit_price: 0,
                amount: 0
            }],
            taxRate: {{ auth()->user()->businessProfile->tax_rate ?? 0 }},
            subtotal: 0,
            taxTotal: 0,
            grandTotal: 0,

            calculateRow(index) {
                let qty = parseFloat(this.items[index].quantity) || 0;
                let price = parseFloat(this.items[index].unit_price) || 0;
                this.items[index].amount = (qty * price).toFixed(2);
                this.calculateTotals();
            },

            calculateTotals() {
                this.subtotal = this.items.reduce((sum, item) => sum + parseFloat(item.amount || 0), 0);
                this.taxTotal = this.subtotal * (this.taxRate / 100);
                this.grandTotal = this.subtotal + this.taxTotal;
            },

            addItem() {
                this.items.push({
                    description: '',
                    quantity: 1,
                    unit_price: 0,
                    amount: 0
                });
            },

            removeItem(index) {
                this.items.splice(index, 1);
                this.calculateTotals();
            }
         }"
         x-init="calculateTotals()"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('invoices.store') }}">
                @csrf
                <input type="hidden" name="tax_rate" :value="taxRate">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Left Column: Invoice Details & Items -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Header Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="customer_id" value="Customer" />
                                    <select id="customer_id" name="customer_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="" disabled selected>Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-user text-gray-400"></i>
                                    </div>
                                </div>
                                <div class="mt-2 text-right">
                                    <a href="{{ route('customers.index') }}" class="text-xs text-royal-600 hover:text-royal-800 font-medium">+ New Customer</a>
                                </div>
                            </div>

                            <!-- Invoice Details -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="date" class="block text-sm font-semibold text-gray-700 mb-1">Invoice Date</label>
                                    <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-royal-500 focus:border-royal-500 sm:text-sm">
                                </div>
                                <div>
                                    <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-1">Due Date</label>
                                    <input type="date" name="due_date" id="due_date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-royal-500 focus:border-royal-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100 mb-8">

                        <!-- Line Items -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-bold text-gray-800">Items</h3>
                                <button type="button" @click="addItem()" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-semibold rounded-md text-royal-700 bg-royal-100 hover:bg-royal-200 transition-colors">
                                    <i class="fa-solid fa-plus mr-1"></i> Add Item
                                </button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="flex flex-col md:flex-row gap-4 items-start md:items-center bg-gray-50 p-4 rounded-xl border border-gray-200 relative group">
                                        <div class="flex-1 w-full">
                                            <label class="block text-xs font-medium text-gray-500 mb-1 md:hidden">Description</label>
                                            <input type="text" x-bind:name="'items[' + index + '][description]'" x-model="item.description" placeholder="Item description" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-royal-500 focus:border-royal-500 sm:text-sm" required>
                                        </div>
                                        <div class="w-full md:w-24">
                                            <label class="block text-xs font-medium text-gray-500 mb-1 md:hidden">Qty</label>
                                            <input type="number" x-bind:name="'items[' + index + '][quantity]'" x-model="item.quantity" @input="calculateTotal()" min="1" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-royal-500 focus:border-royal-500 sm:text-sm text-right" required>
                                        </div>
                                        <div class="w-full md:w-32">
                                            <label class="block text-xs font-medium text-gray-500 mb-1 md:hidden">Price</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">{{ auth()->user()->businessProfile->currency ?? '$' }}</span>
                                                </div>
                                                <input type="number" x-bind:name="'items[' + index + '][unit_price]'" x-model="item.unit_price" @input="calculateTotal()" min="0" step="0.01" class="block w-full pl-7 border-gray-300 rounded-md shadow-sm focus:ring-royal-500 focus:border-royal-500 sm:text-sm text-right" required>
                                            </div>
                                        </div>
                                        <div class="w-full md:w-24 text-right font-bold text-gray-700 pt-1 md:pt-0">
                                            <span x-text="formatMoney(item.quantity * item.unit_price)"></span>
                                        </div>
                                        <button type="button" @click="removeItem(index)" class="absolute -top-2 -right-2 md:static md:ml-2 text-gray-400 hover:text-red-500 transition-colors p-1 bg-white md:bg-transparent rounded-full border md:border-0 shadow-sm md:shadow-none">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8">
                                <div class="bg-gray-50 p-4 rounded-xl h-full border border-gray-200">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                                    <textarea class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-royal-500 focus:border-royal-500 sm:text-sm" rows="3" placeholder="Additional notes for the customer..."></textarea>
                                </div>
                                <div class="bg-royal-50 p-6 rounded-xl border border-royal-100">
                                    <div class="flex justify-between py-2 text-gray-600">
                                        <span>Subtotal</span>
                                        <span class="font-medium" x-text="formatMoney(subtotal)"></span>
                                    </div>
                                    <div class="flex justify-between py-2 text-gray-600 items-center">
                                        <span class="flex items-center">Tax <input type="number" x-model="taxRate" @input="calculateTotal()" class="ml-2 w-16 p-1 text-right text-xs border-gray-300 rounded focus:ring-royal-500 focus:border-royal-500"> %</span>
                                        <span class="font-medium" x-text="formatMoney(taxAmount)"></span>
                                    </div>
                                    <div class="flex justify-between py-2 text-gray-600 items-center">
                                        <span class="flex items-center">Discount <input type="number" x-model="discount" @input="calculateTotal()" class="ml-2 w-20 p-1 text-right text-xs border-gray-300 rounded focus:ring-royal-500 focus:border-royal-500"></span>
                                        <span class="font-medium text-red-500">-<span x-text="formatMoney(discount)"></span></span>
                                    </div>
                                    <div class="border-t border-royal-200 mt-2 pt-2 flex justify-between items-center text-royal-900 text-lg font-bold">
                                        <span>Total</span>
                                        <span x-text="formatMoney(total)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end pt-6 border-t border-gray-100">
                            <a href="{{ route('dashboard') }}" class="mr-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-royal-600 hover:bg-royal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-royal-500 shadow-lg transform transition hover:-translate-y-0.5">
                                <i class="fa-solid fa-save mr-2"></i> Save Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Fields for Form Submission Logic handled by Alpine but here for structure reference -->

    <script>
        function invoiceForm() {
            return {
                items: [
                    { description: '', quantity: 1, unit_price: 0 }
                ],
                taxRate: {{ auth()->user()->businessProfile->tax_rate ?? 0 }},
                discount: 0,
                subtotal: 0,
                taxAmount: 0,
                total: 0,
                currency: '{{ auth()->user()->businessProfile->currency ?? '$' }}',

                addItem() {
                    this.items.push({ description: '', quantity: 1, unit_price: 0 });
                },
                removeItem(index) {
                    if(this.items.length > 1) {
                        this.items.splice(index, 1);
                        this.calculateTotal();
                    }
                },
                calculateTotal() {
                    this.subtotal = this.items.reduce((sum, item) => {
                        return sum + (item.quantity * item.unit_price);
                    }, 0);
                    
                    this.taxAmount = this.subtotal * (this.taxRate / 100);
                    this.total = Math.max(0, this.subtotal + this.taxAmount - this.discount);
                },
                formatMoney(amount) {
                    return this.currency + ' ' + (Number(amount).toFixed(2));
                },
                init() {
                    this.calculateTotal();
                }
            }
        }
    </script>
</x-app-layout>
