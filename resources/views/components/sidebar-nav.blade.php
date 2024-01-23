<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="#">Ninja HR</a>
            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>

        <div class="sidebar-header">
            @if (auth()->user()->profile)
            <div class="user-pic">
                <img class="img-responsive sidebar-profile_img" src="{{asset('storage/'.auth()->user()->profile)}}"
                    alt="{{auth()->user()->name}}">
            </div>
            @endif
            <div class="user-info">
                <span class="user-name">
                    <strong>{{auth()->user()->name}}</strong>
                </span>
                <span class="user-role">{{auth()->user()->department->title}}</span>
                @foreach (auth()->user()->roles as $role)
                <span class="user-role">{{$role->name}}</span>
                @endforeach
                {{-- <span class="user-status">
                    <i class="fa fa-circle"></i>
                    <span>Online</span>
                </span> --}}
            </div>
        </div>
        <!-- sidebar-header  -->

        <div class="sidebar-menu">
            <ul>
                <li class="header-menu">
                    <span>Menu</span>
                </li>
                {{-- <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="fa fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                        <span class="badge badge-pill badge-warning">New</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="#">Dashboard 1
                                    <span class="badge badge-pill badge-success">Pro</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">Dashboard 2</a>
                            </li>
                            <li>
                                <a href="#">Dashboard 3</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                <li>
                    <a href="{{route('home')}}">
                        <i class="fa-solid fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>

                @can('view_company_settings')
                <li>
                    <a href="{{route('company_settings.show',1)}}">
                        <i class="fa-regular fa-building"></i>
                        <span>Company Settings</span>
                    </a>
                </li>
                @endcan

                @can('view_employees')
                <li>
                    <a href="{{route('employees.index')}}">
                        <i class="fa-solid fa-users"></i>
                        <span>Employees</span>
                    </a>
                </li>
                @endcan

                @can('view_salaries')
                <li>
                    <a href="{{route('salaries.index')}}">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <span>Salaries</span>
                    </a>
                </li>
                @endcan

                @can('view_departments')
                <li>
                    <a href="{{route('departments.index')}}">
                        <i class="fa-solid fa-sitemap"></i>
                        <span>Departments</span>
                    </a>
                </li>
                @endcan

                @can('view_projects')
                <li>
                    <a href="{{route('projects.index')}}">
                        <i class="fa-solid fa-toolbox"></i>
                        <span>Projects</span>
                    </a>
                </li>
                @endcan

                @can('view_roles')
                <li>
                    <a href="{{route('roles.index')}}">
                        <i class="fa-solid fa-user-shield"></i>
                        <span>Roles</span>
                    </a>
                </li>
                @endcan

                @can('view_permissions')
                <li>
                    <a href="{{route('permissions.index')}}">
                        <i class="fa-solid fa-shield"></i>
                        <span>Permission</span>
                    </a>
                </li>
                @endcan

                @can('view_attendances')
                <li>
                    <a href="{{route('attendances.index')}}">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Attendances (Employee)</span>
                    </a>
                </li>
                @endcan

                @can('view_attendances')
                <li>
                    <a href="{{route('attendances.overview')}}">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Attendances (Overview)</span>
                    </a>
                </li>
                @endcan

                @can('view_payroll')
                <li>
                    <a href="{{route('payroll_table.index')}}">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>Payroll</span>
                    </a>
                </li>
                @endcan

            </ul>
        </div>
        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
</nav>
