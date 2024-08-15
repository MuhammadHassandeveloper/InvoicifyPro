@extends('admin.layout.base')
@section('title', $title)
@section('accountant-list-page', 'active')


@section('content')
    <!-- Start Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="ml-3"><b>{{ $title }}</b></h4>
                <a href="{{ route('admin.accountants.index') }}" class="btn btn-secondary">Back to List</a>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.accountants.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="first_name">First Name<span class="text-danger">*</span></label>
                                            <input id="first_name" name="first_name" placeholder="Enter First Name" type="text" class="form-control" value="{{ old('first_name') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="last_name">Last Name<span class="text-danger">*</span></label>
                                            <input id="last_name" name="last_name" placeholder="Enter Last Name" type="text" class="form-control" value="{{ old('last_name') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email<span class="text-danger">*</span></label>
                                            <input id="email" name="email" placeholder="Enter Email" type="email" class="form-control" value="{{ old('email') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="phone">Phone<span class="text-danger">*</span></label>
                                            <input id="phone" name="phone" placeholder="Enter Phone" type="text" class="form-control" value="{{ old('phone') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Password</label>
                                            <input id="password" name="password" placeholder="Enter Password" type="password" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                                            <input id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" type="password" class="form-control">
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="country_id">Country<span class="text-danger">*</span></label>
                                        <select class="form-select" name="country_id" id="country_id" required>
                                            <option value="" selected>Select</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary">Create Accountant</button>
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

@stop
