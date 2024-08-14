@extends('user.layout')

@section('user-section')
<!--Add Resort Modal -->
<div class="modal fade" id="resortModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('addResort') }}" method="POST" enctype="multipart/form-data" id="searchMap2">
            @csrf
                <div class="modal-body">
                    <!-- {{ Auth::id() }} -->
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <div class="form-group">
                        <label for="name">Resort Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Resort Name">
                        <span class="text-danger">@error('name') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="image">Resort Image </label>
                        <input type="file" class="form-control" name="image" id="image" placeholder="Enter Resort Image">
                        <span class="text-danger">@error('image') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="price">Resort Price</label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="Enter Resort Price">
                        <span class="text-danger">@error('price') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="location">Resort Location</label>
                        <input type="text" class="form-control" name="location" id="location" placeholder="Enter Resort Address">
                        <span class="text-danger">@error('location') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="location">Resort Latitude</label>
                        <input type="text" class="form-control" name="latitude"  id='latitude' placeholder="Enter Latitude">
                        <span class="text-danger">@error('latitude') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="location">Resort Longitude</label>
                        <input type="text" class="form-control" name="longitude" id='longitude' placeholder="Enter Longitude">
                        <span class="text-danger">@error('longitude') {{$message}} @enderror</span>
                    </div>

                    <!-- <input type="text" id="latitude" name="latitude">
                    <input type="text" id="longitude" name="longitude"> -->

                    <div class="form-group">
                        <label for="description">Resort Description</label>
                        <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description ">
                        <span class="text-danger">@error('description') {{$message}} @enderror</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New Resort</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Resort Model -->
@foreach($resorts as $resort)
    <!-- Modal content for each Resort -->
    <div class="modal fade" id="resorteditModal{{$resort->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header and form -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Resort Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{url('/updateResort/'.$resort->id)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Resort Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{$resort->name}}">
                            <span class="text-danger">@error('name') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="image">Resort Image </label>
                            <input type="file" class="form-control" name="image" id="image" placeholder="Enter Resort Image" value="{{$resort->image}}">
                            <span class="text-danger">@error('image') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="price">Resort Price</label>
                            <input type="number" class="form-control" name="price" id="price" value="{{$resort->price}}">
                            <span class="text-danger">@error('price') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="location">Resort Location</label>
                            <input type="text" class="form-control" name="location" id="location" value="{{$resort->location}}">
                            <span class="text-danger">@error('location') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="latitude">Resort Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="latitude" value="{{$resort->latitude}}">
                            <span class="text-danger">@error('latitude') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Resort Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="longitude" value="{{$resort->longitude}}">
                            <span class="text-danger">@error('longitude') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="description">Resort Description</label>
                            <input type="text" class="form-control" name="description" id="description" value="{{$resort->description}}">
                            <span class="text-danger">@error('description') {{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Resort</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Import and Export Modal -->
<!-- <div class="modal fade" id="resortexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Resort Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ url('import-resort') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <label>Select File</label>
                    <input type="file" name="file" class="form-control" />
                    <span class="text-danger">@error('file') {{$message}} @enderror</span>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> -->

<!-- Show All Resort -->
<div class="container">
    <br><br><br><br>

    <div id="map" style="height: 400px;"></div>

    <div class="records table-responsive">
        <div class="record-header">
            <div class="add">
                <span>Entries</span>
                <select name="" id="">
                    <option value="">ID</option>
                </select>
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->
                <!-- Resort Model -->
                <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#resortModal">Add Resort</button>
                <!-- Import Resort Model -->
                <!-- <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#resortexcelModal">Import Modal</button> -->
                <!--Export Resort Model -->
                <a href="{{ url('export-resort') }}"><button type="button" class="btn btn-primary m-1">Export Resort</button></a>
                <!-- View Resort PDF Model -->
                <!-- <form action="{{ url('resort/view-pdf') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger m-1">View In PDF</button>
                </form> -->
                <!-- Export Resort PDF Model -->
                <!-- <form action="{{ url('resort/download-pdf') }}" method="POST" target="__blank">
                    @csrf
                    <button type="submit" class="btn btn-danger m-1">Download PDF</button>
                </form> -->
            </div>

            <div class="browse">
                <input type="search" placeholder="Search" class="record-search m-1">
                <select name="" id="">
                    <option value="">Status</option>
                </select>
            </div>
        </div>

        @if(\Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error')}}</div>
        @endif

        @if(\Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif

        <div>
            <table width="100%">
                <thead>
                    <tr>
                        <th class="p-2">Resort ID</th>
                        <!-- <th class="p-2">User ID</th> -->
                        <th class="p-2">Resort Name</th>
                        <th class="p-2">Resort Image</th>
                        <th class="p-2">Resort Price</th>
                        <th class="p-2">Resort Location</th>
                        <th class="p-2">Resort Latitude</th>
                        <th class="p-2">Resort Longitude</th>
                        <th class="p-2">Resort Description</th>
                        <th class="p-2">ACTIONS</th>
                    </tr>
                </thead>
                <tbody >
                    @if ($resorts !== null && count($resorts) > 0)
                        @foreach ($resorts as $resort)
                            <tr>
                                <td >{{ $resort->id }}</td>
                                <!-- <td>{{ $resort->user->id }}</td> -->
                                <td>{{ $resort->name }}</td>
                                <td><img width="80" src="{{ asset('images/' . $resort->image) }}" alt="Image"/></td>
                                <td>{{ $resort->price }}</td>
                                <td>{{ $resort->location }}</td>
                                <td>{{ $resort->latitude }}</td>
                                <td>{{ $resort->longitude }}</td>
                                <td>{{ $resort->description }}</td>
                                <td>
                                    <a href="{{url('showResortMap/'.$resort->id).'/map'}}" class="btn btn-info btn-sm"><i class="las la-eye"></i></a>
                                    <a href="{{url('editResort/'.$resort->id).'/edit'}}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#resorteditModal{{$resort->id}}"><i class="las la-pencil-alt"></i></a>
                                    <a onclick="return confirm('Are you sure to delete this data?')" href="{{url('deleteResort/'.$resort->id).'/delete'}}" class="btn btn-danger btn-sm"><i class="las la-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">No Resorts Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <script>
    function initializeMap(resortsJson) {

    var resorts = JSON.parse(resortsJson);

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: { lat: parseFloat(resorts[0].latitude), lng: parseFloat(resorts[0].longitude) }
    });

    resorts.forEach(function(resort) {
        var marker = new google.maps.Marker({
            position: { lat: parseFloat(resort.latitude), lng: parseFloat(resort.longitude) },
            map: map
        });
    });
}


</script> -->

<!-- <script>
    function initMap() {
        var resorts = @json($resorts);

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: resorts.length > 0 ? { lat: resorts[0].latitude, lng: resorts[0].longitude } : { lat: 0, lng: 0 }
        });

        resorts.forEach(function (resort) {
            var marker = new google.maps.Marker({
                position: { lat: resort.latitude, lng: resort.longitude },
                map: map,
                title: resort.name
            });
        });
    }
</script> -->

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG2YHIuPJYMOJzS6wSw5eZ0dTYXnhZFLs"></script> -->
<!-- resorts.length > 0 ? { lat: parseFloat(resorts[0].latitude), lng: parseFloat(resorts[0].longitude) } : { lat: 0, lng: 0 } -->

<!-- Show All Location In Google Map -->
<script>
function initMap() {

    var kualaLumpur = new google.maps.LatLng(3.1390, 101.6869);
    var johorBahru = new google.maps.LatLng(1.4927, 103.7414);

    var resorts = @json($resorts);

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

<!-- <script>
    function showMap(lat, long) {
    var coord = { lat: lat, lng: long };

    var map = new google.maps.Map(
        document.getElementById("googleMap"),
        {
        zoom: 10,
        center: coord
        }
    );

    new google.maps.Marker({
        position: coord,
        map: map
    });
    }

    showMap(0, 0);
</script> -->

<!-- <script>
    $(document).ready(function() {
        let form = '#showMap';
        let clicked_ids = [];

        $(form).on('click', function(){

            let resortId = $(this).find('[id="resortID"]').html();
            // alert(resortId);
                    if(clicked_ids.indexOf(resortId) == -1){
                    clicked_ids.push(resortId);
                    console.log(clicked_ids);

                    }
            let url = '/showMap/' + resortId;
            // alert(value);
            // console.log(value);

            $.ajax({
                url: url,
                type:"GET",
                data: 'request=' + resortId,

                success: function(data){
                    $('.googleMap').html(data);
                    console.log(data)
                    console.log(resortId)
                },

                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(resortId);
                },
            });
        });
    });

    function showMap(lat,long){

        var coord = { lat:lat, lng:long };

        var map = new google.maps.Map(
            document.getElementById("googleMap"),
            {
                zoom: 10,
                center: coord
            }
        );

        new google.maps.Marker({
            position:coord,
            map:map
        });
        }

        showMap(0,0);
</script> -->
@endsection
