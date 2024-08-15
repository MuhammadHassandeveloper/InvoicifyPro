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
