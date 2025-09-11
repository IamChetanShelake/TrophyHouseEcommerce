@extends('admin.layouts.masterlayout')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-tag-edit"></i>
                </span>Edit Coupon
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('coupons.index') }}">Coupons</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Coupon Details</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('coupons.update', $coupon->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Coupon Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            id="code" name="code" value="{{ old('code', $coupon->code) }}"
                                            placeholder="e.g., SAVE20, WELCOME10" maxlength="50" required>
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Discount Type <span class="text-danger">*</span></label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="type"
                                            name="type" required>
                                            <option value="">Select Type</option>
                                            <option value="fixed"
                                                {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>
                                                Fixed Amount
                                            </option>
                                            <option value="percent"
                                                {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>
                                                Percentage
                                            </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="value">Discount Value <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('value') is-invalid @enderror"
                                            id="value" name="value" value="{{ old('value', $coupon->value) }}"
                                            placeholder="e.g., 20 for $20 off or 20 for 20%" min="0" step="0.01"
                                            required>
                                        @error('value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted" id="value-help">
                                            Enter the discount amount or percentage
                                        </small>
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date <span class="text-danger"></span></label>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                            id="start_date" name="start_date"
                                            value="{{ old('start_date', $coupon->start_date->format('Y-m-d')) }}">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date <span class="text-danger">*</span></label>
                                        <input type="date"
                                            class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date"
                                            name="expiry_date"
                                            value="{{ old('expiry_date', $coupon->expiry_date->format('Y-m-d')) }}"
                                            required>
                                        @error('expiry_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="active"
                                                {{ old('status', $coupon->status) == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $coupon->status) == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h6>Please correct the following errors:</h6>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <button type="submit" class="btn btn-gradient-primary mr-2">
                                    <i class="mdi mdi-content-save"></i> Update Coupon
                                </button>
                                <a href="{{ route('coupons.index') }}" class="btn btn-light">
                                    <i class="mdi mdi-arrow-left"></i> Back to Coupons
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Quick Preview</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <i class="mdi mdi-tag-outline" style="font-size: 64px; color: #e91e63;"></i>
                            <h5 class="mt-2" id="preview-code">{{ strtoupper($coupon->code) }}</h5>
                            <p class="mb-1" id="preview-discount">
                                {{ $coupon->type == 'fixed' ? '$' . number_format($coupon->value, 2) . ' OFF' : $coupon->value . '% OFF' }}
                            </p>
                            <small class="text-muted"
                                id="preview-expiry">{{ $coupon->expiry_date->format('M d, Y') }}</small>
                            <div class="mt-3">
                                <span class="badge {{ $coupon->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                    {{ ucfirst($coupon->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.coupons.toggle', $coupon->id) }}"
                            style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="btn {{ $coupon->status == 'active' ? 'btn-outline-warning' : 'btn-outline-success' }} btn-block">
                                <i class="mdi {{ $coupon->status == 'active' ? 'mdi-pause' : 'mdi-play' }}"></i>
                                {{ $coupon->status == 'active' ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('coupons.destroy', $coupon->id) }}"
                            style="display: inline;" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-block"
                                onclick="return confirm('Are you sure you want to delete this coupon?')">
                                <i class="mdi mdi-delete"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update preview dynamically
            const typeSelect = document.getElementById('type');
            const valueInput = document.getElementById('value');
            const codeInput = document.getElementById('code');
            const expiryInput = document.getElementById('expiry_date');

            const previewCode = document.getElementById('preview-code');
            const previewDiscount = document.getElementById('preview-discount');
            const previewExpiry = document.getElementById('preview-expiry');

            function updatePreview() {
                if (codeInput.value.trim() !== '') {
                    previewCode.textContent = codeInput.value.toUpperCase();
                }

                if (valueInput.value !== '') {
                    if (typeSelect.value === 'fixed') {
                        previewDiscount.textContent = '$' + parseFloat(valueInput.value).toFixed(2) + ' OFF';
                    } else if (typeSelect.value === 'percent') {
                        previewDiscount.textContent = valueInput.value + '% OFF';
                    }
                }

                if (expiryInput.value !== '') {
                    const date = new Date(expiryInput.value);
                    previewExpiry.textContent = date.toLocaleDateString('en-US', {
                        month: 'short',
                        day: 'numeric',
                        year: 'numeric'
                    });
                }
            }

            typeSelect.addEventListener('change', updatePreview);
            valueInput.addEventListener('input', updatePreview);
            codeInput.addEventListener('input', updatePreview);
            expiryInput.addEventListener('change', updatePreview);

            // Set minimum date for expiry
            const today = new Date().toISOString().split('T')[0];
            expiryInput.setAttribute('min', today);
        });
    </script>
@endsection
