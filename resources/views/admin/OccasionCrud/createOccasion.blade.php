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
                <a href="{{ route('occasion') }}" class="" style="color:transparent;">
                    <img src="{{ asset('images/left-arrow.png') }}" style="width:40px;" alt="">
                </a> Occasions List
            </h3>

        </div>
        <div class="card">
            <div class="card-body">
                {{-- <h4 class="card-title">Basic form elements</h4>
                <p class="card-description"> Basic form elements </p> --}}
                <form class="forms-sample" action="{{ route('occasion.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- <div class=" "> --}}

                        <div class="form-group col-lg-12">
                            <label for="title">Title</label> <span style="color:red;">*</span>
                            <input type="text" class="form-control" id="title" name="title" placeholder=""
                                required>
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="summernote" rows="4"></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>File upload</label><span style="color:red;">*</span>
                            <input type="file" name="image" class="file-upload-default" required>
                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-gradient-primary py-3"
                                        type="button">Upload</button>
                                </span>
                            </div>
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
