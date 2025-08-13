<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trophy House</title>

    {{-- Core vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/font-awesome/css/font-awesome.min.css') }}">

    {{-- Page-level vendor CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

    {{-- Main template CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/trophy house logo.png') }}" />

    {{-- Summernote --}}
    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/summernote/summernote-lite.min.css') }}">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Active-state colour overrides --}}
    <style>
        .sidebar .nav .nav-item.active>.nav-link .menu-title {
            color: #E31E24;
            font-family: "ubuntu-medium", sans-serif;
        }

        .sidebar .nav .nav-item.active>.nav-link i {
            color: #E31E24;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- ========== TOP NAVBAR ========== -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo" href="#">
                    <img src="{{ asset('admin/assets/images/trophy house logo.png') }}" alt="logo">
                </a>
                <a class="navbar-brand brand-logo-mini" href="#">
                    <img src="{{ asset('admin/assets/images/trophy house logo.png') }}" alt="logo">
                </a>
            </div>

            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>

                <div class="search-field d-none d-md-block">
                    <form class="d-flex align-items-center h-100">
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <span class="input-group-text border-0 mdi mdi-magnify"></span>
                            </div>
                            <input type="text" class="form-control bg-transparent border-0"
                                placeholder="Search projects">
                        </div>
                    </form>
                </div>

                <ul class="navbar-nav navbar-nav-right">
                    {{-- Logout --}}
                    <li class="nav-item nav-logout d-none d-lg-block">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>
                        <a href="#" class="nav-link d-flex align-items-center gap-2"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-power">Logout</i>
                        </a>
                    </li>
                </ul>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <!-- ========== /TOP NAVBAR ========== -->

        <div class="container-fluid page-body-wrapper">
            <!-- ========== SIDEBAR ========== -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">

                    <li class="nav-item" data-keywords="home">
                        <a class="nav-link" href="{{ route('home') }}">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item" data-keywords="orders">
                        <a class="nav-link" href="{{ route('orders') }}">
                            <span class="menu-title">Orders</span>
                            <i class="mdi mdi-receipt-text menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item" data-keywords="payments">
                        <a class="nav-link" href="{{ route('admin.payments') }}">
                            <span class="menu-title">Payments</span>
                            <i class="mdi mdi-credit-card menu-icon"></i>
                        </a>
                    </li>


                    <li class="nav-item" data-keywords="products,addProducts,editProducts,viewProducts">
                        <a class="nav-link" href="{{ route('products') }}">
                            <span class="menu-title">Products</span>
                            <i class="mdi mdi-view-grid menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item" data-keywords="category,addCategory,editCategory,viewCategory">
                        <a class="nav-link" href="{{ route('category') }}">
                            <span class="menu-title">Category</span>
                            <i class="mdi mdi-view-grid menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item" data-keywords="subcat,addSubcat,editSubcat,showSubcat">
                        <a class="nav-link" href="{{ route('subCategory') }}">
                            <span class="menu-title">Sub-Category</span>
                            <i class="mdi mdi-view-list menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item" data-keywords="">
                        <a class="nav-link" href="{{ route('occproducts') }}">
                            <span class="menu-title"></span>Occasional Products
                            <i class="mdi mdi-view-grid menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-keywords="">
                        <a class="nav-link" href="{{ route('occasion') }}">
                            <span class="menu-title"></span>Occasions
                            <i class="mdi mdi-gift menu-icon"></i>
                        </a>
                    </li>


                    <li class="nav-item" data-keywords="team,addTeam,viewTeam,editTeam">
                        <a class="nav-link" href="{{ route('Designerinfo') }}">
                            <span class="menu-title">Designer</span>
                            <i class="mdi mdi-account-group menu-icon"></i>
                        </a>
                    </li>
                    
                    <li class="nav-item" data-keywords="team,addTeam,viewTeam,editTeam">
                        <a class="nav-link" href="{{ route('teams') }}">
                            <span class="menu-title">Team</span>
                            <i class="mdi mdi-account-group menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item" data-keywords="testimonials,addTestimonial,viewTestimonial,editTestimonial">
                        <a class="nav-link" href="{{ route('tests') }}">
                            <span class="menu-title">Testimonials</span>
                            <i class="mdi mdi-comment-text menu-icon"></i>
                        </a>
                    </li>

                    <li class="nav-item" data-keywords="pages,addPage,editPage,viewPage">
                        <a class="nav-link" href="{{ route('pages') }}">
                            <span class="menu-title">Pages</span>
                            <i class="mdi mdi-file-multiple menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-keywords="clients,addClient,editClient,viewClient">
                        <a class="nav-link" href="{{ route('clients') }}">
                            <span class="menu-title">Clients List</span>
                            <i class="mdi mdi-account-group menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-keywords="about,addAbout,viewAbout,editAbout">
                        <a class="nav-link" href="{{ route('about') }}">
                            <span class="menu-title">About</span>
                            <i class="mdi mdi-information menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-keywords="about,addAbout,viewAbout,editAbout">
                        <a class="nav-link" href="{{ route('Admingallery') }}">
                            <span class="menu-title">Our Gallery</span>
                            <i class="mdi mdi-view-grid menu-icon"></i>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- ========== /SIDEBAR ========== -->

            <div class="main-panel">
