<div class="btn-group" role="group" aria-label="First group">
    <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="viewModal('{{Crypt::encrypt($id)}}')"><i class="fa far fa-eye"></i></button>
    @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
        <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" onclick="editData('{{Crypt::encrypt($id)}}')"><i class="fa far fa-edit"></i></button>
        @canany(['isCompanyAdmin','isAdmin'])
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="deleteData('{{Crypt::encrypt($id)}}')"><i class="fa fas fa-trash-alt"></i></button>
        @endcanany
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Add End Clients" onClick="endClients('{{Crypt::encrypt($id)}}')"><i class="fa fas fa-plus-circle"></i></button>
    @endcanany
</div>