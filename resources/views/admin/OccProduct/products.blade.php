@extends('admin.layouts.masterlayout')

@section('content')
    <style>
        table thead,
        table tbody td {
            text-align: center;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .3s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }
    </style>

    <!-- Modal -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="excelImportForm" action="{{ route('OccProducts.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importExcelModalLabel">Import Product Excel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="occasion_id">Occasion</label><span style="color:red;">*</span>
                                <select class="form-select" id="occasion_id" name="occasion_id" required>
                                    <option value="">-- Select Occasion --</option>
                                    @foreach ($occasion as $occ)
                                        <option value="{{ $occ->id }}">{{ $occ->title }}</option>
                                    @endforeach
                                </select>
                                @error('occasion_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="product_cat">Category</label><span style="color:red;">*</span>
                                <select class="form-select" id="product_cat_id" name="product_cat_id" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_cat_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Subcategory Dropdown -->
                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="subcategory_id">Subcategory</label><span style="color:red;">*</span>
                                <select name="subcategory_id" id="subcategory_id" class="form-control">
                                    <option value="">-- Select Subcategory --</option>
                                </select>
                                @error('subcategory_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <label for="excel_file">Choose Excel File (.xlsx or .xls)</label>
                            <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Upload</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Occasional Products Tables </h3>
            <nav aria-label="breadcrumb">
                <a href="{{ route('occProduct.add') }}" class="btn btn-gradient-primary me-2">Add Product</a>
                <!-- Trigger Button -->
                <button type="button" class="btn bg-success mt-2" data-bs-toggle="modal"
                    data-bs-target="#importExcelModal">
                    Import Excel
                </button>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <table class="table">
                            @if (session('error'))
                                <div id="failMessage" class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div id="successMessage" class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    setTimeout(function() {
                                        $("#successMessage, #failMessage").fadeOut('slow');
                                    }, 3000); // 3 seconds
                                });
                            </script>
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($allproducts as $prod)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $prod->title }}</td>
                                        <td>{{ $prod->category->name ?? null }}</td>
                                        <td>{{ $prod->subcategory->title ?? null }}</td>

                                        <td>
                                            <div class="d-flex gap-1" style="justify-content: center;">
                                                <a href="{{ route('occproduct.show', $prod->id) }}" class="btn btn-info"
                                                    style="padding:6px 10px;">View</a>
                                                <a href="{{ route('occproduct.edit', $prod->id) }}" class="btn btn-success"
                                                    style="padding:6px 10px;">update</a>
                                                <form action="{{ route('occproduct.destroy', $prod->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="submit" onclick="return confirm('sure delete ?')"
                                                        value="Delete" class="btn btn-dark" style="padding:6px 10px;">
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- JS for Dependent Dropdown -->
    <script>
        document.getElementById('product_cat_id').addEventListener('change', function() {
            const categoryId = this.value;
            const subcatSelect = document.getElementById('subcategory_id');

            // Reset subcategory options
            subcatSelect.innerHTML = '<option value="">-- Select Subcategory --</option>';

            if (categoryId) {
                fetch(`/get-subcategories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subcat => {
                            const option = document.createElement('option');
                            option.value = subcat.id;
                            option.text = subcat.title;
                            subcatSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching subcategories:', error);
                    });
            }
        });
    </script>
@endsection
