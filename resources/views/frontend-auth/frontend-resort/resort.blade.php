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
        .concert-main {
            color: #C9C3C2;
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
            color: rgb(0, 0, 0);
        }

        #wishlist {
            margin-right: 10px;
        }

        #wishlist:hover {
            color: red;
        }
    </style>

    {{-- Resort Card CSS --}}
    <link rel="stylesheet" href="{{ asset('new/card/resortcard.css') }}">

    {{-- Card Flexible --}}
    {{-- <style>
        .concert {
            width: 500px;
            height: 650px;
            border: 1px solid #d2d2d2;
            background-color: #f0f0f0;
            background: linear-gradient(0deg, #0f0f0f 0%, #faf9f9 100%);
            box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
            overflow: hidden;
            transition: .5s all;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .concert img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .concert-main {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .concert-title {
            font-size: 1.5em;
            margin-bottom: 10px;
            color: #ffdb49 !important;
        }

        .concert-description {
            font-size: 1em;
            margin-bottom: 10px;
            color: #e1e0e4;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            -webkit-line-clamp: 2;
        }

        .concert-creator p,
        .concert-info p {
            font-size: 0.9em;
            color: #fff;
            font-family: 'Nunito', sans-serif;
            margin-bottom: 0;
        }

        .concert-info {
            margin-top: auto;
            /* Push the info section to the bottom */
        }

        .concert-action-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .concert-action {
            color: #fff;
            border: 3px solid #fff;
            background-color: transparent;
            padding: 6px;
            /* text-transform: uppercase; */
            font-size: 0.7em;
            font-weight: bold;
            letter-spacing: 1px;
            text-decoration: none;
            transition: background-color 0.4s;
            cursor: pointer;
        }

        .concert-action:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .concert-footer {
            padding: 10px;
            text-align: center;
            background-color: #fff;
            border-top: 1px solid #d2d2d2;
        }
    </style> --}}

    {{-- Mutliple Location Google Map CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>

    {{-- Image,GPS and Search CSS --}}
    {{-- <style>
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

        .image-display-container {
            margin-top: 20px;
            border: 2px solid #ccc;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }

        .uploaded-image {
            max-width: 100%;
            max-height: 100%;
        }
    </style> --}}
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

    {{-- GPS CSS and JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <br><br><br>

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay" style="height: 200px;">
        <div class="bg-overlay">
            <video autoplay muted loop playsinline class="bg-video">
                <source src="{{ asset('new/img/vid-1.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="bradcumbContent">
            <p>See what's new</p>
            <h2>Resort</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <br>

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
                <input type="search" name="search" id="searchInput" class="form-control" placeholder="Search Resorts">
            </div>

        </div>
    </div>

    <br>

    <!-- ##### Latest Concerts Area Start ##### -->
    <div class="concert-container" id="searchResultsContainer">
        <!-- Results will be dynamically updated here -->
    </div>
    <!-- ##### Latest Concerts Area End ##### -->

    {{-- <div id="searchResultsContainer"></div> --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-42P7F5KveI1Gq6Hp0EUa4Hi/4D8Qxhgzqj/vbduG91o=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- For SVG JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"
        integrity="sha512-TF+R3eFU2x7q+uAqq6I7/Pcx+4zITAdWu6T51t4xt2cTFBrhsVc0pmOXdH5RufRYAbD5HJym2e8s/kI6By9iWg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Mutliple Location Google Map JS --}}
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    {{-- Top --}}
    {{-- Full Image Search Function --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('imageUploadForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch('{{ route('uploadAndSearch') }}', {
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
                        console.log('Search Results:', data); // Log the search results
                        updateSearchResults(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            function updateSearchResults(filteredResorts) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = '';

                if (filteredResorts.length > 0) {
                    filteredResorts.forEach(function(resort) {
                        console.log('Resort Data:', resort); // Log each resort's data

                        var isDisabled = resort.status === 1;
                        const resortId = resort.id;
                        var resortName = resort.name;
                        var resortLocation = resort.location;
                        var resortState = resort.state;
                        var resortCountry = resort.country;
                        var resortDescription = resort.description;
                        var resortImages = resort.images || []; // Ensure images is an array

                        // Generate HTML for images
                        var imagesHTML = resortImages.length > 0 ?
                            resortImages.map(image =>
                                `<img class="concert-image" src="{{ asset('images/') }}/${image.image}" alt="Image" />`
                            ).join('') :
                            `<img class="concert-image" src="path/to/placeholder-image.jpg" alt="No Image" />`;

                        var resortHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') + '">' +
                            '<div class="concert-main" id="resortcard_' + resortId + '">' +
                            imagesHTML + // Display multiple images here
                            '<div class="concert-content">' +
                            '<h2 class="concert-title">' + resortName +
                            ' <i class="fas fa-resort"></i></h2><hr>' +
                            '<p class="concert-description"><i class="fas fa-info-circle"></i> ' +
                            resortDescription + '</p><hr>' +
                            '<div class="concert-creator">' +
                            '<p><i class="fas fa-map-marker-alt"></i> ' + resortLocation + '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p><i class="bi bi-geo-alt-fill"></i> ' + resortState + '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p><i class="bi bi-geo-alt-fill"></i> ' + resortCountry + '</p>' +
                            '</div>' +
                            '</div>' +
                            '<div class="concert-action-container">' +
                            '<p>' + new Date().toLocaleString('en-US', {
                                timeZone: 'Asia/Kuala_Lumpur'
                            }) + '</p>' +
                            (isDisabled ?
                                '<a href="{{ url('Resortdetail/') }}/' + resortId +
                                '/view" class="concert-action disabled">Closed</a>' :
                                '<form id="wishlistForm" action="{{ url('/wishlist/add/resort') }}/' +
                                resortId + '" method="POST">' +
                                '@csrf<button type="submit" id="wishlist" class="concert-action"><i class="fas fa-heart"></i>Wishlist</button></form>' +
                                '<a href="{{ url('Resortdetail/') }}/' + resortId +
                                '/view" class="concert-action" id="viewresort' + resortId + '">Book Now</a>'
                            ) +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        resultsContainer.innerHTML += resortHTML;
                    });
                } else {
                    resultsContainer.innerHTML =
                        '<p style="margin-top:40px; font-size:24px; display:block">No Resorts Found</p>';
                }
            }
        });
    </script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Final Full Real Time Search, Detection Image and GPS Function --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var userMarker = null;
            var resorts = <?php echo json_encode($resort); ?>;

            function initMap() {
                if (map === null) {
                    map = L.map('map').setView([4.2105, 101.9758], 7);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                }
            }

            function updateMapMarkers(resorts) {
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

                if (Array.isArray(resorts)) {
                    resorts.forEach(function(resort) {
                        if (resort.latitude && resort.longitude && resort.register_status === 1) {
                            var marker = L.marker([resort.latitude, resort.longitude]).addTo(map)
                                .bindPopup('<b>' + resort.name + '</b><br>' + resort.location + '<br>' +
                                    resort.price);
                            markers.push(marker);
                        }
                    });
                } else {
                    console.error('Expected an array of resorts but received:', resorts);
                }
            }

            function updateSearchResults(filteredResorts) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty();

                if (Array.isArray(filteredResorts) && filteredResorts.length > 0) {
                    filteredResorts.forEach(function(resort) {
                        if (resort.register_status === 1) {
                            var isDisabled = resort.status === 1;
                            const resortId = resort.id;
                            var resortName = resort.name;
                            var resortLocation = resort.location;
                            var resortState = resort.state;
                            var resortCountry = resort.country;
                            var resortDescription = resort.description;
                            var resortImages = resort.images || [];

                            // Use the first image from the resort object if available, otherwise use a placeholder
                            var imageURL = (resort.image || (resortImages.length > 0 && resortImages[0]
                                    .image)) ?
                                "{{ asset('images/') }}/" + (resort.image || resortImages[0].image) :
                                "{{ asset('images/placeholder-image.jpg') }}";

                            var imageHTML =
                                `<img class="concert-image" src="${imageURL}" alt="${resortName}" />`;

                            var resortHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') +
                                '">' +
                                '<div class="concert-main" id="resortcard_' + resortId + '">' +
                                imageHTML +
                                '<div class="concert-content">' +
                                '<h2 class="concert-title">' +
                                '<i class="fas fa-hotel"></i> ' + resortName + ' ' +
                                '<i class="fas fa-resort"></i>' +
                                '</h2>' +
                                '<p class="concert-description">' +
                                '<i class="fas fa-info-circle"></i> ' + resortDescription +
                                '</p>' +
                                '<div class="concert-creator">' +
                                '<p><i class="fas fa-map-marker-alt"></i> ' + resortLocation + '</p>' +
                                '</div>' +
                                '<div class="concert-action-container">' +
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                (isDisabled ?
                                    '<a href="{{ url('Resortdetail/') }}/' + resortId +
                                    '/view" class="concert-action disabled">Closed</a>' :
                                    '<form id="wishlistForm" action="{{ url('/wishlist/add/resort') }}/' +
                                    resortId + '" method="POST">' +
                                    '@csrf<button type="submit" id="wishlist" class="concert-action"><i class="fas fa-heart"></i> Wishlist</button></form>' +
                                    '<a href="{{ url('Resortdetail/') }}/' + resortId +
                                    '/view" class="concert-action" id="viewresort' + resortId +
                                    '">Book Now</a>'
                                ) +
                                '</div>' +
                                '</div>' +
                                '</div>';

                            resultsContainer.append(resortHTML);
                        }
                    });
                } else {
                    resultsContainer.html(
                        '<p style="margin-top:40px; font-size:24px; display:block">No Resorts Found</p>');
                }
            }

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var filteredResorts = resorts.filter(function(resort) {
                    return resort.name.toLowerCase().includes(searchInputValue) ||
                        resort.country.toLowerCase().includes(searchInputValue) ||
                        resort.state.toLowerCase().includes(searchInputValue) ||
                        resort.location.toLowerCase().includes(searchInputValue) ||
                        resort.description.toLowerCase().includes(searchInputValue);
                });

                updateMapMarkers(filteredResorts);
                updateSearchResults(filteredResorts);
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

                fetch('{{ route('uploadAndSearch') }}', {
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

                        // Display an alert with the detection result
                        if (Array.isArray(data) && data.length > 0) {
                            alert('Detected image result: ' + data.length + ' matching resorts found.');
                        } else {
                            alert('Detected image result: No matching resorts found.');
                        }

                        if (Array.isArray(data) && data.length > 0) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.log('No matching resorts found');
                            updateSearchResults([]); // Update UI to show no results
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error occurred during image upload and search.');
                        updateSearchResults([]); // Update UI to show error state
                    });
            });

            initMap();

            if (Array.isArray(resorts)) {
                updateMapMarkers(resorts);
                updateSearchResults(resorts);
            } else {
                console.error('resorts is not an array:', resorts);
            }

            function fetchNearbyResorts(latitude, longitude) {
                fetch(`/resort-gps-search?latitude=${latitude}&longitude=${longitude}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Nearby resorts data:', data);
                        if (Array.isArray(data)) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => console.error('Error fetching nearby resorts:', error));
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

                        fetchNearbyResorts(latitude, longitude);
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
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($resort as $resorts)
                @if (is_object($resorts) && property_exists($resorts, 'status'))

                    let resortcard = document.getElementById('resortcard_{{ $resorts->id }}');
                    let viewresort = document.getElementById('viewresort{{ $resorts->id }}');

                    if (resortcard && viewresort) {
                        if ({{ $resorts->status }} === 1) {
                            resortcard.classList.add('disabled');
                            viewresort.removeAttribute('disabled');
                        } else {
                            resortcard.classList.remove('disabled');
                            viewresort.setAttribute('disabled', 'disabled');
                        }
                    }
                @endif
            @endforeach
        });
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
