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
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;"><a
                                href="{{ route('admin.material.index') }}"><i class='fa fa-arrow-circle-left'
                                    style='font-size:36px;color:green;'></i></a>Add
                            Usage({{ $material->name }})</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="usageForm" method="POST" action="{{ route('admin.usage.store') }}">
                                    @csrf
                                    <div class="row">
                                        <!-- Material -->
                                        <div class="col-md-6 mb-3">
                                            <label for="material_name" class="form-label">Material</label>
                                            <input type="text" id="material_name" class="form-control"
                                                value="{{ $material->name }}" readonly>

                                            <input type="hidden" name="material_id" value="{{ $material->id }}">
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

                                        <!-- UsePerson Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="use_person_name" class="form-label">UsePerson Name</label>
                                            <input type="text" name="use_person_name" id="use_person_name"
                                                class="form-control" value="{{ old('use_person_name') }}" required>
                                            @error('use_person_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Usage Date -->
                                        <div class="col-md-6 mb-3">
                                            <label for="usage_date" class="form-label">Usage Date</label>
                                            <input type="date" name="usage_date" id="usage_date" class="form-control"
                                                value="{{ old('usage_date') }}" required>
                                            @error('usage_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Add Usage</button>
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
