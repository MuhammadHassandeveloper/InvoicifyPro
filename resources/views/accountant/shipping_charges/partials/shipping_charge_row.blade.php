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
