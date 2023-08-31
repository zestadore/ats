<div class="btn-group" role="group" aria-label="First group">
    @if (Auth::user()->id!=$id)
        <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="viewModal('{{Crypt::encrypt($id)}}')"><i class="fa far fa-eye"></i></button>
        <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Generate Password" onclick="resetPassword('{{Crypt::encrypt($id)}}')"><i class="fa fas fa-cogs"></i></button>
        <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="editData('{{Crypt::encrypt($id)}}')"><i class="fa far fa-edit"></i></button>
        @canany(['isAdmin'])
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="deleteData('{{Crypt::encrypt($id)}}')"><i class="fa fas fa-trash-alt"></i></button>
        @endcanany
    @endif
</div>