@extends('backend-user.newlayout')

@section('newuser-section')

    {{-- back-arrow-circle css --}}
    <style>
        .back-arrow-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            margin-left: 15px;
            /* 与容器的左边距对齐 */
            margin-top: 10px;
            /* 进一步缩短上边距 */
        }

        .back-arrow-circle a {
            color: #007bff;
            text-decoration: none;
            font-size: 20px;
        }

        .container {
            margin-top: 0;
            /* 完全去除容器的上边距 */
        }
    </style>

    <div class="back-arrow-circle">
        <a href="{{ url('/showResort') }}">
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $resorts->name }} Detail
                    <a href="{{ url('showResort') }}" class="float-right btn btn-success btn-sm">View All</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Resort Name</th>
                            <td>{{ $resorts->name }}</td>
                        </tr>
                        <tr>
                            <th>Resort Price</th>
                            <td>RM{{ $resorts->price }}</td>
                        </tr>
                        <tr>
                            <th>Resort Image</th>
                            <td
                                style="border: 5px solid #ddd; padding: 5px; width: 470px; height: 200px; overflow-y: auto; position: relative;">
                                @if (isset($resorts->images) && count($resorts->images) > 0)
                                    <div style="display: flex; flex-wrap: nowrap; width: 100%; height: 100%;">
                                        @foreach ($resorts->images as $image)
                                            <div
                                                style="position: relative; margin-right: 5px; width: 80px; height: 80px; border-radius 2px">
                                                <img src="{{ asset('images/' . $image->image) }}" alt="Resort Image"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span
                                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">No
                                        Image</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Resort Location</th>
                            <td>{{ $resorts->location }}</td>
                        </tr>
                        <tr>
                            <th>Resort Phone</th>
                            <td>{{ $resorts->phone }}</td>
                        </tr>
                        <tr>
                            <th>Resort Country</th>
                            <td>{{ $resorts->country }}</td>
                        </tr>
                        <tr>
                            <th>Resort States</th>
                            <td>{{ $resorts->state }}</td>
                        </tr>
                        <tr>
                            <th>Resort Longitude</th>
                            <td>{{ $resorts->longitude }}</td>
                        </tr>
                        <tr>
                            <th>Resort Latitude</th>
                            <td>{{ $resorts->latitude }}</td>
                        </tr>
                        <tr>
                            <th>Resort Description</th>
                            <td>{{ $resorts->description }}</td>
                        </tr>
                        <tr>
                            <th>Resort Longitude</th>
                            <td>{{ $resorts->digital_lock_password }}</td>
                        </tr>
                        <tr>
                            <th>Resort Latitude</th>
                            <td>{{ $resorts->emailbox_password }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div id="map"><iframe src="{{ $resorts->map }}" width="1325" height="450"></iframe></div>

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
