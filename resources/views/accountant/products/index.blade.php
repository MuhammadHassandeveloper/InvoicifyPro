@extends('accountant.layout.base')
@section('title', $title)
@section('products-dropdown','active')
@section('products-dropdown-show','show')
@section('product-list-page','active')
@section('product-all-list-page','active')
@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
               <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <a href="{{ route('accountant.products.create') }}" class="btn btn-primary" >Create Product</a>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="fs-22 fw-semibold">{{ $outOfStockCount }}</h4>
                            <p class="text-uppercase fw-medium">Out of Stock</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="fs-22 fw-semibold">{{ $lowStockCount }}</h4>
                            <p class="text-uppercase fw-medium">Low Stock</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="fs-22 fw-semibold">{{ $activeCount }}</h4>
                            <p class="text-uppercase fw-medium">Active Products</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="fs-22 fw-semibold">{{ $disabledCount }}</h4>
                            <p class="text-uppercase fw-medium">Disabled Products</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom mb-2 nav-success mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @yield('product-all-list-page')" href="{{ url('/accountant/products') }}" role="tab" aria-selected="true">
                                        All
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link @yield('active-product-list-page')" href="{{ url('/accountant/products/active') }}" role="tab" aria-selected="false">
                                        active
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('disabled-product-list-page')" href="{{ url('/accountant/products/disabled') }}" role="tab" aria-selected="false">
                                        Disabled
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link @yield('low-stock-product-list-page')" href="{{ url('/accountant/products/low-stock') }}" role="tab" aria-selected="false">
                                        Low  Stock
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link @yield('out-of-stock-product-list-page')" href="{{ url('/accountant/products/out-of-stock') }}" role="tab" aria-selected="false">
                                        Out of Stock
                                    </a>
                                </li>

                            </ul>

                            <div class="table-card mt-2 mt-2">
                                <table id="DataTables_Table_0" class="table table-sm dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Created At</th>
                                        <th>Stock</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="product-table-body">
                                    @foreach ($products as $product)
                                        <tr id="product-{{ $product->id }}">
                                            <td>
                                                <img src="{{ asset($product->image) }}" alt="" class="avatar-xs rounded-circle me-2">
                                                <a href="{{ route('accountant.products.edit',$product->id) }}" class="text-body align-middle fw-medium">{{ $product->name }}</a>
                                            </td>
                                            <td>{{ $product->brand->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->created_at->format('d M Y ') }}</td>
                                            <td>
                                                {{ $product->available_stock }}
                                                <i style="cursor: pointer;" class="las la-pen text-primary fs-18 align-middle" data-bs-toggle="modal" data-bs-target=".addStockModal{{ $product->id }}"></i>
                                            </td>
                                            <td>{{ $product->user->first_name}} {{ $product->user->last_name }}</td>

                                            <td>
                                                <span class="badge  p-2 {{ $product->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                    {{ $product->status ? 'Active' : 'Disabled' }}
                                                </span>
                                            </td>
                                            <td>

                                                <button class="btn btn-soft-info btn-sm" onclick="viewProduct({{ $product->id }})">
                                                    <i class="las la-eye fs-17 align-middle"></i>
                                                </button>

                                                <a href="{{ route('accountant.products.edit',$product->id) }}" class="btn btn-soft-primary btn-sm">
                                                    <i class="las la-pen fs-17 align-middle"></i>
                                                </a>

                                                <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $product->id }})">
                                                    <i class="las la-sync fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-danger btn-sm" onclick="deleteProduct({{ $product->id }})">
                                                    <i class="las la-trash fs-17 align-middle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-4 font-weight-bold">Product Name:</div>
                        <div class="col-8" id="productName"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-weight-bold">Brand:</div>
                        <div class="col-8" id="productBrand"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-weight-bold">Category:</div>
                        <div class="col-8" id="productCategory"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-weight-bold">Price:</div>
                        <div class="col-8" id="productPrice"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-weight-bold">Description:</div>
                        <div class="col-8" id="productDescription"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-weight-bold">Stock:</div>
                        <div class="col-8" id="productStock"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4 font-weight-bold">Status:</div>
                        <div class="col-8" id="productStatus"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



{{--    update stock modal--}}
    @foreach ($products as $product)
        <div class="modal fade addStockModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content border-0">
                <div class="modal-header p-4 pb-0">
                    <h5 class="modal-title" id="createMemberLabel">Edit Stock</h5>
                    <button type="button" class="btn-close" id="createMemberBtn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="post" action="{{ route('accountant.products.updateStock') }}" autocomplete="off" id="brandform" class="needs-validation" enctype="multipart/form-data" novalidate="">
                        @csrf
                        @method('post')
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-2 mt-2">
                                    <label for="brandName" class="form-label">Stock<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="available_stock" name="available_stock" value="{{ $product->available_stock }}" placeholder="Enter Stock" required="">
                                </div>
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="addNewBrand">Add</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>
    @endforeach


@endsection

@section('script')
    <script>
        function deleteProduct(productId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/accountant/products/" + productId,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#product-' + productId).remove();
                            Swal.fire({
                                icon: 'success',
                                text: 'Product has been deleted successfully!',
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    });
                }
            });
        }

        function changeStatus(productId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/accountant/products/status/" + productId,
                        type: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                text: 'Product status has been updated successfully!',
                            });
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    });
                }
            });
        }


        function viewProduct(productId) {
            $.ajax({
                url: "/accountant/products/show/" + productId,
                type: 'GET',
                success: function(response) {
                    $('#productName').text(response.name);
                    $('#productBrand').text(response.brand.name);
                    $('#productCategory').text(response.category.name);
                    $('#productPrice').text(response.price);
                    $('#productDescription').text(response.description);
                    $('#productStock').text(response.available_stock);
                    $('#productStatus').text(response.status ? 'Active' : 'Disabled');
                    $('#productModal').modal('show');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        text: 'Something went wrong. Please try again.',
                    });
                }
            });
        }

    </script>
@endsection
