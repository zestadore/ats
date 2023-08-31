<div class="sidebar py-3" id="sidebar">
    <ul class="list-unstyled">
          <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/dashboard'))? 'active' : '' }}" href="{{route('admin.dashboard')}}">Dashboard</a></li>
          @canany(['isAdmin'])
            <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/site-settings*')|| request()->is('admin/mail-settings*')|| request()->is('admin/pricing-plans/*')|| request()->is('admin/companies*'))? 'active' : '' }}" href="#" data-bs-target="#saasDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
                    <svg class="svg-icon svg-icon-md me-3">
                      <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
                    </svg><span class="sidebar-link-title">SaaS </span></a>
              <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/site-settings*')|| request()->is('admin/mail-settings*')|| request()->is('admin/pricing-plans*')|| request()->is('admin/companies*'))? '' : 'collapse' }}" id="saasDropdown">
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/site-settings*'))? 'active' : '' }}" href="{{route('admin.get-site.details')}}">Site settings</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/mail-settings*'))? 'active' : '' }}" href="{{route('admin.get-mail.details')}}">Mail settings</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/pricing-plans*'))? 'active' : '' }}" href="{{route('admin.pricing-plans.index')}}">Pricing plans</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/companies*'))? 'active' : '' }}" href="{{route('admin.companies.index')}}">Companies</a></li>
              </ul>
            </li>
          @endcanany
          @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
            <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/users*'))? 'active' : '' }}" href="#" data-bs-target="#usersDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
              <svg class="svg-icon svg-icon-md me-3">
                <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
              </svg><span class="sidebar-link-title">Users </span></a>
              <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/users*'))? '' : 'collapse' }}" id="usersDropdown">
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/users'))? 'active' : '' }}" href="{{route('admin.users.index')}}">View users</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/users/create'))? 'active' : '' }}" href="{{route('admin.users.create')}}">Add user</a></li>
              </ul>
            </li>
            <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/clients*'))? 'active' : '' }}" href="#" data-bs-target="#clientsDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
              <svg class="svg-icon svg-icon-md me-3">
                <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
              </svg><span class="sidebar-link-title">Clients </span></a>
              <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/clients*'))? '' : 'collapse' }}" id="clientsDropdown">
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/clients'))? 'active' : '' }}" href="{{route('admin.clients.index')}}">View clients</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/clients/create'))? 'active' : '' }}" href="{{route('admin.clients.create')}}">Add client</a></li>
              </ul>
            </li>
          @endcanany
          <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/candidates*'))? 'active' : '' }}" href="#" data-bs-target="#candidatesDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <svg class="svg-icon svg-icon-md me-3">
              <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
            </svg><span class="sidebar-link-title">Candidates </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/candidates*'))? '' : 'collapse' }}" id="candidatesDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/candidates'))? 'active' : '' }}" href="{{route('admin.candidates.index')}}">View candidates</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/candidates/create'))? 'active' : '' }}" href="{{route('admin.candidates.create')}}">Add candidate</a></li>
            </ul>
          </li>
          <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-opportunities*'))? 'active' : '' }}" href="#" data-bs-target="#job-opportunitiesDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <svg class="svg-icon svg-icon-md me-3">
              <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
            </svg><span class="sidebar-link-title">Job Opportunity </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/job-opportunities*'))? '' : 'collapse' }}" id="job-opportunitiesDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-opportunities'))? 'active' : '' }}" href="{{route('admin.job-opportunities.index')}}">View job opportunities</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-opportunities/create'))? 'active' : '' }}" href="{{route('admin.job-opportunities.create')}}">Add job opportunity</a></li>
            </ul>
          </li>
          <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-submissions*'))? 'active' : '' }}" href="#" data-bs-target="#job-submissionsDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <svg class="svg-icon svg-icon-md me-3">
              <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
            </svg><span class="sidebar-link-title">Job Submissions </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/job-submissions*'))? '' : 'collapse' }}" id="job-submissionsDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-submissions'))? 'active' : '' }}" href="{{route('admin.job-submissions.index')}}">View job submissions</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-submissions/create'))? 'active' : '' }}" href="{{route('admin.job-submissions.create')}}">Add job submission</a></li>
            </ul>
          </li>
          <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/interviews*'))? 'active' : '' }}" href="#" data-bs-target="#interviewsDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <svg class="svg-icon svg-icon-md me-3">
              <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
            </svg><span class="sidebar-link-title">Interviews </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/interviews*'))? '' : 'collapse' }}" id="interviewsDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/interviews'))? 'active' : '' }}" href="{{route('admin.interviews.index')}}">View interviews</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/interviews/create'))? 'active' : '' }}" href="{{route('admin.interviews.create')}}">Add interview</a></li>
            </ul>
          </li>
          <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/invoices*'))? 'active' : '' }}" href="#" data-bs-target="#invoicesDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <svg class="svg-icon svg-icon-md me-3">
              <use xlink:href="icons/orion-svg-sprite.svg#real-estate-1"> </use>
            </svg><span class="sidebar-link-title">Invoices </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/invoices*'))? '' : 'collapse' }}" id="invoicesDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/invoices'))? 'active' : '' }}" href="{{route('admin.invoices.index')}}">View invoices</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/invoices/create'))? 'active' : '' }}" href="{{route('admin.invoices.create')}}">Add invoice</a></li>
            </ul>
          </li>
    </ul>
   
</div>