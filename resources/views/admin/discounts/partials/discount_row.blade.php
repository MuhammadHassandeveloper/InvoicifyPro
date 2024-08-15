<tr id="discount-{{ $discount->id }}">
    <td>{{ $discount->name }}</td>
    <td>{{ $discount->percentage }}%</td>
    <td>{{ $discount->created_at->format('d M Y ') }}</td>
    <td>{{ $discount->user->first_name}} {{ $discount->user->last_name }}</td>
    <td>
            <span class="badge  p-2 {{ $discount->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
                {{ $discount->status ? 'Active' : 'Disabled' }}
            </span>
    </td>
    <td>
        <button class="btn btn-soft-primary btn-sm" onclick="editDiscount({{ $discount->id }})">
            <i class="las la-pen fs-17 align-middle"></i>
        </button>

        <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $discount->id }}, {{ $discount->status ? 0 : 1 }})">
            <i class="las la-sync fs-17 align-middle"></i>
        </button>

        <button class="btn btn-soft-danger btn-sm" onclick="deleteDiscount({{ $discount->id }})">
            <i class="las la-trash fs-17 align-middle"></i>
        </button>
    </td>
</tr>
