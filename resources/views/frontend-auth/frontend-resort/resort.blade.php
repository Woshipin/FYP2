@extends('frontend-auth.newlayout')

@section('frontend-section')
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    {{-- New Resort Card UI CSS --}}
    <style>
        .resort-card {
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

        .resort-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 12px 24px rgba(0, 0, 0, 0.2);
            background-color: #f0f0f0;
        }

        .resort-image {
            width: 100%;
            height: 300px;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .resort-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .resort-image img:hover {
            transform: scale(1.1);
        }

        .resort-content {
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

        .resort-content p {
            font-size: 14px;
            color: #333;
            margin: 0 0 5px 0;
            line-height: 1.2;
            text-align: left;
        }

        .resort-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: left;
        }

        .resort-location,
        .resort-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .resort-amenities {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .resort-amenities span {
            font-size: 14px;
            color: #888;
        }

        .resort-rating {
            display: flex;
            justify-content: flex-start;
            margin-top: 10px;
        }

        .resort-rating i {
            font-size: 16px;
            color: gold;
        }

        .resort-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .resort-actions .actions {
            display: flex;
            align-items: center;
        }

        .resort-actions form {
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

    {{-- GPS CSS and JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- AI Chat Bot CSS --}}
    <style>
        :root {
            --primary-color: #4A90E2;
            /* Keeping the original color */
            --secondary-color: #F5F7FA;
            --text-color: #333333;
            --border-radius: 16px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        /* Keeping the button styles unchanged */
        .chatbox__button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            /* background-color: var(--primary-color); */
            background-color: white;
            box-shadow: var(--box-shadow);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
            z-index: 1000;
        }

        .chatbox__button:hover {
            transform: scale(1.1);
        }

        .chatbox__button img {
            width: 30px;
            height: 30px;
        }

        /* Increasing the width of the chat support window */
        .chatbox__support {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 450px;
            /* Increased from 350px */
            height: 550px;
            /* Slightly increased for better proportion */
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
            z-index: 999;
        }

        .chatbox--active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: all;
        }

        /* Keeping the header styles unchanged */
        .chatbox__header {
            background-color: var(--primary-color);
            padding: 15px 20px;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            display: flex;
            align-items: center;
        }

        .chatbox__image--header img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chatbox__content--header {
            color: white;
        }

        .chatbox__heading--header {
            font-size: 18px;
            margin: 0;
        }

        .chatbox__description--header {
            font-size: 12px;
            margin: 0;
        }

        /* Increasing padding for messages area */
        .chatbox__messages {
            flex-grow: 1;
            padding: 25px;
            /* Increased from 20px */
            overflow-y: auto;
        }

        /* Keeping the footer styles unchanged */
        .chatbox__footer {
            padding: 10px 20px;
            background-color: var(--secondary-color);
            border-bottom-left-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
            display: flex;
        }

        #chat-input {
            flex-grow: 1;
            border: none;
            background-color: white;
            padding: 10px 15px;
            border-radius: 20px;
            font-size: 14px;
        }

        #chat-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .chatbox__send--footer {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            margin-left: 10px;
            cursor: pointer;
            transition: var(--transition);
        }

        .chatbox__send--footer:hover {
            background-color: darken(var(--primary-color), 10%);
        }

        /* Increasing the max-width of message items */
        .messages__item {
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 20px;
            max-width: 85%;
            /* Increased from 80% */
            font-size: 14px;
        }

        .messages__item--visitor {
            background-color: var(--primary-color);
            color: white;
            align-self: flex-end;
            margin-left: auto;
        }

        .messages__item--operator {
            background-color: var(--secondary-color);
            color: var(--text-color);
            align-self: flex-start;
        }
    </style>

    {{-- Gemini JS --}}
    <script type="importmap">
        {
            "imports": {
            "@google/generative-ai": "https://esm.run/@google/generative-ai"
            }
        }
    </script>

    <br><br><br>

    {{-- Test --}}
    <div class="chatbox">
        <div class="chatbox__button">
            <img src="chatbot/images/icons/chatbox-icon.svg" alt="Chat Icon">
        </div>
        <div class="chatbox__support">
            <div class="chatbox__header">
                <div class="chatbox__image--header">
                    <img src="chatbot/images/image.png" alt="Chatbot Avatar">
                </div>
                <div class="chatbox__content--header">
                    <h4 class="chatbox__heading--header">SOAR AI Chat Support</h4>
                    <p class="chatbox__description--header">Ask me anything!</p>
                </div>
            </div>

            <div class="chatbox__messages" id="content-box"></div>
            <div class="chatbox__footer">
                <input type="text" id="chat-input" placeholder="Write a message...">
                <button class="chatbox__send--footer" id="send-button">Send</button>
            </div>
        </div>
    </div>

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

    {{-- Top --}}
    {{-- Full Image Search Function --}}
    {{-- <script>
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
    </script> --}}

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Final Full Resort Real Time Search, Detection Image and GPS Function --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var userMarker = null;
            var resorts = @json($resort);
            var resortRatings = @json($resortRatings);

            console.log('Resorts:', resorts);
            console.log('Resort Ratings:', resortRatings);

            // 确保 resorts 是一个数组
            if (!Array.isArray(resorts)) {
                resorts = [resorts];
            }

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
                            var resortRating = resortRatings[resortId] || {
                                averageRating: 0,
                                count: 0
                            };

                            var averageRating = resortRating.averageRating !== undefined && !isNaN(
                                resortRating.averageRating) ? resortRating.averageRating : 0;

                            var imageURL = (resort.image || (resortImages.length > 0 && resortImages[0]
                                    .image)) ?
                                "{{ asset('images/') }}/" + (resort.image || resortImages[0].image) :
                                null;

                            var resortHTML = `
                                <div class="resort-card ${isDisabled ? 'disabled' : ''}" id="resortcard_${resortId}">
                                    <div class="resort-image">
                                        ${imageURL ? `<img src="${imageURL}" alt="${resortName}">` : `
                                                <div class="no-image-box">
                                                    <span>No Image</span>
                                                </div>`}
                                    </div>
                                    <div class="resort-content">
                                        <h2 class="resort-title">
                                            <i class="fas fa-hotel"></i> ${resortName}
                                        </h2>
                                        <p class="resort-location">
                                            <i class="fas fa-map-marker-alt"></i> ${resortLocation}, ${resortState}, ${resortCountry}
                                        </p>
                                        <p class="resort-description">
                                            <i class="fas fa-info-circle"></i> ${resortDescription.length > 100 ? resortDescription.substring(0, 100) + '...' : resortDescription}
                                        </p>
                                        <div class="resort-amenities">
                                            <span><i class="fas fa-swimming-pool"></i> Pool</span>
                                            <span><i class="fas fa-wifi"></i> Free WiFi</span>
                                            <span><i class="fas fa-parking"></i> Parking</span>
                                        </div>
                                        <div class="resort-rating">
                                            ${generateStarRating(averageRating)}
                                            <span>(${averageRating.toFixed(1)})</span>
                                        </div>
                                        <div class="resort-actions">
                                            ${isDisabled ?
                                                '<button class="btn btn-disabled">Closed</button>' :
                                                `<div class="actions">
                                                        <form id="wishlistForm_${resortId}" action="{{ url('/wishlist/add/resort') }}/${resortId}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" id="wishlist" class="btn btn-wishlist">
                                                                <i class="fas fa-heart"></i> Wishlist
                                                            </button>
                                                        </form>
                                                        <a href="{{ url('Resortdetail/') }}/${resortId}/view" class="btn btn-book" id="viewresort${resortId}">Book Now</a>
                                                    </div>`
                                            }
                                        </div>
                                    </div>
                                </div>
                            `;

                            resultsContainer.append(resortHTML);
                        }
                    });
                } else {
                    resultsContainer.html('<p class="no-results">No Resorts Found</p>');
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
                    .catch(error => {
                        console.error('Error fetching nearby resorts:', error);
                    });
            }

            // 获取用户位置
            document.getElementById('getLocationButton').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        // 添加用户位置标记
                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }
                        userMarker = L.marker([latitude, longitude]).addTo(map).bindPopup(
                            "You are here!").openPopup();
                        markers.push(userMarker);

                        // 创建地图圆圈
                        L.circle([latitude, longitude], {
                            color: 'blue',
                            fillColor: '#30f',
                            fillOpacity: 0.2,
                            radius: 5000 // 5 km radius
                        }).addTo(map);

                        fetchNearbyResorts(latitude, longitude);
                        map.setView([latitude, longitude], 13);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });
        });
    </script> --}}

    {{-- AI Chat Bot Testing can use gps --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var userMarker = null;
            var resorts = @json($resort);
            var resortRatings = @json($resortRatings);

            console.log('Resorts:', resorts);
            console.log('Resort Ratings:', resortRatings);

            if (!Array.isArray(resorts)) {
                resorts = [resorts];
            }

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
                            var resortRating = resortRatings[resortId] || {
                                averageRating: 0,
                                count: 0
                            };

                            var averageRating = resortRating.averageRating !== undefined && !isNaN(resortRating.averageRating) ? resortRating.averageRating : 0;

                            var imageURL = (resort.image || (resortImages.length > 0 && resortImages[0].image)) ?
                                "{{ asset('images/') }}/" + (resort.image || resortImages[0].image) :
                                null;

                            var resortHTML = `
                                <div class="resort-card ${isDisabled ? 'disabled' : ''}" id="resortcard_${resortId}">
                                    <div class="resort-image">
                                        ${imageURL ? `<img src="${imageURL}" alt="${resortName}">` : `
                                            <div class="no-image-box">
                                                <span>No Image</span>
                                            </div>`}
                                    </div>
                                    <div class="resort-content">
                                        <h2 class="resort-title">
                                            <i class="fas fa-hotel"></i> ${resortName}
                                        </h2>
                                        <p class="resort-location">
                                            <i class="fas fa-map-marker-alt"></i> ${resortLocation}, ${resortState}, ${resortCountry}
                                        </p>
                                        <p class="resort-description">
                                            <i class="fas fa-info-circle"></i> ${resortDescription.length > 100 ? resortDescription.substring(0, 100) + '...' : resortDescription}
                                        </p>
                                        <div class="resort-amenities">
                                            <span><i class="fas fa-swimming-pool"></i> Pool</span>
                                            <span><i class="fas fa-wifi"></i> Free WiFi</span>
                                            <span><i class="fas fa-parking"></i> Parking</span>
                                        </div>
                                        <div class="resort-rating">
                                            ${generateStarRating(averageRating)}
                                            <span>(${averageRating.toFixed(1)})</span>
                                        </div>
                                        <div class="resort-actions">
                                            ${isDisabled ?
                                                '<button class="btn btn-disabled">Closed</button>' :
                                                `<div class="actions">
                                                    <form id="wishlistForm_${resortId}" action="{{ url('/wishlist/add/resort') }}/${resortId}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" id="wishlist" class="btn btn-wishlist">
                                                            <i class="fas fa-heart"></i> Wishlist
                                                        </button>
                                                    </form>
                                                    <a href="{{ url('Resortdetail/') }}/${resortId}/view" class="btn btn-book" id="viewresort${resortId}">Book Now</a>
                                                </div>`
                                            }
                                        </div>
                                    </div>
                                </div>
                            `;

                            resultsContainer.append(resortHTML);
                        }
                    });
                } else {
                    resultsContainer.html('<p class="no-results">No Resorts Found</p>');
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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Upload and search data:', data);

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
                        } else if (data.error) {
                            alert(data.message);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching nearby resorts:', error);
                    });
            }

            // 确保在 DOM 完全加载后再添加事件监听器
            document.getElementById('openGPSButton').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }
                        userMarker = L.marker([latitude, longitude]).addTo(map).bindPopup("You are here!").openPopup();
                        markers.push(userMarker);

                        L.circle([latitude, longitude], {
                            color: 'blue',
                            fillColor: '#30f',
                            fillOpacity: 0.2,
                            radius: 15000 // 15 km radius
                        }).addTo(map);

                        fetchNearbyResorts(latitude, longitude);
                        map.setView([latitude, longitude], 13);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });
        });
    </script> --}}
    {{-- Good --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var userMarker = null;
            var resorts = @json($resort);
            var resortRatings = @json($resortRatings);

            console.log('Resorts:', resorts);
            console.log('Resort Ratings:', resortRatings);

            if (!Array.isArray(resorts)) {
                resorts = [resorts];
            }

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

            function generateResortHTML(resort) {
                var isDisabled = resort.status === 1;
                const resortId = resort.id;
                var resortName = resort.name;
                var resortLocation = resort.location;
                var resortState = resort.state;
                var resortCountry = resort.country;
                var resortDescription = resort.description;
                var resortImages = resort.images || [];
                var resortRating = resortRatings[resortId] || {
                    averageRating: 0,
                    count: 0
                };

                var averageRating = resortRating.averageRating !== undefined && !isNaN(resortRating.averageRating) ?
                    resortRating.averageRating : 0;

                var imageURL = (resort.image || (resortImages.length > 0 && resortImages[0].image)) ?
                    "{{ asset('images/') }}/" + (resort.image || resortImages[0].image) :
                    null;

                return `
            <div class="resort-card ${isDisabled ? 'disabled' : ''}" id="resortcard_${resortId}">
                <div class="resort-image">
                    ${imageURL ? `<img src="${imageURL}" alt="${resortName}">` : `
                            <div class="no-image-box">
                                <span>No Image</span>
                            </div>`}
                </div>
                <div class="resort-content">
                    <h2 class="resort-title">
                        <i class="fas fa-hotel"></i> ${resortName}
                    </h2>
                    <p class="resort-location">
                        <i class="fas fa-map-marker-alt"></i> ${resortLocation}, ${resortState}, ${resortCountry}
                    </p>
                    <p class="resort-description">
                        <i class="fas fa-info-circle"></i> ${resortDescription.length > 100 ? resortDescription.substring(0, 100) + '...' : resortDescription}
                    </p>
                    <div class="resort-amenities">
                        <span><i class="fas fa-swimming-pool"></i> Pool</span>
                        <span><i class="fas fa-wifi"></i> Free WiFi</span>
                        <span><i class="fas fa-parking"></i> Parking</span>
                    </div>
                    <div class="resort-rating">
                        ${generateStarRating(averageRating)}
                        <span>(${averageRating.toFixed(1)})</span>
                    </div>
                    <div class="resort-actions">
                        ${isDisabled ?
                            '<button class="btn btn-disabled">Closed</button>' :
                            `<div class="actions">
                                    <form id="wishlistForm_${resortId}" action="{{ url('/wishlist/add/resort') }}/${resortId}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" id="wishlist" class="btn btn-wishlist">
                                            <i class="fas fa-heart"></i> Wishlist
                                        </button>
                                    </form>
                                    <a href="{{ url('Resortdetail/') }}/${resortId}/view" class="btn btn-book" id="viewresort${resortId}">Book Now</a>
                                </div>`
                        }
                    </div>
                </div>
            </div>
        `;
            }

            function updateSearchResults(filteredResorts) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty();

                if (Array.isArray(filteredResorts) && filteredResorts.length > 0) {
                    filteredResorts.forEach(function(resort) {
                        if (resort.register_status === 1) {
                            var resortHTML = generateResortHTML(resort);
                            resultsContainer.append(resortHTML);
                        }
                    });
                } else {
                    resultsContainer.html('<p class="no-results">No Resorts Found</p>');
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
                        } else if (data.error) {
                            alert(data.message);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching nearby resorts:', error);
                    });
            }

            document.getElementById('openGPSButton').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }
                        userMarker = L.marker([latitude, longitude]).addTo(map).bindPopup(
                            "You are here!").openPopup();
                        markers.push(userMarker);

                        L.circle([latitude, longitude], {
                            color: 'blue',
                            fillColor: '#30f',
                            fillOpacity: 0.2,
                            radius: 15000 // 15 km radius
                        }).addTo(map);

                        fetchNearbyResorts(latitude, longitude);
                        map.setView([latitude, longitude], 13);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });
        });
    </script> --}}

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

    {{-- Test --}}
    {{-- AI Chat Bot --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatButton = document.querySelector('.chatbox__button');
            const chatSupport = document.querySelector('.chatbox__support');
            const chatInput = document.getElementById('chat-input');
            const contentBox = document.getElementById('content-box');

            chatButton.addEventListener('click', function() {
                chatSupport.classList.toggle('chatbox--active');
            });

            function addMessage(message, sender) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('messages__item', `messages__item--${sender}`);
                messageElement.textContent = message;
                contentBox.appendChild(messageElement);
                contentBox.scrollTop = contentBox.scrollHeight;
            }
        });
    </script>

    <script type="module">
        import {
            GoogleGenerativeAI
        } from "@google/generative-ai";
        const API_KEY = "AIzaSyDQVtdIHsPihe5km66Ptiukc7D3UcHr5RY"; // Replace with your API key
        const genAI = new GoogleGenerativeAI(API_KEY);
        const model = genAI.getGenerativeModel({
            model: "gemini-1.5-flash"
        });

        async function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value;
            if (message.trim() === '') return;

            const contentBox = document.getElementById('content-box');
            const visitorMessage = document.createElement('div');
            visitorMessage.className = 'messages__item messages__item--visitor';
            visitorMessage.textContent = message;
            contentBox.appendChild(visitorMessage);
            contentBox.scrollTop = contentBox.scrollHeight;

            input.value = '';

            try {
                const result = await model.generateContent(message);
                const response = result.response.text();
                const operatorMessage = document.createElement('div');
                operatorMessage.className = 'messages__item messages__item--operator';
                operatorMessage.textContent = response;
                contentBox.appendChild(operatorMessage);
                contentBox.scrollTop = contentBox.scrollHeight;

                // 处理用户查询
                handleUserQuery(message);
            } catch (error) {
                console.error('Error:', error);
                const errorMessage = document.createElement('div');
                errorMessage.className = 'messages__item messages__item--error';
                errorMessage.textContent = 'Error: ' + error.message;
                contentBox.appendChild(errorMessage);
                contentBox.scrollTop = contentBox.scrollHeight;
            }
        }

        function handleUserQuery(query) {
            const resorts = @json($resort);
            const resortRatings = @json($resortRatings);

            // 解析查询
            const keywords = query.toLowerCase().split(' ');
            let filteredResorts = resorts;

            if (keywords.includes('price')) {
                const priceRange = keywords.slice(keywords.indexOf('price') + 1, keywords.indexOf('price') + 3);
                if (priceRange.length === 2) {
                    const minPrice = parseFloat(priceRange[0]);
                    const maxPrice = parseFloat(priceRange[1]);
                    filteredResorts = filteredResorts.filter(resort => {
                        const price = parseFloat(resort.price);
                        return price >= minPrice && price <= maxPrice;
                    });
                }
            }

            if (keywords.includes('name') || keywords.includes('type') || keywords.includes('country') || keywords.includes(
                    'state') || keywords.includes('location') || keywords.includes('description')) {
                const searchTerm = keywords.slice(keywords.indexOf(keywords.includes('name') ? 'name' : keywords.includes(
                        'type') ? 'type' : keywords.includes('country') ? 'country' : keywords.includes('state') ?
                    'state' : keywords.includes('location') ? 'location' : 'description') + 1).join(' ');
                filteredResorts = filteredResorts.filter(resort => {
                    return resort.name.toLowerCase().includes(searchTerm) ||
                        resort.type.toLowerCase().includes(searchTerm) ||
                        resort.country.toLowerCase().includes(searchTerm) ||
                        resort.state.toLowerCase().includes(searchTerm) ||
                        resort.location.toLowerCase().includes(searchTerm) ||
                        resort.description.toLowerCase().includes(searchTerm);
                });
            }

            updateMapMarkers(filteredResorts);
            updateSearchResults(filteredResorts);
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('send-button').addEventListener('click', sendMessage);
            document.getElementById('chat-input').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });
        });
    </script> --}}

    {{-- gemini best --}}
    {{-- <script type="module">
        import {
            GoogleGenerativeAI
        } from "@google/generative-ai";

        document.addEventListener('DOMContentLoaded', function() {
            const chatButton = document.querySelector('.chatbox__button');
            const chatSupport = document.querySelector('.chatbox__support');
            const chatInput = document.getElementById('chat-input');
            const contentBox = document.getElementById('content-box');

            chatButton.addEventListener('click', function() {
                chatSupport.classList.toggle('chatbox--active');
            });

            function addMessage(message, sender) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('messages__item', `messages__item--${sender}`);
                messageElement.textContent = message;
                contentBox.appendChild(messageElement);
                contentBox.scrollTop = contentBox.scrollHeight;
            }

            var map = null;
            var markers = [];
            var userMarker = null;
            var resorts = @json($resort);
            var resortRatings = @json($resortRatings);

            console.log('Resorts:', resorts);
            console.log('Resort Ratings:', resortRatings);

            if (!Array.isArray(resorts)) {
                resorts = [resorts];
            }

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

            function generateResortHTML(resort) {
                var isDisabled = resort.status === 1;
                const resortId = resort.id;
                var resortName = resort.name;
                var resortLocation = resort.location;
                var resortState = resort.state;
                var resortCountry = resort.country;
                var resortDescription = resort.description;
                var resortImages = resort.images || [];
                var resortRating = resortRatings[resortId] || {
                    averageRating: 0,
                    count: 0
                };

                var averageRating = resortRating.averageRating !== undefined && !isNaN(resortRating.averageRating) ?
                    resortRating.averageRating : 0;

                var imageURL = (resort.image || (resortImages.length > 0 && resortImages[0].image)) ?
                    "{{ asset('images/') }}/" + (resort.image || resortImages[0].image) :
                    null;

                return `
                    <div class="resort-card ${isDisabled ? 'disabled' : ''}" id="resortcard_${resortId}">
                        <div class="resort-image">
                            ${imageURL ? `<img src="${imageURL}" alt="${resortName}">` : `
                                                                <div class="no-image-box">
                                                                    <span>No Image</span>
                                                                </div>`}
                        </div>
                        <div class="resort-content">
                            <h2 class="resort-title">
                                <i class="fas fa-hotel"></i> ${resortName}
                            </h2>
                            <p class="resort-location">
                                <i class="fas fa-map-marker-alt"></i> ${resortLocation}, ${resortState}, ${resortCountry}
                            </p>
                            <p class="resort-description">
                                <i class="fas fa-info-circle"></i> ${resortDescription.length > 100 ? resortDescription.substring(0, 100) + '...' : resortDescription}
                            </p>
                            <div class="resort-amenities">
                                <span><i class="fas fa-swimming-pool"></i> Pool</span>
                                <span><i class="fas fa-wifi"></i> Free WiFi</span>
                                <span><i class="fas fa-parking"></i> Parking</span>
                            </div>
                            <div class="resort-rating">
                                ${generateStarRating(averageRating)}
                                <span>(${averageRating.toFixed(1)})</span>
                            </div>
                            <div class="resort-actions">
                                ${isDisabled ?
                                    '<button class="btn btn-disabled">Closed</button>' :
                                    `<div class="actions">
                                                                        <form id="wishlistForm_${resortId}" action="{{ url('/wishlist/add/resort') }}/${resortId}" method="POST" style="display: inline;">
                                                                            @csrf
                                                                            <button type="submit" id="wishlist" class="btn btn-wishlist">
                                                                                <i class="fas fa-heart"></i> Wishlist
                                                                            </button>
                                                                        </form>
                                                                        <a href="{{ url('Resortdetail/') }}/${resortId}/view" class="btn btn-book" id="viewresort${resortId}">Book Now</a>
                                                                    </div>`
                                }
                            </div>
                        </div>
                    </div>
                `;
            }

            function updateSearchResults(filteredResorts) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty();

                if (Array.isArray(filteredResorts) && filteredResorts.length > 0) {
                    filteredResorts.forEach(function(resort) {
                        if (resort.register_status === 1) {
                            var resortHTML = generateResortHTML(resort);
                            resultsContainer.append(resortHTML);
                        }
                    });
                } else {
                    resultsContainer.html('<p class="no-results">No Resorts Found</p>');
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
                        } else if (data.error) {
                            alert(data.message);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching nearby resorts:', error);
                    });
            }

            document.getElementById('openGPSButton').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }
                        userMarker = L.marker([latitude, longitude]).addTo(map).bindPopup(
                            "You are here!").openPopup();
                        markers.push(userMarker);

                        L.circle([latitude, longitude], {
                            color: 'blue',
                            fillColor: '#30f',
                            fillOpacity: 0.2,
                            radius: 15000 // 15 km radius
                        }).addTo(map);

                        fetchNearbyResorts(latitude, longitude);
                        map.setView([latitude, longitude], 13);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });

            const API_KEY = "AIzaSyDQVtdIHsPihe5km66Ptiukc7D3UcHr5RY"; // Replace with your API key
            const genAI = new GoogleGenerativeAI(API_KEY);
            const model = genAI.getGenerativeModel({
                model: "gemini-1.5-flash"
            });

            async function sendMessage() {
                const input = document.getElementById('chat-input');
                const message = input.value;
                if (message.trim() === '') return;

                const contentBox = document.getElementById('content-box');
                const visitorMessage = document.createElement('div');
                visitorMessage.className = 'messages__item messages__item--visitor';
                visitorMessage.textContent = message;
                contentBox.appendChild(visitorMessage);
                contentBox.scrollTop = contentBox.scrollHeight;

                input.value = '';

                try {
                    const result = await model.generateContent(message);
                    const response = result.response.text();
                    const operatorMessage = document.createElement('div');
                    operatorMessage.className = 'messages__item messages__item--operator';
                    operatorMessage.textContent = response;
                    contentBox.appendChild(operatorMessage);
                    contentBox.scrollTop = contentBox.scrollHeight;

                    // 处理用户查询
                    handleUserQuery(message);
                } catch (error) {
                    console.error('Error:', error);
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'messages__item messages__item--error';
                    errorMessage.textContent = 'Error: ' + error.message;
                    contentBox.appendChild(errorMessage);
                    contentBox.scrollTop = contentBox.scrollHeight;
                }
            }

            // function handleUserQuery(query) {
            //     const resorts = @json($resort);
            //     const resortRatings = @json($resortRatings);

            //     // 解析查询
            //     const keywords = query.toLowerCase().split(' ');
            //     console.log('Keywords:', keywords);

            //     let matchedResorts = [];

            //     // 检查是否有价格范围
            //     const priceRange = keywords.find(keyword => keyword.includes('-'));
            //     if (priceRange) {
            //         const [minPrice, maxPrice] = priceRange.split('-').map(Number);
            //         matchedResorts = resorts.filter(resort => {
            //             const price = parseFloat(resort.price);
            //             return price >= minPrice && price <= maxPrice;
            //         });
            //     } else {
            //         matchedResorts = resorts;
            //     }

            //     // 筛选逻辑：只要酒店卡片中有符合问题的字或内容就显示符合问题的酒店卡片和位置
            //     matchedResorts = matchedResorts.filter(resort => {
            //         return keywords.some(keyword => {
            //             return resort.name.toLowerCase().includes(keyword) ||
            //                 resort.type.toLowerCase().includes(keyword) ||
            //                 resort.country.toLowerCase().includes(keyword) ||
            //                 resort.state.toLowerCase().includes(keyword) ||
            //                 resort.location.toLowerCase().includes(keyword) ||
            //                 resort.description.toLowerCase().includes(keyword);
            //         });
            //     });

            //     console.log('Matched Resorts:', matchedResorts);

            //     updateMapMarkers(matchedResorts);
            //     updateSearchResults(matchedResorts);
            // }

            function handleUserQuery(query) {
                const resorts = @json($resort);
                const resortRatings = @json($resortRatings);

                // Trim and normalize the query
                query = query.trim().toLowerCase();

                // Split the query into keywords, handling phrases in quotes
                const keywords = [];
                const quotedPhraseRegex = /"([^"]*)"/g;
                let match;

                // Extract quoted phrases first
                while ((match = quotedPhraseRegex.exec(query)) !== null) {
                    keywords.push(match[1].toLowerCase());
                    query = query.replace(match[0], '');
                }

                // Add remaining non-quoted words
                keywords.push(...query.split(/\s+/).filter(k => k.trim() !== ''));

                console.log('Processed Keywords:', keywords);

                // Function to check if a resort matches the keywords
                function isResortsMatch(resort) {
                    // Check for price range first (if applicable)
                    const priceRangeKeyword = keywords.find(k => /^\d+-\d+$/.test(k));
                    if (priceRangeKeyword) {
                        const [minPrice, maxPrice] = priceRangeKeyword.split('-').map(Number);
                        const price = parseFloat(resort.price);
                        if (price < minPrice || price > maxPrice) return false;
                    }

                    // Create a searchable string for the resort
                    const searchString = [
                        resort.name.toLowerCase(),
                        resort.type.toLowerCase(),
                        resort.country.toLowerCase(),
                        resort.state.toLowerCase(),
                        resort.location.toLowerCase(),
                        resort.description.toLowerCase()
                    ].join(' ');

                    // Check if ANY keyword matches
                    return keywords.some(keyword => searchString.includes(keyword));
                }

                // Filter resorts based on the matching function
                const matchedResorts = resorts.filter(isResortsMatch);

                // Additional filtering for exact match on resort name
                const exactMatchedResorts = matchedResorts.filter(resort =>
                    resort.name.toLowerCase() === query
                );

                console.log('Matched Resorts:', matchedResorts);
                console.log('Exact Matched Resorts:', exactMatchedResorts);

                // Update map and search results
                updateMapMarkers(exactMatchedResorts.length > 0 ? exactMatchedResorts : matchedResorts);
                updateSearchResults(exactMatchedResorts.length > 0 ? exactMatchedResorts : matchedResorts);
            }



            document.getElementById('send-button').addEventListener('click', sendMessage);
            document.getElementById('chat-input').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });
        });
    </script> --}}

    {{-- Gemini Filter --}}
    <script type="module">
        import { GoogleGenerativeAI } from "@google/generative-ai";

        document.addEventListener('DOMContentLoaded', function() {
            const chatButton = document.querySelector('.chatbox__button');
            const chatSupport = document.querySelector('.chatbox__support');
            const chatInput = document.getElementById('chat-input');
            const contentBox = document.getElementById('content-box');

            chatButton.addEventListener('click', function() {
                chatSupport.classList.toggle('chatbox--active');
            });

            function addMessage(message, sender) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('messages__item', `messages__item--${sender}`);
                messageElement.textContent = message;
                contentBox.appendChild(messageElement);
                contentBox.scrollTop = contentBox.scrollHeight;
            }

            var map = null;
            var markers = [];
            var userMarker = null;
            var resorts = @json($resort);
            var resortRatings = @json($resortRatings);

            console.log('Resorts:', resorts);
            console.log('Resort Ratings:', resortRatings);

            if (!Array.isArray(resorts)) {
                resorts = [resorts];
            }

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

            function generateResortHTML(resort) {
                var isDisabled = resort.status === 1;
                const resortId = resort.id;
                var resortName = resort.name;
                var resortLocation = resort.location;
                var resortState = resort.state;
                var resortCountry = resort.country;
                var resortDescription = resort.description;
                var resortImages = resort.images || [];
                var resortRating = resortRatings[resortId] || {
                    averageRating: 0,
                    count: 0
                };

                var averageRating = resortRating.averageRating !== undefined && !isNaN(resortRating.averageRating) ?
                    resortRating.averageRating : 0;

                var imageURL = (resort.image || (resortImages.length > 0 && resortImages[0].image)) ?
                    "{{ asset('images/') }}/" + (resort.image || resortImages[0].image) :
                    null;

                return `
                    <div class="resort-card ${isDisabled ? 'disabled' : ''}" id="resortcard_${resortId}">
                        <div class="resort-image">
                            ${imageURL ? `<img src="${imageURL}" alt="${resortName}">` : `
                                                            <div class="no-image-box">
                                                                <span>No Image</span>
                                                            </div>`}
                        </div>
                        <div class="resort-content">
                            <h2 class="resort-title">
                                <i class="fas fa-hotel"></i> ${resortName}
                            </h2>
                            <p class="resort-location">
                                <i class="fas fa-map-marker-alt"></i> ${resortLocation}, ${resortState}, ${resortCountry}
                            </p>
                            <p class="resort-description">
                                <i class="fas fa-info-circle"></i> ${resortDescription.length > 100 ? resortDescription.substring(0, 100) + '...' : resortDescription}
                            </p>
                            <div class="resort-amenities">
                                <span><i class="fas fa-swimming-pool"></i> Pool</span>
                                <span><i class="fas fa-wifi"></i> Free WiFi</span>
                                <span><i class="fas fa-parking"></i> Parking</span>
                            </div>
                            <div class="resort-rating">
                                ${generateStarRating(averageRating)}
                                <span>(${averageRating.toFixed(1)})</span>
                            </div>
                            <div class="resort-actions">
                                ${isDisabled ?
                                    '<button class="btn btn-disabled">Closed</button>' :
                                    `<div class="actions">
                                                                <form id="wishlistForm_${resortId}" action="{{ url('/wishlist/add/resort') }}/${resortId}" method="POST" style="display: inline;">
                                                                    @csrf
                                                                    <button type="submit" id="wishlist" class="btn btn-wishlist">
                                                                        <i class="fas fa-heart"></i> Wishlist
                                                                    </button>
                                                                </form>
                                                                <a href="{{ url('Resortdetail/') }}/${resortId}/view" class="btn btn-book" id="viewresort${resortId}">Book Now</a>
                                                            </div>`
                                }
                            </div>
                        </div>
                    </div>
                `;
            }

            function updateSearchResults(filteredResorts) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty();

                if (Array.isArray(filteredResorts) && filteredResorts.length > 0) {
                    filteredResorts.forEach(function(resort) {
                        if (resort.register_status === 1) {
                            var resortHTML = generateResortHTML(resort);
                            resultsContainer.append(resortHTML);
                        }
                    });
                } else {
                    resultsContainer.html('<p class="no-results">No Resorts Found</p>');
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
                        } else if (data.error) {
                            alert(data.message);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching nearby resorts:', error);
                    });
            }

            document.getElementById('openGPSButton').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }
                        userMarker = L.marker([latitude, longitude]).addTo(map).bindPopup(
                            "You are here!").openPopup();
                        markers.push(userMarker);

                        L.circle([latitude, longitude], {
                            color: 'blue',
                            fillColor: '#30f',
                            fillOpacity: 0.2,
                            radius: 15000 // 15 km radius
                        }).addTo(map);

                        fetchNearbyResorts(latitude, longitude);
                        map.setView([latitude, longitude], 13);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });

            const API_KEY = "AIzaSyDQVtdIHsPihe5km66Ptiukc7D3UcHr5RY"; // Replace with your API key
            const genAI = new GoogleGenerativeAI(API_KEY);
            const model = genAI.getGenerativeModel({
                model: "gemini-1.5-flash"
            });

            async function sendMessage() {
                const input = document.getElementById('chat-input');
                const message = input.value;
                if (message.trim() === '') return;

                const contentBox = document.getElementById('content-box');
                const visitorMessage = document.createElement('div');
                visitorMessage.className = 'messages__item messages__item--visitor';
                visitorMessage.textContent = message;
                contentBox.appendChild(visitorMessage);
                contentBox.scrollTop = contentBox.scrollHeight;

                input.value = '';

                try {
                    const result = await model.generateContent(message);
                    const response = result.response.text();
                    const operatorMessage = document.createElement('div');
                    operatorMessage.className = 'messages__item messages__item--operator';
                    operatorMessage.textContent = response;
                    contentBox.appendChild(operatorMessage);
                    contentBox.scrollTop = contentBox.scrollHeight;

                    // 处理用户查询
                    handleUserQuery(message);
                } catch (error) {
                    console.error('Error:', error);
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'messages__item messages__item--error';
                    errorMessage.textContent = 'Error: ' + error.message;
                    contentBox.appendChild(errorMessage);
                    contentBox.scrollTop = contentBox.scrollHeight;
                }
            }

            async function handleUserQuery(query) {
                const resorts = @json($resort);
                const resortRatings = @json($resortRatings);

                // Trim and normalize the query
                query = query.trim().toLowerCase();

                // Extract keywords manually
                const keywords = extractKeywordsManually(query);
                console.log('Extracted Keywords:', keywords);

                // Function to check if a resort matches the keywords
                function isResortsMatch(resort) {
                    // Check for price range first (if applicable)
                    const priceRangeKeyword = keywords.find(k => /^\d+-\d+$/.test(k));
                    if (priceRangeKeyword) {
                        const [minPrice, maxPrice] = priceRangeKeyword.split('-').map(Number);
                        const price = parseFloat(resort.price);
                        if (price < minPrice || price > maxPrice) return false;
                    }

                    // Create a searchable string for the resort
                    const searchString = [
                        resort.name.toLowerCase(),
                        resort.type.toLowerCase(),
                        resort.country.toLowerCase(),
                        resort.state.toLowerCase(),
                        resort.location.toLowerCase(),
                        resort.description.toLowerCase()
                    ].join(' ');

                    // Check if ANY keyword matches
                    return keywords.some(keyword => searchString.includes(keyword));
                }

                // Filter resorts based on the matching function
                const matchedResorts = resorts.filter(isResortsMatch);

                // Additional filtering for exact match on resort name
                const exactMatchedResorts = matchedResorts.filter(resort =>
                    resort.name.toLowerCase() === query
                );

                console.log('Matched Resorts:', matchedResorts);
                console.log('Exact Matched Resorts:', exactMatchedResorts);

                // Update map and search results
                updateMapMarkers(exactMatchedResorts.length > 0 ? exactMatchedResorts : matchedResorts);
                updateSearchResults(exactMatchedResorts.length > 0 ? exactMatchedResorts : matchedResorts);
            }

            function extractKeywordsManually(query) {
                // Split the query into keywords, handling phrases in quotes
                const keywords = [];
                const quotedPhraseRegex = /"([^"]*)"/g;
                let match;

                // Extract quoted phrases first
                while ((match = quotedPhraseRegex.exec(query)) !== null) {
                    keywords.push(match[1].toLowerCase());
                    query = query.replace(match[0], '');
                }

                // Add remaining non-quoted words
                keywords.push(...query.split(/\s+/).filter(k => k.trim() !== ''));

                return keywords;
            }

            document.getElementById('send-button').addEventListener('click', sendMessage);
            document.getElementById('chat-input').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });
        });
    </script>

    {{-- NLP Testing --}}
    {{-- <script type="module">
        import { GoogleGenerativeAI } from "@google/generative-ai";

        document.addEventListener('DOMContentLoaded', function() {
            const chatButton = document.querySelector('.chatbox__button');
            const chatSupport = document.querySelector('.chatbox__support');
            const chatInput = document.getElementById('chat-input');
            const contentBox = document.getElementById('content-box');

            chatButton.addEventListener('click', function() {
                chatSupport.classList.toggle('chatbox--active');
            });

            function addMessage(message, sender) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('messages__item', `messages__item--${sender}`);
                messageElement.textContent = message;
                contentBox.appendChild(messageElement);
                contentBox.scrollTop = contentBox.scrollHeight;
            }

            var map = null;
            var markers = [];
            var userMarker = null;
            var resorts = @json($resortArray);
            var resortRatings = @json($resortRatings);

            console.log('Resorts:', resorts);
            console.log('Resort Ratings:', resortRatings);

            if (!Array.isArray(resorts)) {
                resorts = [resorts];
            }

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

            function generateResortHTML(resort) {
                var isDisabled = resort.status === 1;
                const resortId = resort.id;
                var resortName = resort.name;
                var resortLocation = resort.location;
                var resortState = resort.state;
                var resortCountry = resort.country;
                var resortDescription = resort.description;
                var resortImages = resort.images || [];
                var resortRating = resortRatings[resortId] || {
                    averageRating: 0,
                    count: 0
                };

                var averageRating = resortRating.averageRating !== undefined && !isNaN(resortRating.averageRating) ?
                    resortRating.averageRating : 0;

                var imageURL = (resort.image || (resortImages.length > 0 && resortImages[0].image)) ?
                    "{{ asset('images/') }}/" + (resort.image || resortImages[0].image) :
                    null;

                return `
                    <div class="resort-card ${isDisabled ? 'disabled' : ''}" id="resortcard_${resortId}">
                        <div class="resort-image">
                            ${imageURL ? `<img src="${imageURL}" alt="${resortName}">` : `
                                                        <div class="no-image-box">
                                                            <span>No Image</span>
                                                        </div>`}
                        </div>
                        <div class="resort-content">
                            <h2 class="resort-title">
                                <i class="fas fa-hotel"></i> ${resortName}
                            </h2>
                            <p class="resort-location">
                                <i class="fas fa-map-marker-alt"></i> ${resortLocation}, ${resortState}, ${resortCountry}
                            </p>
                            <p class="resort-description">
                                <i class="fas fa-info-circle"></i> ${resortDescription.length > 100 ? resortDescription.substring(0, 100) + '...' : resortDescription}
                            </p>
                            <div class="resort-amenities">
                                <span><i class="fas fa-swimming-pool"></i> Pool</span>
                                <span><i class="fas fa-wifi"></i> Free WiFi</span>
                                <span><i class="fas fa-parking"></i> Parking</span>
                            </div>
                            <div class="resort-rating">
                                ${generateStarRating(averageRating)}
                                <span>(${averageRating.toFixed(1)})</span>
                            </div>
                            <div class="resort-actions">
                                ${isDisabled ?
                                    '<button class="btn btn-disabled">Closed</button>' :
                                    `<div class="actions">
                                                                <form id="wishlistForm_${resortId}" action="{{ url('/wishlist/add/resort') }}/${resortId}" method="POST" style="display: inline;">
                                                                    @csrf
                                                                    <button type="submit" id="wishlist" class="btn btn-wishlist">
                                                                        <i class="fas fa-heart"></i> Wishlist
                                                                    </button>
                                                                </form>
                                                                <a href="{{ url('Resortdetail/') }}/${resortId}/view" class="btn btn-book" id="viewresort${resortId}">Book Now</a>
                                                            </div>`
                                }
                            </div>
                        </div>
                    </div>
                `;
            }

            function updateSearchResults(matchedResorts) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty();

                if (Array.isArray(matchedResorts) && matchedResorts.length > 0) {
                    matchedResorts.forEach(function(resort) {
                        if (resort.register_status === 1) {
                            var resortHTML = generateResortHTML(resort);
                            resultsContainer.append(resortHTML);
                        }
                    });
                } else {
                    resultsContainer.html('<p class="no-results">No Resorts Found</p>');
                }
            }

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var matchedResorts = resorts.filter(function(resort) {
                    return resort.name.toLowerCase().includes(searchInputValue) ||
                        resort.country.toLowerCase().includes(searchInputValue) ||
                        resort.state.toLowerCase().includes(searchInputValue) ||
                        resort.location.toLowerCase().includes(searchInputValue) ||
                        resort.description.toLowerCase().includes(searchInputValue);
                });

                updateMapMarkers(matchedResorts);
                updateSearchResults(matchedResorts);
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
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Upload and search data:', data);

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
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Nearby resorts data:', data);
                        if (Array.isArray(data)) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else if (data.error) {
                            alert(data.message);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching nearby resorts:', error);
                    });
            }

            document.getElementById('openGPSButton').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        if (userMarker) {
                            map.removeLayer(userMarker);
                        }
                        userMarker = L.marker([latitude, longitude]).addTo(map).bindPopup(
                            "You are here!").openPopup();
                        markers.push(userMarker);

                        L.circle([latitude, longitude], {
                            color: 'blue',
                            fillColor: '#30f',
                            fillOpacity: 0.2,
                            radius: 15000 // 15 km radius
                        }).addTo(map);

                        fetchNearbyResorts(latitude, longitude);
                        map.setView([latitude, longitude], 13);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            });

            const API_KEY = "AIzaSyDQVtdIHsPihe5km66Ptiukc7D3UcHr5RY"; // Replace with your API key
            const genAI = new GoogleGenerativeAI(API_KEY);
            const model = genAI.getGenerativeModel({
                model: "gemini-1.5-flash"
            });

            async function sendMessage() {
                const input = document.getElementById('chat-input');
                const message = input.value;
                if (message.trim() === '') return;

                const contentBox = document.getElementById('content-box');
                const visitorMessage = document.createElement('div');
                visitorMessage.className = 'messages__item messages__item--visitor';
                visitorMessage.textContent = message;
                contentBox.appendChild(visitorMessage);
                contentBox.scrollTop = contentBox.scrollHeight;

                input.value = '';

                try {
                    const result = await model.generateContent(message);
                    const response = result.response.text();
                    const operatorMessage = document.createElement('div');
                    operatorMessage.className = 'messages__item messages__item--operator';
                    operatorMessage.textContent = response;
                    contentBox.appendChild(operatorMessage);
                    contentBox.scrollTop = contentBox.scrollHeight;

                    // 处理用户查询
                    handleUserQuery(message);
                } catch (error) {
                    console.error('Error:', error);
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'messages__item messages__item--error';
                    errorMessage.textContent = 'Error: ' + error.message;
                    contentBox.appendChild(errorMessage);
                    contentBox.scrollTop = contentBox.scrollHeight;
                }
            }

            async function handleUserQuery(query) {
                try {
                    const response = await fetch('/analyze-query', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            query
                        })
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(
                            `Network response was not ok: ${response.status} ${response.statusText}\n${errorText}`
                        );
                    }

                    const matchedResorts = await response.json();
                    console.log('Matched Resorts:', matchedResorts);

                    updateMapMarkers(matchedResorts);
                    updateSearchResults(matchedResorts);
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                }
            }

            document.getElementById('send-button').addEventListener('click', sendMessage);
            document.getElementById('chat-input').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });
        });
    </script> --}}
    
@endsection
