@extends('accountant.layout.base')
@section('title', $title)
@section('taxes-discounts-dropdown','active')
@section('taxes-discounts-dropdown-show','show')
@section('taxes-page','active')
@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
               <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTaxModal">Create Tax</button>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-card mt-2 mt-2">
                                <table id="DataTables_Table_0" class="table table-sm dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Country</th>
                                        <th>Tax Name</th>
                                        <th>Percentage</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tax-table-body">
                                    @foreach ($taxes as $tax)
                                        <tr id="tax-{{ $tax->id }}">
                                            <td>@isset($tax->country->name) {{ $tax->country->name }} @else N/O @endisset</td>
                                            <td>{{ $tax->name }}</td>
                                            <td>{{ $tax->percentage }}%</td>
                                            <td>{{ $tax->created_at->format('d M Y ') }}</td>
                                            <td>{{ $tax->user->first_name}} {{ $tax->user->last_name }}</td>
                                            <td>
                                                <span class="badge  p-2 {{ $tax->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                    {{ $tax->status ? 'Active' : 'Disabled' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-soft-primary btn-sm" onclick="editTax({{ $tax->id }})">
                                                    <i class="las la-pen fs-17 align-middle"></i>
                                                </button>
                                                <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $tax->id }}, {{ $tax->status ? 0 : 1 }})">
                                                    <i class="las la-sync fs-17 align-middle"></i>
                                                </button>
                                                <button class="btn btn-soft-danger btn-sm" onclick="deleteTax({{ $tax->id }})">
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

    <!-- Create Tax Modal -->
    <div class="modal fade" id="createTaxModal" tabindex="-1" role="dialog" aria-labelledby="createTaxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="create-tax-form" method="post" class="needs-validation was-validated">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTaxModalLabel">Create Tax</h5>
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
                            <input type="text" class="form-control" id="create-percentage" name="percentage" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Tax</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Tax Modal -->
    <div class="modal fade" id="editTaxModal" tabindex="-1" role="dialog" aria-labelledby="editTaxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0">
                <form id="edit-tax-form" class="needs-validation was-validated">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaxModalLabel">Edit Tax</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-tax_id" name="tax_id">
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
                            <input type="text" class="form-control" id="edit-percentage" name="percentage" required>
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
            // Handle form submission for create tax
            $('#create-tax-form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('accountant.taxes.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#tax-table-body').append(response);
                        $('#createTaxModal').modal('hide');
                        $('#create-tax-form')[0].reset();
                        Swal.fire({
                            icon: 'success',
                            text: 'Tax has been created successfully!',
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

            // Handle form submission for edit tax
            $('#edit-tax-form').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let taxId = $('#edit-tax_id').val();

                $.ajax({
                    url: "{{ route('accountant.taxes.update', '') }}/" + taxId,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function(response) {
                        $('#tax-' + taxId).replaceWith(response);
                        $('#editTaxModal').modal('hide');
                        $('#edit-tax-form')[0].reset();
                        Swal.fire({
                            icon: 'success',
                            text: 'Tax has been updated successfully!',
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

        function editTax(id) {
            $.ajax({
                url: "{{ route('accountant.taxes.show', '') }}/" + id,
                type: 'GET',
                success: function(response) {
                    $('#editTaxModalLabel').text('Edit Tax');
                    $('#edit-tax_id').val(response.id);
                    $('#edit-country_id').val(response.country_id);
                    $('#edit-name').val(response.name);
                    $('#edit-percentage').val(response.percentage);
                    $('#editTaxModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        text: 'Something went wrong. Please try again.',
                    });
                }
            });
        }

        function deleteTax(id) {
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
                        url: "{{ route('accountant.taxes.destroy', '') }}/" + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#tax-' + id).remove();
                            Swal.fire(
                                'Deleted!',
                                'Tax has been deleted.',
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
                url: '/accountant/taxes/' + id + '/status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    $('#tax-'+id).replaceWith(response);
                    Swal.fire({
                        icon: 'success',
                        text: 'tax status has been updated successfully!',
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
