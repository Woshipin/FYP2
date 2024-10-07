@extends('frontend-auth.newlayout')

@section('frontend-section')
    {{-- HotelStatus Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('66e2c17903cc96af1475', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('hotelstatus');
        channel.bind('hotel-status', function() {
            window.location.reload();
        });
    </script>

    {{-- Pusher Disabled CSS --}}
    <style>
        /* Style for disabled hotel cards */
        .disabled {
            opacity: 0.5;
            /* Reduce opacity to indicate disabled state */
            pointer-events: none;
            /* Disable pointer events */
        }

        /* Additional CSS styles for your hotel cards */
        .box {
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
        }
    </style>

    {{-- Search CSS --}}
    <style>
        /* Target the input group */
        .input-group {
            /* Set the display property to flex */
            display: flex;
            /* Align the items (input and button) to the right */
            justify-content: flex-end;
        }
    </style>

    {{-- Wishlist UI CSS --}}
    <style>
        #wishlist {
            /* color: rgb(255, 183, 0); */
            color: black;
        }

        #wishlist {
            margin-right: 10px;
        }

        #wishlist:hover {
            color: red;
        }
    </style>

    {{-- Hotel Card CSS --}}
    <link rel="stylesheet" href="{{ asset('new/card/restaurantcard.css') }}">

    {{-- Mutliple Location Google Map CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>

    {{-- Image,GPS and Search CSS --}}
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 1500px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .custom-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .upload-form {
            width: 30%;
        }

        .upload-form input[type="file"] {
            display: none;
        }

        .upload-form label {
            display: block;
            width: 100%;
            padding: 16px;
            border-radius: 15px;
            background: var(--blue);
            color: #fff;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all .3s ease;
        }

        .upload-form label:hover {
            background: var(--dark-blue);
        }

        .upload-form button {
            width: 100%;
            padding: 16px;
            border-radius: 15px;
            background: var(--blue);
            color: #fff;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all .3s ease;
            margin-top: 10px;
        }

        .upload-form button:hover {
            background: var(--dark-blue);
        }

        .image-display-container {
            /* margin-top: 20px; */
            border: 2px solid black;
            padding: 10px;
            min-height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        :root {
            --blue: #007bff;
            --dark-blue: #0056b3;
        }
    </style>

    <br><br><br>

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay" style="height: 200px;">
        <div class="bg-overlay">
            <video autoplay muted loop playsinline class="bg-video">
                <source src="{{ asset('new/img/vid-3.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="bradcumbContent">
            <p>See what's new</p>
            <h2>Restaurant</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <br>

    {{-- Google Map --}}
    <div id="map"></div>

    <br>

    {{-- Detection Image, Real Time Search and GPS --}}
    <div class="container">
        <div class="custom-container">

            <!-- Image Upload Form -->
            <div class="upload-form">
                <form id="imageUploadForm" enctype="multipart/form-data">
                    @csrf
                    <label for="imageInput">Select Image</label>
                    <input type="file" name="image" id="imageInput" required>
                    <div class="image-display-container" id="imageDisplayContainer"></div>
                    <button type="submit" class="btn btn-primary">Detect Image</button>
                </form>
            </div>

            <!-- Open GPS Button -->
            <div class="gps-button">
                <button type="button" name="gps" id="openGPSButton" class="btn btn-primary">Open GPS</button>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <input type="search" name="search" id="searchInput" class="form-control" placeholder="Search Restaurants">
            </div>

        </div>
    </div>

    <br>

    <!-- ##### Latest Concerts Area Start ##### -->
    <div class="concert-container" id="searchResultsContainer">
        <!-- Results will be dynamically updated here -->
    </div>
    <!-- ##### Latest Concerts Area End ##### -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-42P7F5KveI1Gq6Hp0EUa4Hi/4D8Qxhgzqj/vbduG91o=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- For SVG JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"
        integrity="sha512-TF+R3eFU2x7q+uAqq6I7/Pcx+4zITAdWu6T51t4xt2cTFBrhsVc0pmOXdH5RufRYAbD5HJym2e8s/kI6By9iWg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Mutliple Location Google Map JS --}}
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    {{-- New Full Real Time Search, Detection Image and GPS Function --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var userMarker = null;
            var restaurants = <?php echo json_encode($restaurant); ?>;

            function initMap() {
                if (map === null) {
                    map = L.map('map').setView([4.2105, 101.9758], 7);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                }
            }

            function updateMapMarkers(restaurants) {
                if (map === null) {
                    console.error('Map not initialized');
                    return;
                }

                markers.forEach(function(marker) {
                    if (marker !== userMarker) {
                        map.removeLayer(marker);
                    }
                });
                markers = markers.filter(marker => marker !== userMarker);

                if (Array.isArray(restaurants)) {
                    restaurants.forEach(function(restaurant) {
                        if (restaurant.latitude && restaurant.longitude && restaurant.register_status === 1) {
                            var marker = L.marker([restaurant.latitude, restaurant.longitude]).addTo(map)
                                .bindPopup('<b>' + restaurant.name + '</b><br>' + restaurant.address + '<br>' +
                                    restaurant.price);
                            markers.push(marker);
                        }
                    });
                } else {
                    console.error('Expected an array of restaurants but received:', restaurants);
                }
            }

            function updateSearchResults(filteredRestaurants) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty();

                if (Array.isArray(filteredRestaurants) && filteredRestaurants.length > 0) {
                    filteredRestaurants.forEach(function(restaurant) {
                        if (restaurant.register_status === 1) {
                            var isDisabled = restaurant.status === 1;
                            const restaurantId = restaurant.id;
                            var restaurantName = restaurant.name;
                            var restaurantAddress = restaurant.address;
                            var restaurantState = restaurant.state;
                            var restaurantCountry = restaurant.country;
                            var restaurantDescription = restaurant.description;
                            var restaurantImages = restaurant.images || [];

                            var imageURL = (restaurant.image || (restaurantImages.length > 0 && restaurantImages[0]
                                    .image)) ?
                                "{{ asset('images/') }}/" + (restaurant.image || restaurantImages[0].image) :
                                "{{ asset('images/placeholder-image.jpg') }}";

                            var imageHTML =
                                `<img class="concert-image" src="${imageURL}" alt="${restaurantName}" />`;

                            var restaurantHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') +
                                '">' +
                                '<div class="concert-main" id="restaurantcard_' + restaurantId + '">' +
                                imageHTML +
                                '<div class="concert-content">' +
                                '<h2 class="concert-title">' +
                                '<i class="fas fa-utensils"></i> ' + restaurantName + ' ' +
                                '</h2>' +
                                '<p class="concert-description">' +
                                '<i class="fas fa-info-circle"></i> ' + restaurantDescription +
                                '</p>' +
                                '<div class="concert-creator">' +
                                '<p><i class="fas fa-map-marker-alt"></i> ' + restaurantAddress + '</p>' +
                                '</div>' +
                                '<div class="concert-action-container">' +
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                (isDisabled ?
                                    '<a href="{{ url('Restaurantdetail/') }}/' + restaurantId +
                                    '/view" class="concert-action disabled">Closed</a>' :
                                    '<form id="wishlistForm" action="{{ url('/wishlist/add/restaurant') }}/' +
                                    restaurantId + '" method="POST">' +
                                    '@csrf<button type="submit" id="wishlist" class="concert-action"><i class="fas fa-heart"></i> Wishlist</button></form>' +
                                    '<a href="{{ url('Restaurantdetail/') }}/' + restaurantId +
                                    '/view" class="concert-action" id="viewrestaurant' + restaurantId +
                                    '">Book Now</a>'
                                ) +
                                '</div>' +
                                '</div>' +
                                '</div>';

                            resultsContainer.append(restaurantHTML);
                        }
                    });
                } else {
                    resultsContainer.html(
                        '<p style="margin-top:40px; font-size:24px; display:block">No Restaurants Found</p>');
                }
            }

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var filteredRestaurants = restaurants.filter(function(restaurant) {
                    return restaurant.name.toLowerCase().includes(searchInputValue) ||
                        restaurant.country.toLowerCase().includes(searchInputValue) ||
                        restaurant.state.toLowerCase().includes(searchInputValue) ||
                        restaurant.address.toLowerCase().includes(searchInputValue) ||
                        restaurant.description.toLowerCase().includes(searchInputValue);
                });

                updateMapMarkers(filteredRestaurants);
                updateSearchResults(filteredRestaurants);
            }

            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            document.getElementById('imageUploadForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                var fileInput = document.getElementById('imageInput');
                if (!fileInput || !fileInput.files || !fileInput.files[0]) {
                    console.error('No file selected');
                    return;
                }

                fetch('{{ route('uploadAndSearchRestaurants') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Upload and search data:', data);

                        if (Array.isArray(data) && data.length > 0) {
                            alert('Detected image result: ' + data.length + ' matching restaurants found.');
                        } else {
                            alert('Detected image result: No matching restaurants found.');
                        }

                        if (Array.isArray(data) && data.length > 0) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.log('No matching restaurants found');
                            updateSearchResults([]);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error occurred during image upload and search.');
                        updateSearchResults([]);
                    });
            });

            initMap();

            if (Array.isArray(restaurants)) {
                updateMapMarkers(restaurants);
                updateSearchResults(restaurants);
            } else {
                console.error('restaurants is not an array:', restaurants);
            }

            function fetchNearbyRestaurants(latitude, longitude) {
                fetch(`/restaurant-gps-search?latitude=${latitude}&longitude=${longitude}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Nearby restaurants data:', data);
                        if (Array.isArray(data)) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => console.error('Error fetching nearby restaurants:', error));
            }

            document.getElementById('openGPSButton').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        if (map === null) {
                            initMap();
                        }

                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }
                        userMarker = L.marker([latitude, longitude]).addTo(map)
                            .bindPopup('<b>You are here</b>').openPopup();
                        markers.push(userMarker);

                        var searchRadius = L.circle([latitude, longitude], {
                            color: 'red',
                            fillColor: '#f03',
                            fillOpacity: 0.5,
                            radius: 150000
                        }).addTo(map);

                        map.setView([latitude, longitude], 10);

                        fetchNearbyRestaurants(latitude, longitude);
                    }, function(error) {
                        console.error('Geolocation error:', error);
                    });
                } else {
                    console.error('This browser does not support geolocation.');
                }
            });
        });
    </script>

    {{-- Pusher JS Disabled Function --}}
    <script>
        // JavaScript code here to disable resort cards based on status
        let restaurantcard_; // Declare the variable outside of the loop
        let viewrestaurant;

        @foreach ($restaurant as $restaurants)
            @if ($restaurants->status == 1)
                // Get the resort card element for the current resort
                restaurantcard_ = document.getElementById('restaurantcard_{{ $restaurants->id }}');
                viewrestaurant = document.getElementById('viewrestaurant{{ $restaurants->id }}');

                // Add the "disabled" class to style and disable the card
                restaurantcard_.classList.add('disabled');

                // Remove the "disabled" attribute from the View Detail button
                viewrestaurant.removeAttribute('disabled');
            @else
                // Remove the "disabled" class from the card
                // restaurantcard_.classList.remove('disabled');
                // Add the "disabled" attribute to the View Detail button
                // viewrestaurant.setAttribute('disabled', 'disabled');
            @endif
        @endforeach
    </script>

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
    </script>

    {{-- Show User Upload Image --}}
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#imageInput').change(function(event) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement("img");
                    img.src = e.target.result;
                    img.style.maxWidth = "100%";
                    img.style.maxHeight = "100%";
                    document.getElementById("imageDisplayContainer").innerHTML = '';
                    document.getElementById("imageDisplayContainer").appendChild(img);
                };
                reader.readAsDataURL(event.target.files[0]);
            });
        });
    </script>

@endsection
