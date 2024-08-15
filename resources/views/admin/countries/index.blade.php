@extends('admin.layout.base')
@section('title', $title)
@section('countries-page','active')
@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
               <h4 class="ml-3"><b>Manage Client Countries</b></h4>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createCountryModal">Create Country</button>
            </div>


            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3 p-2">
                                <h5 class="fw-bold">Overview of Available Countries for Client Assignments</h5>
                                You can use this section to view and manage the different countries associated with your clients. Ensure that each client is assigned to the correct country for accurate invoicing and operations.
                            </div>

                            <div class="table-card">
                                <table id="DataTables_Table_0" class="table nowrap dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Country Name</th>
                                        <th>ISO Code</th>
                                        <th>Currency Sign</th>
                                        <th>Currency Code</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="country-table-body">
                                    @foreach ($countries as $index => $country)
                                        <tr id="country-{{ $country->id }}">
                                            <td>{{ $country->name }}</td>
                                            <td>{{ $country->iso_code }}</td>
                                            <td>{{ $country->currency_sign }}</td>
                                            <td>{{ $country->currency_code }}</td>
                                            <td>{{ $country->created_at->format('d M Y ') }}</td>
                                            <td>
                                                <span class="badge  p-2 {{ $country->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                    {{ $country->status ? 'Active' : 'Disabled' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-soft-primary btn-sm" onclick="editCountry({{ $country->id }})">
                                                    <i class="las la-pen fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $country->id }}, {{ $country->status ? 0 : 1 }})">
                                                    <i class="las la-sync fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-danger btn-sm" onclick="deleteCountry({{ $country->id }})">
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

    <!-- Create Country Modal -->
    <div class="modal fade" id="createCountryModal" tabindex="-1" role="dialog" aria-labelledby="createCountryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="create-country-form" method="post" class="needs-validation was-validated">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCountryModalLabel">Create Country</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="create-name">Name</label>
                            <input type="text" class="form-control" id="create-name" name="name" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="create-iso_code">ISO Code</label>
                            <input type="text" class="form-control" id="create-iso_code" name="iso_code" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="create-currency_sign">Currency Sign</label>
                            <input type="text" class="form-control" id="create-currency_sign" name="currency_sign" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="create-currency_code">Currency Code</label>
                            <input type="text" class="form-control" id="create-currency_code" name="currency_code" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Country</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Country Modal -->
    <div class="modal fade" id="editCountryModal" tabindex="-1" role="dialog" aria-labelledby="editCountryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="edit-country-form" class="needs-validation was-validated">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCountryModalLabel">Edit Country</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-country_id" name="country_id">
                        <div class="form-group mb-2">
                            <label for="edit-name">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="edit-iso_code">ISO Code</label>
                            <input type="text" class="form-control" id="edit-iso_code" name="iso_code" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="edit-currency_sign">Currency Sign</label>
                            <input type="text" class="form-control" id="edit-currency_sign" name="currency_sign" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="edit-currency_code">Currency Code</label>
                            <input type="text" class="form-control" id="edit-currency_code" name="currency_code" required>
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
    @section('script')
        <script>
            $(document).ready(function() {
                // Handle form submission for create country
                $('#create-country-form').on('submit', function(e) {
                    e.preventDefault();
                    let formData = $(this).serialize();
                    $.ajax({
                        url: "{{ route('admin.countries.store') }}",
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $('#createCountryModal').modal('hide');
                            $('#country-table-body').append(response);
                            $('#create-country-form')[0].reset();
                            Swal.fire({
                                icon: 'success',
                                text: 'Country has been created successfully!',
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
                                    title: 'Error',
                                    text: 'Something went wrong. Please try again.',
                                });
                            }
                        }
                    });
                });

                $('#edit-country-form').on('submit', function(e) {
                    e.preventDefault();
                    let formData = $(this).serialize();
                    let countryId = $('#edit-country_id').val();

                    $.ajax({
                        url: "{{ route('admin.countries.update', '') }}/" + countryId,
                        type: 'POST',
                        data: formData,
                        headers: {
                            'X-HTTP-Method-Override': 'PUT'
                        },
                        success: function(response) {
                            $('#country-' + countryId).replaceWith(response);
                            $('#editCountryModal').modal('hide');
                            $('#edit-country-form')[0].reset();
                            Swal.fire({
                                icon: 'success',
                                text: 'Country has been updated successfully!',
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

            function editCountry(id) {
                $.ajax({
                    url: "{{ route('admin.countries.show', '') }}/" + id,
                    type: 'GET',
                    success: function(response) {
                        $('#editCountryModalLabel').text('Edit Country');
                        $('#edit-country_id').val(response.id);
                        $('#edit-name').val(response.name);
                        $('#edit-iso_code').val(response.iso_code);
                        $('#edit-currency_sign').val(response.currency_sign);
                        $('#edit-currency_code').val(response.currency_code);
                        $('#editCountryModal').modal('show');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                });
            }

            function deleteCountry(id) {
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
                            url: "{{ route('admin.countries.destroy', '') }}/" + id,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('#country-' + id).remove();
                                Swal.fire(
                                    'Deleted!',
                                    'Country has been deleted.',
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
                    url: '/admin/countries/' + id + '/status',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        $('#country-'+id).replaceWith(response);
                        Swal.fire({
                            icon: 'success',
                            text: 'country status has been updated successfully!',
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

@stop
