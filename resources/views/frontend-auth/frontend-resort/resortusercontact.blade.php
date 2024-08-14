@extends('frontend-auth.newlayout')

@section('frontend-section')
    <br><br><br><br><br><br><br>

    <!-- Contact Section Starts -->
    <section class="contact" id="contact">
        <h1 class="heading">
            <span>C</span>
            <span>o</span>
            <span>n</span>
            <span>t</span>
            <span>a</span>
            <span>c</span>
            <span>t</span>
        </h1>

        <div class="row">
            <div class="img">
                <img src="{{ asset('new/img/book-img.jpg') }}" alt="">
            </div>
            <form action="{{ url('contactresort') }}" method="post">
                @csrf

                {{-- <div class="inputBox">
                <input type="text" name="name" placeholder="name">
                <input type="email" name="email" placeholder="email">
            </div> --}}
                <input type="text" name="name" value="{{ auth()->user()->name }}">
                <input type="text" name="email" value="{{ auth()->user()->email }}">

                <input type="text" name="ownertype" value="{{ $resorts->name }}">
                <input type="text" name="ownername" value="{{ $resorts->user->name }}">

                <div class="inputBox">
                    <input type="number" name="phone" placeholder="Phone Number">
                    <input type="text" name="subject" placeholder="subject">
                </div>
                <textarea placeholder="message" name="message" cols="30" rows="10"></textarea>
                <input type="submit" class="btn" value="send message">
            </form>
        </div>
    </section>

    {{-- Toastr New JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- New Toastr --}}
    <script>
        @if (Session::has('success'))
            Toastify({
                text: "{{ Session::get('success') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)"
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

    {{-- Real Time Search --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Function to update search results
            function updateSearchResults(filteredResorts) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = ''; // Clear previous results

                if (filteredResorts.length > 0) {
                    filteredResorts.forEach(function(resorts) {
                        // Check if resorts is disabled
                        var isDisabled = resorts.status === 1;

                        // Create and append HTML for each hotel
                        var resortHTML = '<div class="concert ' + (isDisabled ? 'disabled' : '') + '">' +
                            '<div class="concert-main" id="resortcard_' + resorts.id + '">' +
                            '<img class="concert-image" src="{{ asset('images/') }}/' + resorts.image +
                            '" alt=" Image" />' +
                            '<h2 class="concert-title">' + resorts.name +
                            ' <i class="fas fa-resort"></i></h2>' +
                            '<p class="concert-description"><i class="fas fa-info-circle"></i> ' + resorts
                            .description + '</p>' +
                            '<hr />' +
                            '<div class="concert-creator">' +
                            '<p style="color:#C9C3C2; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="fas fa-map-marker-alt">' +
                            '<span style="color: #DAA520; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                                resorts.type + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#C9C3C2; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #ffb700; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                                resorts.location + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#C9C3C2; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #ffb700; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                                resorts.state + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-creator">' +
                            '<p style="color:#C9C3C2; font-family: \'Oswald\', sans-serif;">' +
                            '<i class="bi bi-geo-alt-fill">' +
                            '<span style="color: #ce9400; font-size:18px;font-family: \'Oswald\', sans-serif;">' +
                                resorts.country + '</span>' +
                            '</i>' +
                            '</p>' +
                            '</div>' +
                            '<div class="concert-info">' +
                            '<div class="concert-action-container">' +
                            (isDisabled ?
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                '<a href="{{ url('Resortdetail/') }}/' + resorts.id +
                                '/view" class="concert-action disabled">Closed</a>' :
                                '<p>' + new Date().toLocaleString('en-US', {
                                    timeZone: 'Asia/Kuala_Lumpur'
                                }) + '</p>' +
                                '<a href="{{ url('Resortdetail/') }}/' + resorts.id +
                                '/view" class="concert-action" id="viewresort' + resorts.id +
                                '">Book Now</a>'
                            ) +
                            '</div>' +
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

            // Initial search on page load
            var initialResorts = <?php echo json_encode($resort); ?>; // Assuming $resort is available in the Blade template
            updateSearchResults(initialResorts);

            // Check if initialResorts is an array
            // if (Array.isArray(initialResorts)) {
            //     updateSearchResults(initialResorts);
            // } else {
            //     console.error('Invalid initialResorts data:', initialResorts);
            //     // Handle the error or provide a default behavior
            // }

            // Event listener for the search input
            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            // Function to perform real-time search
            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var resort = <?php echo json_encode($resort); ?>; // Assuming $resort is available in the Blade template

                // Filter resort based on search input
                var filteredResorts = resort.filter(function(hotel) {
                    return hotel.name.toLowerCase().includes(searchInputValue);
                });

                // Update the content of the search results container
                updateSearchResults(filteredResorts);
            }
        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach ($resort as $resorts)
                @if ($resorts->status == 1)
                    let resortcard = document.getElementById('resortcard_{{ $resorts->id }}');
                    let viewresort = document.getElementById('viewresort{{ $resorts->id }}');

                    if (resortcard) {
                        resortcard.classList.add('disabled');
                    }

                    if (viewresort) {
                        viewresort.removeAttribute('disabled');
                    }
                @else
                    let resortcard = document.getElementById('resortcard_{{ $resorts->id }}');
                    let viewresort = document.getElementById('viewresort{{ $resorts->id }}');

                    if (resortcard) {
                        resortcard.classList.remove('disabled');
                    }

                    if (viewresort) {
                        viewresort.setAttribute('disabled', 'disabled');
                    }
                @endif
            @endforeach
        });
    </script> --}}

    <!-- Contact Section Ends -->
@endsection
