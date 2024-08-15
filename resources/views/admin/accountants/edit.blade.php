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
                            <form method="POST" action="{{ route('admin.accountants.update', $accountant->id) }}">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name"
                                                   value="{{ $accountant->first_name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                   value="{{ $accountant->last_name }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value="{{ $accountant->email }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                   value="{{ $accountant->phone }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password (Leave blank to keep
                                                current)</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm
                                                Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                   name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="country_id">Country<span class="text-danger">*</span></label>
                                        <select class="form-select" name="country_id" id="country_id" required>
                                            <option value="" selected>Select</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ old('country_id', $accountant->country_id ?? '') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary">Update Accountant</button>
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
