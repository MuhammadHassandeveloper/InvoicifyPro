@extends('admin.layout.base')
@section('title',$title)
@section('style')
@stop
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3>Site Setting</h3>
                    </div>

                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12" id="error_msg">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="p-0 m-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <form  action="{{ route('site_setting_save') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 mb-3">
                                            <label for="site_name" class="form-label">Site Name <span class="required">*</span></label>
                                            <input type="text" id="site_name" class="form-control" name="site_name" value="{{ $siteSettings->site_name }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 mb-3">
                                            <label for="stripe_publish_key" class="form-label">Stripe Publish Key  <span class="required">*</span></label>
                                            <input type="text" id="stripe_publish_key" class="form-control" name="stripe_publish_key" value="{{ $siteSettings->stripe_publish_key }}">
                                        </div>
                                        <div class="col-lg-12 col-sm-12 mb-3">
                                            <label for="stripe_secret_key" class="form-label">Stripe Secret Key <span class="required">*</span></label>
                                            <input type="text" id="stripe_secret_key" class="form-control" name="stripe_secret_key" value="{{ $siteSettings->stripe_secret_key }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="currency_sign" class="form-label">Currency Sign(د.إ)  <span class="required">*</span></label>
                                            <input type="text" id="currency_sign" class="form-control" name="currency_sign" value="{{ $siteSettings->currency_sign }}">
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="currency_code" class="form-label">Currency Code(AED)<span class="required">*</span></label>
                                            <input type="text" id="currency_code" class="form-control" name="currency_code" value="{{ $siteSettings->currency_code }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="site_white_logo" class="form-label">Site White Logo <span class="required">*</span></label>
                                            <input type="file" id="site_white_logo" value="{{ $siteSettings->site_white_logo }}" class="form-control" name="site_white_logo">
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="site_dark_logo" class="form-label">Site Dark Logo <span class="required">*</span></label>
                                            <input type="file" id="site_dark_logo" class="form-control" value="{{ $siteSettings->site_dark_logo }}" name="site_dark_logo">
                                        </div>

                                      </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-sm-12 mb-3">
                                            <label for="site_fav_icon" class="form-label">Site FavIcon <span class="required">*</span></label>
                                            <input type="file" id="site_fav_icon" value="{{ $siteSettings->site_fav_icon }}" class="form-control" name="site_fav_icon">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>

                            <div class="row mt-4">
                                <div class="col-xl-4 col-md-6">
                                    <div class="card card-height-100 bg-soft-primary shadow-none bg-opacity-10">
                                        <div class="card-body">
                                            <div class="mb-4 pb-2">
                                                <img style="width: 120px; height: 100px;" src="{{ asset('assets/logo/'.$siteSettings->site_white_logo) }}">
                                            </div>
                                            <a href="javascript:void(0);">
                                                <h6 class="fs-15 fw-semibold">White Logo</h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="card card-height-100 bg-soft-primary shadow-none bg-opacity-10">
                                        <div class="card-body">
                                            <div class="mb-4 pb-2">
                                                <img style="width: 120px; height: 100px;" src="{{ asset('assets/logo/'.$siteSettings->site_dark_logo) }}">
                                            </div>
                                            <a href="javascript:void(0);">
                                                <h6 class="fs-15 fw-semibold">Dark Logo</h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="card card-height-100 bg-soft-primary shadow-none bg-opacity-10">
                                        <div class="card-body">
                                            <div class="mb-4 pb-2">
                                                <img style="width: 120px; height: 100px;" src="{{ asset('assets/logo/'.$siteSettings->site_fav_icon) }}">
                                            </div>
                                            <a href="#!">
                                                <h6 class="fs-15 fw-semibold">FavIcon <span class="text-muted fs-13"></span></h6>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
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

