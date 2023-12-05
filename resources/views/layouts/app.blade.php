<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield("title")</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.min.css" rel="stylesheet" />
    <!-- JQUERY -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    {{-- CUSTOM CSS --}}
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>
    <div id="app">

        <!-- App bar -->
        <div class="app-bar text-center p-3 shadow">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="d-flex justify-content-between align-items-center fs-5">
                        <div type="button">
                            <i class="fa-solid fa-bars" id="show-sidebar"></i>
                        </div>
                        <div>
                            @yield("title")
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="page-wrapper chiller-theme">
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
                            <img class="img-responsive img-rounded" src="https://i.pravatar.cc/300" alt="User picture">
                        </div>
                        <div class="user-info">
                            <span class="user-name">Jhon
                                <strong>Smith</strong>
                            </span>
                            <span class="user-role">Administrator</span>
                            <span class="user-status">
                                <i class="fa fa-circle"></i>
                                <span>Online</span>
                            </span>
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
                                <a href="{{route('employee.index')}}">
                                    <i class="fa-solid fa-users"></i>
                                    <span>Employees</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- sidebar-menu  -->
                </div>
                <!-- sidebar-content  -->

            </nav>
            <!-- sidebar-wrapper  -->

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <main class="page-content">
                        @yield('content')
                    </main>
                </div>
            </div>
            <!-- page-content" -->
        </div>

        <!-- Bottom bar -->
        <div class="bottom-bar text-center p-3 shadow">
            <div class="row">
                <div class="col-md-8 mx-auto d-flex justify-content-between">
                    <a href="#">
                        <i class="fa-solid fa-home"></i>
                        <p class="mb-0">Home</p>
                    </a>

                    <a href="#">
                        <i class="fa-solid fa-home"></i>
                        <p class="mb-0">Home</p>
                    </a>

                    <a href="#">
                        <i class="fa-solid fa-home"></i>
                        <p class="mb-0">Home</p>
                    </a>

                    <a href="#">
                        <i class="fa-solid fa-home"></i>
                        <p class="mb-0">Home</p>
                    </a>
                </div>
            </div>
        </div>


    </div>



    {{-- slidebar --}}
    <script src="{{asset('js/slidebar.js')}}"></script>

    <!-- Bootstrap -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
    </script>

    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.umd.min.js">
    </script>

    <!-- Datatable -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    @yield('script')
</body>

</html>