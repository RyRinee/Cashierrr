<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dreams Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.jpg')}}">

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" />

    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>

<body>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left active">
                <a href="index.html" class="logo">
                    <img src="{{asset('assets/img/logo.png')}}" alt="">
                </a>
                <a href="index.html" class="logo-small">
                    <img src="{{asset('assets/img/logo-small.png')}}" alt="">
                </a>
                <a id="toggle_btn" href="javascript:void(0);">
                </a>
            </div>

            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <ul class="nav user-menu">

                <li class="nav-item">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#">
                            <div class="searchinputs">
                                <input type="text" placeholder="Search Here ...">
                                <div class="search-addon">
                                    <span><img src="{{asset('assets/img/icons/closes.svg')}}" alt="img"></span>
                                </div>
                            </div>
                            <a class="btn" id="searchdiv"><img src="{{asset('assets/img/icons/search.svg')}}" alt="img"></a>
                        </form>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="javascript:void(0);" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <!-- Menggunakan gambar dinamis -->
                            <img src="{{ asset('storage/image/' . auth()->user()->image) }}" alt="">
                            <span class="status online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profilename">
                            <div class="profileset">
                                <span class="user-img">
                                    <!-- Menampilkan avatar dari pengguna yang sedang login -->
                                    <img src="{{ asset('storage/image/' . auth()->user()->image) }}" alt="">
                                    <span class="status online"></span>
                                </span>
                                <div class="profilesets">
                                    <!-- Menampilkan nama dan role pengguna yang sedang login -->
                                    <h6>{{ auth()->user()->name }}</h6>
                                    <h5>{{ auth()->user()->role }}</h5>
                                </div>
                            </div>
                            <hr class="m-0">
                            <a class="dropdown-item logout pb-0" href="{{ route('login') }}">
                                <img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout
                            </a>
                        </div>
                    </div>
                </li>
                
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="signin.html">Logout</a>
                </div>
            </div>

        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        @if (auth()->user()->role === 'employee')
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{asset('assets/img/icons/product.svg')}}"
                                    alt="img"><span>
                                    Menu</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('menuList') }}" class="{{ Request::routeIs('menuList') ? 'active' : '' }}">Menu List</a></li>
                                <li><a href="{{ route('addMenu') }}" class="{{ Request::routeIs('addMenu') ? 'active' : '' }}">Add Menu </a></li>
                            </ul>
                        </li>
                        @endIf
                        @if (auth()->user()->role === 'admin')
                        <li class="{{ Request::routeIs('adminDash') ? 'active' : '' }}">
                            <a href="{{route('adminDash')}}"><img src="{{asset('assets/img/icons/dashboard.svg')}}" alt="img"><span>
                                    Dashboard</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{asset('assets/img/icons/product.svg')}}"
                                    alt="img"><span>
                                    Menu</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('menuListAdmin') }}" class="{{ Request::routeIs('menuListAdmin') ? 'active' : '' }}">Menu List</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{asset('assets/img/icons/users1.svg')}}"
                                    alt="img">
                                    <span>Employee</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('employeeList') }}" class="{{ Request::routeIs('employeeList') ? 'active' : '' }}">Employee List</a></li>
                                <li><a href="{{ route('addEmployee') }}" class="{{ Request::routeIs('addEmployee') ? 'active' : '' }}">Add Employee </a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);"><img src="{{asset('assets/img/icons/users1.svg')}}"
                                    alt="img">
                                    <span>Transactions</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('transactionDetails') }}" class="{{ Request::routeIs('transactionDetails') ? 'active' : '' }}"> Transaction Details </a></li>
                                <li><a href="{{ route('rekap') }}" class="{{ Request::routeIs('rekap') ? 'active' : '' }}"> Rekap </a></li>
                            </ul>
                        </li>
                        @endIf
                    </ul>
                </div>
            </div>
        </div>  
        <div>
            @yield('content');
        </div>
    </div>


    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>

    <script src="{{asset('assets/js/feather.min.js')}}"></script>

    <script src="{{asset('assets/js/jquery.slimscroll.min.js')}}"></script>

    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

    <script src="{{asset('assets/js/moment.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>

    <script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>

    <script src="{{asset('assets/plugins/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/plugins/apexchart/chart-data.js')}}"></script>

    <script src="{{asset('assets/js/script.js')}}"></script>
</body>

</html>
