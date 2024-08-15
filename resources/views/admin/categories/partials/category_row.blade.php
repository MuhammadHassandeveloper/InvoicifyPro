<tr id="category-{{ $category->id }}">
    <td>{{ $category->name }}</td>
    <td>{{ $category->created_at->format('d M Y ') }}</td>
    <td>{{ $category->user->first_name}} {{ $category->user->last_name }}</td>
    <td>
        <span class="badge  p-2 {{ $category->status ? 'badge-soft-success' : 'badge-soft-danger' }}">
            {{ $category->status ? 'Active' : 'Disabled' }}
        </span>
    </td>
    <td>
        <button class="btn btn-soft-info btn-sm d-inline-block" onclick="editCategory({{ $category->id }})">
            <i class="las la-pen fs-17 align-middle"></i>
        </button>
        <button class="btn btn-soft-warning btn-sm d-inline-block" onclick="changeStatus({{ $category->id }}, {{ $category->status ? 0 : 1 }})">
            <i class="las la-sync fs-17 align-middle"></i>
        </button>
        <button class="btn btn-soft-danger btn-sm d-inline-block" onclick="deleteCategory({{ $category->id }})">
            <i class="las la-trash fs-17 align-middle"></i>
        </button>
    </td>
</tr>
