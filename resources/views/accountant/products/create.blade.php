@extends('accountant.layout.base')
@section('title', $title)
@section('products-dropdown','active')
@section('products-dropdown-show','show')
@section('product-create-page','active')
@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
               <h4 class="ml-3"><b>{{ $title }}</b></h4>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-2">
                                <form method="POST" action="{{ route('accountant.products.store') }}" autocomplete="off" class="needs-validation was-validated" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="product_name">Product Name<span class="text-danger">*</span></label>
                                                <input id="product_name" name="product_name" maxlength="40" max="40" placeholder="Enter Product Name" type="text" class="form-control" value="{{ old('product_name') }}" required="">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="available_stock">Stock<span class="text-danger">*</span></label>
                                                <input type="number" id="available_stock" name="available_stock" placeholder="Enter Stock" class="form-control" value="{{ old('available_stock') }}" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Product Brand<span class="text-danger">*</span></label>
                                                <select class="form-select" name="brand" id="brand" required="">
                                                    <option value="" selected="">Select</option>
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->id }}" {{ old('brand') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Product Category<span class="text-danger">*</span></label>
                                                <select class="form-select" name="category" id="category" required="">
                                                    <option value="" selected="">Select</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="price">Product Price<span class="text-danger">*</span></label>
                                                <input type="number" id="price" name="price" placeholder="Enter Price" class="form-control" value="{{ old('price') }}" required="">

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="productImage">Product Thumbnail Image<span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" id="productImage" name="product_image" placeholder="Select Product Image" required="">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="productdesc">Product Description<span class="text-danger">*</span></label>
                                        <textarea class="form-control" max="150" maxlength="150" id="productdesc" name="product_description" placeholder="Enter Description" rows="4" required="">{{ old('product_description') }}</textarea>
                                    </div>

                                    <div class="hstack gap-2 mt-4">
                                        <button type="submit" class="btn btn-primary float-end" id="addProduct">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
    <script>
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                var submitButton = form.querySelector('button[type="submit"]');
                var originalText = submitButton.innerText; // Store the original text
                var $button = $(submitButton);
                $($button).html(`
                    <span class="text-light">processing...</span>
                    <span class="text-end text-light spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
                );
                submitButton.disabled = true;
                setTimeout(function() {
                    form.submit();
                }, 1000);
                setTimeout(function() {
                    $($button).html(originalText);
                    submitButton.disabled = false;
                }, 3000);
            });
        });
    </script>

@stop
