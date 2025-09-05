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
                        <p style="font-family: Rubik; font-size: 38px; font-weight: 500; color: #000;">Add Supplier</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="supplierForm" method="POST" action="{{ route('admin.supplier.store') }}">
                                    @csrf
                                    <div class="row">
                                        <!-- Purchase Date -->
                                        <div class="col-md-6 mb-3">
                                            <label for="purchase_date" class="form-label">Purchase Date</label>
                                            <input type="date" name="purchase_date" id="purchase_date"
                                                class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                                            @error('purchase_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <!-- Bill No -->
                                        <div class="col-md-6 mb-3">
                                            <label for="bill_no" class="form-label">Bill No</label>
                                            <input type="text" name="bill_no" id="bill_no" class="form-control"
                                                value="{{ old('bill_no') }}" required>
                                            @error('bill_no')
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

                                        <!-- Supplier Address -->
                                        <div class="col-md-6 mb-3">
                                            <label for="supplier_address" class="form-label">Supplier Address</label>
                                            <input type="text" name="supplier_address" id="supplier_address"
                                                class="form-control" value="{{ old('supplier_address') }}">
                                            @error('supplier_address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-4">
                                        <table class="table" id="materialTable">
                                            <thead>
                                                <tr>
                                                    <th>Material</th>
                                                    <th>Current Stock</th>
                                                    <th>Unit Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total Cost</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="material-row">
                                                    <td>
                                                        <select name="material_id[]" class="form-control material-select"
                                                            required>
                                                            <option value="" disabled selected>Select Material
                                                            </option>
                                                            @foreach ($materials as $material)
                                                                <option value="{{ $material->id }}">{{ $material->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control current-stock" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="unit_price[]"
                                                            class="form-control unit-price" step="0.01" min="0"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="quantity[]"
                                                            class="form-control quantity" step="0.01" min="0"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="total_cost[]"
                                                            class="form-control total-cost" readonly>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remove-row"><i
                                                                class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="sub_amount" class="form-label">Sub Amount</label>
                                            <input type="number" id="sub_amount" class="form-control" readonly>
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

        document.addEventListener('DOMContentLoaded', function() {
            function updateCurrentStock(select) {
                const selectedId = select.value;
                const row = select.closest('.material-row');
                const currentStockInput = row.querySelector('.current-stock');
                const material = materials.find(m => m.id == selectedId);
                currentStockInput.value = material ? material.current_stock : 0;
            }

            function updateTotal(row) {
                const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                const totalCostInput = row.querySelector('.total-cost');
                totalCostInput.value = (unitPrice * quantity).toFixed(2);
                updateSubAmount();
            }

            function updateSubAmount() {
                let subAmount = 0;
                document.querySelectorAll('.total-cost').forEach(input => {
                    subAmount += parseFloat(input.value) || 0;
                });
                document.getElementById('sub_amount').value = subAmount.toFixed(2);
            }

            // Event listeners for existing row
            const firstRow = document.querySelector('.material-row');
            firstRow.querySelector('.material-select').addEventListener('change', function() {
                updateCurrentStock(this);
            });
            firstRow.querySelector('.unit-price').addEventListener('input', function() {
                updateTotal(firstRow);
            });
            firstRow.querySelector('.quantity').addEventListener('input', function() {
                updateTotal(firstRow);
            });

            // Add row
            document.getElementById('add-row').addEventListener('click', function() {
                const newRow = firstRow.cloneNode(true);
                newRow.querySelectorAll('input, select').forEach(input => {
                    input.value = '';
                });
                newRow.querySelector('.material-select').selectedIndex = 0;
                newRow.querySelector('.material-select').addEventListener('change', function() {
                    updateCurrentStock(this);
                });
                newRow.querySelector('.unit-price').addEventListener('input', function() {
                    updateTotal(newRow);
                });
                newRow.querySelector('.quantity').addEventListener('input', function() {
                    updateTotal(newRow);
                });
                newRow.querySelector('.remove-row').addEventListener('click', function() {
                    if (document.querySelectorAll('.material-row').length > 1) {
                        newRow.remove();
                        updateSubAmount();
                    }
                });
                document.querySelector('#materialTable tbody').appendChild(newRow);
            });

            // Remove row for first row
            firstRow.querySelector('.remove-row').addEventListener('click', function() {
                if (document.querySelectorAll('.material-row').length > 1) {
                    firstRow.remove();
                    updateSubAmount();
                }
            });
        });
    </script>
@endsection
