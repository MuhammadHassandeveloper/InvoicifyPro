@extends('admin.layout.base')
@section('title', $title)
@section('taxes-discounts-dropdown','active')
@section('taxes-discounts-dropdown-show','show')
@section('discounts-page','active')
@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
               <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDiscountModal">Create Discount</button>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-card">
                                <table id="DataTables_Table_0" class="table nowrap dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Discount Name</th>
                                        <th>Percentage</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="discount-table-body">
                                    @foreach ($discounts as $discount)
                                        <tr id="discount-{{ $discount->id }}">
                                            <td>{{ $discount->name }}</td>
                                            <td>{{ $discount->percentage }}%</td>
                                            <td>{{ $discount->created_at->format('d M Y ') }}</td>
                                            <td>{{ $discount->user->first_name}} {{ $discount->user->last_name }}</td>
                                            <td>
                                                <span class="badge  p-2 {{ $discount->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                    {{ $discount->status ? 'Active' : 'Disabled' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-soft-primary btn-sm" onclick="editDiscount({{ $discount->id }})">
                                                    <i class="las la-pen fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $discount->id }}, {{ $discount->status ? 0 : 1 }})">
                                                    <i class="las la-sync fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-danger btn-sm" onclick="deleteDiscount({{ $discount->id }})">
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

    <!-- Create Discount Modal -->
    <div class="modal fade" id="createDiscountModal" tabindex="-1" role="dialog" aria-labelledby="createDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="create-discount-form" method="post" class="needs-validation was-validated">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createDiscountModalLabel">Create Discount</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-name">Name</label>
                            <input type="text" class="form-control" id="create-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="create-percentage">Percentage</label>
                            <input type="number" class="form-control" id="create-percentage" name="percentage" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Discount</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Discount Modal -->
    <div class="modal fade" id="editDiscountModal" tabindex="-1" role="dialog" aria-labelledby="editDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="edit-discount-form" class="needs-validation was-validated">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDiscountModalLabel">Edit Discount</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-discount_id" name="discount_id">
                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-percentage">Percentage</label>
                            <input type="number" class="form-control" id="edit-percentage" name="percentage" required>
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
                    url: "{{ route('admin.discounts.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#discount-table-body').append(response);
                        $('#createDiscountModal').modal('hide');
                        $('#create-discount-form')[0].reset();
                        Swal.fire({
                            icon: 'success',
                            text: 'Discount has been created successfully!',
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
                    url: "{{ route('admin.discounts.update', '') }}/" + discountId,
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
                            text: 'Discount has been updated successfully!',
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

        function editDiscount(id) {
            $.ajax({
                url: "{{ route('admin.discounts.show', '') }}/" + id,
                type: 'GET',
                success: function(response) {
                    $('#edit-name').val(response.name);
                    $('#edit-percentage').val(response.percentage);
                    $('#edit-discount_id').val(response.id);
                    $('#editDiscountModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Discount not found.',
                    });
                }
            });
        }

        function deleteDiscount(id) {
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
                        url: "{{ route('admin.discounts.destroy', '') }}/" + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#discount-' + id).remove();
                            Swal.fire(
                                'Deleted!',
                                'Discount has been deleted.',
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
                url: '/admin/discounts/' + id + '/status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    $('#discount-'+id).replaceWith(response);
                    Swal.fire({
                        icon: 'success',
                        text: 'discount status has been updated successfully!',
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
@endsection
