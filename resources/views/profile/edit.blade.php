@extends('layouts.business.app')

@section('title', 'Profile Settings')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">Profile Information</h5>
                    <p class="text-muted small mb-0">Update your account's profile information and email address.</p>
                </div>
                <div class="card-body">
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="alert alert-warning mt-2 p-2">
                                        <small>
                                            Your email address is unverified.
                                            <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-underline">
                                                Click here to re-send the verification email.
                                            </button>
                                        </small>
                                    </div>

                                    @if (session('status') === 'verification-link-sent')
                                        <div class="alert alert-success mt-2 p-2">
                                            <small>A new verification link has been sent to your email address.</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mt-4">
                            <button type="submit" class="btn btn-primary">Save</button>

                            @if (session('status') === 'profile-updated')
                                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-success small">
                                    Saved.
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Business Profile Settings -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">Business Profile</h5>
                    <p class="text-muted small mb-0">Manage your business information and invoice defaults.</p>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('business-profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="business_name" class="form-label">Business Name <span class="text-danger">*</span></label>
                                <input type="text" id="business_name" name="name" class="form-control" value="{{ old('name', $user->businessProfile->name ?? '') }}" required>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="business_email" class="form-label">Business Email</label>
                                <input type="email" id="business_email" name="email" class="form-control" value="{{ old('email', $user->businessProfile->email ?? '') }}">
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="business_phone" class="form-label">Business Phone</label>
                                <input type="text" id="business_phone" name="phone" class="form-control" value="{{ old('phone', $user->businessProfile->phone ?? '') }}" placeholder="+1 (555) 000-0000">
                                @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="business_logo" class="form-label">Business Logo</label>
                                <input type="file" id="business_logo" name="logo" class="form-control" accept="image/*">
                                @error('logo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                @if($user->businessProfile && $user->businessProfile->logo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $user->businessProfile->logo) }}" alt="Current Logo" class="img-thumbnail" style="max-height: 60px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <label for="business_address" class="form-label">Business Address <span class="text-danger">*</span></label>
                                <textarea id="business_address" name="address" class="form-control" rows="3" required>{{ old('address', $user->businessProfile->address ?? '') }}</textarea>
                                @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="currency" class="form-label">Currency <span class="text-danger">*</span></label>
                                <select id="currency" name="currency" class="form-select" required>
                                    <option value="$" {{ old('currency', $user->businessProfile->currency ?? '$') == '$' ? 'selected' : '' }}>$ - US Dollar</option>
                                    <option value="€" {{ old('currency', $user->businessProfile->currency ?? '') == '€' ? 'selected' : '' }}>€ - Euro</option>
                                    <option value="£" {{ old('currency', $user->businessProfile->currency ?? '') == '£' ? 'selected' : '' }}>£ - British Pound</option>
                                    <option value="¥" {{ old('currency', $user->businessProfile->currency ?? '') == '¥' ? 'selected' : '' }}>¥ - Japanese Yen</option>
                                    <option value="₹" {{ old('currency', $user->businessProfile->currency ?? '') == '₹' ? 'selected' : '' }}>₹ - Indian Rupee</option>
                                    <option value="₦" {{ old('currency', $user->businessProfile->currency ?? '') == '₦' ? 'selected' : '' }}>₦ - Nigerian Naira</option>
                                </select>
                                @error('currency') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tax_rate" class="form-label">Default Tax Rate (%)</label>
                                <input type="number" id="tax_rate" name="tax_rate" class="form-control" value="{{ old('tax_rate', $user->businessProfile->tax_rate ?? 0) }}" min="0" max="100" step="0.01">
                                @error('tax_rate') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                <small class="text-muted">This will be used as the default tax rate for new invoices.</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mt-4">
                            <button type="submit" class="btn btn-primary">Save Business Profile</button>

                            @if (session('status') === 'business-profile-updated')
                                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-success small">
                                    Saved.
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-1">Update Password</h5>
                    <p class="text-muted small mb-0">Ensure your account is using a long, random password to stay secure.</p>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="update_password_current_password" class="form-label">Current Password</label>
                                <input type="password" id="update_password_current_password" name="current_password" class="form-control" autocomplete="current-password">
                                @error('current_password', 'updatePassword') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="update_password_password" class="form-label">New Password</label>
                                <input type="password" id="update_password_password" name="password" class="form-control" autocomplete="new-password">
                                @error('password', 'updatePassword') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control" autocomplete="new-password">
                                @error('password_confirmation', 'updatePassword') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mt-4">
                            <button type="submit" class="btn btn-primary">Save</button>

                            @if (session('status') === 'password-updated')
                                <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-success small">
                                    Saved.
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="col-12">
            <div class="card border-danger">
                <div class="card-header bg-label-danger">
                    <h5 class="card-title mb-1 text-danger">Delete Account</h5>
                    <p class="text-muted small mb-0">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Are you sure you want to delete your account?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <p class="text-muted mb-3">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                    </p>
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        @error('password', 'userDeletion') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    @if($errors->userDeletion->isNotEmpty())
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        deleteModal.show();
    @endif
</script>
@endpush
@endsection
