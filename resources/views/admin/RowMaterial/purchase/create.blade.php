@extends('admin.layouts.masterlayout')
@section('content')
    <style>
        .form-control,
        .btn {
            font-size: 16px;
        }

        .form-label {
            font-size: 16px;
            font-weight: 500;
            color: #000;
        }

        .btn-primary {
            background-color: #FFE235;
            border: none;
            color: #000;
        }

        .btn-primary:hover {
            background-color: #f5f5f5;
        }

        .app-wrapper {
            background: #FFFFF4;
        }

        @media (max-width: 768px) {
            .custom-margin {
                margin-left: 10px !important;
            }
        }
    </style>
    <div class="content-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <x-session-message />
                <div class="row">
                    <div class="col-lg-12">
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;">Add Purchase</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="purchaseForm" method="POST" action="{{ route('admin.purchase.store') }}">
                                    @csrf
                                    <div class="row">
                                        <!-- Material -->
                                        <div class="col-md-6 mb-3">
                                            <label for="material_id" class="form-label">Material</label>
                                            <select name="material_id" id="material_id" class="form-control" required>
                                                <option value="" disabled {{ old('material_id') ? '' : 'selected' }}>
                                                    Select Material</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}"
                                                        {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                                        {{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('material_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Quantity -->
                                        <div class="col-md-6 mb-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" name="quantity" id="quantity" class="form-control"
                                                value="{{ old('quantity') }}" step="0.01" min="0" required>
                                            @error('quantity')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Unit Price -->
                                        <div class="col-md-6 mb-3">
                                            <label for="unit_price" class="form-label">Unit Price</label>
                                            <input type="number" name="unit_price" id="unit_price" class="form-control"
                                                value="{{ old('unit_price') }}" step="0.01" min="0" required>
                                            @error('unit_price')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Total Cost -->
                                        <div class="col-md-6 mb-3">
                                            <label for="total_cost" class="form-label">Total Cost</label>
                                            <input type="number" name="total_cost" id="total_cost" class="form-control"
                                                value="{{ old('total_cost') }}" step="0.01" min="0" required>
                                            @error('total_cost')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Supplier Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="supplier_name" class="form-label">Supplier Name</label>
                                            <input type="text" name="supplier_name" id="supplier_name"
                                                class="form-control" value="{{ old('supplier_name') }}" required>
                                            @error('supplier_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Supplier Contact -->
                                        <div class="col-md-6 mb-3">
                                            <label for="supplier_contact" class="form-label">Supplier Contact</label>
                                            <input type="text" name="supplier_contact" id="supplier_contact"
                                                class="form-control" value="{{ old('supplier_contact') }}">
                                            @error('supplier_contact')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Purchase Date -->
                                        <div class="col-md-6 mb-3">
                                            <label for="purchase_date" class="form-label">Purchase Date</label>
                                            <input type="date" name="purchase_date" id="purchase_date"
                                                class="form-control" value="{{ old('purchase_date') }}" required>
                                            @error('purchase_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Add Purchase</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
