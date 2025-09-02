@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h3 class="page-title">
                <a href="{{ route('products') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a>Add Product
            </h3>
            {{-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Forms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form elements</li>
                    </ol>
                </nav> --}}
        </div>
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title">Basic form elements</h4>
                <p class="card-description"> Basic form elements </p> --}}
                <form class="forms-sample" action="{{ route('product.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- <div class=" "> --}}

                        <div class="form-group col-lg-12">
                            <label for="title">Title</label> <span style="color:red;">*</span>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ old('title') }}" placeholder="" required>
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="description">Description</label><span style="color:red;">*</span>
                            <textarea class="form-control" name="description" id="summernote" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>


                        <div class="variant-wrapper">

                            <div class="variant-row row gx-2 mb-2 align-items-center">
                                <div class="col-2">
                                    <input type="number" name="variants[0][size]" class="form-control" min="0"
                                        step="0.01" placeholder="Size (inch)" value="{{ old('variants.0.size') }}"
                                        required>
                                </div>
                                <div class="col-2">
                                    <input type="number" name="variants[0][price]" class="form-control price"
                                        min="0" step="0.01" placeholder="Price"
                                        value="{{ old('variants.0.price') }}" required>
                                </div>
                                <div class="col-2">
                                    <input type="number" name="variants[0][discount_percentage]"
                                        class="form-control discount" min="0" max="100" step="0.01"
                                        placeholder="Discount %" value="{{ old('variants.0.discount_percentage') }}">
                                </div>
                                <div class="col-2">
                                    <input type="number" name="variants[0][discounted_price]"
                                        class="form-control discounted_price" placeholder="Final Price"
                                        value="{{ old('variants.0.discounted_price') }}" readonly>
                                </div>
                                <div class="col-2">
                                    <input type="number" name="variants[0][quantity]" class="form-control" min="0"
                                        step="1" placeholder="Quantity" value="{{ old('variants.0.quantity') }}"
                                        required>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-success add-variant">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="color-wrapper">
                            @php $colors = old('colors',['']); @endphp
                            <div class="color-row row gx-2 mb-2 align-items-center">
                                <div class="col-10">
                                    <input type="text" name="colors[]" class="form-control color" placeholder="color">
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-success add-color">+</button>
                                </div>
                            </div>
                        </div>


                        <div class="form-group col-lg-6 col-sm-12">
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
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="subcategory_id">Subcategory</label><span style="color:red;">*</span>
                            <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                <option value="">-- Select Subcategory --</option>
                            </select>
                            @error('subcategory_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="rating">Rating (1-5)</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="0"
                                max="5" step="0.01" placeholder="" value="{{ old('rating') }}" required>
                            @error('rating')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-12">
                            <div class="form-group col-lg-6 col-sm-12">
                                <div class="d-flex gap-2">

                                    <div class="col-lg-3 col-sm-2">
                                        <div class="d-flex align-items-center gap-2">

                                            <label for="top_picks" style="margin-bottom:0px;">Top Pick ?</label>
                                            <input type="checkbox" name="is_top_pick" id="top_picks" style="zoom: 2;"
                                                {{ old('is_top_pick') }} ? 'checked' : ''>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-sm-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <label for="top_picks" style="margin-bottom:0px;">Best Seller ?</label>
                                            <input type="checkbox" name="is_best_seller" id=""
                                                {{ old('is_best_seller') }} ? 'checked' : '' style="zoom: 2;">
                                        </div>
                                    </div>




                                    <div class="col-lg-3 col-sm-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <label for="top_picks" style="margin-bottom:0px;">New Arrival ?</label>
                                            <input type="checkbox" name="is_new_arrival" id=""
                                                {{ old('is_new_arrival') }} ? 'checked' : '' style="zoom: 2;">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">

                            <label>File upload</label><span style="color:red;">*</span>
                            <input type="file" name="image" class="file-upload-default" accept="image/*">

                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-gradient-primary py-3"
                                        type="button">Upload</button>
                                </span>
                            </div>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">

                            <label>Upload multiple</label>
                            <input type="file" name="images[]" class="file-upload-default" multiple
                                accept="images/*">
                            @error('images')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Upload
                                        multiple</button>
                                </span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="cdr_file">Upload CDR File</label>
                            <input type="file" name="cdr_file" accept=".cdr" class="form-control">


                            @error('cdr_file')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-4">


                            <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                            {{-- <button class="btn btn-light">Cancel</button> --}}
                        </div>
                </form>

            </div>
        </div>
    </div>
    </div>

    <!-- content-wrapper ends -->
    <script src="../../assets/vendors/select2/select2.min.js"></script>
    <script src="../../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>




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


    {{-- aadd remove and calculate  --}}
    <script>
        let index = 1;

        // Live discounted price calculation for a row
        function calculateDiscountedPrice(row) {
            const priceInput = row.querySelector('.price');
            const discountInput = row.querySelector('.discount');
            const discountedInput = row.querySelector('.discounted_price');

            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            const discounted = price - (price * discount / 100);
            discountedInput.value = discounted.toFixed(2);
        }

        // Attach calculation events to a row
        function attachEvents(row) {
            row.querySelector('.price').addEventListener('input', () => calculateDiscountedPrice(row));
            row.querySelector('.discount').addEventListener('input', () => calculateDiscountedPrice(row));
        }

        // Clone + Remove functionality
        document.querySelector('.variant-wrapper').addEventListener('click', function(e) {
            // ADD VARIANT
            if (e.target.classList.contains('add-variant')) {
                const firstRow = document.querySelector('.variant-row');
                const newRow = firstRow.cloneNode(true);

                newRow.querySelectorAll('input').forEach(input => {
                    input.value = '';
                    const name = input.getAttribute('name');
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                });

                // Replace the add button with remove button
                const buttonCol = newRow.querySelector('.col-2:last-child');
                buttonCol.innerHTML = `<button type="button" class="btn btn-danger remove-variant">−</button>`;

                document.querySelector('.variant-wrapper').appendChild(newRow);
                attachEvents(newRow);
                index++;
            }

            // REMOVE VARIANT
            if (e.target.classList.contains('remove-variant')) {
                e.target.closest('.variant-row').remove();
            }
        });

        // Attach to first row
        document.querySelectorAll('.variant-row').forEach(row => {
            attachEvents(row);
        });
    </script>
    <script>
        let colorIndex = 1;

        // Clone + Remove functionality for COLORS
        document.querySelector('.color-wrapper').addEventListener('click', function(e) {
            // ADD COLOR
            if (e.target.classList.contains('add-color')) {
                const firstRow = document.querySelector('.color-row');
                const newRow = firstRow.cloneNode(true);

                // Clear input and set unique name
                const input = newRow.querySelector('input');
                input.value = '';
                input.setAttribute('name', `colors[]`);

                // Replace + button with − button
                const buttonCol = newRow.querySelector('.col-2:last-child');
                buttonCol.innerHTML = `<button type="button" class="btn btn-danger remove-color">−</button>`;

                document.querySelector('.color-wrapper').appendChild(newRow);
                colorIndex++;
            }

            // REMOVE COLOR
            if (e.target.classList.contains('remove-color')) {
                e.target.closest('.color-row').remove();
            }
        });
    </script>




@endsection
