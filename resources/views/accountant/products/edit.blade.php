@extends('accountant.layout.base')
@section('title', $title)
@section('products-dropdown','active')
@section('products-dropdown-show','show')
@section('product-list-page','active')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
               <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <a href="{{ route('accountant.products.index') }}" class="btn btn-secondary">Back to Products</a>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="edit-product-form" class="needs-validation was-validated"
                                  action="{{ route('accountant.products.update', $product->id) }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('POST')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="product_name">Product Name<span class="text-danger">*</span></label>
                                            <input id="product_name" maxlength="40" max="40" name="product_name" placeholder="Enter Product Name" type="text" class="form-control" value="{{ $product->name }}" required="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="available_stock">Stock<span class="text-danger">*</span></label>
                                            <input type="number" id="available_stock" name="available_stock" placeholder="Enter Stock" class="form-control" value="{{ $product->available_stock }}" required="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-brand">Brand</label>
                                            <select class="form-control" id="edit-brand" name="brand" required>
                                                @foreach ($brands as $brand)
                                                    <option
                                                        value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-category">Category</label>
                                            <select class="form-control" id="edit-category" name="category" required>
                                                @foreach ($categories as $category)
                                                    <option
                                                        value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-price">Price</label>
                                            <input type="number" class="form-control" id="edit-price" name="price"
                                                   value="{{ $product->price }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="edit-image">Image</label>
                                            <input type="file" class="form-control" id="edit-image"
                                                   name="product_image">
                                            @if ($product->image)
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-thumbnail mt-2" width="150">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="edit-description">Description</label>
                                    <textarea class="form-control" max="150" maxlength="150" id="edit-description" name="product_description"
                                              required>{{ $product->description }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        var forms = document.querySelectorAll('form');
        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                var submitButton = form.querySelector('button[type="submit"]');
                var originalText = submitButton.innerText; // Store the original text
                var $button = $(submitButton);
                $($button).html(`
                    <span class="text-light">processing...</span>
                    <span class="text-end text-light spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`
                );
                submitButton.disabled = true;
                setTimeout(function () {
                    form.submit();
                }, 1000);
                setTimeout(function () {
                    $($button).html(originalText);
                    submitButton.disabled = false;
                }, 3000);
            });
        });
    </script>
@stop
