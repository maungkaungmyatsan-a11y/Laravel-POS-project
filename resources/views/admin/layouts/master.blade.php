<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>POS Admin Dashboard</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('admin_template/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="mx-3 sidebar-brand-text">Code Lab Studio</div>
            </a>

            <!-- Divider -->
            <hr class="my-0 sidebar-divider">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin#home') }}"><i class="fas fa-fw fa-table"></i><span>Dashboard
                    </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('category#list') }}"><i
                        class="fa-solid fa-circle-plus"></i><span>Category </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('product#createPage') }}"><i class="fa-solid fa-plus"></i><span>Add
                        Products </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('product#list') }}"><i
                        class="fa-solid fa-layer-group"></i><span>Product List </span></a>
            </li>


            @if(auth()->user()->role == 'superadmin')
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa-solid fa-credit-card"></i><span>Payment Method </span></a>
                </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin#saleInformation') }}"><i class="fa-solid fa-list"></i><span>Sale Information </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin#orderList') }}"><i class="fa-solid fa-cart-shopping"></i><span>Order Board </span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile#changePasswordPage') }}"><i
                        class="fa-solid fa-lock"></i><span>Change Password </span></a>
            </li>


            <li class="nav-item">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <span class="nav-link">
                        <button type="submit" class="text-white btn bg-dark"><i
                                class="fa-solid fa-right-from-bracket"></i> Logout</button>
                    </span>
                </form>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="mb-4 bg-white shadow navbar navbar-expand navbar-light topbar static-top">



                    <!-- Topbar Navbar -->
                    <ul class="ml-auto navbar-nav">


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mt-1 mr-2 text-gray-600 d-none d-lg-inline"><b>
                                        {{auth()->user()->name}}</b></span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset(auth()->user()->profile == null ? 'defaultImage/profile.webp' : 'adminProfile/' . auth()->user()->profile) }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="shadow dropdown-menu dropdown-menu-right animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile#details') }}">
                                    <i class="mr-2 text-gray-400 fas fa-user fa-sm fa-fw"></i>
                                    Profile
                                </a>

                                @if(auth()->user()->role == 'superadmin')
                                    <a class="dropdown-item" href="{{ route('profile#addNewAdminPage') }}">
                                        <i class="mr-2 text-gray-400 fas fa-cogs fa-sm fa-fw"></i>
                                        Add New Admin Account
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ route('profile#accountList', ['accountType' => 'admin']) }}">
                                        <i class="mr-2 text-gray-400 fas fa-users fa-sm fa-fw"></i>
                                        Admin List
                                    </a>

                                    <a class="dropdown-item"
                                        href="{{ route('profile#accountList', ['accountType' => 'user']) }}">
                                        <i class="mr-2 text-gray-400 fas fa-cogs fa-sm fa-fw"></i>
                                        User List
                                    </a>
                                @endif


                                <a class="dropdown-item" href="{{ route('profile#changePasswordPage') }}">
                                    <i class="mr-2 text-gray-400 fa-solid fa-lock fa-sm fa-fw"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf

                                        <input type="submit" class="text-white btn btn-dark w-100" value="Logout">
                                    </form>
                                </span>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

                <!-- Bootstrap core JavaScript-->
                <script src="{{ asset('admin_template/vendor/jquery/jquery.min.js') }}"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
                    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script src="{{ asset('admin_template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

                <!-- Core plugin JavaScript-->
                <script src="{{ asset('admin_template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

                <!-- Custom scripts for all pages-->
                <script src="{{ asset('admin_template/js/sb-admin-2.min.js') }}"></script>



                {{-- sweet alert 2 package --}}
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
@yield('script-code')

<script>
    function loadFile(event) {
        var reader = new FileReader()

        reader.onload = function () {
            document.getElementById("output").src = reader.result;
        }

        reader.readAsDataURL(event.target.files[0])
    }
</script>

</html>
