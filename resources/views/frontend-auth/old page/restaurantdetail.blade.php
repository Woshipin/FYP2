@extends('auth.layout')

@section('main-section')

<!-- tour section -->
<section class="tour section-py" id="tour">
    <div class="container">
        <span class="section-name">
            Special Restaurant
        </span>
        <h2 class="section-title">
            <span>Restaurant</span>
        </h2>


        <div class="tour-wrapper">
            <!-- single tour card -->
            <div class="card">
                <img src="{{ asset('images/' . $restaurant->image) }}" alt="tour places">
                <div class="card-body">
                    <div class="tour-place">
                        <h2 class="normal-text">Restaurant Name: {{ $restaurant->name }}</h2>
                    </div>
                    <h3><p class="normal-para">Restaurant Open Date: {{ $restaurant->date }}</p></h3>
                    <h3><p class="normal-para">Restaurant Open Time: {{ $restaurant->time }}</p></h3>
                    <h3><p class="normal-para">Restaurant Address: {{ $restaurant->address }}</p></h3>
                    <h3><p class="normal-para">Restaurant Description: {{ $restaurant->description }}</p></h3>
                    <hr>
                </div>
                <!-- <div class="card-footer">
                    <button type="button" class="btn btn-info">View Resort Detail</button>
                    <button class="btn-green">Booking</button>
                </div> -->
            </div>
            <!-- end of single tour card -->

        </div>

        <div id="map"><iframe src="{{$restaurant->map}}" width="1325" height="450"></iframe></div>
        <br><br>
    </div>
</section>
<!-- end of tour section -->

<!-- <script>
    function initMap() {
        var restaurant = @json($restaurant);

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: { lat: parseFloat(restaurant.latitude), lng: parseFloat(restaurant.longitude) }
        });

        var marker = new google.maps.Marker({
            position: { lat: parseFloat(restaurant.latitude), lng: parseFloat(restaurant.longitude) },
            map: map,
            title: restaurant.name
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG2YHIuPJYMOJzS6wSw5eZ0dTYXnhZFLs&callback=initMap" async defer></script> -->

@endsection
