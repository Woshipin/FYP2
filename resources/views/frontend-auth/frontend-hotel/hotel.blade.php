@extends('frontend-auth.newlayout')

@section('frontend-section')
    {{-- Hotel-Status Pusher --}}
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
            /* margin: 10px;
                                                                                                                                                                                                padding: 10px; */
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
        }

        */
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
    <link rel="stylesheet" href="{{ asset('new/card/hotelcard.css') }}">

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

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-BxGoSTaGW2MuHiZfxZI6f6pHVC2zTbCspWtZtSfRjJGevW8C3t/Gt9X9i66nTlUxV1dpnh4q9pxGq+Jz4YR6Jw=="
        crossorigin="anonymous" />

    <br><br><br>

    <!-- ##### Breadcumb Area Start ##### -->

    <section class="breadcumb-area bg-img bg-overlay" style="height: 200px;">
        <div class="bg-overlay">
            <video autoplay muted loop playsinline class="bg-video">
                <source src="{{ asset('new/img/vid-4.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

        <div class="bradcumbContent">
            <p>See what's new</p>
            <h2>Hotel</h2>
        </div>
    </section>

    <!-- ##### Breadcumb Area End ##### -->

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
                <input type="search" name="search" id="searchInput" class="form-control" placeholder="Search Hotels">
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
            var hotels = @json($hotels);
            console.log(hotels); // 调试输出 hotels 变量

            if (!Array.isArray(hotels)) {
                console.error('hotels is not an array');
            }

            // 设置地图中心到马来西亚，并设置适当的缩放级别
            var map = L.map('map').setView([4.2105, 101.9758], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            hotels.forEach(function(hotels) {
                var mapIframe = hotels.map;
                console.log('mapIframe', mapIframe);

                var coordinates = getCoordinatesFromIframe(mapIframe);
                if (coordinates) {
                    L.marker([coordinates.lat, coordinates.lng]).addTo(map)
                        .bindPopup('<b>' + hotels.name + '</b><br>' + hotels.address);
                }
            });

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
        });
    </script> --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var hotels = @json($hotels);

            if (!Array.isArray(hotels)) {
                console.error('hotels is not an array');
            }

            // Initialize map centered on Malaysia
            var map = L.map('map').setView([4.2105, 101.9758], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Function to update map markers based on hotels array
            function updateMapMarkers(hotels) {
                map.eachLayer(function (layer) {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                });

                hotels.forEach(function(hotel) {
                    var mapIframe = hotel.map;
                    var coordinates = getCoordinatesFromIframe(mapIframe);
                    if (coordinates) {
                        L.marker([coordinates.lat, coordinates.lng]).addTo(map)
                            .bindPopup('<b>' + hotel.name + '</b><br>' + hotel.address);
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
            updateMapMarkers(hotels);

            // Function to filter hotels based on search input
            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var filteredHotels = hotels.filter(function(hotel) {
                    return hotel.name.toLowerCase().includes(searchInputValue) ||
                           hotel.country.toLowerCase().includes(searchInputValue) ||
                           hotel.state.toLowerCase().includes(searchInputValue) ||
                           hotel.address.toLowerCase().includes(searchInputValue) ||
                           hotel.description.toLowerCase().includes(searchInputValue);
                });

                updateMapMarkers(filteredHotels);
                updateSearchResults(filteredHotels);
            }

            // Function to update search results
            function updateSearchResults(filteredHotels) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = '';

                if (filteredHotels.length > 0) {
                    filteredHotels.forEach(function(hotel) {
                        var hotelHTML = '<div class="hotel-result">' +
                            '<h2>' + hotel.name + '</h2>' +
                            '<p>' + hotel.address + ', ' + hotel.state + ', ' + hotel.country + '</p>' +
                            '<p>' + hotel.description + '</p>' +
                            '</div>';
                        resultsContainer.innerHTML += hotelHTML;
                    });
                } else {
                    resultsContainer.innerHTML = '<p>No Hotels Found</p>';
                }
            }

            // Attach event listener to search input
            document.getElementById('searchInput').addEventListener('input', performSearch);
        });
    </script> --}}

    {{-- Real Time Search --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to update search results
            // function updateSearchResults(filteredHotels) {
            //     var resultsContainer = document.getElementById('searchResultsContainer');
            //     resultsContainer.innerHTML = ''; // Clear previous results

            //     if (filteredHotels.length > 0) {
            //         filteredHotels.forEach(function(hotel) {
            //             // Create and append HTML for each hotel
            //             var hotelHTML = '<div class="concert">' +
            //                 '<div class="concert-main" id="hotelcard_' + hotel.id + '">' +
            //                 '<img class="concert-image" src="{{ asset('images/') }}/' + hotel.image +
            //                 '" alt=" Image" />' +
            //                 '<h2 class="concert-title">' + hotel.name +
            //                 ' <i class="fas fa-hotel"></i></h2>' +
            //                 '<p class="concert-description"><i class="fas fa-info-circle"></i> ' + hotel
            //                 .description + '</p>' +
            //                 '<hr />' +
            //                 '<div class="concert-creator">' +
            //                 '<p style="color:#C9C3C2; font-family: \'Oswald\', sans-serif;">' +
            //                 '<i class="fas fa-map-marker-alt">' +
            //                 '<span style="color: #DAA520; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
            //                 hotel.address + '</span>' +
            //                 '</i>' +
            //                 '</p>' +
            //                 '</div>' +
            //                 '<div class="concert-creator">' +
            //                 '<p style="color:#C9C3C2; font-family: \'Oswald\', sans-serif;">' +
            //                 '<i class="bi bi-geo-alt-fill">' +
            //                 '<span style="color: #ffb700; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
            //                 hotel.state + '</span>' +
            //                 '</i>' +
            //                 '</p>' +
            //                 '</div>' +
            //                 '<div class="concert-creator">' +
            //                 '<p style="color:#C9C3C2; font-family: \'Oswald\', sans-serif;">' +
            //                 '<i class="bi bi-geo-alt-fill">' +
            //                 '<span style="color: #ce9400; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
            //                 hotel.country + '</span>' +
            //                 '</i>' +
            //                 '</p>' +
            //                 '</div>' +
            //                 '<div class="concert-info">' +
            //                 '<div class="concert-action-container">' +
            //                 (hotel.status == 0 ?
            //                     '<p>' + new Date().toLocaleString('en-US', {
            //                         timeZone: 'Asia/Kuala_Lumpur'
            //                     }) + '</p>' +
            //                     '<a href="{{ url('Hoteldetail/') }}/' + hotel.id +
            //                     '/view" class="concert-action">Book Now</a>' :
            //                     '<p>' + new Date().toLocaleString('en-US', {
            //                         timeZone: 'Asia/Kuala_Lumpur'
            //                     }) + '</p>' +
            //                     '<a href="{{ url('Hoteldetail/') }}/' + hotel.id +
            //                     '/view" class="concert-action" id="viewhotel' + hotel.id + '">Closed</a>'
            //                 ) +
            //                 '</div>' +
            //                 '</div>' +
            //                 '</div>' +
            //                 '</div>';

            //             resultsContainer.innerHTML += hotelHTML;
            //         });
            //     } else {
            //         resultsContainer.innerHTML =
            //             '<p style="margin-top:40px; font-size:24px; display:block">No Events Found</p>';
            //     }
            // }

            // Function to update search results
            function updateSearchResults(filteredHotels) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = ''; // Clear previous results

                if (filteredHotels.length > 0) {
                    filteredHotels.forEach(function(hotel) {
                        // Check if hotel is disabled
                        var isDisabled = hotel.status === 1;

                        // Create and append HTML for each hotel
                        var hotelHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') + '">' +
                            '<div class="concert-main" id="hotelcard_' + hotel.id + '">' +
                            '<img class="concert-image" src="{{ asset('images/') }}/' + hotel.image +
                            '" alt=" Image" />' +
                            '<h2 class="concert-title">' + hotel.name +
                            ' <i class="fas fa-hotel"></i></h2>' +
                            '<p class="concert-description"><i class="fas fa-info-circle"></i> ' + hotel
                            .description + '</p>' +
                            '<hr />' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="fas fa-map-marker-alt">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                            hotel.address + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                            hotel.state + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                            hotel.country + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-info">' +
                            '<div class="concert-action-container">' +
                            (isDisabled ?
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                '<a href="{{ url('Hoteldetail/') }}/' + hotel.id +
                                '/view" class="concert-action disabled">Closed</a>' :
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                '<a href="{{ url('Hoteldetail/') }}/' + hotel.id +
                                '/view" class="concert-action" id="viewhotel' + hotel.id + '">Book Now</a>'
                            ) +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        resultsContainer.innerHTML += hotelHTML;
                    });
                } else {
                    resultsContainer.innerHTML =
                        '<p style="margin-top:40px; font-size:24px; display:block">No Hotels Found</p>';
                }
            }

            // Initial search on page load
            var initialHotels = <?php echo json_encode($hotels); ?>; // Assuming $hotels is available in the Blade template
            updateSearchResults(initialHotels);

            // Event listener for the search input
            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            // Function to perform real-time search
            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var hotels = <?php echo json_encode($hotels); ?>; // Assuming $hotels is available in the Blade template

                // Filter hotels based on search input
                var filteredHotels = hotels.filter(function(hotel) {
                    return hotel.name.toLowerCase().includes(searchInputValue);
                });

                // Update the content of the search results container
                updateSearchResults(filteredHotels);
            }
        });
    </script> --}}

    {{-- Full Correct  Real Time Search Code --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateSearchResults(filteredHotels) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = '';

                if (filteredHotels.length > 0) {
                    filteredHotels.forEach(function(hotel) {
                        var isDisabled = hotel.status === 1;

                        // Access hotel information using data attributes
                        const hotelId = hotel.id;
                        var hotelName = hotel.name;
                        var hotelAddress = hotel.address;
                        var hotelState = hotel.state;
                        var hotelCountry = hotel.country;
                        var hotelImage = hotel.image;
                        var hotelDescription = hotel.description;

                        // Check if the hotel image is null
                        var hotelImageSrc = hotelImage ? '{{ asset('images/') }}/' + hotelImage :
                            'path/to/placeholder-image.jpg';
                        var hotelAltText = hotelImage ? 'Image' : 'No Image';

                        var hotelHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') + '">' +
                            '<div class="wishlist-button-container">' +
                            '<div class="concert-main" id="hotelcard_' + hotelId + '">' +
                            '<img class="concert-image" src="' + hotelImageSrc + '" alt="' + hotelAltText +
                            '" />' +
                            '<h2 class="concert-title">' + hotelName +
                            ' <i class="fas fa-hotel"></i></h2>' +
                            '<p class="concert-description"><i class="fas fa-info-circle"></i> ' +
                            hotelDescription + '</p>' +
                            '<hr />' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="fas fa-map-marker-alt">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                            hotelAddress + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                            hotelState + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                            hotelCountry + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-info">' +
                            '<div class="concert-action-container">' +
                            (isDisabled ?
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                '/view" class="concert-action disabled">Closed</a>' :
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                '<div class="wishlist-button-container">' +
                                '<form id="wishlistForm" action="{{ url('/wishlist/add/hotel') }}/' + hotelId +
                                '" method="POST">' +
                                '@csrf<button type="submit" id="wishlist" class="concert-action">Wishlist</button></form>' +
                                '</div>' +
                                '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                '/view" class="concert-action" id="viewhotel' + hotelId + '">Book Now</a>'
                            ) +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        resultsContainer.innerHTML += hotelHTML;
                    });
                } else {
                    resultsContainer.innerHTML =
                        '<p style="margin-top:40px; font-size:24px; display:block">No Hotels Found</p>';
                }
            }

            // Sample data for initialHotels, replace it with your actual JSON data
            var initialHotels = <?php echo json_encode($hotels); ?>;
            updateSearchResults(initialHotels);

            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var hotels = <?php echo json_encode($hotels); ?>;

                var filteredHotels = hotels.filter(function(hotel) {
                    return hotel.name.toLowerCase().includes(searchInputValue);
                });

                updateSearchResults(filteredHotels);
            }
        });
    </script> --}}

    {{-- Full Correct Real Time Search Code --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateSearchResults(filteredHotels) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = '';

                if (filteredHotels.length > 0) {
                    filteredHotels.forEach(function(hotel) {
                        var isDisabled = hotel.status === 1;

                        const hotelId = hotel.id;
                        var hotelName = hotel.name;
                        var hotelAddress = hotel.address;
                        var hotelState = hotel.state;
                        var hotelCountry = hotel.country;
                        var hotelImage = hotel.image;
                        var hotelDescription = hotel.description;

                        var hotelImageSrc = hotelImage ? '{{ asset('images/') }}/' + hotelImage :
                            'path/to/placeholder-image.jpg';
                        var hotelAltText = hotelImage ? 'Image' : 'No Image';

                        var hotelHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') + '">' +
                            '<div class="wishlist-button-container">' +
                            '<div class="concert-main" id="hotelcard_' + hotelId + '">' +
                            '<img class="concert-image" src="' + hotelImageSrc + '" alt="' + hotelAltText +
                            '" />' +
                            '<h2 class="concert-title">' + hotelName +
                            ' <i class="fas fa-hotel"></i></h2>' +
                            '<p class="concert-description"><i class="fas fa-info-circle"></i> ' +
                            hotelDescription + '</p>' +
                            '<hr />' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="fas fa-map-marker-alt">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                            hotelAddress + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                            hotelState + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#000000; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #000000; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                            hotelCountry + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-info">' +
                            '<div class="concert-action-container">' +
                            (isDisabled ? '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                '/view" class="concert-action disabled">Closed</a>' :
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                '<div class="wishlist-button-container">' +
                                '<form id="wishlistForm" action="{{ url('/wishlist/add/hotel') }}/' +
                                hotelId + '" method="POST">' +
                                '@csrf<button type="submit" id="wishlist" class="concert-action">Wishlist</button></form>' +
                                '</div>' +
                                '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                '/view" class="concert-action" id="viewhotel' + hotelId + '">Book Now</a>'
                            ) +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        resultsContainer.innerHTML += hotelHTML;
                    });
                } else {
                    resultsContainer.innerHTML =
                        '<p style="margin-top:40px; font-size:24px; display:block">No Hotels Found</p>';
                }
            }

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value;

                fetch(`{{ route('hotelsearch') }}?search=${searchInputValue}`, {
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
            var initialHotels = <?php echo json_encode($hotels); ?>;
            updateSearchResults(initialHotels);
        });
    </script> --}}

    {{-- Full Image Search Function --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('imageUploadForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch('{{ route('uploadAndSearchHotels') }}', {
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
                        updateSearchResults(data);
                    })
                    .catch(error => console.error('Error:', error));
            });

            function updateSearchResults(filteredHotels) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = '';

                if (filteredHotels.length > 0) {
                    filteredHotels.forEach(function(hotel) {
                        var isDisabled = hotel.status === 1;

                        var hotelHTML = `
                            <div class="concert ${isDisabled ? 'disabled' : ''}">
                                <div class="wishlist-button-container">
                                    <div class="concert-main" id="hotelcard_${hotel.id}">
                                        <img class="concert-image" src="{{ asset('images/') }}/${hotel.image}" alt="${hotel.image ? 'Image' : 'No Image'}" />
                                        <h2 class="concert-title">${hotel.name} <i class="fas fa-hotel"></i></h2>
                                        <p class="concert-description"><i class="fas fa-info-circle"></i> ${hotel.description}</p>
                                        <hr />
                                        <div class="concert-creator">
                                            <p style="color:#000000; font-family: 'Oswald', sans-serif;">
                                                <i class="fas fa-map-marker-alt">
                                                    <span style="color: #000000; font-size:18px;font-family: 'Oswald', sans-serif;">${hotel.location}</span>
                                                </i>
                                            </p>
                                        </div>
                                        <div class="concert-creator">
                                            <p style="color:#000000; font-family: 'Oswald', sans-serif;">
                                                <i class="bi bi-geo-alt-fill">
                                                    <span style="color: #000000; font-size:18px;font-family: 'Oswald', sans-serif;">${hotel.state}</span>
                                                </i>
                                            </p>
                                        </div>
                                        <div class="concert-creator">
                                            <p style="color:#000000; font-family: 'Oswald', sans-serif;">
                                                <i class="bi bi-geo-alt-fill">
                                                    <span style="color: #000000; font-size:18px;font-family: 'Oswald', sans-serif;">${hotel.country}</span>
                                                </i>
                                            </p>
                                        </div>
                                        <div class="concert-info">
                                            <div class="concert-action-container">
                                                ${isDisabled ? `
                                                            <p>${new Date().toLocaleString('en-US', { timeZone: 'Asia/Kuala_Lumpur' })}</p>
                                                            <a href="{{ url('Hoteldetail/') }}/${hotel.id}/view" class="concert-action disabled">Closed</a>
                                                        ` : `
                                                            <p>${new Date().toLocaleString('en-US', { timeZone: 'Asia/Kuala_Lumpur' })}</p>
                                                            <div class="wishlist-button-container">
                                                                <form id="wishlistForm" action="{{ url('/wishlist/add/hotel') }}/${hotel.id}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" id="wishlist" class="concert-action">Wishlist</button>
                                                                </form>
                                                            </div>
                                                            <a href="{{ url('Hoteldetail/') }}/${hotel.id}/view" class="concert-action" id="viewhotel${hotel.id}">Book Now</a>
                                                        `}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        resultsContainer.innerHTML += hotelHTML;
                    });
                } else {
                    alert('Image not found');
                }
            }
        });
    </script> --}}

    {{-- Image Search and display Google map position function --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var hotels = <?php echo json_encode($hotels); ?>;

            // Initialize map function
            function initMap() {
                if (map === null) {
                    map = L.map('map').setView([4.2105, 101.9758], 7);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                }
            }

            // Update map markers function
            function updateMapMarkers(hotels) {
                if (map === null) {
                    console.error('地图尚未初始化');
                    return;
                }

                markers.forEach(function(marker) {
                    map.removeLayer(marker);
                });
                markers = [];

                if (Array.isArray(hotels)) {
                    hotels.forEach(function(hotel) {
                        if (hotel.latitude && hotel.longitude) {
                            var marker = L.marker([hotel.latitude, hotel.longitude]).addTo(map)
                                .bindPopup('<b>' + hotel.name + '</b><br>' + hotel.address);
                            markers.push(marker);
                        }
                    });
                } else {
                    console.error('Expected an array of hotels but received:', hotels);
                }
            }

            // Update search results function
            function updateSearchResults(filteredHotels) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty(); // Clear existing content

                if (Array.isArray(filteredHotels) && filteredHotels.length > 0) {
                    filteredHotels.forEach(function(hotel) {
                        if (hotel.register_status === 1) {
                            var isDisabled = hotel.status === 1;
                            const hotelId = hotel.id;
                            var hotelName = hotel.name;
                            var hotelLocation = hotel.address;
                            var hotelState = hotel.state;
                            var hotelCountry = hotel.country;
                            var hotelDescription = hotel.description;
                            var hotelImages = hotel.images || []; // Default to empty array

                            // Display only the first image
                            var firstImageHTML = hotelImages.length > 0 && hotelImages[0].image ?
                                `<img class="concert-image" src="{{ asset('images/') }}/${hotelImages[0].image}" alt="Image" />` :
                                `<img class="concert-image" src="path/to/placeholder-image.jpg" alt="No Image" />`;

                            var hotelHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') + '">' +
                                '<div class="concert-main" id="hotelcard_' + hotelId + '">' +
                                firstImageHTML + // Display only the first image here
                                '<div class="concert-content">' +
                                '<h2 class="concert-title">' +
                                '<i class="fas fa-hotel"></i> ' + hotelName + ' ' +
                                '</h2>' +
                                '<p class="concert-description">' +
                                '<i class="fas fa-info-circle"></i> ' + hotelDescription +
                                '</p>' +
                                '<div class="concert-creator">' +
                                '<p><i class="fas fa-map-marker-alt"></i> ' + hotelLocation + '</p>' +
                                '</div>' +
                                '<div class="concert-action-container">' +
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                (isDisabled ?
                                    '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                    '/view" class="concert-action disabled">Closed</a>' :
                                    '<form id="wishlistForm" action="{{ url('/wishlist/add/hotel') }}/' +
                                    hotelId + '" method="POST">' +
                                    '@csrf<button type="submit" id="wishlist" class="concert-action"><i class="fas fa-heart"></i> Wishlist</button></form>' +
                                    '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                    '/view" class="concert-action" id="viewhotel' + hotelId + '">Book Now</a>'
                                ) +
                                '</div>' +
                                '</div>' +
                                '</div>';

                            resultsContainer.append(hotelHTML);
                        }
                    });
                } else {
                    resultsContainer.html(
                        '<p style="margin-top:40px; font-size:24px; display:block">No Hotels Found</p>'
                    );
                }
            }

            // Perform search function
            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value
                    .toLowerCase();
                var filteredHotels = hotels.filter(function(hotel) {
                    return hotel.name.toLowerCase().includes(searchInputValue) ||
                        hotel.country.toLowerCase().includes(searchInputValue) ||
                        hotel.state.toLowerCase().includes(searchInputValue) ||
                        hotel.address.toLowerCase().includes(searchInputValue) ||
                        hotel.description.toLowerCase().includes(searchInputValue);
                });

                // Update map markers and search results
                updateMapMarkers(filteredHotels);
                updateSearchResults(filteredHotels);
            }

            // Listen for search input changes
            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            // Listen for image upload form submission
            document.getElementById('imageUploadForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch('{{ route('uploadAndSearch') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')
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

            // Initialize map
            initMap();

            // Show all hotels on page load
            if (Array.isArray(hotels)) {
                updateMapMarkers(hotels);
                updateSearchResults(hotels);
            } else {
                console.error('hotels is not an array:', hotels);
            }

            // Fetch nearby hotels function
            function fetchNearbyHotels(latitude, longitude) {
                fetch(`/gps-search?latitude=${latitude}&longitude=${longitude}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('附近酒店数据:', data); // 调试输出
                        if (Array.isArray(data)) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.error('获取的数据不是数组:', data);
                        }
                    })
                    .catch(error => console.error('获取附近酒店时发生错误:', error));
            }

            // Listen for open GPS button click event
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

                        fetchNearbyHotels(latitude, longitude);
                    }, function(error) {
                        console.error('地理定位错误:', error);
                    });
                } else {
                    console.error('此浏览器不支持地理定位。');
                }
            });

        });
    </script> --}}

    {{-- Full Real Time Search, Detection Image and GPS Function --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var userMarker = null; // 存储用户标记
            var hotels = <?php echo json_encode($hotels); ?>;

            // Initialize map function
            function initMap() {
                if (map === null) {
                    map = L.map('map').setView([4.2105, 101.9758], 7);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                }
            }

            // Update map markers function
            function updateMapMarkers(hotels) {
                if (map === null) {
                    console.error('Map not initialized');
                    return;
                }

                // 移除所有酒店标记
                markers.forEach(function(marker) {
                    if (marker !== userMarker) { // 跳过用户标记
                        map.removeLayer(marker);
                    }
                });
                markers = markers.filter(marker => marker !== userMarker); // 过滤掉用户标记

                if (Array.isArray(hotels)) {
                    hotels.forEach(function(hotel) {
                        if (hotel.latitude && hotel.longitude) {
                            var marker = L.marker([hotel.latitude, hotel.longitude]).addTo(map)
                                .bindPopup('<b>' + hotel.name + '</b><br>' + hotel.address);
                            markers.push(marker);
                        }
                    });
                } else {
                    console.error('Expected an array of hotels but received:', hotels);
                }
            }

            // Update search results function
            function updateSearchResults(filteredHotels) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty();

                if (Array.isArray(filteredHotels) && filteredHotels.length > 0) {
                    filteredHotels.forEach(function(hotel) {
                        if (hotel.register_status === 1) {
                            var isDisabled = hotel.status === 1;
                            const hotelId = hotel.id;
                            var hotelName = hotel.name;
                            var hotelAddress = hotel.address;
                            var hotelState = hotel.state;
                            var hotelCountry = hotel.country;
                            var hotelDescription = hotel.description;
                            var hotelImages = hotel.images || [];

                            // Use the first image from the hotel object if available, otherwise use a placeholder
                            var imageHTML = (hotel.image || (hotelImages.length > 0 && hotelImages[0]
                                    .image)) ?
                                `<img class="concert-image" src="{{ asset('images/') }}/${hotel.image || hotelImages[0].image}" alt="${hotelName}" />` :
                                `<img class="concert-image" src="{{ asset('images/placeholder-image.jpg') }}" alt="No Image" />`;

                            var hotelHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') + '">' +
                                '<div class="concert-main" id="hotelcard_' + hotelId + '">' +
                                imageHTML +
                                '<div class="concert-content">' +
                                '<h2 class="concert-title">' +
                                '<i class="fas fa-hotel"></i> ' + hotelName + ' ' +
                                '</h2>' +
                                '<p class="concert-description">' +
                                '<i class="fas fa-info-circle"></i> ' + hotelDescription +
                                '</p>' +
                                '<div class="concert-creator">' +
                                '<p><i class="fas fa-map-marker-alt"></i> ' + hotelAddress + '</p>' +
                                '</div>' +
                                '<div class="concert-action-container">' +
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                (isDisabled ?
                                    '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                    '/view" class="concert-action disabled">Closed</a>' :
                                    '<form id="wishlistForm" action="{{ url('/wishlist/add/hotel') }}/' +
                                    hotelId + '" method="POST">' +
                                    '@csrf<button type="submit" id="wishlist" class="concert-action"><i class="fas fa-heart"></i> Wishlist</button></form>' +
                                    '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                    '/view" class="concert-action" id="viewhotel' + hotelId +
                                    '">Book Now</a>'
                                ) +
                                '</div>' +
                                '</div>' +
                                '</div>';

                            resultsContainer.append(hotelHTML);
                        }
                    });
                } else {
                    resultsContainer.html(
                        '<p style="margin-top:40px; font-size:24px; display:block">No Hotels Found</p>');
                }
            }

            // Perform search function
            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var filteredHotels = hotels.filter(function(hotel) {
                    return hotel.name.toLowerCase().includes(searchInputValue) ||
                        hotel.country.toLowerCase().includes(searchInputValue) ||
                        hotel.state.toLowerCase().includes(searchInputValue) ||
                        hotel.address.toLowerCase().includes(searchInputValue) ||
                        hotel.description.toLowerCase().includes(searchInputValue);
                });

                updateMapMarkers(filteredHotels);
                updateSearchResults(filteredHotels);
            }

            // Listen for search input changes
            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            // Listen for image upload form submit event
            document.getElementById('imageUploadForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch('{{ route('uploadAndSearchHotels') }}', {
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
                        if (Array.isArray(data)) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });

            // Initialize map
            initMap();

            // Display all hotels on page load
            if (Array.isArray(hotels)) {
                updateMapMarkers(hotels);
                updateSearchResults(hotels);
            } else {
                console.error('hotels is not an array:', hotels);
            }

            // Fetch nearby hotels function
            function fetchNearbyHotels(latitude, longitude) {
                fetch(`/hotel-gps-search?latitude=${latitude}&longitude=${longitude}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Nearby hotels data:', data);
                        if (Array.isArray(data)) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => console.error('Error fetching nearby hotels:', error));
            }

            // Listen for Open GPS button click event
            document.getElementById('openGPSButton').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        if (map === null) {
                            initMap();
                        }

                        // 使用默认图标添加用户标记
                        if (userMarker) {
                            map.removeLayer(userMarker); // 移除之前的用户标记
                        }
                        userMarker = L.marker([latitude, longitude]).addTo(map)
                            .bindPopup('<b>您在这里</b>').openPopup();
                        markers.push(userMarker);

                        // 在用户位置绘制圆圈代表搜索半径
                        var searchRadius = L.circle([latitude, longitude], {
                            color: 'red',
                            fillColor: '#f03',
                            fillOpacity: 0.5,
                            radius: 150000 // 半径单位为米，150公里需要转换为米
                        }).addTo(map);

                        map.setView([latitude, longitude], 10); // 调整视图焦点到用户位置

                        // 请求附近酒店数据
                        fetchNearbyHotels(latitude, longitude);
                    }, function(error) {
                        console.error('地理定位错误:', error);
                    });
                } else {
                    console.error('此浏览器不支持地理定位。');
                }
            });
        });
    </script> --}}

    {{-- New Full Real Time Search, Detection Image and GPS Function --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = null;
            var markers = [];
            var userMarker = null;
            var hotels = <?php echo json_encode($hotels); ?>;

            function initMap() {
                if (map === null) {
                    map = L.map('map').setView([4.2105, 101.9758], 7);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);
                }
            }

            function updateMapMarkers(hotels) {
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

                if (Array.isArray(hotels)) {
                    hotels.forEach(function(hotel) {
                        if (hotel.latitude && hotel.longitude && hotel.register_status === 1) {
                            var marker = L.marker([hotel.latitude, hotel.longitude]).addTo(map)
                                .bindPopup('<b>' + hotel.name + '</b><br>' + hotel.address + '<br>' +
                                    hotel.price);
                            markers.push(marker);
                        }
                    });
                } else {
                    console.error('Expected an array of hotels but received:', hotels);
                }
            }

            function updateSearchResults(filteredHotels) {
                var resultsContainer = $('#searchResultsContainer');
                resultsContainer.empty();

                if (Array.isArray(filteredHotels) && filteredHotels.length > 0) {
                    filteredHotels.forEach(function(hotel) {
                        if (hotel.register_status === 1) {
                            var isDisabled = hotel.status === 1;
                            const hotelId = hotel.id;
                            var hotelName = hotel.name;
                            var hotelAddress = hotel.address;
                            var hotelState = hotel.state;
                            var hotelCountry = hotel.country;
                            var hotelDescription = hotel.description;
                            var hotelImages = hotel.images || [];

                            var imageURL = (hotel.image || (hotelImages.length > 0 && hotelImages[0]
                                    .image)) ?
                                "{{ asset('images/') }}/" + (hotel.image || hotelImages[0].image) :
                                "{{ asset('images/placeholder-image.jpg') }}";

                            var imageHTML =
                                `<img class="concert-image" src="${imageURL}" alt="${hotelName}" />`;

                            var hotelHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') +
                                '">' +
                                '<div class="concert-main" id="hotelcard_' + hotelId + '">' +
                                imageHTML +
                                '<div class="concert-content">' +
                                '<h2 class="concert-title">' +
                                '<i class="fas fa-hotel"></i> ' + hotelName + ' ' +
                                '</h2>' +
                                '<p class="concert-description">' +
                                '<i class="fas fa-info-circle"></i> ' + hotelDescription +
                                '</p>' +
                                '<div class="concert-creator">' +
                                '<p><i class="fas fa-map-marker-alt"></i> ' + hotelAddress + '</p>' +
                                '</div>' +
                                '<div class="concert-action-container">' +
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                (isDisabled ?
                                    '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                    '/view" class="concert-action disabled">Closed</a>' :
                                    '<form id="wishlistForm" action="{{ url('/wishlist/add/hotel') }}/' +
                                    hotelId + '" method="POST">' +
                                    '@csrf<button type="submit" id="wishlist" class="concert-action"><i class="fas fa-heart"></i> Wishlist</button></form>' +
                                    '<a href="{{ url('Hoteldetail/') }}/' + hotelId +
                                    '/view" class="concert-action" id="viewhotel' + hotelId +
                                    '">Book Now</a>'
                                ) +
                                '</div>' +
                                '</div>' +
                                '</div>';

                            resultsContainer.append(hotelHTML);
                        }
                    });
                } else {
                    resultsContainer.html(
                        '<p style="margin-top:40px; font-size:24px; display:block">No Hotels Found</p>');
                }
            }

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var filteredHotels = hotels.filter(function(hotel) {
                    return hotel.name.toLowerCase().includes(searchInputValue) ||
                        hotel.country.toLowerCase().includes(searchInputValue) ||
                        hotel.state.toLowerCase().includes(searchInputValue) ||
                        hotel.address.toLowerCase().includes(searchInputValue) ||
                        hotel.description.toLowerCase().includes(searchInputValue);
                });

                updateMapMarkers(filteredHotels);
                updateSearchResults(filteredHotels);
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

                fetch('{{ route('uploadAndSearchHotels') }}', {
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
                            alert('Detected image result: ' + data.length + ' matching hotels found.');
                        } else {
                            alert('Detected image result: No matching hotels found.');
                        }

                        if (Array.isArray(data) && data.length > 0) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.log('No matching hotels found');
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

            if (Array.isArray(hotels)) {
                updateMapMarkers(hotels);
                updateSearchResults(hotels);
            } else {
                console.error('hotels is not an array:', hotels);
            }

            function fetchNearbyHotels(latitude, longitude) {
                fetch(`/hotel-gps-search?latitude=${latitude}&longitude=${longitude}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Nearby hotels data:', data);
                        if (Array.isArray(data)) {
                            updateMapMarkers(data);
                            updateSearchResults(data);
                        } else {
                            console.error('Received data is not an array:', data);
                        }
                    })
                    .catch(error => console.error('Error fetching nearby hotels:', error));
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

                        fetchNearbyHotels(latitude, longitude);
                    }, function(error) {
                        console.error('Geolocation error:', error);
                    });
                } else {
                    console.error('This browser does not support geolocation.');
                }
            });
        });
    </script>

    // {{-- Pusher JS Disabled Function --}}
    <script>
        // JavaScript code here to disable hotel cards based on status
        let hotelcard; // Declare the variable outside of the loop
        let viewhotel;

        @foreach ($hotels as $hotel)
            @if ($hotel->status == 1)
                // Get the hotel card element for the current hotel
                hotelcard = document.getElementById('hotelcard_{{ $hotel->id }}');
                viewhotel = document.getElementById('viewhotel{{ $hotel->id }}');

                // Add the "disabled" class to style and disable the card
                hotelcard.classList.add('disabled');

                // Remove the "disabled" attribute from the View Detail button
                viewhotel.removeAttribute('disabled');
            @else
                // Remove the "disabled" class from the card
                // hotelcard.classList.remove('disabled');
                // Add the "disabled" attribute to the View Detail button
                // viewhotel.setAttribute('disabled', 'disabled');
            @endif
        @endforeach
    </script>

    // {{-- Toastr JS --}}
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

    // {{-- Show User Upload Image --}}
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
