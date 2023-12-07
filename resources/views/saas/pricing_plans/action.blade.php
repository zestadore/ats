{{-- <div class="button-group-flex" role="group" aria-label="First group">
    <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="viewModal('{{Crypt::encrypt($id)}}')"><i class="fa far fa-eye"></i></button>
    <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="editData('{{Crypt::encrypt($id)}}')"><i class="fa far fa-edit"></i></button>
    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="deleteData('{{Crypt::encrypt($id)}}')"><i class="fa fas fa-trash-alt"></i></button>
</div> --}}
<div class="button-group-flex position-static" role="group" aria-label="First group">
    {{-- <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="viewModal('{{Crypt::encrypt($id)}}')"><i class="fa far fa-eye"></i></button>
    <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="editData('{{Crypt::encrypt($id)}}')"><i class="fa far fa-edit"></i></button>
    @canany(['isAdmin'])
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="deleteData('{{Crypt::encrypt($id)}}')"><i class="fa fas fa-trash-alt"></i></button>
    @endcanany --}}
    <button type="button" class="btn btn-outline-dark" data-bs-toggle="dropdown" data-boundary="window" aria-expanded="false"><i class="fa fas fa-ellipsis-v"></i></button>
    <ul class="dropdown-menu" style="white-space: nowrap !important;">
        <li><a class="dropdown-item" href="javascript::void(0)" onclick="viewModal('{{Crypt::encrypt($id)}}')">View</a></li>
        <li><a class="dropdown-item" href="javascript::void(0)" onclick="editData('{{Crypt::encrypt($id)}}')">Edit</a></li>
        <li><a class="dropdown-item" href="javascript::void(0)" onclick="deleteData('{{Crypt::encrypt($id)}}')">Delete</a></li>
        <li><hr class="dropdown-divider"></li>
    </ul>
</div>