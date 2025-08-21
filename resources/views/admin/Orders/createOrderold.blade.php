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
                    <style>
                        /* Rate, Disc.Rate, Total inputs clearly दिसण्यासाठी */
                        #products_table input[readonly] {
                            background-color: #f8f9fa !important;
                            /* हलकं ग्रे background */
                            color: #000 !important;
                            /* काळा text */
                            opacity: 1 !important;
                            /* faint दिसू नये म्हणून */
                            padding: 4px 6px;
                            /* थोडी padding */
                            text-align: right;
                            /* नंबर उजवीकडे align */
                        }
                    </style>

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
                                <th>Disc.Rate</th>
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
                                <td>
                                    <!-- 🔹 size_dropdown class fix -->
                                    <select name="size[]" class="form-control size_dropdown">
                                        <option value="">Select</option>
                                    </select>
                                </td>
                                <td><input type="number" name="qty[]" class="form-control qty"></td>
                                <td><input type="number" name="rate[]" class="form-control rate" readonly></td>
                                <td><input type="number" name="disc_rate[]" class="form-control disc-rate" readonly></td>
                                <td><input type="number" name="total[]" class="form-control total" readonly></td>
                                <td><button type="button" class="btn btn-danger remove_row">X</button></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-primary" id="add_row">+ Add Product</button>
                    </div>

                    <hr>
                    <div class="form-group">
                        <label for="address">Total Amount</label>
                        <input type="text" class="form-control" id="totalamount" name="totalamount" value=""
                            required>
                    </div>

                    <div class="form-group">
                        <label for="payment_mode">Payment Mode</label>
                        <select class="form-control" id="payment_mode" name="payment_mode" required>
                            <option value="">-- Select Payment Mode --</option>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="upi">UPI</option>
                            <option value="netbanking">Net Banking</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="address">Payment Amount</label>
                        <input type="text" class="form-control" id="paidamount" name="paidamount" value=""
                            required>
                    </div>
                    <button type="submit" class="btn btn-success">Save Order</button>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {

                            // Add row
                            document.getElementById("add_row").addEventListener("click", function() {
                                let table = document.querySelector("#products_table tbody");
                                let newRow = table.rows[0].cloneNode(true);
                                newRow.querySelectorAll("input, select").forEach(el => el.value = "");
                                table.appendChild(newRow);
                                updateGrandTotal();
                            });

                            // Remove row
                            document.addEventListener("click", function(e) {
                                if (e.target.classList.contains("remove_row")) {
                                    if (document.querySelectorAll("#products_table tbody tr").length > 1) {
                                        e.target.closest("tr").remove();
                                        updateGrandTotal();
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

                            // Product → Sizes
                            document.addEventListener("change", function(e) {
                                if (e.target.classList.contains("product")) {
                                    let productId = e.target.value;
                                    let sizeDropdown = e.target.closest("tr").querySelector(".size_dropdown");

                                    fetch(`/get-sizes/${productId}`)
                                        .then(response => response.json())
                                        .then(variants => {
                                            sizeDropdown.innerHTML = '<option value="">Select</option>';
                                            variants.forEach(variant => {
                                                let option = document.createElement('option');
                                                option.value = variant.id;
                                                option.textContent = variant.size; // 🔹 only size in dropdown
                                                option.setAttribute('data-price', variant.price);
                                                option.setAttribute('data-discount', variant.discounted_price ??
                                                    variant.price);
                                                sizeDropdown.appendChild(option);
                                            });
                                        });
                                }
                            });

                            // Size → Auto-fill Rate & Disc.Rate
                            document.addEventListener("change", function(e) {
                                if (e.target.classList.contains("size_dropdown")) { // 🔹 fixed class name
                                    let row = e.target.closest("tr");
                                    let selectedOption = e.target.options[e.target.selectedIndex];

                                    let rate = selectedOption.getAttribute("data-price");
                                    let discRate = selectedOption.getAttribute("data-discount");

                                    row.querySelector(".rate").value = rate || 0;
                                    row.querySelector(".disc-rate").value = discRate || 0;

                                    let qty = row.querySelector(".qty").value || 0;
                                    row.querySelector(".total").value = qty * (discRate || rate);

                                    updateGrandTotal();
                                }
                            });

                            // Qty change → Recalculate row total & grand total
                            document.addEventListener("input", function(e) {
                                if (e.target.classList.contains("qty")) {
                                    let row = e.target.closest("tr");
                                    let qty = parseFloat(row.querySelector(".qty").value) || 0;
                                    let discRate = parseFloat(row.querySelector(".disc-rate").value) || 0;
                                    row.querySelector(".total").value = qty * discRate;
                                    updateGrandTotal();
                                }
                            });

                            // Grand total calculation
                            function updateGrandTotal() {
                                let grandTotal = 0;
                                document.querySelectorAll("#products_table tbody tr").forEach(row => {
                                    let rowTotal = parseFloat(row.querySelector(".total").value) || 0;
                                    grandTotal += rowTotal;
                                });
                                document.getElementById("totalamount").value = grandTotal;
                            }

                        });
                    </script>
                @endsection
