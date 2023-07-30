<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="editData('{{Crypt::encrypt($id)}}')"><i class="bx bx-message-square-edit"></i>
    </button>
    <button type="button" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="deleteData('{{Crypt::encrypt($id)}}')"><i class="bx bx-trash"></i>
    </button>
    <button type="button" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Add End Clients"><i class="bx bx-book-add"></i>
    </button>
</div>