<div class="btn-group" role="group" aria-label="First group">
    @if (Auth::user()->id!=$id)
        <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="viewModal('{{Crypt::encrypt($id)}}')"><i class="bx bx bx-zoom-in"></i></button>
        <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Generate Password" onclick="resetPassword('{{Crypt::encrypt($id)}}')"><i class="bx bx-lock-alt"></i></button>
        <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="editData('{{Crypt::encrypt($id)}}')"><i class="bx bx-message-square-edit"></i></button>
        @canany(['isAdmin'])
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="deleteData('{{Crypt::encrypt($id)}}')"><i class="bx bx-trash"></i></button>
        @endcanany
    @endif
</div>