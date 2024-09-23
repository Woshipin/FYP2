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
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 1500px;
            width: 100%;
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

        .upload-form,
        .gps-button,
        .search-bar {
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
            width: 50%;
            padding: 6px;
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

        .gps-button button,
        .search-bar input {
            width: 100%;
            padding: 16px;
            border-radius: 15px;
            border: none;
            font-size: 16px;
            margin-top: 10px;
        }

        .gps-button button {
            background: var(--blue);
            color: #fff;
            cursor: pointer;
            transition: all .3s ease;
        }

        .gps-button button:hover {
            background: var(--dark-blue);
        }

        .search-bar input {
            border: 1px solid #ccc;
        }

        :root {
            --blue: #007bff;
            --dark-blue: #0056b3;
            --grey: #f8f9fa;
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
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var restaurants = @json($restaurant);

            if (!Array.isArray(restaurants)) {
                console.error('Restaurants is not an array');
            }

            // Initialize map centered on Malaysia
            var map = L.map('map').setView([4.2105, 101.9758], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Function to update map markers based on restaurants array
            function updateMapMarkers(restaurants) {
                map.eachLayer(function (layer) {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                });

                restaurants.forEach(function(restaurants) {
                    var mapIframe = restaurants.map;
                    var coordinates = getCoordinatesFromIframe(mapIframe);
                    if (coordinates) {
                        L.marker([coordinates.lat, coordinates.lng]).addTo(map)
                            .bindPopup('<b>' + restaurants.name + '</b><br>' + restaurants.address);
                    }
                });
            }

            // Extract coordinates from iframe URL
            function getCoordinatesFromIframe(iframe) {
                var match = iframe.match(/!2d([-0-9.]+)!3d([-0-9.]+)/);
                if (match) {
                    return {
                        lat: parseFloat(match[2]),
                        lng: parseFloat(match[1])
                    };
                }
                return null;
            }

            // Initial load of all hotel markers
            updateMapMarkers(restaurants);

            // Function to filter restaurants based on search input
            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var filteredRestaurants = restaurants.filter(function(hotel) {
                    return hotel.name.toLowerCase().includes(searchInputValue) ||
                           hotel.country.toLowerCase().includes(searchInputValue) ||
                           hotel.state.toLowerCase().includes(searchInputValue) ||
                           hotel.address.toLowerCase().includes(searchInputValue) ||
                           hotel.description.toLowerCase().includes(searchInputValue);
                });

                updateMapMarkers(filteredRestaurants);
                updateSearchResults(filteredRestaurants);
            }

            // Function to update search results
            function updateSearchResults(filteredRestaurants) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = '';

                if (filteredRestaurants.length > 0) {
                    filteredRestaurants.forEach(function(hotel) {
                        var hotelHTML = '<div class="hotel-result">' +
                            '<h2>' + hotel.name + '</h2>' +
                            '<p>' + hotel.address + ', ' + hotel.state + ', ' + hotel.country + '</p>' +
                            '<p>' + hotel.description + '</p>' +
                            '</div>';
                        resultsContainer.innerHTML += hotelHTML;
                    });
                } else {
                    resultsContainer.innerHTML = '<p>No Restaurants Found</p>';
                }
            }

            // Attach event listener to search input
            document.getElementById('searchInput').addEventListener('input', performSearch);
        });
    </script> --}}

    {{-- Real Time Search --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateSearchResults(filteredRestaurants) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = '';

                if (filteredRestaurants.length > 0) {
                    filteredRestaurants.forEach(function(restaurant) {
                        var isDisabled = restaurant.status === 1;

                        const restaurantId = restaurant.id;
                        var restaurantName = restaurant.name;
                        var restaurantAddress = restaurant.address;
                        var restaurantState = restaurant.state;
                        var restaurantCountry = restaurant.country;
                        var restaurantImage = restaurant.image;
                        var restaurantDescription = restaurant.description;

                        var restaurantImageSrc = restaurantImage ? '{{ asset('images/') }}/' + restaurantImage : 'path/to/placeholder-image.jpg';
                        var restaurantAltText = restaurantImage ? 'Image' : 'No Image';

                        var restaurantHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') + '">' +
                            '<div class="wishlist-button-container">' +
                            '<div class="concert-main" id="restaurantcard_' + restaurantId + '">' +
                            '<img class="concert-image" src="' + restaurantImageSrc + '" alt="' + restaurantAltText + '" />' +
                            '<h2 class="concert-title">' + restaurantName + ' <i class="fas fa-restaurant"></i></h2>' +
                            '<p class="concert-description"><i class="fas fa-info-circle"></i> ' + restaurantDescription + '</p>' +
                            '<hr />' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="fas fa-map-marker-alt">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' + restaurantAddress + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' + restaurantState + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' + restaurantCountry + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-info">' +
                            '<div class="concert-action-container">' +
                            (isDisabled ? '<p>' + new Date().toLocaleString('en-US', { timeZone: 'Asia/Kuala_Lumpur' }) + '</p>' +
                                '<a href="{{ url('Restaurantdetail/') }}/' + restaurantId + '/view" class="concert-action disabled">Closed</a>' :
                                '<p>' + new Date().toLocaleString('en-US', { timeZone: 'Asia/Kuala_Lumpur' }) + '</p>' +
                                '<div class="wishlist-button-container">' +
                                '<form id="wishlistForm" action="{{ url('/wishlist/add/restaurant') }}/' + restaurantId + '" method="POST">' +
                                '@csrf<button type="submit" id="wishlist" class="concert-action">Wishlist</button></form>' +
                                '</div>' +
                                '<a href="{{ url('Restaurantdetail/') }}/' + restaurantId + '/view" class="concert-action" id="viewrestaurant' + restaurantId + '">Book Now</a>'
                            ) +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        resultsContainer.innerHTML += restaurantHTML;
                    });
                } else {
                    resultsContainer.innerHTML = '<p style="margin-top:40px; font-size:24px; display:block">No Restaurants Found</p>';
                }
            }

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value;

                fetch(`{{ route('restaurantsearch') }}?search=${searchInputValue}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        updateSearchResults(data);
                    })
                    .catch(error => console.error('Error:', error));
            }

            document.getElementById('searchInput').addEventListener('input', performSearch);

            // Initial load
            var initialRestaurants = <?php echo json_encode($restaurant); ?>;
            updateSearchResults(initialRestaurants);
        });
    </script> --}}

    {{-- // Full Image Search Function --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('imageUploadForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch('{{ route("uploadAndSearchRestaurants") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    updateSearchResults(data);
                })
                .catch(error => console.error('Error:', error));
            });

            function updateSearchResults(filteredRestaurants) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = '';

                if (filteredRestaurants.length > 0) {
                    filteredRestaurants.forEach(function(restaurant) {
                        var isDisabled = restaurant.status === 1;

                        var restaurantHTML = `
                            <div class="concert ${isDisabled ? 'disabled' : ''}">
                                <div class="wishlist-button-container">
                                    <div class="concert-main" id="restaurantcard_${restaurant.id}">
                                        <img class="concert-image" src="{{ asset('images/') }}/${restaurant.image}" alt="${restaurant.image ? 'Image' : 'No Image'}" />
                                        <h2 class="concert-title">${restaurant.name} <i class="fas fa-utensils"></i></h2>
                                        <p class="concert-description"><i class="fas fa-info-circle"></i> ${restaurant.description}</p>
                                        <hr />
                                        <div class="concert-creator">
                                            <p style="color:#000000; font-family: 'Oswald', sans-serif;">
                                                <i class="fas fa-map-marker-alt">
                                                    <span style="color: #000000; font-size:18px;font-family: 'Oswald', sans-serif;">${restaurant.address}</span>
                                                </i>
                                            </p>
                                        </div>
                                        <div class="concert-creator">
                                            <p style="color:#000000; font-family: 'Oswald', sans-serif;">
                                                <i class="bi bi-geo-alt-fill">
                                                    <span style="color: #000000; font-size:18px;font-family: 'Oswald', sans-serif;">${restaurant.state}</span>
                                                </i>
                                            </p>
                                        </div>
                                        <div class="concert-creator">
                                            <p style="color:#000000; font-family: 'Oswald', sans-serif;">
                                                <i class="bi bi-geo-alt-fill">
                                                    <span style="color: #000000; font-size:18px;font-family: 'Oswald', sans-serif;">${restaurant.country}</span>
                                                </i>
                                            </p>
                                        </div>
                                        <div class="concert-info">
                                            <div class="concert-action-container">
                                                ${isDisabled ? `
                                                    <p>${new Date().toLocaleString('en-US', { timeZone: 'Asia/Kuala_Lumpur' })}</p>
                                                    <a href="{{ url('Restaurantdetail/') }}/${restaurant.id}/view" class="concert-action disabled">Closed</a>
                                                ` : `
                                                    <p>${new Date().toLocaleString('en-US', { timeZone: 'Asia/Kuala_Lumpur' })}</p>
                                                    <div class="wishlist-button-container">
                                                        <form id="wishlistForm" action="{{ url('/wishlist/add/restaurant') }}/${restaurant.id}" method="POST">
                                                            @csrf
                                                            <button type="submit" id="wishlist" class="concert-action">Wishlist</button>
                                                        </form>
                                                    </div>
                                                    <a href="{{ url('Restaurantdetail/') }}/${restaurant.id}/view" class="concert-action" id="viewrestaurant${restaurant.id}">Book Now</a>
                                                `}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        resultsContainer.innerHTML += restaurantHTML;
                    });
                } else {
                    alert('Image not found');
                }
            }
        });
    </script> --}}

    {{-- Image Search and display Google map position function --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var restaurants = <?php echo json_encode($restaurant); ?>;

            // 初始化地图函数
            function initMap() {
                if (map === null) {
                    map = L.map('map').setView([4.2105, 101.9758], 7);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                }
            }

            // 更新地图标记函数
            function updateMapMarkers(restaurants) {
                if (map === null) {
                    console.error('地图尚未初始化');
                    return;
                }

                markers.forEach(function(marker) {
                    map.removeLayer(marker);
                });
                markers = [];

                if (Array.isArray(restaurants)) {
                    restaurants.forEach(function(restaurant) {
                        var mapIframe = restaurant.map;
                        var coordinates = getCoordinatesFromIframe(mapIframe);
                        if (coordinates) {
                            var marker = L.marker([coordinates.lat, coordinates.lng]).addTo(map)
                                .bindPopup('<b>' + restaurant.name + '</b><br>' + restaurant.address +
                                    '<br>' + restaurant.state);
                            markers.push(marker);
                        }
                    });
                } else {
                    console.error('Expected an array of restaurants but received:', restaurants);
                }
            }

            // 从 iframe URL 提取坐标函数
            function getCoordinatesFromIframe(iframe) {
                var match = iframe.match(/!2d([-0-9.]+)!3d([-0-9.]+)/);
                if (match) {
                    return {
                        lat: parseFloat(match[2]),
                        lng: parseFloat(match[1])
                    };
                }
                return null;
            }

            // 更新搜索结果函数
            function updateSearchResults(filteredRestaurants) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty(); // Clear existing content

                if (Array.isArray(filteredRestaurants) && filteredRestaurants.length > 0) {
                    filteredRestaurants.forEach(function(restaurant) {
                        if (restaurant.register_status === 1) {
                            var isDisabled = restaurant.status === 1;
                            var restaurantImages = restaurant.images || []; // Default to empty array

                            // Display only the first image
                            var firstImageHTML = restaurantImages.length > 0 && restaurantImages[0].image ?
                                `<img class="concert-image" src="{{ asset('images/') }}/${restaurantImages[0].image}" alt="Image" />` :
                                `<img class="concert-image" src="path/to/placeholder-image.jpg" alt="No Image" />`;

                            var restaurantHTML = `
                                <div class="concert ${isDisabled ? 'disabled' : ''}">
                                    <div class="concert-main" id="restaurantcard_${restaurant.id}">
                                        ${firstImageHTML} <!-- Display only the first image here -->
                                        <div class="concert-content">
                                            <h2 class="concert-title">
                                                <i class="fas fa-utensils"></i> ${restaurant.name}
                                            </h2>
                                            <p class="concert-description">
                                                <i class="fas fa-info-circle"></i> ${restaurant.description}
                                            </p>
                                            <div class="concert-creator">
                                                <p><i class="fas fa-map-marker-alt"></i> ${restaurant.address}</p>
                                            </div>

                                            <div class="concert-action-container">
                                                <p>${new Date().toLocaleString('en-US', {
                                                    timeZone: 'Asia/Kuala_Lumpur'
                                                })}</p>
                                                ${isDisabled ?
                                                    `<a href="{{ url('Restaurantdetail/') }}/${restaurant.id}/view" class="concert-action disabled">Closed</a>` :
                                                    `<form id="wishlistForm" action="{{ url('/wishlist/add/restaurant') }}/${restaurant.id}" method="POST">
                                                            @csrf
                                                            <button type="submit" id="wishlist" class="concert-action"><i class="fas fa-heart"></i> Wishlist</button>
                                                        </form>
                                                        <a href="{{ url('Restaurantdetail/') }}/${restaurant.id}/view" class="concert-action" id="viewrestaurant${restaurant.id}">Book Now</a>`
                                                }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            resultsContainer.append(restaurantHTML);
                        }
                    });
                } else {
                    resultsContainer.html(
                        '<p style="margin-top:40px; font-size:24px; display:block">No Restaurants Found</p>');
                }
            }


            // 执行搜索函数
            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var filteredRestaurants = restaurants.filter(function(restaurant) {
                    return (restaurant.name && restaurant.name.toLowerCase().includes(searchInputValue)) ||
                        (restaurant.country && restaurant.country.toLowerCase().includes(
                        searchInputValue)) ||
                        (restaurant.state && restaurant.state.toLowerCase().includes(searchInputValue)) ||
                        (restaurant.address && restaurant.address.toLowerCase().includes(
                        searchInputValue)) ||
                        (restaurant.description && restaurant.description.toLowerCase().includes(
                            searchInputValue));
                });

                // 更新地图标记和搜索结果
                updateMapMarkers(filteredRestaurants);
                updateSearchResults(filteredRestaurants);
            }

            // 监听搜索输入变化
            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            // 监听图片上传表单提交事件
            document.getElementById('imageUploadForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

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
                        console.log('上传和搜索数据:', data); // Log the data from upload and search
                        if (Array.isArray(data)) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.error('获取的数据不是数组:', data);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            // 初始化地图
            initMap();

            // 页面加载时显示所有餐馆
            if (Array.isArray(restaurants)) {
                updateMapMarkers(restaurants);
                updateSearchResults(restaurants);
            } else {
                console.error('restaurants is not an array:', restaurants);
            }

            // 获取附近餐馆函数
            function fetchNearbyRestaurants(latitude, longitude) {
                fetch(`/gps-search?latitude=${latitude}&longitude=${longitude}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('附近餐馆数据:', data); // 调试输出
                        if (Array.isArray(data)) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.error('获取的数据不是数组:', data);
                        }
                    })
                    .catch(error => console.error('获取附近餐馆时发生错误:', error));
            }

            // 监听打开GPS按钮点击事件
            document.getElementById('openGPSButton').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        if (map === null) {
                            initMap();
                        }
                        var userMarker = L.marker([latitude, longitude], {
                                color: 'red'
                            }).addTo(map)
                            .bindPopup('<b>您在这里</b>').openPopup();
                        map.setView([latitude, longitude], 10);
                        markers.push(userMarker);

                        fetchNearbyRestaurants(latitude, longitude);
                    }, function(error) {
                        console.error('地理定位错误:', error);
                    });
                } else {
                    console.error('此浏览器不支持地理定位。');
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

@endsection
