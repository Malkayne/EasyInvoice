<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Customers') }}
            </h2>
            <button @click="$dispatch('open-modal', 'create-customer')" class="inline-flex items-center px-4 py-2 bg-royal-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-royal-700 active:bg-royal-900 focus:outline-none focus:border-royal-900 focus:ring ring-royal-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                <i class="fa-solid fa-user-plus mr-2"></i> Add Customer
            </button>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ editingCustomer: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    @if (session('success'))
                        <div class="m-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg flex items-center">
                            <i class="fa-solid fa-circle-check mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($customers->isEmpty())
                        <div class="p-16 text-center">
                            <div class="bg-gray-50 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-users text-3xl text-gray-300"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">No customers yet</h3>
                            <p class="mt-2 text-gray-500">Add your first customer to start creating invoices.</p>
                            <div class="mt-6">
                                <button @click="$dispatch('open-modal', 'create-customer')" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-royal-600 hover:bg-royal-700 transition-colors">
                                    Add New Customer
                                </button>
                            </div>
                        </div>
                    @else
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($customers as $customer)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-royal-100 flex items-center justify-center text-royal-600 font-bold">
                                                    {{ substr($customer->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $customer->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $customer->email }}</div>
                                        <div class="text-sm text-gray-500">{{ $customer->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button 
                                            @click="editingCustomer = {{ $customer }}; $dispatch('open-modal', 'edit-customer')"
                                            class="text-royal-600 hover:text-royal-900 mr-4 transition-colors" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 transition-colors" title="Delete">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Create Customer Modal -->
        <x-modal name="create-customer" :show="$errors->any() && !old('_method')" focusable>
            <form method="POST" action="{{ route('customers.store') }}" class="p-6">
                @csrf
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-900">Add New Customer</h2>
                    <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-500">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required placeholder="Company or Person Name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" placeholder="email@example.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="phone" value="Phone" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" placeholder="+1 (555) 000-0000" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="address" value="Address" />
                        <textarea id="address" name="address" class="block w-full border-gray-300 focus:border-royal-500 focus:ring-royal-500 rounded-md shadow-sm mt-1" rows="3" placeholder="Billing Address">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                    <x-primary-button class="bg-royal-600 hover:bg-royal-700">Save Customer</x-primary-button>
                </div>
            </form>
        </x-modal>

        <!-- Edit Customer Modal -->
        <x-modal name="edit-customer" :show="$errors->any() && old('_method') === 'PATCH'" focusable>
            <form method="POST" x-bind:action="'/customers/' + (editingCustomer ? editingCustomer.id : '')" class="p-6">
                @csrf
                @method('PATCH')
                
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-900">Edit Customer</h2>
                    <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-500">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <x-input-label for="edit_name" value="Name" />
                        <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" x-bind:value="editingCustomer ? editingCustomer.name : ''" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit_email" value="Email" />
                            <x-text-input id="edit_email" name="email" type="email" class="mt-1 block w-full" x-bind:value="editingCustomer ? editingCustomer.email : ''" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="edit_phone" value="Phone" />
                            <x-text-input id="edit_phone" name="phone" type="text" class="mt-1 block w-full" x-bind:value="editingCustomer ? editingCustomer.phone : ''" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="edit_address" value="Address" />
                        <textarea id="edit_address" name="address" class="block w-full border-gray-300 focus:border-royal-500 focus:ring-royal-500 rounded-md shadow-sm mt-1" rows="3" x-bind:value="editingCustomer ? editingCustomer.address : ''"></textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                    <x-primary-button class="bg-royal-600 hover:bg-royal-700">Update Customer</x-primary-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>
