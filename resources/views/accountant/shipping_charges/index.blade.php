@extends('accountant.layout.base')
@section('title', $title)
@section('taxes-discounts-dropdown','active')
@section('taxes-discounts-dropdown-show','show')
@section('shipping-charges-page','active')
@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
               <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createShippingChargeModal">Create Shipping Charge</button>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-card">
                                <table id="DataTables_Table_0" class="table nowrap dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Country</th>
                                        <th>Shipping Name</th>
                                        <th>Percentage</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="shipping-charge-table-body">
                                    @foreach ($shippingCharges as $shippingCharge)
                                        <tr id="shipping-charge-{{ $shippingCharge->id }}">
                                            <td>{{ $shippingCharge->country->name }}</td>
                                            <td>{{ $shippingCharge->name }}</td>
                                            <td>{{ $shippingCharge->percentage }}%</td>
                                            <td>{{ $shippingCharge->created_at->format('d M Y ') }}</td>
                                            <td>{{ $shippingCharge->user->first_name}} {{ $shippingCharge->user->last_name }}</td>
                                            <td>
                                                <span class="badge  p-2 {{ $shippingCharge->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                    {{ $shippingCharge->status ? 'Active' : 'Disabled' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-soft-primary btn-sm" onclick="editShippingCharge({{ $shippingCharge->id }})">
                                                    <i class="las la-pen fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $shippingCharge->id }}, {{ $shippingCharge->status ? 0 : 1 }})">
                                                    <i class="las la-sync fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-danger btn-sm" onclick="deleteShippingCharge({{ $shippingCharge->id }})">
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

    <!-- Create Shipping Charge Modal -->
    <div class="modal fade" id="createShippingChargeModal" tabindex="-1" role="dialog" aria-labelledby="createShippingChargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="create-shipping-charge-form" method="post" class="needs-validation was-validated">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createShippingChargeModalLabel">Create Shipping Charge</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create-country_id">Country</label>
                            <select class="form-control" id="create-country_id" name="country_id" required>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="create-name">Name</label>
                            <input type="text" class="form-control" id="create-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="create-percentage">Percentage</label>
                            <input type="number" class="form-control" id="create-percentage" name="percentage" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Shipping Charge</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Shipping Charge Modal -->
    <div class="modal fade" id="editShippingChargeModal" tabindex="-1" role="dialog" aria-labelledby="editShippingChargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="edit-shipping-charge-form" class="needs-validation was-validated">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editShippingChargeModalLabel">Edit Shipping Charge</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-shipping-charge_id" name="shipping_charge_id">
                        <div class="form-group">
                            <label for="edit-country_id">Country</label>
                            <select class="form-control" id="edit-country_id" name="country_id" required>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-name">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-percentage">Percentage</label>
                            <input type="number" class="form-control" id="edit-percentage" name="percentage" step="0.01" required>
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
        $(document).ready(function () {
            // Handle form submission for creating shipping charge
            $('#create-shipping-charge-form').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: "{{ route('accountant.shipping-charges.store') }}",
                    type: 'POST',
                    data: form.serialize(),
                    success: function (response) {
                        $('#shipping-charge-table-body').append(response);
                        $('#createShippingChargeModal').modal('hide');
                        form.trigger('reset');
                        Swal.fire({
                            icon: 'success',
                            text: 'Shipping charge has been created successfully!',
                        });
                    },
                    error: function (xhr) {
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

            // Handle form submission for editing shipping charge
            $('#edit-shipping-charge-form').on('submit', function (e) {
                e.preventDefault();
                let form = $(this);
                let id = $('#edit-shipping-charge_id').val();
                $.ajax({
                    url: "{{ url('accountant/shipping-charges') }}/" + id,
                    type: 'PUT',
                    data: form.serialize(),
                    success: function (response) {
                        $('#shipping-charge-' + id).replaceWith(response);
                        $('#editShippingChargeModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            text: 'Shipping charge has been updated successfully!',
                        });
                    },
                    error: function (xhr) {
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

            // Handle showing edit modal with existing data
            window.editShippingCharge = function (id) {
                $.ajax({
                    url: "{{ url('accountant/shipping-charges') }}/" + id + "/edit",
                    type: 'GET',
                    success: function (response) {
                        let data = response;
                        $('#edit-shipping-charge_id').val(data.id);
                        $('#edit-country_id').val(data.country_id);
                        $('#edit-name').val(data.name);
                        $('#edit-percentage').val(data.percentage);
                        $('#editShippingChargeModal').modal('show');
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Failed to load shipping charge details.',
                        });
                    }
                });
            };

            // Handle deletion of shipping charge
            window.deleteShippingCharge = function (id) {
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
                            url: "{{ url('accountant/shipping-charges') }}/" + id,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function () {
                                $('#shipping-charge-' + id).remove();
                                Swal.fire(
                                    'Deleted!',
                                    'Shipping charge has been deleted.',
                                    'success'
                                );
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    text: 'Something went wrong. Please try again.',
                                });
                            }
                        });
                    }
                });
            };
        });


        function changeStatus(id, status) {
            $.ajax({
                url: '/accountant/shipping-charges/' + id + '/status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    $('#shipping-charge-'+id).replaceWith(response);
                    Swal.fire({
                        icon: 'success',
                        text: 'Shipping Charges status has been updated successfully!',
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
