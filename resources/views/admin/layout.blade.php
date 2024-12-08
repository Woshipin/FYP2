<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('admin/style.css') }}">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Excel Modal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- 包含 Font Awesome 的 CSS 文件 Chart CSS Color-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Custom styles for this Charts template-->
    <link href="{{ asset('charts/chart.css') }}" rel="stylesheet">

    {{-- CRSF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- 引入 jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>M<span>odern</span></h3>
        </div>

        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(img/3.jpeg)"></div>
                @php
                    $adminId = session('loginId');
                    $adminName = session('loginName');
                @endphp

                {{-- <h6 style="color:white;">Admin ID : {{ $adminId }}</h6> --}}

                <h6 style="color:white;">Admin Name: {{ $adminName }} </h6>

            </div>

            <div class="side-menu">
                <ul>
                    <li>
                        <a href="{{ url('/admin/dashboard') }}" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/wallet') }}" class="active">
                            <span class="las la-wallet"></span>
                            <small>Admin Wallet</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/showStaff') }}">
                            <span class="las la-user-tie"></span>
                            <small>Staff</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/showfacilities') }}">
                            <span class="las la-user-tie"></span>
                            <small>Facilities</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/community') }}">
                            <span class="fas fa-globe"></span>
                            <small>Community Category</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/Resorts') }}">
                            <span class="fas fa-umbrella-beach"></span>
                            <small>Resort</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/Hotels') }}">
                            <span class="fas fa-hotel"></span>
                            <small>Hotel</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/Restaurants') }}">
                            <span class="fas fa-utensils"></span>
                            <small>Restaurant</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/Tables') }}">
                            <span class="fas fa-table"></span>
                            <small>Table</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/Rooms') }}">
                            <span class="fas fa-bed"></span>
                            <small>Room</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/genders') }}">
                            <span class="fas fa-venus-mars"></span>
                            <small>Gender</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/contact') }}">
                            <span class="las la-envelope"></span>
                            <small>Contact</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/logout') }}">
                            <span class="fas fa-sign-out-alt"></span>
                            <small>Logout</small>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">

        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>

                <div class="header-menu">
                    <label for="">
                        <span class="las la-search"></span>
                    </label>

                    <a href="{{ url('/admin/contact') }}" style="display: inline-block;">
                        <div class="notify-icon">
                            <span class="las la-envelope"></span>
                            <span class="notify">{{ App\Models\Contact::count() }}</span>
                        </div>
                    </a>

                    <a href="{{ url('/admin/contact') }}" style="display: inline-block;">
                        <div class="notify-icon">
                            <span class="las la-bell"></span>
                            <span class="notify">{{ App\Models\Contact::count() }}</span>
                        </div>
                    </a>

                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>

                        <span class="las la-power-off"></span>
                        <a href="{{ url('admin/logout') }}"><span>Logout</span></a>
                    </div>
                </div>
            </div>
        </header>

        @yield('admin-section')

    </div>

    <!-- Modal JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    <!-- Excel Modal -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Read Excel JS -->
    <!-- <script src="{{ asset('js/read.js') }}"></script> -->

    {{-- Toastr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        @if (Session::has('success'))
            Toastify({
                text: "{{ Session::get('success') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)"
                }
            }).showToast();
        @elseif (Session::has('fail'))
            Toastify({
                text: "{{ Session::get('fail') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #b90000, #c99396)"
                }
            }).showToast();
        @endif

        @if (Session::has('error'))
            Toastify({
                text: "{{ Session::get('error') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #b90000, #c99396)"
                }
            }).showToast();
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toastify({
                    text: "{{ $error }}",
                    duration: 10000,
                    style: {
                        background: "linear-gradient(to right, #b90000, #c99396)"
                    }
                }).showToast();
            @endforeach
        @endif
    </script>

</body>

</html>
