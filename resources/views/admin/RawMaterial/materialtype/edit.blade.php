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
    {{--  <div class="app-wrapper">  --}}
    <div class="content-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">

            <div class="container-xl">
                <x-session-message />
                <div class="row">
                    <div class="col-lg-12">
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;">Edit Material Type
                        </p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-body">
                                <form id="materialTypeForm" method="POST"
                                    action="{{ route('admin.materialtype.update', $materialType->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ old('name', $materialType->name) }}" required>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $materialType->desc) }}</textarea>
                                            @error('description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Update Material Type</button>
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
