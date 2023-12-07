<div class="button-group-flex" role="group" aria-label="First group">
    {{-- <button type="button" class="btn btn-outline-secondary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="View" onclick="viewModal('{{Crypt::encrypt($id)}}')"><i class="fa far fa-eye"></i></button>
    @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
        @canany(['isAdmin','isCompanyAdmin'])
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="deleteData('{{Crypt::encrypt($id)}}')"><i class="fa fas fa-trash-alt"></i></button>
        @endcanany
    @endcanany --}}
    <button type="button" class="btn btn-outline-dark" data-bs-toggle="dropdown" data-boundary="window" aria-expanded="false"><i class="fa fas fa-ellipsis-v"></i></button>
    <ul class="dropdown-menu" style="white-space: nowrap !important;">
        <li><a class="dropdown-item" href="javascript::void(0)" onclick="viewModal('{{Crypt::encrypt($id)}}')">View</a></li>
        @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
            {{-- <li><a class="dropdown-item" href="javascript::void(0)" onclick="editData('{{Crypt::encrypt($id)}}')">Edit</a></li> --}}
            <li><hr class="dropdown-divider"></li>
            @canany(['isAdmin','isCompanyAdmin'])
                <li><a class="dropdown-item" href="javascript::void(0)" onclick="deleteData('{{Crypt::encrypt($id)}}')">Delete</a></li>
            @endcanany
        @endcanany
    </ul>
</div>