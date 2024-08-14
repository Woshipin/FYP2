<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="{{asset ('admin/style.css') }}">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Excel Modal -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Google Map JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Google Map JS API KEY -->
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG2YHIuPJYMOJzS6wSw5eZ0dTYXnhZFLs&libraries=places"></script> -->
    <!-- Map JS -->
    <!-- <script src="map.js"></script> -->

    <!-- <script type="text/javascript">

        $(document).ready(function(){
            var autocomplete;
            var to = 'location';

            autocomplete = new google.maps.places.Autocomplete((document.getElementById(to)),{
                types:['geocode'],
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function(){

                var near_place = autocomplete.getPlace();

                jQuery("#latitude").val( near_place.geometry.location.lat() );
                jQuery("#longitude").val( near_place.geometry.location.lng() );

            });
        });

        //map code start

        // function showMap(lat,long){

        //     var coord = { lat:lat, lng:long };

        //     var map = new google.maps.Map(
        //         document.getElementById("map"),
        //         {
        //             zoom: 10,
        //             center: coord
        //         }
        //     );

        //     new google.maps.Marker({
        //         position:coord,
        //         map:map
        //     });
        // }

        // showMap(0,0);
    </script> -->



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
                    $id = Auth::id();
                    $name = Auth::user()->name;
                @endphp

                <h6 style="color:white;">User ID : {{ $id }}</h6>

                <h6 style="color:white;">User Name: {{ $name }} </h6>

            </div>

            <div class="side-menu">
                <ul>
                    <li>
                       <a href="{{ url('/users/dashboard/{id}') }}" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="{{ url('/showResort') }}">
                            <span class="las la-user-alt"></span>
                            <small>Resort</small>
                        </a>
                    </li>
                    <li>
                       <a href="">
                            <span class="las la-envelope"></span>
                            <small>Hotel</small>
                        </a>
                    </li>
                    <li>
                       <a href="{{ url('showRestaurant') }}">
                            <span class="las la-clipboard-list"></span>
                            <small>Restaurant</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('showTable') }}">
                            <span class="las la-shopping-cart"></span>
                            <small>Table</small>
                        </a>
                    </li>
                     <li>
                        <a href="{{ url('bookingsrestaurant') }}">
                            <span class="las la-shopping-cart"></span>
                            <small>Bookings</small>
                        </a>
                    </li>
                    <li>
                       <a href="">
                            <span class="las la-shopping-cart"></span>
                            <small>Contact</small>
                        </a>
                    </li>
                    <li>
                       <a href="{{ url('logout') }}">
                            <span class="las la-tasks"></span>
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

                    <div class="notify-icon">
                        <span class="las la-envelope"></span>
                        <span class="notify">4</span>
                    </div>

                    <div class="notify-icon">
                        <span class="las la-bell"></span>
                        <span class="notify">3</span>
                    </div>

                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>

                        <span class="las la-power-off"></span>
                        <a href="{{ url('logout') }}"><span>Logout</span></a>
                    </div>
                </div>
            </div>
        </header>

        @yield('user-section')

    </div>

    <!-- Modal JavaScript -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


    <!-- Read Excel JS -->
    <script src = "{{ asset ('js/read.js') }}"></script>
</body>
</html>
