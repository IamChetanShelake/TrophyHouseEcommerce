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
                <a href="{{ route('occproducts') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a>Edit Occasional Product
            </h3>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('occproduct.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="product_cat">Occasion</label>
                            <select class="form-select" id="occasion_id" name="occasion_id">
                                <option value="">-- Select Occasion --</option>
                                @foreach ($occasion as $occ)
                                    <option value="{{ $occ->id }}"
                                        {{ $occ->id == $product->occasion_id ? 'selected' : '' }}>{{ $occ->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="title">Title</label> <span style="color:red;">*</span>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $product->title }}" required>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="description">Description</label><span style="color:red;">*</span>
                            <textarea class="form-control" name="description" id="summernote" rows="4">{{ $product->description }}</textarea>
                        </div>
                        <hr>

                        <div class="variant-wrapper">
                            @foreach ($product->variants as $index => $variant)
                                <div class="variant-row row gx-2 mb-2 align-items-center">
                                    <div class="col-3">
                                        <label for="variants[{{ $index }}][size]">Size (inch):</label>
                                        <input type="text" name="variants[{{ $index }}][size]"
                                            class="form-control" placeholder="Size" value="{{ $variant->size }}" required>
                                    </div>
                                    <div class="col-3">
                                        <label for="variants[{{ $index }}][price]">Price(₹):</label>
                                        <input type="number" name="variants[{{ $index }}][price]"
                                            class="form-control price" min="0" step="0.01" placeholder="Price"
                                            value="{{ $variant->price }}" required>
                                    </div>
                                    <div class="col-3">
                                        <label
                                            for="variants[{{ $index }}][discount_percentage]">Discount(%):</label>
                                        <input type="number" name="variants[{{ $index }}][discount_percentage]"
                                            class="form-control discount" min="0" max="100" step="0.01"
                                            placeholder="Discount %" value="{{ $variant->discount_percentage }}">
                                    </div>
                                    <div class="col-2">
                                        <label for="variants[{{ $index }}][discounted_price]">Discounted
                                            Price(₹):</label>
                                        <input type="number" name="variants[{{ $index }}][discounted_price]"
                                            class="form-control discounted_price" placeholder="Final Price"
                                            value="{{ $variant->discounted_price }}" readonly>
                                    </div>
                                    <div class="col-1">
                                        @if ($loop->first)
                                            <button type="button" class="btn btn-success add-variant">+</button>
                                        @else
                                            <button type="button" class="btn btn-danger remove-variant">−</button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <hr>

                        <div class="color-wrapper">
                            @php
                                $colors = json_decode($variant->color ?? '[]', true);
                            @endphp

                            @if (!empty($colors))
                                @foreach ($colors as $index => $color)
                                    <div class="color-row row gx-2 mb-2 align-items-center">
                                        <div class="col-11">
                                            <label for="colors[]">color:</label>
                                            <input type="text" name="colors[]" value="{{ $color }}"
                                                class="form-control color" placeholder="color">
                                        </div>
                                        <div class="col-1">
                                            @if ($loop->first)
                                                <button type="button" class="btn btn-success add-color">+</button>
                                            @else
                                                <button type="button" class="btn btn-danger remove-color">−</button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{-- Default one input if no color found --}}
                                <div class="color-row row gx-2 mb-2 align-items-center">
                                    <div class="col-11">
                                        <input type="text" name="colors[]" class="form-control color"
                                            placeholder="color">
                                    </div>
                                    <div class="col-1">
                                        <button type="button" class="btn btn-success add-color">+</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <hr>


                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="product_cat">Category</label><span style="color:red;">*</span>
                            <select class="form-select" id="product_cat_id" name="product_cat_id" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $cat->id == $product->category_id ? 'selected' : '' }}>{{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="subcategory_id">Subcategory</label><span style="color:red;">*</span>
                            <select name="subcategory_id" id="subcategory_id" class="form-control">
                                <option value=""> -- Select Subcategory -- </option>
                                @foreach ($subcategories as $subcat)
                                    <option value="{{ $subcat->id }}"
                                        {{ $subcat->id == $product->sub_category_id ? 'selected' : '' }}>
                                        {{ $subcat->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label for="rating">Rating (1-5)</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="0"
                                max="5" step="0.01" value="{{ $product->rating }}">
                        </div>

                        <div class="form-group">
                            @if ($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset('OccasionalProduct_images/' . $product->image) }}"
                                        alt="Current Image" style="max-height: 100px;">
                                </div>
                            @endif
                            <label>File upload</label>
                            <input type="file" name="image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-gradient-primary py-3"
                                        type="button">Upload</button>
                                </span>
                            </div>

                        </div>

                        <h5>Existing Images</h5>
                        <div class="row">
                            @foreach ($product->images as $image)
                                <div class="col-md-3 mb-3" id="image-box-{{ $image->id }}">
                                    <img src="{{ asset('OccasionalProduct_images/' . $image->image) }}"
                                        class="img-fluid rounded mb-2" style="height: 120px; object-fit: cover;">

                                    <button type="button" class="btn btn-sm btn-danger w-100"
                                        onclick="submitDeleteForm({{ $image->id }})">
                                        Delete
                                    </button>

                                    {{-- <form action="{{ route('deleteOccProductImage', $image->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure to delete this image?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger w-100">Delete</button>
                                    </form> --}}
                                </div>
                            @endforeach
                        </div>

                        <h5>Add More Images</h5>
                        <div class="form-group">
                            <input type="file" name="images[]" multiple class="form-control" accept="image/*">
                        </div>

                        <div class="col-4">
                            <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form id="deleteImageForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <script>
        function submitDeleteForm(imageId) {
            if (confirm("Are you sure you want to delete this image?")) {
                const form = document.getElementById('deleteImageForm');
                form.action = "{{ url('/occasional-product/image') }}/" + imageId;;
                form.submit();
            }
        }
    </script>


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
                const buttonCol = newRow.querySelector('.col-1');
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
                const buttonCol = newRow.querySelector('.col-1');
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
