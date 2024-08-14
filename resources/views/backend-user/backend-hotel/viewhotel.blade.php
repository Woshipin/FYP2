@extends('backend-user.newlayout')

@section('newuser-section')

    <style>
        img {
            width: 80px;
            /* 设置所有图片的宽度为 80 像素 */
            height: auto;
            /* 保持宽高比例 */
        }
    </style>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $hotel->name }} Detail
                    <a href="{{ url('showHotel') }}" class="float-right btn btn-success btn-sm">View All</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Hotel Owner Name</th>
                            <td>{{ $hotel->name }}</td>
                        </tr>
                        <tr>
                            <th>Hotel Image</th>
                            <td>
                                @if ($hotel->image)
                                    <img width="80" src="{{ asset('images/' . $hotel->image) }}" alt="Resort Image" />
                                @else
                                    <span width="80">No Image</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Hotel Type</th>
                            <td>{{ $hotel->type }}</td>
                        </tr>
                        <tr>
                            <th>Hotel Owner Email</th>
                            <td>{{ $hotel->email }}</td>
                        </tr>
                        <tr>
                            <th>Hotel Phone</th>
                            <td>{{ $hotel->phone }}</td>
                        </tr>
                        <tr>
                            <th>Hotel Country</th>
                            <td>{{ $hotel->country }}</td>
                        </tr>
                        <tr>
                            <th>Hotel State</th>
                            <td>{{ $hotel->state }}</td>
                        </tr>
                        <tr>
                            <th>Hotel Address</th>
                            <td>{{ $hotel->address }}</td>
                        </tr>
                        {{-- <tr>
                        <th>Hotel Latitude</th>
                        <td>{{$hotel->latitude}}</td>
                    </tr>
                    <tr>
                        <th>Hotel Longitude</th>
                        <td>{{$hotel->longitude}}</td>
                    </tr> --}}
                        <tr>
                            <th>Hotel Description</th>
                            <td>{{ $hotel->description }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div id="map"><iframe src="{{ $hotel->map }}" width="1325" height="450"></iframe></div>
        <br><br>
    </div>
    <!-- /.container-fluid -->

    {{-- <script>
    function initMap() {
        var hotels = @json($hotel);

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: { lat: parseFloat(hotels.latitude), lng: parseFloat(hotels.longitude) }
        });

        var marker = new google.maps.Marker({
            position: { lat: parseFloat(hotels.latitude), lng: parseFloat(hotels.longitude) },
            map: map,
            title: hotels.name
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG2YHIuPJYMOJzS6wSw5eZ0dTYXnhZFLs&callback=initMap" async defer></script> --}}
@endsection
