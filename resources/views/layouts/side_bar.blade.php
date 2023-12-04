<div class="sidebar py-3" id="sidebar">
    <ul class="list-unstyled">
          <li class="sidebar-list-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Dashboard"><a class="sidebar-link text-muted {{ (request()->is('admin/dashboard'))? 'active' : '' }}" href="{{route('admin.dashboard')}}"><i class="fa fa-tasks" style="font-size:13px;padding:2px;"></i>&nbsp;<span class="sidebar_title">Dashboard</span></a></li>
          @canany(['isAdmin'])
            <li class="sidebar-list-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Saas"><a class="sidebar-link text-muted {{ (request()->is('admin/site-settings*')|| request()->is('admin/mail-settings*')|| request()->is('admin/pricing-plans*')|| request()->is('admin/companies*'))? 'active' : '' }}" href="#" data-bs-target="#saasDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
              <img src="{{asset('assets/icons/saas.png')}}" class="img-fluid" width="15px" alt="">&nbsp;<span class="sidebar-link-title sidebar_title">&nbsp;SaaS </span></a>
              <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/site-settings*')|| request()->is('admin/mail-settings*')|| request()->is('admin/pricing-plans*')|| request()->is('admin/companies*'))? '' : 'collapse' }}" id="saasDropdown">
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/site-settings*'))? 'active' : '' }}" href="{{route('admin.get-site.details')}}">Site settings</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/mail-settings*'))? 'active' : '' }}" href="{{route('admin.get-mail.details')}}">Mail settings</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/pricing-plans*'))? 'active' : '' }}" href="{{route('admin.pricing-plans.index')}}">Pricing plans</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/companies*'))? 'active' : '' }}" href="{{route('admin.companies.index')}}">Companies</a></li>
              </ul>
            </li>
          @endcanany
          @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
            <li class="sidebar-list-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Users"><a class="sidebar-link text-muted {{ (request()->is('admin/users*'))? 'active' : '' }}" href="{{route('admin.users.index')}}"><img src="{{asset('assets/icons/users.png')}}" class="img-fluid" width="15px" alt="">&nbsp;<span class="sidebar_title">Users</span></a></li>
            {{-- <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/users*'))? 'active' : '' }}" href="#" data-bs-target="#usersDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
              <i class="fa fa-users" style="font-size:24px"></i>&nbsp;<span class="sidebar-link-title">Users </span></a>
              <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/users*'))? '' : 'collapse' }}" id="usersDropdown">
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/users'))? 'active' : '' }}" href="{{route('admin.users.index')}}">View users</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/users/create'))? 'active' : '' }}" href="{{route('admin.users.create')}}">Add user</a></li>
              </ul>
            </li> --}}
            <li class="sidebar-list-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Clients"><a class="sidebar-link text-muted {{ (request()->is('admin/clients*'))? 'active' : '' }}" href="{{route('admin.clients.index')}}"><img src="{{asset('assets/icons/clients.png')}}" class="img-fluid" width="15px" alt="">&nbsp;<span class="sidebar_title">Clients</span></a></li>
            {{-- <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/clients*'))? 'active' : '' }}" href="#" data-bs-target="#clientsDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
              <i class="fa fa-user-secret" style="font-size:24px"></i>&nbsp;<span class="sidebar-link-title">Clients </span></a>
              <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/clients*'))? '' : 'collapse' }}" id="clientsDropdown">
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/clients'))? 'active' : '' }}" href="{{route('admin.clients.index')}}">View clients</a></li>
                <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/clients/create'))? 'active' : '' }}" href="{{route('admin.clients.create')}}">Add client</a></li>
              </ul>
            </li> --}}
          @endcanany
          <li class="sidebar-list-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Candidates"><a class="sidebar-link text-muted {{ (request()->is('admin/candidates*'))? 'active' : '' }}" href="{{route('admin.candidates.index')}}"><img src="{{asset('assets/icons/candidates.png')}}" class="img-fluid" width="15px" alt="">&nbsp;<span class="sidebar_title">Candidates</span></a></li>
          {{-- <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/candidates*'))? 'active' : '' }}" href="#" data-bs-target="#candidatesDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <i class="fa fa-user-plus" style="font-size:24px"></i>&nbsp;<span class="sidebar-link-title">Candidates </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/candidates*'))? '' : 'collapse' }}" id="candidatesDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/candidates'))? 'active' : '' }}" href="{{route('admin.candidates.index')}}">View candidates</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/candidates/create'))? 'active' : '' }}" href="{{route('admin.candidates.create')}}">Add candidate</a></li>
            </ul>
          </li> --}}
          <li class="sidebar-list-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Job Opportunity"><a class="sidebar-link text-muted {{ (request()->is('admin/job-opportunities*'))? 'active' : '' }}" href="{{route('admin.job-opportunities.index')}}"><img src="{{asset('assets/icons/jobs.png')}}" class="img-fluid" width="15px" alt="">&nbsp;<span class="sidebar_title">Job Opportunities</span></a></li>
          {{-- <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-opportunities*'))? 'active' : '' }}" href="#" data-bs-target="#job-opportunitiesDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <i class="fa fa-tags" style="font-size:24px"></i>&nbsp;<span class="sidebar-link-title">Job Opportunity </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/job-opportunities*'))? '' : 'collapse' }}" id="job-opportunitiesDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-opportunities'))? 'active' : '' }}" href="{{route('admin.job-opportunities.index')}}">View job opportunities</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-opportunities/create'))? 'active' : '' }}" href="{{route('admin.job-opportunities.create')}}">Add job opportunity</a></li>
            </ul>
          </li> --}}
          <li class="sidebar-list-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Job Submissions"><a class="sidebar-link text-muted {{ (request()->is('admin/job-submissions*'))? 'active' : '' }}" href="{{route('admin.job-submissions.index')}}"><img src="{{asset('assets/icons/submissions.png')}}" class="img-fluid" width="15px" alt="">&nbsp;<span class="sidebar_title">Job Submissions</span></a></li>
          {{-- <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-submissions*'))? 'active' : '' }}" href="#" data-bs-target="#job-submissionsDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <i class="fa fa-rocket" style="font-size:24px"></i>&nbsp;<span class="sidebar-link-title">Job Submissions </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/job-submissions*'))? '' : 'collapse' }}" id="job-submissionsDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-submissions'))? 'active' : '' }}" href="{{route('admin.job-submissions.index')}}">View job submissions</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/job-submissions/create'))? 'active' : '' }}" href="{{route('admin.job-submissions.create')}}">Add job submission</a></li>
            </ul>
          </li> --}}
          <li class="sidebar-list-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Interviews"><a class="sidebar-link text-muted {{ (request()->is('admin/interviews*'))? 'active' : '' }}" href="{{route('admin.interviews.index')}}"><img src="{{asset('assets/icons/interviews.png')}}" class="img-fluid" width="15px" alt="">&nbsp;<span class="sidebar_title">Interviews</span></a></li>
          {{-- <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/interviews*'))? 'active' : '' }}" href="#" data-bs-target="#interviewsDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <i class="fa fa-podcast" style="font-size:24px"></i>&nbsp;<span class="sidebar-link-title">Interviews </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/interviews*'))? '' : 'collapse' }}" id="interviewsDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/interviews'))? 'active' : '' }}" href="{{route('admin.interviews.index')}}">View interviews</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/interviews/create'))? 'active' : '' }}" href="{{route('admin.interviews.create')}}">Add interview</a></li>
            </ul>
          </li> --}}
          <li class="sidebar-list-item" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Invoices"><a class="sidebar-link text-muted {{ (request()->is('admin/invoices*'))? 'active' : '' }}" href="{{route('admin.invoices.index')}}"><img src="{{asset('assets/icons/invoices.png')}}" class="img-fluid" width="15px" alt="">&nbsp;<span class="sidebar_title">Invoices</span></a></li>
          {{-- <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/invoices*'))? 'active' : '' }}" href="#" data-bs-target="#invoicesDropdown" role="button" aria-expanded="true" data-bs-toggle="collapse"> 
            <i class="fa fa-file-pdf-o" style="font-size:24px"></i>&nbsp;<span class="sidebar-link-title">Invoices </span></a>
            <ul class="sidebar-menu list-unstyled {{ (request()->is('admin/invoices*'))? '' : 'collapse' }}" id="invoicesDropdown">
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/invoices'))? 'active' : '' }}" href="{{route('admin.invoices.index')}}">View invoices</a></li>
              <li class="sidebar-list-item"><a class="sidebar-link text-muted {{ (request()->is('admin/invoices/create'))? 'active' : '' }}" href="{{route('admin.invoices.create')}}">Add invoice</a></li>
            </ul>
          </li> --}}
    </ul>
   
</div>