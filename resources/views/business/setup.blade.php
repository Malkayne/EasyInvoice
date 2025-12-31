<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setup Your Business') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 border-b pb-4">
                        <h3 class="text-lg font-medium text-gray-900">Step 1 of 1: Business Profile</h3>
                        <p class="text-sm text-gray-600">Let's set up your business details to appear on your invoices.</p>
                    </div>

                    <form method="POST" action="{{ route('business.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Logo Upload -->
                        <div x-data="{ preview: null }" class="flex items-center gap-6">
                            <div class="shrink-0">
                                <template x-if="preview">
                                    <img :src="preview" class="h-20 w-20 object-cover rounded-full border border-gray-200" />
                                </template>
                                <template x-if="!preview">
                                    <div class="h-20 w-20 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <label class="block">
                                <span class="sr-only">Choose logo</span>
                                <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100
                                "
                                @change="preview = URL.createObjectURL($event.target.files[0])"
                                />
                                <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                            </label>
                        </div>

                        <!-- Business Name -->
                        <div>
                            <x-input-label for="name" :value="__('Business Name *')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Business Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', auth()->user()->email)" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Business Address *')" />
                            <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3" required>{{ old('address') }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Currency -->
                            <div>
                                <x-input-label for="currency" :value="__('Default Currency *')" />
                                <select id="currency" name="currency" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="USD">USD ($)</option>
                                    <option value="EUR">EUR (€)</option>
                                    <option value="GBP">GBP (£)</option>
                                    <option value="CAD">CAD ($)</option>
                                    <option value="AUD">AUD ($)</option>
                                </select>
                                <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                            </div>

                            <!-- Tax Rate -->
                            <div>
                                <x-input-label for="tax_rate" :value="__('Default Tax Rate (%)')" />
                                <x-text-input id="tax_rate" class="block mt-1 w-full" type="number" step="0.01" name="tax_rate" :value="old('tax_rate')" placeholder="0.00" />
                                <x-input-error :messages="$errors->get('tax_rate')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Save & Continue to Dashboard') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
