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
                <form class="forms-sample" action="{{ route('offlineorder.store') }}" method="POST">
                    @csrf

                    <!-- Customer Info -->
                    <div class="row">

                        <div class="form-group text-end" style="margin-bottom: -5px;">
                            <input type="hidden" name="status" value="0"> <!-- off value -->
                            <label class="switch">
                                <input type="checkbox" name="status" value="1" id="status_toggle" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <style>
                            .switch {
                                position: relative;
                                display: inline-block;
                                width: 60px;
                                height: 34px;
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
                                transition: .4s;
                                border-radius: 34px;
                            }

                            .slider:before {
                                position: absolute;
                                content: "Off";
                                height: 26px;
                                width: 26px;
                                left: 4px;
                                bottom: 4px;
                                background-color: white;
                                transition: .4s;
                                border-radius: 50%;
                                text-align: center;
                                line-height: 26px;
                                font-size: 12px;
                                font-weight: bold;
                                color: #ff9800;
                            }

                            input:checked+.slider {
                                background-color: #ff9800;
                            }

                            input:checked+.slider:before {
                                transform: translateX(26px);
                                content: "On";
                            }
                        </style>




                        <!-- Name -->
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="name">Name</label> <span style="color:red;">*</span>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" required>
                        </div>

                        <!-- Mobile -->
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="mobile">Mobile</label> <span style="color:red;">*</span>
                            <input type="tel" class="form-control" id="mobile" name="mobile" value=""
                                pattern="[0-9]{10}" placeholder="10 digit number" required>
                            {{--  <small id="mobile_error" class="text-danger d-none">This mobile already exists.</small>  --}}
                        </div>

                        <!-- Email -->
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" autocomplete="off">
                        </div>

                        <!-- GSTIN Field (shown when toggle is ON) -->
                        <div class="form-group col-lg-12 col-sm-12 gst-fields" id="gstin_group" style="display: none;">
                            <label for="gstin">GSTIN</label>
                            <input type="text" class="form-control" id="gstin" name="gstin"
                                value="{{ old('gstin') }}"
                                pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$"
                                placeholder="22AAAAA0000A1Z5" maxlength="15">
                            <small class="text-muted">Enter 15-digit GSTIN number</small>
                        </div>

                        <!-- HSN Code Field (shown when toggle is ON) -->
                        <div class="form-group col-lg-12 col-sm-12 gst-fields" id="hsn_group" style="display: none;">
                            <label for="hsn_code">HSN Code</label>
                            <input type="text" class="form-control" id="hsn_code" name="hsn_code"
                                value="{{ old('hsn_code') }}" pattern="^[0-9]{4,8}$" placeholder="1234" maxlength="8">
                            <small class="text-muted">Enter 4-8 digit HSN Code</small>
                        </div>

                        <!-- Password group (hide/show) -->
                        <div class="form-group col-lg-12 col-sm-12" id="password_group">
                            <label for="password">Password</label> <span style="color:red;">*</span>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    autocomplete="new-password">
                                <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">👁</span>
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
                            .table td {
                                vertical-align: middle;
                                font-size: 0.875rem;
                                line-height: 1;
                                white-space: wrap;
                                padding: 0.2rem !important;
                            }

                            .form-control,
                            .typeahead,
                            .tt-query,
                            .tt-hint,
                            .select2-container--default .select2-selection--single .select2-search__field,
                            .select2-container--default .select2-selection--single {
                                display: block;
                                width: 100%;
                                padding: 0.94rem 0.5rem !important;
                                font-size: 0.8125rem;
                                font-weight: 400;
                                line-height: 1;
                                color: var(--bs-body-color);
                                appearance: none;
                                background-color: #ffffff;
                                background-clip: padding-box;
                                border: var(--bs-border-width) solid var(--bs-border-color);
                                border-radius: 2px;
                                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                            }

                            select.form-control,
                            select.typeahead,
                            select.tt-query,
                            select.tt-hint,
                            .select2-container--default .select2-selection--single select.select2-search__field,
                            .select2-container--default select.select2-selection--single {
                                padding: 0.4375rem 0.75rem;
                                border: 0;
                                outline: 1px solid #ebedf2;
                                color: #242020 !important;
                            }
                        </style>

                        <!-- Products Table -->
                        <table class="table table-bordered" id="products_table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>Av.Qty</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    <th>Disc.Rate</th>
                                    <th>Total</th>
                                    <th>Customization</th>
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
                                        <img src="" alt="" class="product-image"
                                            style="width:50px;height:80px;border-radius:0px; display:none;">
                                    </td>
                                    <td>
                                        <select name="size[]" class="form-control size_dropdown">
                                            <option value="">Select</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="color[]" class="form-control color_dropdown">
                                            <option value="">Select</option>
                                        </select>
                                    </td>
                                    <td><input type="number" name="avqty[]" class="form-control avqty"></td>
                                    <td><input type="number" name="qty[]" class="form-control qty"></td>
                                    <td><input type="number" name="rate[]" class="form-control rate" readonly></td>
                                    <td><input type="number" name="disc_rate[]" class="form-control disc-rate" readonly>
                                    </td>
                                    <td><input type="number" name="total[]" class="form-control total" readonly></td>
                                    {{--  <td>
                                        <input type="checkbox" name="customization[]" value="1" class="form-check-input">
                                        <input type="hidden" name="customization[]" value="0">
                                    </td>  --}}
                                    <td>
                                        <input type="checkbox" name="customization[0]" value="1"
                                            class="form-check-input">
                                    </td>
                                    <td><button type="button" class="btn btn-danger remove_row"
                                            style="padding:4px 8px;">
                                            <i class="fa fa-trash"></i></button>
                                    </td>

                                </tr>
                            </tbody>
                        </table>

                        <div class="text-end mt-2">
                            <button type="button" class="btn btn-primary" id="add_row">+ Add Product</button>
                        </div>

                        <hr>
                        <div class="form-group">
                            <label for="address">Total Amount</label>
                            <input type="text" class="form-control" id="totalamount" name="totalamount"
                                value="" required>
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
                            <label for="address">Paid Amount</label>
                            <input type="text" class="form-control" id="paidamount" name="paidamount" value=""
                                required>
                        </div>
                        <button type="submit" class="btn btn-warning">Save Order</button>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {



                document.getElementById("add_row").addEventListener("click", function() {
                    let table = document.querySelector("#products_table tbody");
                    let newRow = table.rows[0].cloneNode(true);
                    let rowCount = table.rows.length; // Get the current number of rows for the new index

                    // Reset input & select values
                    newRow.querySelectorAll("input, select").forEach(el => {
                        if (el.name.startsWith("customization[")) {
                            el.name = `customization[${rowCount}]`; // Set new index for customization
                        } else {
                            el.value = ""; // Reset other inputs
                        }
                    });

                    // Reset image properly
                    let img = newRow.querySelector(".product-image");
                    if (img) {
                        img.src = "";
                        img.style.display = "none";
                    }

                    table.appendChild(newRow);
                    updateGrandTotal();
                });

                // Remove row
                document.addEventListener("click", function(e) {
                    let removeBtn = e.target.closest(".remove_row"); // check button or its child
                    if (removeBtn) {
                        if (document.querySelectorAll("#products_table tbody tr").length > 1) {
                            removeBtn.closest("tr").remove();
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
                        let row = e.target.closest("tr");
                        let productDropdown = row.querySelector(".product");

                        fetch(`/get-products_list/${subcatId}`)
                            .then(res => res.json())
                            .then(data => {
                                productDropdown.innerHTML = '<option value="">Select</option>';
                                data.forEach(prod => {
                                    productDropdown.innerHTML +=
                                        `<option value="${prod.id}" data-image="${prod.image}">${prod.title}</option>`;
                                });
                            });
                    }
                });

                // Product → Image + Sizes
                document.addEventListener("change", function(e) {
                    if (e.target.classList.contains("product")) {
                        let row = e.target.closest("tr");
                        let productId = e.target.value;
                        let sizeDropdown = row.querySelector(".size_dropdown");
                        let productImage = row.querySelector(".product-image");

                        // get selected option
                        let selectedOption = e.target.options[e.target.selectedIndex];
                        let imageName = selectedOption.getAttribute("data-image");

                        if (imageName) {
                            productImage.src = `/product_images/${imageName}`;
                            productImage.style.display = "block";
                        } else {
                            productImage.style.display = "none";
                        }

                        fetch(`/get-sizes/${productId}`)
                            .then(response => response.json())
                            .then(variants => {
                                sizeDropdown.innerHTML = '<option value="">Select Size</option>';
                                let colorDropdown = row.querySelector(".color_dropdown");
                                colorDropdown.innerHTML = '<option value="">Select Color</option>';
                                variants.forEach(variant => {
                                    let option = document.createElement('option');
                                    option.value = variant.id;
                                    option.textContent = variant.size;

                                    // इथे attributes नीट बसवलेत
                                    option.setAttribute('data-price', variant.price);
                                    option.setAttribute('data-discount', variant.discounted_price ??
                                        variant.price);
                                    option.setAttribute('data-avqty', variant.quantity);
                                    option.setAttribute('data-colors', JSON.stringify(variant
                                        .color || []));

                                    sizeDropdown.appendChild(option);
                                });
                            });

                    }
                });



                // Size → Auto-fill Rate, Disc.Rate & Av.Qty + Colors
                document.addEventListener("change", function(event) {
                    if (event.target.classList.contains("size_dropdown")) {
                        let row = event.target.closest("tr");
                        let selectedOption = event.target.options[event.target.selectedIndex];

                        if (!selectedOption) return;

                        // attributes वाचून values घे
                        let rate = parseFloat(selectedOption.getAttribute("data-price")) || 0;
                        let discRate = parseFloat(selectedOption.getAttribute("data-discount")) || 0;
                        let avQty = parseFloat(selectedOption.getAttribute("data-avqty")) || 0;
                        let colors = JSON.parse(selectedOption.getAttribute("data-colors")) || [];

                        // set values in row inputs
                        row.querySelector(".rate").value = rate;
                        row.querySelector(".disc-rate").value = discRate;
                        row.querySelector(".avqty").value = avQty;

                        // populate color dropdown
                        let colorDropdown = row.querySelector(".color_dropdown");
                        colorDropdown.innerHTML = '<option value="">Select Color</option>';
                        colors.forEach(color => {
                            let option = document.createElement('option');
                            option.value = color;
                            option.textContent = color;
                            colorDropdown.appendChild(option);
                        });

                        // जर qty आधी टाकलं असेल तर total पण calculate कर
                        let qty = parseFloat(row.querySelector(".qty").value) || 0;
                        row.querySelector(".total").value = qty * (discRate > 0 ? discRate : rate);

                        // update grand total
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

            function checkUserExists() {
                let mobile = document.getElementById("mobile").value;

                if (mobile && mobile.length === 10) {
                    fetch("{{ route('checkUser') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                mobile: mobile
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.exists) {
                                // Old user - hide password field
                                document.getElementById("password_group").style.display = "none";
                            } else {
                                // New user - show password field
                                document.getElementById("password_group").style.display = "block";
                            }
                        });
                }
            }

            // Mobile blur event
            document.getElementById("mobile").addEventListener("blur", checkUserExists);

            // Toggle GST fields based on status switch
            const statusToggle = document.getElementById('status_toggle');
            const gstFields = document.querySelectorAll('.gst-fields');

            function toggleGstFields() {
                const isChecked = statusToggle.checked;
                console.log('Toggle status:', isChecked); // Debug log
                gstFields.forEach(field => {
                    field.style.display = isChecked ? 'block' : 'none';
                    console.log('Field display:', field.id, isChecked ? 'block' : 'none'); // Debug log
                });

                // Clear GST fields when toggle is off
                if (!isChecked) {
                    document.getElementById('gstin').value = '';
                    document.getElementById('hsn_code').value = '';
                }
            }

            // Initial check on page load
            if (statusToggle) {
                toggleGstFields();

                // Add event listener for toggle changes
                statusToggle.addEventListener('change', toggleGstFields);

                // Also add click event to the label for better UX
                const toggleLabel = statusToggle.closest('.switch');
                if (toggleLabel) {
                    toggleLabel.addEventListener('click', function() {
                        // Small delay to let the checkbox state update
                        setTimeout(toggleGstFields, 10);
                    });
                }
            } else {
                console.log('Status toggle not found'); // Debug log
            }
        </script>
        {{--  <script>

              // Add row
                document.getElementById("add_row").addEventListener("click", function() {
                    let table = document.querySelector("#products_table tbody");
                    let newRow = table.rows[0].cloneNode(true);
                    newRow.querySelectorAll("input, select").forEach(el => el.value = "");
                    table.appendChild(newRow);
                    updateGrandTotal();
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
                                sizeDropdown.innerHTML = '<option value="">Select Size</option>';
                                variants.forEach(variant => {
                                    let option = document.createElement('option');
                                    option.value = variant.id;
                                    option.textContent = variant.size;
                                    option.setAttribute('data-price', variant.price);
                                    option.setAttribute('data-discount', variant.discounted_price ??
                                        variant.price);
                                    option.setAttribute('data-avqty', variant
                                        .quantity);
                                    console.log('hello');
                                    sizeDropdown.appendChild(option);
                                });
                            });
                    }
                });


                // Size → Auto-fill Rate, Disc.Rate & Av.Qty
                document.addEventListener("change", function(event) {
                    if (event.target.classList.contains("size_dropdown")) {
                        let row = event.target.closest("tr");
                        let selectedOption = event.target.options[event.target.selectedIndex];

                        // convert to numbers
                        let rate = parseFloat(selectedOption.getAttribute("data-price")) || 0;
                        let discRate = parseFloat(selectedOption.getAttribute("data-discount")) || 0;
                        let avQty = parseFloat(selectedOption.getAttribute("data-avqty")) || 0;

                        console.log("Rate:", rate, "Disc Rate:", discRate, "Av Qty:", avQty);
                        // set values in row
                        row.querySelector(".rate").value = rate;
                        row.querySelector(".disc-rate").value = discRate;
                        row.querySelector(".avqty").value = avQty;

                        // calculate total if qty already entered
                        let qty = parseFloat(row.querySelector(".qty").value) || 0;
                        row.querySelector(".total").value = qty * (discRate > 0 ? discRate : rate);

                        // update grand total
                        updateGrandTotal();
                    }
                });


        </script>  --}}
    @endsection
