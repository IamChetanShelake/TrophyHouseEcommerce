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
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;">Edit Material</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="materialForm" method="POST"
                                    action="{{ route('admin.material.update', $material->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Material Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ old('name', $material->name) }}" required>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Category -->
                                        <div class="col-md-6 mb-3">
                                            <label for="category_id" class="form-label">Category</label>
                                            <select name="category_id" id="category_id" class="form-control" required>
                                                <option value="" disabled>Select Category</option>
                                                @foreach ($materialTypes as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ old('category_id', $material->category_id) == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Unit -->
                                        <div class="col-md-6 mb-3">
                                            <label for="unit" class="form-label">Unit</label>
                                            <select name="unit" id="unit" class="form-control" required>
                                                <option value="" disabled>Select Unit</option>
                                                <option value="kg"
                                                    {{ old('unit', $material->unit) == 'kg' ? 'selected' : '' }}>kg</option>
                                                <option value="piece"
                                                    {{ old('unit', $material->unit) == 'piece' ? 'selected' : '' }}>piece
                                                </option>
                                                <option value="meter"
                                                    {{ old('unit', $material->unit) == 'meter' ? 'selected' : '' }}>meter
                                                </option>
                                                <option value="sheet"
                                                    {{ old('unit', $material->unit) == 'sheet' ? 'selected' : '' }}>sheet
                                                </option>
                                            </select>
                                            @error('unit')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{--  <!-- Stock In -->
                                        <div class="col-md-6 mb-3">
                                            <label for="stock_in" class="form-label">Stock In</label>
                                            <input type="number" name="stock_in" id="stock_in" class="form-control"
                                                value="{{ old('stock_in', $material->stock_in) }}" step="0.01"
                                                min="0" required>
                                            @error('stock_in')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>  --}}

                                        {{--  <!-- Stock Out -->
                                        <div class="col-md-6 mb-3">
                                            <label for="stock_out" class="form-label">Stock Out</label>
                                            <input type="number" name="stock_out" id="stock_out" class="form-control"
                                                value="{{ old('stock_out', $material->stock_out) }}" step="0.01"
                                                min="0" required>
                                            @error('stock_out')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>  --}}

                                        {{--  <!-- Current Stock -->
                                        <div class="col-md-6 mb-3">
                                            <label for="current_stock" class="form-label">Current Stock</label>
                                            <input type="number" name="current_stock" id="current_stock"
                                                class="form-control"
                                                value="{{ old('current_stock', $material->current_stock) }}" step="0.01"
                                                min="0" required>
                                            @error('current_stock')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Reorder Level -->
                                        <div class="col-md-6 mb-3">
                                            <label for="reorder_level" class="form-label">Reorder Level</label>
                                            <input type="number" name="reorder_level" id="reorder_level"
                                                class="form-control"
                                                value="{{ old('reorder_level', $material->reorder_level) }}" step="0.01"
                                                min="0" required>
                                            @error('reorder_level')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>  --}}

                                        <!-- Description -->
                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $material->desc) }}</textarea>
                                            @error('description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Update Material</button>
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
