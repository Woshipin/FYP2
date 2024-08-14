@extends('admin.layout')

@section('admin-section')
<!-- Begin Page Content -->
<br><br><br><br>
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{$resorts->name}} Detail
                <a href="{{ url('admin/Resorts')}}" class="float-right btn btn-success btn-sm">View All</a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" >
                    <tr>
                        <th>Resort Name</th>
                        <td>{{$resorts->name}}</td>
                    </tr>
                    <tr>
                        <th>Resort Price</th>
                        <td>{{$resorts->price}}</td>
                    </tr>
                    <tr>
                        <th>Resort Photo</th>
                        <td><img width="80" src="{{ asset('images/' . $resorts->image) }}" alt="Image"/></td>
                    </tr>
                    <tr>
                        <th>Resort Location</th>
                        <td>{{$resorts->location}}</td>
                    </tr>
                    <tr>
                        <th>Resort Phone</th>
                        <td>{{$resorts->phone}}</td>
                    </tr>
                    <tr>
                        <th>Resort Country</th>
                        <td>{{$resorts->country}}</td>
                    </tr>
                    <tr>
                        <th>Resort State</th>
                        <td>{{$resorts->state}}</td>
                    </tr>
                    <tr>
                        <th>Resort Description</th>
                        <td>{{$resorts->description}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div id="map"><iframe src="{{$resorts->map}}" width="1325" height="450"></iframe></div>
    <br><br>
</div>
<!-- /.container-fluid -->

{{-- <script>
    function initMap() {
        var resorts = @json($resorts);

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: { lat: parseFloat(resorts.latitude), lng: parseFloat(resorts.longitude) }
        });

        var marker = new google.maps.Marker({
            position: { lat: parseFloat(resorts.latitude), lng: parseFloat(resorts.longitude) },
            map: map,
            title: resorts.name
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG2YHIuPJYMOJzS6wSw5eZ0dTYXnhZFLs&callback=initMap" async defer></script> --}}

@endsection
