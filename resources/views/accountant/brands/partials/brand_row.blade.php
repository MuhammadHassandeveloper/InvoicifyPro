<tr id="discount-{{ $brand->id }}">
    <td>{{ $brand->name }}</td>
    <td>{{ $brand->created_at->format('d M Y ') }}</td>
    <td>{{ $brand->user->first_name}} {{ $brand->user->last_name }}</td>
    <td>
        <span class="badge  p-2 {{ $brand->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
            {{ $brand->status ? 'Active' : 'Disabled' }}
        </span>
    </td>
    <td>
        <button class="btn btn-soft-info btn-sm d-inline-block" onclick="editBrand({{ $brand->id }})">
            <i class="las la-pen fs-17 align-middle"></i>
        </button>
        <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $brand->id }}, {{ $brand->status ? 0 : 1 }})">
            <i class="las la-sync fs-17 align-middle"></i>
        </button>
        <button class="btn btn-soft-danger btn-sm d-inline-block" onclick="deleteBrand({{ $brand->id }})">
            <i class="las la-trash fs-17 align-middle"></i>
        </button>
    </td>
</tr>
