@extends('auth.layout')

@section('main-section')

<div id="map" style="height: 500px;"></div>

<!-- tour section -->
<section class = "tour section-py" id = "tour">
    <div class = "container">
        <span class = "section-name">
            Special Resort
        </span>
        <h2 class = "section-title">
            <span>Resort</span>
        </h2>

        <div class = "tour-wrapper">
            <!-- single tour card -->

            @foreach($resort as $resorts)
            <div class = "card">
                <div class="row">
                    <img src = "{{ asset('images/' . $resorts->image) }}" alt = "tour places">
                    <div class = "card-body">
                        <div class = "tour-place">
                            <h1 class = "normal-text">Resort Name : {{$resorts->name}}</h1>
                            <h2 class = "tour-price">Resort Price : RM{{$resorts->price}}</h2>
                        </div>
                        <h6 class = "rating-text">Rating</h6>
                        <div class = "rating">
                            <span><i class = "fas fa-star"></i></span>
                            <span><i class = "fas fa-star"></i></span>
                            <span><i class = "fas fa-star"></i></span>
                            <span><i class = "fas fa-star"></i></span>
                            <span><i class = "far fa-star"></i></span>
                        </div>
                        <h3><p class = "normal-para">Resort Location : {{$resorts->location}}</p></h3>
                        <h3><p class = "normal-para">Resort Description :{{$resorts->description}}</p></h3>
                        <hr>
                    </div>
                    <div class = "card-footer">
                        <a href="{{url('allResort/'.$resorts->id).'/view'}}"><button class ="button-31">View Resort Detail</button></a>
                        <a href=""><button class ="button-32">Booking</button></a>
                    </div>
                </div>
            </div>
            <!-- end of single tour card -->
            @endforeach
        </div>
    </div>
</section>
<!-- end of tour section -->

<script>
function initMap() {

    var kualaLumpur = new google.maps.LatLng(3.1390, 101.6869);
    var johorBahru = new google.maps.LatLng(1.4927, 103.7414);

    var resorts = @json($resort);

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: 1.4927, lng: 103.7414 }
    });

    resorts.forEach(function(resort) {
        var marker = new google.maps.Marker({
            position: { lat: parseFloat(resort.latitude), lng: parseFloat(resort.longitude) },
            map: map,
            title: resort.name
        });
    });
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG2YHIuPJYMOJzS6wSw5eZ0dTYXnhZFLs&callback=initMap"></script>

@endsection
