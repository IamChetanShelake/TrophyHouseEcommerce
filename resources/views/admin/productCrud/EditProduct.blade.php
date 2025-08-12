@extends('admin.layouts.masterlayout')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <a href="{{ route('products') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a> Edit Product
            </h3>

        </div>
        <div class="card">
            <div class="card-body">

                <form class="forms-sample" action="{{ route('product.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group">
                                <label for="title">Title</label><span style="color:red;">*</span>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $product->title }}" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label><span style="color:red;">*</span>
                                <textarea class="form-control" name="description" id="summernote" rows="4" required>{!! $product->description !!}</textarea>
                            </div>


                        </div>
                        <hr>



                        <div class="variant-wrapper">
                            @foreach ($product->variants as $index => $variant)
                                <div class="variant-row d-flex gap-2 mb-2 align-items-center">
                                    <label for="variants[{{ $index }}][size]">Size (inch):</label>
                                    <input type="text" name="variants[{{ $index }}][size]" class="form-control"
                                        min="0" step="0.01" placeholder="Size (inch)" value="{{ $variant->size }}"
                                        required>

                                    <label for="variants[{{ $index }}][price]">Price(₹):</label>
                                    <input type="number" name="variants[{{ $index }}][price]"
                                        class="form-control price-input" placeholder="Price" value="{{ $variant->price }}"
                                        step="0.01" required>

                                    <label for="variants[{{ $index }}][discount_percentage]">Discount(%):</label>
                                    <input type="number" name="variants[{{ $index }}][discount_percentage]"
                                        class="form-control discount-input" placeholder="Discount %"
                                        value="{{ $variant->discount_percentage }}" step="0.01" min="0"
                                        max="100">

                                    <label for="variants[{{ $index }}][discounted_price]">Discounted
                                        Price(₹):</label>
                                    <input type="number" name="variants[{{ $index }}][discounted_price]"
                                        class="form-control discounted-price" placeholder="Discounted Price"
                                        value="{{ $variant->discounted_price }}" readonly>

                                    <input type="hidden" name="variants[{{ $index }}][id]"
                                        value="{{ $variant->id }}">


                                    @if ($loop->first)
                                        <button type="button" class="btn btn-success add-variant">+</button>
                                    @else
                                        <button type="button" class="btn btn-danger remove-variant">−</button>
                                    @endif
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
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="subcategory_id">Subcategory</label><span style="color:red;">*</span>
                            <select name="subcategory_id" id="subcategory_id" class="form-control">
                                <option value="">-- Select Subcategory --</option>
                                @foreach ($subcategories as $subcat)
                                    <option value="{{ $subcat->id }}"
                                        {{ $product->sub_category_id == $subcat->id ? 'selected' : '' }}>
                                        {{ $subcat->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="rating">Rating (1-5)</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="0"
                                max="5" step="0.01" placeholder="" value="{{ $product->rating }}">
                        </div>


                        <div class="form-group col-lg-6 col-sm-12">
                            <h6> Mark as :-</h6>

                            <div class="d-flex">


                                <div class="col-3">
                                    <div class="d-flex align-items-center gap-2">

                                        <label for="top_picks" style="margin-bottom:0px;">Top Pick ?</label>
                                        <input type="checkbox" name="is_top_pick" id="top_picks" style="zoom: 2;"
                                            {{ $product->is_top_pick ? 'checked' : '' }}>
                                    </div>
                                </div>


                                <div class="col-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <label for="top_picks" style="margin-bottom:0px;">Best Seller ?</label>
                                        <input type="checkbox" name="is_best_seller" id="" style="zoom: 2;"
                                            {{ $product->is_best_seller ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <label for="top_picks" style="margin-bottom:0px;">New Arrival
                                            ?</label>
                                        <input type="checkbox" name="is_new_arrival" id="" style="zoom: 2;"
                                            {{ $product->is_new_arrival ? 'checked' : '' }}>
                                    </div>
                                </div>

                            </div>

                        </div>


                        <div class="form-group">
                            @if ($product->image)
                                <div>
                                    <img src="{{ asset('product_images/' . $product->image) }}" alt="Product Image"
                                        width="70px;">
                                </div>
                            @else
                                <p>No Image Uploaded</p>
                            @endif


                            <label>File upload</label><span style="color:red;">*</span>
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
                                    <img src="{{ asset('product_images/' . $image->image) }}"
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


                        <div class="form-group col-4">
                            <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                        </div>
                        {{-- <button class="btn btn-light">Cancel</button> --}}
                </form>
            </div>
        </div>

    </div>
    <a href="{{ route('products') }}" class="btn btn-dark">Back</a>

    </div>
    <form id="deleteImageForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <script>
        function submitDeleteForm(imageId) {
            if (confirm("Are you sure you want to delete this image?")) {
                const form = document.getElementById('deleteImageForm');
                form.action = "{{ url('/product/image') }}/" + imageId;
                form.submit();
            }
        }
    </script>
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

    <script>
        let index = {{ $product->variants->count() }};

        // Event delegation for adding/removing variants
        document.querySelector('.variant-wrapper').addEventListener('click', function(e) {
            if (e.target.classList.contains('add-variant')) {
                const firstRow = document.querySelector('.variant-row');
                const newRow = firstRow.cloneNode(true);

                // Reset input values
                newRow.querySelectorAll('input').forEach(input => {
                    input.value = '';
                    const name = input.getAttribute('name');
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                });

                // Replace button
                newRow.querySelector('.add-variant').outerHTML = `
                <button type="button" class="btn btn-danger remove-variant">−</button>
            `;

                document.querySelector('.variant-wrapper').appendChild(newRow);
                index++;
            }

            if (e.target.classList.contains('remove-variant')) {
                e.target.closest('.variant-row').remove();
            }
        });

        // Calculate discounted price automatically
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('price-input') || e.target.classList.contains('discount-input')) {
                const row = e.target.closest('.variant-row');
                const price = parseFloat(row.querySelector('.price-input')?.value || 0);
                const discount = parseFloat(row.querySelector('.discount-input')?.value || 0);
                const discountedPrice = row.querySelector('.discounted-price');

                if (!isNaN(price) && !isNaN(discount)) {
                    const newPrice = price - (price * discount / 100);
                    discountedPrice.value = newPrice.toFixed(2);
                } else {
                    discountedPrice.value = '';
                }
            }
        });
    </script>

    <script>
        document.querySelector('.color-wrapper').addEventListener('click', function(e) {
            // ADD COLOR
            if (e.target.classList.contains('add-color')) {
                const firstRow = document.querySelector('.color-row');
                const newRow = firstRow.cloneNode(true);

                // Reset input
                const input = newRow.querySelector('input');
                input.value = '';

                // Replace + button with −
                const buttonCol = newRow.querySelector('.col-1');
                buttonCol.innerHTML = `<button type="button" class="btn btn-danger remove-color">−</button>`;

                document.querySelector('.color-wrapper').appendChild(newRow);
            }

            // REMOVE COLOR
            if (e.target.classList.contains('remove-color')) {
                e.target.closest('.color-row').remove();
            }
        });
    </script>


@endsection
