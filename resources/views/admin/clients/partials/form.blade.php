<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="first_name">First Name<span class="text-danger">*</span></label>
            <input id="first_name" name="first_name" placeholder="Enter First Name" type="text" class="form-control" value="{{ old('first_name', $client->first_name ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="last_name">Last Name<span class="text-danger">*</span></label>
            <input id="last_name" name="last_name" placeholder="Enter Last Name" type="text" class="form-control" value="{{ old('last_name', $client->last_name ?? '') }}" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="email">Email<span class="text-danger">*</span></label>
            <input id="email" name="email" placeholder="Enter Email" type="email" class="form-control" value="{{ old('email', $client->email ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="phone">Phone<span class="text-danger">*</span></label>
            <input id="phone" name="phone" placeholder="Enter Phone" type="text" class="form-control" value="{{ old('phone', $client->phone ?? '') }}" required>
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
</div>

<div class="row">
        <div class="mb-3">
            <label class="form-label" for="country_id">Country<span class="text-danger">*</span></label>
            <select class="form-select" name="country_id" id="country_id" required>
                <option value="" selected>Select</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ old('country_id', $client->country_id ?? '') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
</div>

<div class="row mb-1 mt-1">
    <h4>Client Billing Detail</h4>
</div>

<div class="row">

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="billing_phone">Billing Phone<span class="text-danger">*</span></label>
            <input id="billing_phone" name="billing_phone" placeholder="Enter Billing  Phone" type="text" class="form-control" value="{{ old('billing_phone', $client->billing_phone ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="billing_address">Billing Address<span class="text-danger">*</span></label>
            <input id="billing_address" name="billing_address" placeholder="Enter Billing Address" type="text" class="form-control" value="{{ old('billing_address', $client->billing_address ?? '') }}" required>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="billing_state">Billing State<span class="text-danger">*</span></label>
            <input id="billing_state" name="billing_state" placeholder="Enter Billing State" type="text" class="form-control" value="{{ old('billing_state', $client->billing_state ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="billing_city">Billing City<span class="text-danger">*</span></label>
            <input id="billing_city" name="billing_city" placeholder="Enter Billing City" type="text" class="form-control" value="{{ old('billing_city', $client->billing_city ?? '') }}" required>
        </div>
    </div>
</div>




<div class="row mb-1 mt-1">
    <h4>Client Shipping Detail</h4>
</div>


<div class="row">

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="shipping_phone">Shipping Phone<span class="text-danger">*</span></label>
            <input id="shipping_zip" name="shipping_phone" placeholder="Enter Shipping Phone" type="text" class="form-control" value="{{ old('shipping_phone', $client->shipping_phone ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-6">
    <div class="mb-3">
            <label class="form-label" for="shipping_address">Shipping Address<span class="text-danger">*</span></label>
            <input id="shipping_address" name="shipping_address" placeholder="Enter Shipping Address" type="text" class="form-control" value="{{ old('shipping_address', $client->shipping_address ?? '') }}" required>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="shipping_city">Shipping City<span class="text-danger">*</span></label>
            <input id="shipping_city" name="shipping_city" placeholder="Enter Shipping City" type="text" class="form-control" value="{{ old('shipping_city', $client->shipping_city ?? '') }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label" for="shipping_state">Shipping State<span class="text-danger">*</span></label>
            <input id="shipping_state" name="shipping_state" placeholder="Enter Shipping State" type="text" class="form-control" value="{{ old('shipping_state', $client->shipping_state ?? '') }}" required>
        </div>
    </div>
</div>

