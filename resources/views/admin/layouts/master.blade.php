<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>@yield('title')</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('admin/css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet"
        media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('admin/vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('admin/vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('admin/vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('admin/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('admin/css/theme.css') }}" rel="stylesheet" media="all">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>

        a {
            text-decoration: none;
            color: black;
        }

        .navbar-nav .nav-item .nav-link:hover {
            background-color: #352a30;
            color: #fff !important;
        }

        .main-content {
            background-color: #dcdcdc;
            padding-bottom: 50px;
        }
    </style>

</head>

<body class="animsition">
    <div class="">
        <!-- MENU SIDEBAR-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 bg-light border-right" style="z-index: 2000;">

                    <h2 class="my-3 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('admin/images/icon/logo-mini.png') }}" alt="Cool Admin" />
                        <span style="color: black;" class="d-none d-lg-block ml-2">Admin</span>

                    </h2>
                    <nav class="mt-5">
                        <ul class="navbar-nav">

                            <li class="nav-item mb-3" title="Category">
                                <a class="nav-link text-black-50 px-3" style="font-size: 20px;"
                                    href="{{ route('category#list') }}">
                                    <i class="fas fa-chart-bar mr-3 "></i>
                                    <span class="d-none d-lg-inline">Category</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3" title="Product">
                                <a class="nav-link text-black-50 px-3" href="{{ route('product#list') }}"
                                    style="font-size: 20px;">
                                    <i class="fas fa-utensils mr-3 "></i>
                                    <span class="d-none d-lg-inline">Product</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3" title="Order">
                                <a class="nav-link text-black-50 px-3" href="{{ route('order#list') }}"
                                    style="font-size: 20px;">
                                    <i class="fas fa-pizza-slice mr-3"></i>
                                    <span class="d-none d-lg-inline">Order</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3" title="User List">
                                <a class="nav-link text-black-50 px-3" href="{{ route('admin#normalUserList') }}"
                                    style="font-size: 20px;">
                                    <i class="fas fa-users mr-3 "></i>
                                    <span class="d-none d-lg-inline">User List</span>
                                </a>
                            </li>
                            <li class="nav-item mb-3" title="User Messages">
                                <a class="nav-link text-black-50 px-3" href="{{ route('admin#userContactList') }}"
                                    style="font-size: 20px;">
                                    <i class="fa-solid fa-message mr-3"></i>
                                    <span class="d-none d-lg-inline">Messages</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
                <div class="col-10 p-0">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <h4>Admin Dashboard</h4>
                        <div class="account-item clearfix js-item-menu mr-3">
                            <div class="image">
                                @if (Auth::user()->image == null)
                                    @if (Auth::user()->gender == 'male')
                                        <img style="max-height: 300px;" src="{{ asset('image/default_male.png') }}" />
                                    @else
                                        <img style="max-height: 300px;"
                                            src="{{ asset('image/default_female.png') }}" />
                                    @endif
                                @else
                                    <img src="{{ asset('storage/profileImage/' . Auth::user()->image) }}" />
                                @endif
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#">
                                    {{ Auth::user()->name }}
                                </a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender == 'male')
                                                <img style="max-height: 300px;"
                                                    src="{{ asset('image/default_male.png') }}" />
                                            @else
                                                <img style="max-height: 300px;"
                                                    src="{{ asset('image/default_female.png') }}" />
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/profileImage/' . Auth::user()->image) }}" />
                                        @endif
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#">{{ Auth::user()->name }}</a>
                                        </h5>
                                        <span class="email">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ route('admin#detail') }}">
                                            <i class="zmdi zmdi-account"></i>Account Profile
                                        </a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ route('admin#list') }}">
                                            <i class="zmdi zmdi-accounts"></i>Admin List
                                        </a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ route('admin#changePasswordPage') }}">
                                            <i class="fas fa-key"></i>Change Password</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer my-3">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-dark w-75 p-2">
                                            <i class="zmdi zmdi-power mr-3"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @yield('content')
                </div>


            </div>
        </div>






    </div>

    </div>

    <!-- Jquery JS-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('admin/vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('admin/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/wow/wow.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/animsition/animsition.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/counter-up/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/counter-up/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/select2/select2.min.js') }}"></script>

    <!-- Main JS-->
    <script src="{{ asset('admin/js/main.js') }}"></script>
    @yield('myjs')

</body>

</html>
<!-- end document-->
