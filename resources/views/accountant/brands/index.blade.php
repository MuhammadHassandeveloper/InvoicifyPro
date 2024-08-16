@extends('accountant.layout.base')
@section('title', $title)
@section('products-dropdown','active')
@section('products-dropdown-show','show')
@section('brands-page','active')
@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
               <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBrandModal">Create Brand</button>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-card mt-2 mt-2">
                                <table id="DataTables_Table_0" class="table table-sm dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Brand Name</th>
                                        <th>Created At</th>
                                        <th>created By</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="discount-table-body">
                                    @foreach ($brands as $index => $br)
                                        <tr id="discount-{{ $br->id }}">
                                            <td>{{ $br->name }}</td>
                                            <td>{{ $br->created_at->format('d M Y ') }}</td>
                                            <td>{{ $br->user->first_name}} {{ $br->user->last_name }}</td>
                                            <td>
                                                 <span class="badge  p-2 {{ $br->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                        {{ $br->status ? 'Active' : 'Disabled' }}
                                                 </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-soft-info btn-sm d-inline-block" onclick="editBrand({{ $br->id }})">
                                                    <i class="las la-pen fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $br->id }}, {{ $br->status ? 0 : 1 }})">
                                                    <i class="las la-sync fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-danger btn-sm d-inline-block" onclick="deleteBrand({{ $br->id }})">
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

    <!-- Create Brand Modal -->
    <div class="modal fade" id="createBrandModal" tabindex="-1" role="dialog" aria-labelledby="createDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="create-discount-form" method="post" class="needs-validation was-validated">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createDiscountModalLabel">Create Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-name">Name</label>
                            <input type="text" class="form-control" id="create-name" name="name" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Brand Modal -->
    <div class="modal fade" id="editDiscountModal" tabindex="-1" role="dialog" aria-labelledby="editDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="edit-discount-form" class="needs-validation was-validated">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDiscountModalLabel">Edit Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-discount_id" name="discount_id">
                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Handle form submission for create discount
            $('#create-discount-form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('accountant.brands.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#discount-table-body').append(response);
                        $('#createBrandModal').modal('hide');
                        $('#create-discount-form')[0].reset();
                        Swal.fire({
                            icon: 'success',
                            text: 'Brand has been created successfully!',
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            for (let key in errors) {
                                errorMessage += errors[key][0] + '<br>';
                            }
                            Swal.fire({
                                icon: 'error',
                                html: errorMessage,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    }
                });
            });

            // Handle form submission for edit discount
            $('#edit-discount-form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let discountId = $('#edit-discount_id').val();

                $.ajax({
                    url: "{{ route('accountant.brands.update', '') }}/" + discountId,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function(response) {
                        $('#discount-' + discountId).replaceWith(response);
                        $('#editDiscountModal').modal('hide');
                        $('#edit-discount-form')[0].reset();
                        Swal.fire({
                            icon: 'success',
                            text: 'Brand has been updated successfully!',
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            for (let key in errors) {
                                errorMessage += errors[key][0] + '<br>';
                            }
                            Swal.fire({
                                icon: 'error',
                                html: errorMessage,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    }
                });
            });
        });

        function editBrand(id) {
            $.ajax({
                url: "{{ route('accountant.brands.show', '') }}/" + id,
                type: 'GET',
                success: function(response) {
                    $('#edit-name').val(response.name);
                    $('#edit-discount_id').val(response.id);
                    $('#editDiscountModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Brand not found.',
                    });
                }
            });
        }

        function deleteBrand(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffaa33',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('accountant.brands.destroy', '') }}/" + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#discount-' + id).remove();
                            Swal.fire(
                                'Deleted!',
                                'Brand has been deleted.',
                                'success'
                            );
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    });
                }
            });
        }


        function changeStatus(id, status) {
            $.ajax({
                url: '/accountant/brands/' + id + '/status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    $('#discount-' + id).replaceWith(response);
                    Swal.fire({
                        icon: 'success',
                        text: 'Brand status has been updated successfully!',
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Something went wrong. Please try again.',
                    });
                }
            });
        }
    </script>
    </script>
@endsection
