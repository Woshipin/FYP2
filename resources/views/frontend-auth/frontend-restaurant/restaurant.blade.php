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

    {{-- No Image CSS --}}
    <style>
        .no-image-box {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 150px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            color: #555;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
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

    {{-- New Bar Image,GPS and Search CSS --}}
    <style>
        .custom-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .upload-section {
            margin-bottom: 2rem;
        }

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-upload-input {
            position: absolute;
            font-size: 100px;
            opacity: 0;
            right: 0;
            top: 0;
        }

        .file-upload-label {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .file-upload-label:hover {
            background-color: #0056b3;
        }

        .image-preview {
            margin-top: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            min-height: 100px;
        }

        .btn-detect {
            width: 100%;
            margin-top: 1rem;
        }

        .action-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-gps {
            flex: 0 0 auto;
            margin-right: 1rem;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px;
            padding-right: 40px;
            border: 1px solid #ddd;
            border-radius: 20px;
            transition: box-shadow 0.3s;
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .btn {
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>

    {{-- New Restaurant Card UI CSS --}}
    <style>
        .restaurant-card {
            border-radius: 10px;
            padding: 10px;
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
            height: 600px;
            width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
            text-align: left;
            margin-bottom: 20px;
        }

        .restaurant-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.2);
            background-color: #f0f0f0;
        }

        .restaurant-image {
            width: 100%;
            height: 300px;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .restaurant-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .restaurant-image img:hover {
            transform: scale(1.1);
        }

        .restaurant-content {
            flex: 0 0 auto;
            height: 400px;
            padding: 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: left;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .restaurant-content p {
            font-size: 14px;
            color: #333;
            margin: 0 0 5px 0;
            line-height: 1.2;
            text-align: left;
        }

        .restaurant-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: left;
        }

        .restaurant-address,
        .restaurant-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .restaurant-amenities {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .restaurant-amenities span {
            font-size: 14px;
            color: #888;
        }

        .restaurant-rating {
            display: flex;
            justify-content: flex-start;
            margin-top: 10px;
        }

        .restaurant-rating i {
            font-size: 16px;
            color: gold;
        }

        .restaurant-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .restaurant-actions .actions {
            display: flex;
            align-items: center;
        }

        .restaurant-actions form {
            margin-right: 10px;
        }

        .btn {
            padding: 5px 10px;
            font-size: 14px;
            background: var(--orange);
            color: #fff;
            border: .2rem solid var(--orange);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background: rgba(255, 165, 0, .2);
            color: black;
        }

        .btn-wishlist {
            background: #f0f0f0;
            color: #333;
            border: .2rem solid #f0f0f0;
        }

        .btn-book {
            background: #4CAF50;
            color: white;
            border: .2rem solid #4CAF50;
        }

        .btn-disabled {
            background: #ccc;
            color: #666;
            border: .2rem solid #ccc;
            cursor: not-allowed;
        }

        .no-results {
            text-align: center;
            font-size: 1.2em;
            color: #666;
            margin-top: 40px;
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
            <!-- Image Upload Section -->
            <div class="upload-section">
                <form id="imageUploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="file-upload-wrapper">
                        <input type="file" name="image" id="imageInput" class="file-upload-input" required>
                        <label for="imageInput" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i> Choose an Image
                        </label>
                    </div>
                    <div class="image-preview" id="imageDisplayContainer"></div>
                    <button type="submit" class="btn btn-primary btn-detect">
                        <i class="fas fa-search"></i> Detect Image
                    </button>
                </form>
            </div>

            <!-- GPS and Search Section -->
            <div class="action-section">
                <button type="button" id="openGPSButton" class="btn btn-secondary btn-gps">
                    <i class="fas fa-map-marker-alt"></i> Open GPS
                </button>
                <div class="search-wrapper">
                    <input type="search" id="searchInput" class="search-input" placeholder="Search Resorts">
                    <i class="fas fa-search search-icon"></i>
                </div>
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

    {{-- New Full Restaurant Real Time Search, Detection Image and GPS Function --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var userMarker = null;
            var restaurants = @json($restaurant);
            var restaurantRatings = @json($restaurantRatings);

            console.log('Restaurants:', restaurants);

            // 确保 restaurants 是一个数组
            if (!Array.isArray(restaurants)) {
                restaurants = [restaurants];
            }

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
                        if (restaurant.latitude && restaurant.longitude && restaurant.register_status ===
                            1) {
                            var marker = L.marker([restaurant.latitude, restaurant.longitude]).addTo(map)
                                .bindPopup('<b>' + restaurant.name + '</b><br>' + restaurant.address +
                                    '<br>' +
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
                            var restaurantRating = restaurantRatings[restaurantId] || {
                                averageRating: 0,
                                count: 0
                            };

                            // 确保 averageRating 是有效的数字
                            var averageRating = restaurantRating.averageRating !== undefined && !isNaN(
                                restaurantRating.averageRating) ? restaurantRating.averageRating : 0;

                            // 判断是否有图片，否则使用占位符
                            var imageURL = (restaurant.image || (restaurantImages.length > 0 &&
                                    restaurantImages[0].image)) ?
                                "{{ asset('images/') }}/" + (restaurant.image || restaurantImages[0]
                                .image) :
                                null; // 没有图片时设为 null

                            var restaurantHTML = `
                    <div class="restaurant-card ${isDisabled ? 'disabled' : ''}" id="restaurantcard_${restaurantId}">
                        <div class="restaurant-image">
                            ${imageURL ? `<img src="${imageURL}" alt="${restaurantName}">` : `
                                <div class="no-image-box">
                                    <span>No Image</span>
                                </div>`}
                        </div>
                        <div class="restaurant-content">
                            <h2 class="restaurant-title">
                                <i class="fas fa-utensils"></i> ${restaurantName}
                            </h2>
                            <p class="restaurant-address">
                                <i class="fas fa-map-marker-alt"></i> ${restaurantAddress}, ${restaurantState}, ${restaurantCountry}
                            </p>
                            <p class="restaurant-description">
                                <i class="fas fa-info-circle"></i> ${restaurantDescription.length > 100 ? restaurantDescription.substring(0, 100) + '...' : restaurantDescription}
                            </p>
                            <div class="restaurant-amenities">
                                <span><i class="fas fa-wifi"></i> Free WiFi</span>
                                <span><i class="fas fa-parking"></i> Parking</span>
                            </div>
                            <div class="resort-rating">
                                ${generateStarRating(averageRating)}
                                <span>(${averageRating.toFixed(1)})</span>
                            </div>
                            <div class="restaurant-actions">
                                ${isDisabled ?
                                    '<button class="btn btn-disabled">Closed</button>' :
                                    `<div class="actions">
                                            <form id="wishlistForm_${restaurantId}" action="{{ url('/wishlist/add/restaurant') }}/${restaurantId}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" id="wishlist" class="btn btn-wishlist">
                                                    <i class="fas fa-heart"></i> Wishlist
                                                </button>
                                            </form>
                                            <a href="{{ url('Restaurantdetail/') }}/${restaurantId}/view" class="btn btn-book" id="viewrestaurant${restaurantId}">Book Now</a>
                                        </div>`
                                }
                            </div>
                        </div>
                    </div>
                `;

                            resultsContainer.append(restaurantHTML);
                        }
                    });
                } else {
                    resultsContainer.html('<p class="no-results">No Restaurants Found</p>');
                }
            }


            function generateStarRating(rating) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) {
                        stars += '<i class="fas fa-star" style="color: gold; font-size: 20px;"></i>';
                    } else if (i - 0.5 <= rating) {
                        stars += '<i class="fas fa-star-half-alt" style="color: gold; font-size: 20px;"></i>';
                    } else {
                        stars += '<i class="far fa-star" style="font-size: 20px; color: black;"></i>';
                    }
                }
                return stars;
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
                            alert('Detected image result: ' + data.length +
                                ' matching restaurants found.');
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
