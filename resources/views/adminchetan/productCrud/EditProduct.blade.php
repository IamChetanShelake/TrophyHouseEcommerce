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
                                <textarea class="form-control" name="description" id="description" rows="4" required>{{ $product->description }}</textarea>
                            </div>

                        </div>



                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="price">Old price</label><span style="color:red;">*</span>
                            <input type="number" class="form-control" min="0" step="0.01" id="price"
                                name="price" placeholder="" value="{{ $product->price }}" required>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="discount_percentage">Discount (%) <small>(optional)</small></label>
                            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage"
                                min="0" max="100" step="0.01" value="{{ $product->discount_percentage }}">
                        </div>

                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="new_price">New Price (Auto-calculated)</label>
                            <input type="number" class="form-control" id="new_price" name="new_price"
                                value="{{ $product->new_price }}" readonly>
                        </div>



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
                                <label for="rating">Rating (1-5)</label><span style="color:red;">*</span>
                                <input type="number" class="form-control" id="rating" name="rating" min="0"
                                    max="5" step="0.01" placeholder="" value="{{ $product->rating }}" required>
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
                            <input type="file" name="image" class="file-upload-default" >
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-gradient-primary py-3"
                                        type="button">Upload</button>
                                </span>
                            </div>
                        </div>


                        <div class="form-group col-4">
                            <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        </div>
                        {{-- <button class="btn btn-light">Cancel</button> --}}
                </form>
            </div>
        </div>
        
    </div>
    <a href="{{ route('products') }}" class="btn btn-dark">Back</a>
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

    <script>
        function calculateNewPrice() {
            const price = parseFloat(document.getElementById('price').value);
            const discountInput = document.getElementById('discount_percentage');
            const discount = parseFloat(discountInput.value);
            const newPriceInput = document.getElementById('new_price');

            if (!isNaN(price) && !isNaN(discount) && discount > 0) {
                const discountedPrice = price - ((discount / 100) * price);
                newPriceInput.value = discountedPrice.toFixed(2);
            } else if (!isNaN(price)) {
                newPriceInput.value = price.toFixed(2);
            } else {
                newPriceInput.value = '';
            }
        }

        document.getElementById('discount_percentage').addEventListener('input', calculateNewPrice);
        document.getElementById('price').addEventListener('input', calculateNewPrice);

        calculateNewPrice(); // run on load
    </script>
@endsection
