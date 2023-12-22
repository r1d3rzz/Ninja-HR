<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand">
            <a href="#">Ninja HR</a>
            <div id="close-sidebar">
                <i class="fas fa-times"></i>
            </div>
        </div>

        <div class="sidebar-header">
            <div class="user-pic">
                <img class="img-responsive sidebar-profile_img" src="{{asset('storage/'.auth()->user()->profile)}}"
                    alt="{{auth()->user()->name}}">
            </div>
            <div class="user-info">
                <span class="user-name">
                    <strong>{{auth()->user()->name}}</strong>
                </span>
                <span class="user-role">{{auth()->user()->department->title}}</span>
                <span class="user-role">{{auth()->user()->employee_id}}</span>
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

                <li>
                    <a href="{{route('employees.index')}}">
                        <i class="fa-solid fa-users"></i>
                        <span>Employees</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('departments.index')}}">
                        <i class="fa-solid fa-sitemap"></i>
                        <span>Departments</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
</nav>