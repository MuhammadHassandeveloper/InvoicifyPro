@extends('customer.layout.base')
@section('title',$title)
@section('style')
@stop
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3>Profile Setting</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <form  action="{{ route('profile.update') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="first_name" class="form-label">First Name <span class="required">*</span></label>
                                            <input type="text" id="first_name" class="form-control" name="first_name" value="{{ $user->first_name }}">
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="last_name" class="form-label">Last Name <span class="required">*</span></label>
                                            <input type="text" id="last_name" class="form-control" name="last_name" value="{{ $user->last_name }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="email" class="form-label">Email <span class="required">*</span></label>
                                            <input type="text" id="email" class="form-control" name="email" value="{{ $user->email }}">
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="phone" class="form-label">Phone <span class="required">*</span></label>
                                            <input type="text" id="phone" class="form-control" name="phone" value="{{ $user->phone }}">
                                        </div>

                                        <div class="col-lg-12 col-sm-12 mb-3">
                                            <label for="address" class="form-label">Address <span class="required">*</span></label>
                                            <input type="text" id="address" class="form-control" name="billing_address" value="{{ $user->billing_address }}">
                                        </div>

                                      </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="password" class="form-label">Password <span class="required">*</span></label>
                                            <input type="password" id="password" class="form-control" name="password" placeholder="Enter Password">
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password <span class="required">*</span></label>
                                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
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

@endsection

