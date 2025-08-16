{{--  @extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">

            <h3 class="page-title">
                <a href="{{ route('orders') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a>Create Order
            </h3>
         
        </div>
        <div class="card">
            <div class="card-body">
              
                <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <!-- Name -->
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="name">Name</label> <span style="color:red;">*</span>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Mobile -->
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="mobile">Mobile</label> <span style="color:red;">*</span>
                            <input type="tel" class="form-control" id="mobile" name="mobile"
                                value="{{ old('mobile') }}" pattern="[0-9]{10}" placeholder="10 digit number" required>
                            @error('mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="email">Email</label> <span style="color:red;">*</span>
                            <input type="email" class="form-control" id="email" name="email" value=""
                                autocomplete="off" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password with show/hide -->
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="password">Password</label> <span style="color:red;">*</span>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" value=""
                                    autocomplete="new-password" required>
                                <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                    👁
                                </span>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <script>
                            function togglePassword() {
                                const passField = document.getElementById('password');
                                passField.type = passField.type === 'password' ? 'text' : 'password';
                            }
                        </script>


<hr>

                    </div>
            </div>
        </div>
    </div>

    <!-- content-wrapper ends -->
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
@endsection  --}}



@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <a href="{{ route('orders') }}">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a> Create Order
            </h3>
        </div>

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="" method="POST">
                    @csrf

                    <!-- Customer Info -->
                    <div class="row">
                        <!-- Name -->
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="name">Name</label> <span style="color:red;">*</span>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Mobile -->
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="mobile">Mobile</label> <span style="color:red;">*</span>
                            <input type="tel" class="form-control" id="mobile" name="mobile"
                                value="{{ old('mobile') }}" pattern="[0-9]{10}" placeholder="10 digit number" required>
                            @error('mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="email">Email</label> <span style="color:red;">*</span>
                            <input type="email" class="form-control" id="email" name="email" value=""
                                autocomplete="off" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Password with show/hide -->
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="password">Password</label> <span style="color:red;">*</span>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" value=""
                                    autocomplete="new-password" required>
                                <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                    👁
                                </span>
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <script>
                            function togglePassword() {
                                const passField = document.getElementById('password');
                                passField.type = passField.type === 'password' ? 'text' : 'password';
                            }
                        </script>
                    </div>

                    <hr>

                    <!-- Products Table -->
                    <table class="table table-bordered" id="products_table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="category[]" class="form-control category">
                                        <option value="">Select</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="subcategory[]" class="form-control subcategory">
                                        <option value="">Select</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="product[]" class="form-control product">
                                        <option value="">Select</option>
                                    </select>
                                </td>
                                <td><input type="text" name="size[]" class="form-control"></td>
                                <td><input type="number" name="qty[]" class="form-control qty"></td>
                                <td><input type="number" name="rate[]" class="form-control rate"></td>
                                <td><input type="number" name="total[]" class="form-control total" readonly></td>
                                <td><button type="button" class="btn btn-danger remove_row">X</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-primary" id="add_row">+ Add Product</button>

                    </div>

                    <hr>

                    <button type="submit" class="btn btn-success">Save Order</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Add row
            document.getElementById("add_row").addEventListener("click", function() {
                let table = document.querySelector("#products_table tbody");
                let newRow = table.rows[0].cloneNode(true);
                newRow.querySelectorAll("input, select").forEach(el => el.value = "");
                table.appendChild(newRow);
            });

            // Remove row
            document.addEventListener("click", function(e) {
                if (e.target.classList.contains("remove_row")) {
                    if (document.querySelectorAll("#products_table tbody tr").length > 1) {
                        e.target.closest("tr").remove();
                    }
                }
            });
            // Category → Subcategory
            document.addEventListener("change", function(e) {
                if (e.target.classList.contains("category")) {
                    let categoryId = e.target.value;
                    let subcatDropdown = e.target.closest("tr").querySelector(".subcategory");

                    fetch(`/get-subcategories/${categoryId}`)
                        .then(res => res.json())
                        .then(data => {
                            subcatDropdown.innerHTML = '<option value="">Select</option>';
                            data.forEach(sub => {
                                subcatDropdown.innerHTML +=
                                    `<option value="${sub.id}">${sub.title}</option>`;
                            });
                        });
                }
            });

            // Subcategory → Product
            document.addEventListener("change", function(e) {
                if (e.target.classList.contains("subcategory")) {
                    let subcatId = e.target.value;
                    console.log(subcatId);
                    let productDropdown = e.target.closest("tr").querySelector(".product");

                    fetch(`/get-products_list/${subcatId}`)
                        .then(res => res.json())
                        .then(data => {
                            productDropdown.innerHTML = '<option value="">Select</option>';
                            data.forEach(prod => {

                                productDropdown.innerHTML +=
                                    `<option value="${prod.id}">${prod.title}</option>`;
                            });
                        });
                }
            });


            // Auto calculate total
            document.addEventListener("input", function(e) {
                if (e.target.classList.contains("qty") || e.target.classList.contains("rate")) {
                    let row = e.target.closest("tr");
                    let qty = row.querySelector(".qty").value || 0;
                    let rate = row.querySelector(".rate").value || 0;
                    row.querySelector(".total").value = qty * rate;
                }
            });
        });
    </script>
@endsection
