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

        .btn-add-row {
            background-color: #0d6efd;
            border: none;
            color: #fff;
        }

        .btn-submit {
            background-color: #28a745;
            border: none;
            color: #fff;
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
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;">Edit Usage Person</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="usageForm" method="POST"
                                    action="{{ route('admin.usage-person.update', $usagePerson->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <!-- Date -->
                                        <div class="col-md-6 mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" name="date" id="date" class="form-control"
                                                value="{{ old('date', $usagePerson->date) }}" required>
                                            @error('date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Name -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" id="name" class="form-control"
                                                value="{{ old('name', $usagePerson->name) }}" required>
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Contact -->
                                        <div class="col-md-6 mb-3">
                                            <label for="contact" class="form-label">Contact</label>
                                            <input type="text" name="contact" id="contact" class="form-control"
                                                value="{{ old('contact', $usagePerson->contact) }}" required>
                                            @error('contact')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-4">
                                        <table class="table" id="materialTable">
                                            <thead>
                                                <tr>
                                                    <th>Material Type</th>
                                                    <th>Raw Material</th>
                                                    <th>Current Stock</th>
                                                    <th>Quantity</th>
                                                    <th>Usage Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($usages as $usage)
                                                    <tr class="material-row">
                                                        <td>
                                                            <select name="material_type_id[]"
                                                                class="form-control material-type-select" required>
                                                                <option value="" disabled>Select Material Type
                                                                </option>
                                                                @foreach ($materialTypes as $type)
                                                                    <option value="{{ $type->id }}"
                                                                        {{ $type->id == $usage->material->category_id ? 'selected' : '' }}>
                                                                        {{ $type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="material_id[]"
                                                                class="form-control material-select" required>
                                                                <option value="" disabled>Select Material</option>
                                                                @foreach ($materials as $material)
                                                                    @if ($material->category_id == $usage->material->category_id)
                                                                        <option value="{{ $material->id }}"
                                                                            {{ $usage->material_id == $material->id ? 'selected' : '' }}>
                                                                            {{ $material->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control current-stock"
                                                                value="{{ $usage->material->current_stock }}" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="quantity[]"
                                                                class="form-control quantity"
                                                                value="{{ $usage->quantity }}" step="0.01"
                                                                min="0" required>
                                                        </td>
                                                        <td>
                                                            <input type="date" name="usage_date[]"
                                                                class="form-control usage-date"
                                                                value="{{ $usage->usage_date }}" required>
                                                        </td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-row"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="total_quantity" class="form-label">Total Quantity</label>
                                            <input type="number" id="total_quantity" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12 text-center">
                                            <button type="button" id="add-row" class="btn btn-add-row">Add Row</button>
                                            <button type="submit" class="btn btn-submit">Submit</button>
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

    <script>
        const materials = {!! json_encode($materials) !!};
        const materialTypes = {!! json_encode($materialTypes) !!};

        document.addEventListener('DOMContentLoaded', function() {
            function updateMaterials(select) {
                const typeId = select.value;
                const row = select.closest('.material-row');
                const materialSelect = row.querySelector('.material-select');
                const currentStockInput = row.querySelector('.current-stock');

                // Clear existing options
                materialSelect.innerHTML = '<option value="" disabled selected>Select Material</option>';

                // Filter materials by category_id
                const filteredMaterials = materials.filter(m => m.category_id == typeId);
                filteredMaterials.forEach(material => {
                    const option = document.createElement('option');
                    option.value = material.id;
                    option.textContent = material.name;
                    materialSelect.appendChild(option);
                });

                // Do not auto-select the first material, just update current stock to 0
                currentStockInput.value = 0;
                materialSelect.value = ''; // Ensure no default selection
            }

            function updateCurrentStock(select) {
                const materialId = select.value;
                const row = select.closest('.material-row');
                const currentStockInput = row.querySelector('.current-stock');
                const material = materials.find(m => m.id == materialId);
                currentStockInput.value = material ? material.current_stock : 0;
            }

            function updateTotal(row) {
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                updateTotalQuantity();
            }

            function updateTotalQuantity() {
                let totalQuantity = 0;
                document.querySelectorAll('.quantity').forEach(input => {
                    totalQuantity += parseFloat(input.value) || 0;
                });
                document.getElementById('total_quantity').value = totalQuantity.toFixed(2);
            }

            // Event listeners for existing rows
            document.querySelectorAll('.material-row').forEach(row => {
                row.querySelector('.material-type-select').addEventListener('change', function() {
                    updateMaterials(this);
                });
                row.querySelector('.material-select').addEventListener('change', function() {
                    updateCurrentStock(this);
                });
                row.querySelector('.quantity').addEventListener('input', function() {
                    updateTotal(row);
                });
                row.querySelector('.remove-row').addEventListener('click', function() {
                    if (document.querySelectorAll('.material-row').length > 1) {
                        row.remove();
                        updateTotalQuantity();
                    }
                });
            });

            // Add row
            document.getElementById('add-row').addEventListener('click', function() {
                const firstRow = document.querySelector('.material-row');
                const newRow = firstRow.cloneNode(true);
                newRow.querySelectorAll('input, select').forEach(input => {
                    input.value = '';
                });
                newRow.querySelector('.material-select').innerHTML =
                    '<option value="" disabled selected>Select Material</option>';
                newRow.querySelector('.material-type-select').selectedIndex = 0;
                newRow.querySelector('.material-type-select').addEventListener('change', function() {
                    updateMaterials(this);
                });
                newRow.querySelector('.material-select').addEventListener('change', function() {
                    updateCurrentStock(this);
                });
                newRow.querySelector('.quantity').addEventListener('input', function() {
                    updateTotal(newRow);
                });
                newRow.querySelector('.remove-row').addEventListener('click', function() {
                    if (document.querySelectorAll('.material-row').length > 1) {
                        newRow.remove();
                        updateTotalQuantity();
                    }
                });
                document.querySelector('#materialTable tbody').appendChild(newRow);
            });

            // Initial total quantity calculation
            updateTotalQuantity();
        });
    </script>
@endsection
