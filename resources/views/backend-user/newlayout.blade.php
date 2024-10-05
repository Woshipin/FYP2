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
                    aria-expanded="true" aria-controls="MyPlace">
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
                    aria-expanded="true" aria-controls="CustomerBooked">
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
                    aria-expanded="true" aria-controls="MyHasBooked">
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
                <a class="nav-link" href="{{ url('viewusercontact') }}">
                    <i class="fas fa-address-book"></i>
                    <span>User Contact</span></a>
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

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

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

                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="{{ url('profile/' . $id) }}"
                                class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#profileModal{{ $id }}">
                                {{-- <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $name }}</span> --}}
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('newuserdashboard/img/undraw_profile.svg') }}">
                            </a>

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

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    {{-- JS User Backend UI --}}
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('newuserdashboard/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('newuserdashboard/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('newuserdashboard/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('newuserdashboard/js/sb-admin-2.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</body>

</html>
