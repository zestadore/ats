<!-- navbar-->
<header class="header">
    <nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow"><a class="fw-bold text-uppercase text-base" href="JavaScript:void(0)"><span class="d-none d-brand-partial">
      <img src="{{asset('assets/img/ezizaas_logo.png')}}" alt="" class="img-responsive" width="150px">
    </span></a>&nbsp;<a class="sidebar-toggler text-gray-500 me-4 me-lg-5 lead" href="#" style="float: left !important;"><i class="fas fa-align-left"></i></a>
    <div class="spinner-grow centerLoader" role="status" style="float: left;"> <span class="visually-hidden">Loading...</span>
    </div>  
    <ul class="ms-auto d-flex align-items-center list-unstyled mb-0">
        <li class="nav-item dropdown me-2" onclick="openCalendar()" style="padding : 10px;cursor : pointer">
          <div class="icon text-white bg-indigo"><i class="far fa-calendar-plus"></i></div>
        </li>
        <li class="nav-item dropdown me-2" style="padding : 10px;cursor : pointer">
          <a class="nav-link pe-0" id="notesInfo" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="icon text-white bg-indigo"><i class="fas fa-plus"></i></div>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="notesInfo">
            <a class="dropdown-item" href="Javascript::void(0)" onclick="openNotes('Notes')">
                Notes
            </a>
            <a class="dropdown-item" href="Javascript::void(0)" onclick="openNotes('ToDos')">
                ToDos
            </a>
          </div>
        </li>
        <li class="nav-item dropdown me-2" style="padding : 15px;">
          <a class="nav-link pe-0" id="dashboardInfo" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="icon text-white bg-indigo"><i class="fas fa-cog"></i></div>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="dashboardInfo">
            <a class="dropdown-item" href="Javascript::void(0)">
                <label class="switch">
                    <input type="checkbox" id="countsToggle" checked>
                    <span class="slider round"></span>
                </label>
                Counts
            </a>
            <a class="dropdown-item" href="Javascript::void(0)">
                <label class="switch">
                    <input type="checkbox" id="pipelineToggle" checked>
                    <span class="slider round"></span>
                </label>
                Pipeline Summary
            </a>
            <a class="dropdown-item" href="Javascript::void(0)">
                <label class="switch">
                    <input type="checkbox" id="interviewsToggle" checked>
                    <span class="slider round"></span>
                </label>
                Upcomming Interviews
            </a>
            <a class="dropdown-item" href="Javascript::void(0)">
                <label class="switch">
                    <input type="checkbox" id="completedInterviewsToggle" checked>
                    <span class="slider round"></span>
                </label>
                Completed Interviews
            </a>
            <a class="dropdown-item" href="Javascript::void(0)">
                <label class="switch">
                    <input type="checkbox" id="submissionsToggle" checked>
                    <span class="slider round"></span>
                </label>
                Recent Submissions
            </a>
            <a class="dropdown-item" href="Javascript::void(0)">
                <label class="switch">
                    <input type="checkbox" id="activityLogsToggle" checked>
                    <span class="slider round"></span>
                </label>
                Activity Logs
            </a>
          </div>
        </li>
        <li class="nav-item dropdown ms-auto">
          <a class="nav-link pe-0" id="userInfo" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if (Auth::user()->image==null)
                <img src="{{asset('uploads/site_logo/'.env('SITE_LOGO',''))}}" class="avatar p-1" alt="User Image">
            @else
                <img src="{{Auth::user()->image_path}}" class="avatar p-1" alt="user avatar">
            @endif
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated" aria-labelledby="userInfo">
            <div class="dropdown-header text-gray-700">
              <h6 class="text-uppercase font-weight-bold">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h6><small>{{strtoupper(Auth::user()->role)}}</small>
            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('profile')}}">
              Profile
            </a>
            <a class="dropdown-item" href="{{route('change.password')}}">
              Change Password
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript::void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              Logout
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </div>
        </li>
      </ul>
    </nav>
</header>