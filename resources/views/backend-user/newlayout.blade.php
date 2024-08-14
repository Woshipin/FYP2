<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('newuserdashboard/vendor/fontawesome-free/css/all.min.css') }}"
        rel="stylesheet"type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('newuserdashboard/css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- <link href="{{ asset('table/assets/images/favicon.png') }}" rel="icon"> --}}
    {{-- <link href="{{ asset('table/assets/images/favicon.png') }}" rel="apple-touch-icon"> --}}
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- ========================================================= -->

    {{-- Table CSS --}}
    <link rel="stylesheet" href="{{ asset('table/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('table/assets/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('table/assets/css/style.css') }}">

    {{-- Icon CSS --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/line-awesome@1.3.0/dist/css/line-awesome.min.css" rel="stylesheet"> --}}

    <!-- Google Map JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Excel Modal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    {{-- Paginate CSS --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    {{-- Ajax JS --}}
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    {{-- Pagination --}}
    <!-- Add this at the end of your view file, before the closing </body> tag -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Latest compiled and minified CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> --}}
    <!-- Optional theme -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> --}}
    <!-- Latest compiled and minified JavaScript -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> --}}

    {{-- <style>
        .custom-margin {
            margin: 2px;
        }

        .custom-bg {
        background-color: white;
    }
    </style> --}}

    <style>
        .count-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            overflow: hidden;
            /* Prevent content from overflowing */
        }

        .count {
            margin-left: 10px;
            /* Adjust as needed */
        }
    </style>

</head>

<style>
    .navbar-nav {
        /* background: rgb(63,251,239); */
        /* background:linear-gradient(45deg, deeppink, blueviolet); */
        /* background:linear-gradient(45deg, #d2001a, #7462ff,#f48e21,#23d5ab); */
        /* background:linear-gradient(45deg, #d2001a, #f48e21,#7462ff,#23d5ab); */
        /* background-size: 125% 125%;
        animation: color 10s ease-in-out infinite; */
        /* background: linear-gradient(45deg, orange, white); */
        /* background: rgb(255, 166, 0); */
        /* background: #e78720; */
        /* background: black; */
    }

    .ml-auto {
        background: white;
    }

    .abc {
        /* background: rgb(63,251,239); */
        /* background: radial-gradient(circle at 50% 0,rgba(255, 0, 0, 0.5),rgba(255, 0, 0, 0) 70.71%); */
        /* background:linear-gradient(45deg, #d2001a, #7462ff,#f48e21,#23d5ab);
        background-size: 300% 300%;
        animation: color 12s ease-in-out infinite; */
    }

    @keyframes color {
        0% {
            background-position: 0 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0 50%;
        }
    }
</style>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="{{ url('/users/dashboard/{id}') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>

                @php
                    $id = Auth::id();
                    $name = Auth::user()->name;
                    $email = Auth::user()->email;
                    $password = Auth::user()->password;
                @endphp

                {{-- <div class="sidebar-brand-text mx-3">User Name: {{$id}} <sup></sup></div><br> --}}
                <div class="sidebar-brand-text mx-3">Name: {{ $name }} <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/users/dashboard/{id}') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ url('/users/wallet/' . auth()->user()->id) }}">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>My Wallet</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Interface</div>

            <!-- My Place Nav Item - Pages Collapse My Place Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#MyPlace"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>My Place</span>
                </a>
                <div id="MyPlace" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header"><i class="fas fa-map-marker-alt"></i>&nbsp;My Place</h6>
                        <a class="collapse-item" href="{{ url('/showResort') }}"><i
                                class="fas fa-map-marker-alt"></i>&nbsp;Resort&nbsp;&nbsp;<span
                                style="color: black">{{ App\Models\Resort::count() }}</span></a>
                        <a class="collapse-item" href="{{ url('/showHotel') }}"><i
                                class="fas fa-map-marker-alt"></i>&nbsp;Hotel&nbsp;&nbsp;<span
                                style="color: black">{{ App\Models\Hotel::count() }}</span></a>
                        <a class="collapse-item" href="{{ url('/showRestaurant') }}"><i
                                class="fas fa-map-marker-alt"></i>&nbsp;Restaurant&nbsp;&nbsp;<span
                                style="color: black">{{ App\Models\Restaurant::count() }}</span></a>
                    </div>
                </div>
            </li>

            <!-- Customer Booked Nav Item - Pages Collapse My Place Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#CustomerBooked"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-check-circle"></i>
                    <span>Customer Booked</span>
                </a>
                <div id="CustomerBooked" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header"><i class="fas fa-check-circle"></i>&nbsp;Customer Booked</h6>
                        <a class="collapse-item" href="{{ url('bookingsresort') }}">
                            <i class="fas fa-check-circle"></i>&nbsp;Booked Resort&nbsp;&nbsp;
                            <span id="resort-booked-count"
                                style="color: red;">{{ App\Models\BookingResort::whereIn('resort_id', auth()->user()->hotels()->pluck('id')->toArray())->where('payment_status', 'unpaid')->count() }}</span>
                        </a>
                        <a class="collapse-item" href="{{ url('bookingshotel') }}">
                            <i class="fas fa-check-circle"></i>&nbsp;Booked Hotel&nbsp;&nbsp;
                            <span id="hotel-booked-count"
                                style="color: red;">{{ App\Models\BookingHotel::whereIn('hotel_id', auth()->user()->hotels()->pluck('id')->toArray())->where('payment_status', 'unpaid')->count() }}</span>
                        </a>
                        <a class="collapse-item" href="{{ url('bookingsrestaurant') }}">
                            <i class="fas fa-check-circle"></i>&nbsp;Booked Restaurant&nbsp;&nbsp;
                            <span id="restaurant-booked-count"
                                style="color: red;">{{ App\Models\BookingRestaurant::whereIn('restaurant_id', auth()->user()->hotels()->pluck('id')->toArray())->where('payment_status', 'unpaid')->count() }}</span>
                        </a>
                    </div>
                </div>
            </li>

            <!-- My Booked Nav Item - Pages Collapse My Place Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#MyHasBooked"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-bookmark"></i>&nbsp;
                    <span>My Booked</span>
                </a>
                <div id="MyHasBooked" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header"><i class="fas fa-bookmark"></i>&nbsp;My Booked</h6>
                        <a class="collapse-item" href="{{ url('mybookingsrestaurant') }}"><i
                                class="fas fa-bookmark"></i>&nbsp;My Booked Restaurant&nbsp;&nbsp;<span
                                style="color: red;">{{ auth()->user()->bookingRestaurants()->where('payment_status', 'unpaid')->count() }}</span>
                        </a>
                        <a class="collapse-item" href="{{ url('mybookingshotel') }}"><i
                                class="fas fa-bookmark"></i>&nbsp;My Booked Hotel&nbsp;&nbsp;<span
                                style="color: red;">{{ auth()->user()->bookingHotels()->where('payment_status', 'unpaid')->count() }}</span>
                        </a>
                        <a class="collapse-item" href="{{ url('mybookingsresort') }}"><i
                                class="fas fa-bookmark"></i>&nbsp;My Booked Resort&nbsp;&nbsp;<span
                                style="color: red;">{{ auth()->user()->bookingResorts()->where('payment_status', 'unpaid')->count() }}</span>
                        </a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Addons</div> --}}

            {{-- <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                    aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item active" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li> --}}

            <!-- Nav Item - My Booked -->
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ url('mybookingsrestaurant') }}">
                    <i class="fas fa-bookmark"></i>
                    <span>My Booked</span>
                </a>
            </li> --}}

            <!-- Nav Item - Table -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('showTable') }}">
                    <i class="fas fa-table"></i>
                    <span>Table</span>
                </a>
            </li>

            <!-- Nav Item - Room -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('showRoom') }}">
                    <i class="fas fa-bed"></i>
                    <span>Room</span>
                </a>
            </li>

            <!-- Nav Item - Hotel Contact -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('viewhotelcontact') }}">
                    <i class="fas fa-address-book"></i>
                    <span>Contact</span></a>
            </li>

            <!-- Nav Item - User Deposit -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('deposit') }}">
                    <i class="fas fa-user-circle"></i>
                    <span>User Deposit</span></a>
            </li>

            <!-- Nav Item - Refund Deposit -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('viewrefund') }}">
                    <i class="fas fa-money-check"></i>
                    <span>Refund Deposit</span></a>
            </li>

            <!-- Nav Item - User Wishlist -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('userwishlist') }}">
                    <i class="fas fa-heart"></i>
                    <span>Wishlist</span></a>
            </li>

            <!-- Nav Item - Back -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back</span></a>
            </li>

            <!-- Nav Item - Tables -->
            {{-- <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Hotel</span></a>
            </li> --}}

            <!-- Nav Item - Tables -->
            {{-- <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Restaurant</span></a>
            </li> --}}

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" class="abc">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"><i
                            class="fa fa-bars"></i></button>

                    <!-- Topbar Search -->
                    {{-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button"><i class="fas fa-search fa-sm"></i></button>
                            </div>
                        </div>
                    </form> --}}

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        {{-- <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li> --}}

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="{{ url('viewhotelcontact') }}"
                                id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span
                                    class="badge badge-danger badge-counter">{{ App\Models\UserContact::count() }}</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            {{-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to
                                            download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                    Alerts</a>
                            </div> --}}
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="{{ url('viewhotelcontact') }}"
                                id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span
                                    class="badge badge-danger badge-counter">{{ App\Models\UserContact::count() }}</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            {{-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle"
                                            src="{{ asset('newuserdashboard/img/undraw_profile_1.svg') }}"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle"
                                            src="{{ asset('newuserdashboard/img/undraw_profile_2.svg') }}"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle"
                                            src="{{ asset('newuserdashboard/img/undraw_profile_3.svg') }}"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy
                                            with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle"
                                            src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More
                                    Messages</a>
                            </div> --}}
                        </li>

                        <!-- User Profile Model -->
                        <!-- Modal content for each User Profile -->
                        <div class="modal fade" id="profileModal{{ $id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <!-- Modal header and form -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">User Profile</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" name="name"
                                                    id="name" value="{{ $name }}">
                                                <span class="text-danger">
                                                    @error('name')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" name="email"
                                                    id="email" value="{{ $email }}">
                                                <span class="text-danger">
                                                    @error('email')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            {{-- <button type="submit" class="btn btn-primary">Update Profile</button> --}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        {{-- <a href="{{ url('refunduserdeposit/' . $userdeposit->id) }}"
                            class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#refunduserdepositModal{{ $userdeposit->id }}"><i class="fa fa-reply"></i>Refund</a> --}}

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="{{ url('profile/' . $id) }}"
                                class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#profileModal{{ $id }}">
                                {{-- <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $name }}</span> --}}
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('newuserdashboard/img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            {{-- <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout
                                </a>
                            </div> --}}
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('newuser-section')

                <br>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    {{-- <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a> --}}

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ url('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    {{-- JS User Backend UI --}}
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('newuserdashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('newuserdashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('newuserdashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('newuserdashboard/js/sb-admin-2.min.js') }}"></script>

    <!-- Modal JavaScript -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    {{-- Count JS --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/get-booking-counts')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    updateBookingCount('resort', data.resortCount);
                    updateBookingCount('hotel', data.hotelCount);
                    updateBookingCount('restaurant', data.restaurantCount);
                })
                .catch(error => {
                    console.error('Error fetching booking counts:', error);
                });

            function updateBookingCount(type, count) {
                var countElement = document.getElementById(type + '-booked-count');
                if (countElement) {
                    countElement.textContent = count;
                }
            }
        });
    </script> --}}



    {{-- Open and Down Navbar --}}
    {{-- <script>
        // 获取要控制的元素
        var userDropdown = document.querySelector('#userDropdown');
        var userDropdownMenu = document.querySelector('.dropdown-menu');

        // 添加点击事件监听器
        userDropdown.addEventListener('click', function (event) {
            event.preventDefault(); // 防止链接的默认行为

            // 检查下拉菜单的状态
            if (userDropdownMenu.classList.contains('show')) {
                // 如果下拉菜单已展开，则关闭它
                userDropdownMenu.classList.remove('show');
            } else {
                // 如果下拉菜单已关闭，则展开它
                userDropdownMenu.classList.add('show');
            }
        });

        // 为了在其他地方点击时关闭下拉菜单，添加全局点击事件监听器
        document.addEventListener('click', function (event) {
            if (!userDropdown.contains(event.target)) {
                // 如果点击事件不在用户下拉菜单内部，关闭下拉菜单
                userDropdownMenu.classList.remove('show');
            }
        });

    </script> --}}

    <!-- JS Table Files -->
    <!-- Add the necessary JavaScript files here -->
    {{-- <script src="{{ asset('table/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('table/assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('table/assets/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('table/assets/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('table/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('table/assets/js/custom.js') }}"></script> --}}

    <script>
        // =============  Data Table - (Start) ================= //
        // $(document).ready(function() {
        //     var table = $('#example').DataTable();

        //     // Destroy the existing DataTable instance
        //     table.destroy();

        //     // Now, you can reinitialize the DataTable with new settings or data
        //     $('#example').DataTable({
        //         buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        //     });
        // });

        // =============  Data Table - (End) ================= //
    </script>

</body>

</html>
