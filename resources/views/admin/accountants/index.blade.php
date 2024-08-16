@extends('admin.layout.base')
@section('title', $title)
@section('accountant-list-page', 'active')

@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <a href="{{ route('admin.accountants.create') }}" class="btn btn-primary">Create Accountant</a>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-card mt-2 mt-2">
                                    <table id="DataTables_Table_0" class="table table-sm dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Country</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($accountants as $accountant)
                                            <tr>
                                                <td>{{ $accountant->first_name }} {{ $accountant->last_name }}</td>
                                                <td>{{ $accountant->email }}</td>
                                                <td>{{ $accountant->phone }}</td>
                                                <td>{{ $accountant->country->name }}</td>
                                                <td>
                                                <span class="badge p-2 {{ $accountant->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                    {{ $accountant->status ? 'Active' : 'Inactive' }}
                                                </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.accountants.edit', $accountant->id) }}" class="btn btn-soft-primary btn-sm">
                                                        <i class="las la-pen fs-17 align-middle"></i>
                                                    </a>

                                                    <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $accountant->id }})">
                                                        <i class="las la-sync fs-17 align-middle"></i>
                                                    </button>

                                                    <button class="btn btn-soft-danger btn-sm" onclick="deleteAccountant({{ $accountant->id }})">
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

    <script>
        function deleteAccountant(id) {
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
                        url: '/admin/accountants/destroy/' + id,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function() {
                            location.reload();
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

        function changeStatus(clientId) {
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
                        url: '/admin/accountants/status/' + clientId,
                        type: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                text: 'Accountant status has been updated successfully!',
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


    </script>
@endsection
