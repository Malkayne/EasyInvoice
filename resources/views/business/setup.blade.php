@extends('layouts.business.app')

@section('title', 'Setup Your Business')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title mb-1">Setup Your Business</h5>
                    <p class="text-muted small mb-0">Step 1 of 1: Business Profile</p>
                    <p class="text-muted small mb-0">Let's set up your business details to appear on your invoices.</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('business.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Logo Upload -->
                        <div class="mb-4" x-data="{ preview: null }">
                            <label class="form-label">Business Logo</label>
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <template x-if="preview">
                                        <img :src="preview" class="rounded" style="height: 80px; width: 80px; object-fit: cover;" />
                                    </template>
                                    <template x-if="!preview">
                                        <div class="rounded bg-label-secondary d-flex align-items-center justify-content-center" style="height: 80px; width: 80px;">
                                            <i class="ti ti-photo fs-2 text-muted"></i>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" 
                                           name="logo" 
                                           accept="image/*" 
                                           class="form-control"
                                           @change="preview = URL.createObjectURL($event.target.files[0])">
                                    @error('logo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Business Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Business Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Business Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}">
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                                @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Business Address <span class="text-danger">*</span></label>
                            <textarea id="address" name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                            @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Currency -->
                            <div class="col-md-6">
                                <label for="currency" class="form-label">Default Currency <span class="text-danger">*</span></label>
                                <select id="currency" name="currency" class="form-select">
                                    <option value="USD">USD ($)</option>
                                    <option value="EUR">EUR (€)</option>
                                    <option value="GBP">GBP (£)</option>
                                    <option value="CAD">CAD ($)</option>
                                    <option value="AUD">AUD ($)</option>
                                </select>
                                @error('currency') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Tax Rate -->
                            <div class="col-md-6">
                                <label for="tax_rate" class="form-label">Default Tax Rate (%)</label>
                                <input type="number" id="tax_rate" name="tax_rate" class="form-control" step="0.01" value="{{ old('tax_rate') }}" placeholder="0.00">
                                @error('tax_rate') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-check me-1"></i> Save & Continue to Dashboard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
