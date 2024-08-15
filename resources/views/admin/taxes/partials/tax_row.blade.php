
<tr id="tax-{{ $tax->id }}">
    <td>{{ $tax->country->name }}</td>
    <td>{{ $tax->name }}</td>
    <td>{{ $tax->percentage }}%</td>
    <td>{{ $tax->created_at->format('d M Y ') }}</td>
    <td>{{ $tax->user->first_name}} {{ $tax->user->last_name }}</td>

    <td>
            <span class="badge  p-2 {{ $tax->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                {{ $tax->status ? 'Active' : 'Disabled' }}
            </span>
    </td>

    <td>
        <button class="btn btn-soft-primary btn-sm" onclick="editTax({{ $tax->id }})">
            <i class="las la-pen fs-17 align-middle"></i>
        </button>
        <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $tax->id }}, {{ $tax->status ? 0 : 1 }})">
            <i class="las la-sync fs-17 align-middle"></i>
        </button>
        <button class="btn btn-soft-danger btn-sm" onclick="deleteTax({{ $tax->id }})">
            <i class="las la-trash fs-17 align-middle"></i>
        </button>
    </td>
</tr>
