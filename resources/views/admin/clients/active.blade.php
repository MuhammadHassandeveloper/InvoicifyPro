@extends('admin.layout.base')
@section('title', $title)
@section('clients-dropdown','active')
@section('clients-dropdown-show','show')
@section('client-list-page','active')
@section('client-active-list-page','active')
@section('style')

@endsection
@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <a href="{{ route('admin.clients.create') }}" class="btn btn-primary" >Add Client</a>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom mb-2 nav-success mb-3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @yield('client-all-list-page')" href="{{ route('admin.clients.index') }}" role="tab" aria-selected="true">
                                        All
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link @yield('client-active-list-page')" href="{{ route('admin.clients.active') }}" role="tab" aria-selected="false">
                                        Active
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @yield('disabled-client-list-page')" href="{{ route('admin.clients.disabled') }}" role="tab" aria-selected="false">
                                        Disabled
                                    </a>
                                </li>


                            </ul>

                            <div class="table-card mt-2 mt-2">
                                <table id="DataTables_Table_0" class="table table-sm  dt-responsive align-middle table-hover table-bordered mb-0 dataTable no-footer dtr-inline collapsed">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody id="client-table-body">
                                    @foreach ($clients as $client)
                                        <tr id="client-{{ $client->id }}">
                                            <td>
                                                <a href="{{ route('admin.clients.edit',$client->id) }}" class="text-body align-middle fw-medium">{{ $client->first_name }} {{ $client->last_name }}</a>
                                            </td>
                                            <td>{{ $client->phone }}</td>
                                            <td>{{ $client->created_at->format('d M Y ') }}</td>
                                            <td>
                                                <span class="badge p-2 {{ $client->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                                    {{ $client->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-soft-info btn-sm" onclick="viewClient({{ $client->id }})">
                                                    <i class="las la-eye fs-17 align-middle"></i>
                                                </button>

                                                <a href="{{ route('admin.clients.edit',$client->id) }}" class="btn btn-soft-primary btn-sm">
                                                    <i class="las la-pen fs-17 align-middle"></i>
                                                </a>

                                                <button class="btn btn-soft-warning btn-sm" onclick="changeStatus({{ $client->id }})">
                                                    <i class="las la-sync fs-17 align-middle"></i>
                                                </button>

                                                <button class="btn btn-soft-danger btn-sm" onclick="deleteClient({{ $client->id }})">
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


    <div class="modal fade" id="clientModal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Client Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Billing Details -->
                    <div class="card card-light">
                        <div class="card-body">
                            <div class="card-header">
                                <h5 class="card-title fw-bold">
                                    Billing Details
                                </h5>
                                <div class="row mb-2">
                                    <div class="col-6 font-weight-bold">Billing Address:</div>
                                    <div class="col-6" id="clientBillingAddress"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 font-weight-bold">Billing City:</div>
                                    <div class="col-6" id="clientBillingCity"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 font-weight-bold">Billing State:</div>
                                    <div class="col-6" id="clientBillingState"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 font-weight-bold">Billing Phone:</div>
                                    <div class="col-6" id="clientBillingZip"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shipping Details -->
                    <div class="card card-light">
                        <div class="card-body">
                            <div class="card-header">
                                <h5 class="card-title fw-bold">
                                    Shipping Details
                                </h5>
                                <div class="row mb-2">
                                    <div class="col-6 font-weight-bold">Shipping Address:</div>
                                    <div class="col-6" id="clientShippingAddress"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 font-weight-bold">Shipping City:</div>
                                    <div class="col-6" id="clientShippingCity"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 font-weight-bold">Shipping State:</div>
                                    <div class="col-6" id="clientShippingState"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6 font-weight-bold">Shipping Phone:</div>
                                    <div class="col-6" id="clientShippingZip"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function deleteClient(clientId) {
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
                        url: "/admin/clients/destroy/" + clientId,
                        type: 'GET',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#client-' + clientId).remove();
                            Swal.fire({
                                icon: 'success',
                                text: 'Client has been deleted successfully!',
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
                        url: "/admin/clients/status/" + clientId,
                        type: 'post',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                text: 'Client status has been updated successfully!',
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

        function viewClient(clientId) {
            $.ajax({
                url: "/admin/clients/show/" + clientId,
                type: 'GET',
                success: function(response) {
                    $('#clientName').text(response.client.name);
                    $('#clientEmail').text(response.client.email);
                    $('#clientPhone').text(response.client.phone);

                    // Billing Details
                    $('#clientBillingAddress').text(response.client.billing_address);
                    $('#clientBillingCity').text(response.client.billing_city);
                    $('#clientBillingState').text(response.client.billing_state);
                    $('#clientBillingZip').text(response.client.billing_phone);

                    // Shipping Details
                    $('#clientShippingAddress').text(response.client.shipping_address);
                    $('#clientShippingCity').text(response.client.shipping_city);
                    $('#clientShippingState').text(response.client.shipping_state);
                    $('#clientShippingZip').text(response.client.shipping_phone);
                    $('#clientModal').modal('show');
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
