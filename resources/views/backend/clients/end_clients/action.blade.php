@canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
    <div class="btn-group" role="group" aria-label="First group">
        <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="editData('{{Crypt::encrypt($id)}}')"><i class="fa far fa-edit"></i></button>
        @canany(['isAdmin','isCompanyAdmin'])
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="deleteData('{{Crypt::encrypt($id)}}')"><i class="fa fas fa-trash-alt"></i></button>
        @endcanany
    </div>
@endcanany