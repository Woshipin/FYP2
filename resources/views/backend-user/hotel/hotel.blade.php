@extends('user.newlayout')

@section('newuser-section')

{{-- Hotel Area --}}
{{-- add new room --}}
<div class="modal fade" id="hotelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Room Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ url('addHotel') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">

                    <!-- {{ Auth::id() }} -->
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                    <div class="form-group">
                        <label for="name">Hotel Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Hotel Name">
                        <span class="text-danger">@error('name') {{$message}} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="image">Hotel Image </label>
                        <input type="file" class="form-control" name="image" id="image"placeholder="Select Hotel Image" value="">
                        <span class="text-danger">@error('image'){{ $message }}@enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="price">Hotel Price</label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="Enter Hotel Price">
                        <span class="text-danger">@error('price') {{$message}} @enderror</span>
                    </div>

                    {{-- <div class="form-group">
                        <label for="email">Hotel Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter Hotel Email">
                        <span class="text-danger">@error('email') {{$message}} @enderror</span>
                    </div> --}}

                    <div class="form-group">
                        <label for="phone">Hotel Phone</label>
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter Hotel Phone">
                        <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="country">Hotel Country</label>
                        <input type="text" class="form-control" name="country" id="country" placeholder="Enter Hotel Country">
                        <span class="text-danger">@error('country') {{$message}} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="state">Hotel State</label>
                        <input type="text" class="form-control" name="state" id="state" placeholder="Enter Hotel State">
                        <span class="text-danger">@error('state') {{$message}} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="address">Hotel Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Enter Hotel Address">
                        <span class="text-danger">@error('address') {{$message}} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="latitude">Hotel Latitude</label>
                        <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Enter Hotel Latitude">
                        <span class="text-danger">@error('latitude') {{$message}} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="longitude">Hotel Longitude</label>
                        <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Enter Hotel Longitude">
                        <span class="text-danger">@error('longitude') {{$message}} @enderror</span>
                    </div>

                    <div class="form-group">
                        <label for="description">Hotel Description</label>
                        <input type="text" class="form-control" name="description" id="description" placeholder="Enter Hotel Description">
                        <span class="text-danger">@error('description') {{$message}} @enderror</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New Hotel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- edit new hotels --}}
@foreach ($hotels as $hotel)
    <!-- Modal content for each Resort -->
    <div class="modal fade" id="hoteleditModal{{ $hotel->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header and form -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Hotel Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ url('/updateHotel/' . $hotel->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Hotel Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $hotel->name }}">
                            <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="image">Hotel Image </label>
                            <input type="file" class="form-control" name="image" id="image" value="{{ $hotel->image }}">
                            <span class="text-danger">@error('image'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="email">Hotel Email </label>
                            <input type="text" class="form-control" name="email" id="email" value="{{ $hotel->email }}">
                            <span class="text-danger">@error('email'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="price">Hotel Price</label>
                            <input type="text" class="form-control" name="price" id="price"value="{{ $hotel->price }}">
                            <span class="text-danger">@error('date'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Hotel Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $hotel->phone }}">
                            <span class="text-danger">@error('phone'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="country">Hotel Country</label>
                            <input type="text" class="form-control" name="country" id="country" value="{{ $hotel->country }}">
                            <span class="text-danger">@error('country'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="state">Hotel State</label>
                            <input type="text" class="form-control" name="state" id="state" value="{{ $hotel->state }}">
                            <span class="text-danger">@error('address'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="latitude">Hotel Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="latitude" value="{{ $hotel->latitude }}">
                            <span class="text-danger">@error('latitude'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Hotel Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="longitude" value="{{ $hotel->longitude }}">
                            <span class="text-danger">@error('longitude'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="address">Hotel Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{ $hotel->address }}">
                            <span class="text-danger">@error('address'){{ $message }}@enderror</span>
                        </div>
                        <div class="form-group">
                            <label for="description">Hotel Description</label>
                            <input type="text" class="form-control" name="description" id="description" value="{{ $hotel->description }}">
                            <span class="text-danger">@error('description'){{ $message }}@enderror</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Hotel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- show all hotels --}}
<div class="container">

    <div id="map" style="height: 400px;"></div><br>

    <div class="row">
        <div class="col-12">
            <div class="data_table">

                @if (\Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif

                @if (\Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif

                <!-- Button to delete all selected items -->
                <form action="{{ route('hotels.mutlipledeletehotel') }}" method="post" id="deleteMultipleForm">
                    @csrf
                    <!-- Your table code here -->
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                        {{-- Button to delete all selected items --}}
                        <button type="submit" class="btn btn-primary m-1" id="deleteAllSelectedRecord">Delete All Selected Hotels</button>
                        {{-- Add Resort --}}
                        <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#hotelModal">Add Hotel</button>
                        {{-- Export Resort --}}
                        <a href="{{ url('export-hotel') }}"><button type="button" class="btn btn-primary m-1">Export Hotel</button></a>
                        <thead class="table-dark">
                            <tr>
                                <th><input type="checkbox" name="" id="select_all_ids" onclick="checkAll(this)"></th>
                                <th>Hotel Name</th>
                                <th>Hotel Image</th>
                                <th>Hotel Price</th>
                                <th>Hotel Country</th>
                                <th>Hotel State</th>
                                <th>Hotel Address</th>
                                <th>Open / Close</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($hotels !== 0 && count($hotels) > 0)
                                @foreach($hotels as $hotel)
                                    <tr>
                                        <td><input type="checkbox" name="ids" class="checkbox_ids" id="" value="{{ $hotel->id }}"></td>
                                        <td>{{ $hotel->name }}</td>
                                        <td><img width="80" src="{{ asset('images/' . $hotel->image) }}" alt="Image" /></td>
                                        <td>{{ $hotel->price }}</td>
                                        <td>{{ $hotel->country }}</td>
                                        <td>{{ $hotel->state }}</td>
                                        <td>{{ $hotel->address }}</td>
                                        <td>
                                            @if ($hotel->status == 0)
                                                <a href="{{ url('changehotel-status/' . $hotel->id) }}"
                                                    class="btn btn-sm btn-success"
                                                    onclick="return confirm('Are you sure you want to change this status?')">Active</a>
                                            @else
                                                <a href="{{ url('changehotel-status/' . $hotel->id) }}"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to change this status?')">InActive</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('viewHotel/' . $hotel->id) . '/view' }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#hoteleditModal{{ $hotel->id }}"><i class="fa fa-edit"></i></a>
                                            <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('deleteHotel/'.$hotel->id).'/delete' }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9">No Hotel Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    </div>

                </form>

                <!-- Pagination links -->

            </div>
        </div>
    </div>
</div>

<br>
<hr>

{{-- Room Area --}}
{{-- Add New Room Model --}}
<div class="modal fade" id="roomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Room Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('addRoom') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <!-- {{ Auth::id() }} -->
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                    <select class="form-control" name="hotel_id">
                        <option value="">---------Select Hotel---------</option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                        @endforeach
                    </select>

                    <div class="form-group">
                        <label for="title">Room Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Enter Room title">
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="title">Room Type</label>
                        <input type="text" class="form-control" name="type" id="type"
                            placeholder="Enter Room title">
                        <span class="text-danger">
                            @error('type')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="title">Room Available</label>
                        <input type="number" class="form-control" name="available" id="available"
                            placeholder="Enter Room title">
                        <span class="text-danger">
                            @error('available')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New Room</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit New Room Model --}}
@foreach ($rooms as $room)
    <!-- Modal content for each Resort -->
    <div class="modal fade" id="roomeditModal{{ $room->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header and form -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Room Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ url('/updateRoom/' . $room->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <select class="form-control" name="hotel_id">
                            <option value="">-------</option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}"
                                    {{ $hotel->id == $room->hotel_id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="name">Room Name </label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Table title" value="{{ $room->name }}">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="type">Room Type </label>
                            <input type="text" class="form-control" name="type" id="type"
                                placeholder="Enter Table title" value="{{ $room->type }}">
                            <span class="text-danger">
                                @error('type')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="available">Room Available </label>
                            <input type="number" class="form-control" name="available" id="available"
                                placeholder="Enter Table title" value="{{ $room->available }}">
                            <span class="text-danger">
                                @error('available')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Room</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- show all rooms --}}
<div class="container">

    {{-- <div id="map" style="height: 400px;"></div><br> --}}

    <div class="row">
        <div class="col-12">
            <div class="data_table">

                @if (\Session::has('rooms'))
                    <div class="alert alert-danger">{{ Session::get('rooms') }}</div>
                @endif

                @if (\Session::has('room'))
                    <div class="alert alert-success">{{ Session::get('room') }}</div>
                @endif

                <!-- Button to delete all selected items -->
                <form action="{{ route('rooms.mutlipledeleterooms') }}" method="post" id="deleteMultipleForms">
                    @csrf
                    <!-- Your table code here -->
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                            {{-- Button to delete all selected items --}}
                            <button type="submit" class="btn btn-primary m-1" id="deleteAllSelectedRecords">Delete All
                                Selected Rooms</button>
                            {{-- Add Resort --}}
                            <button type="button" class="btn btn-info m-1" data-toggle="modal"
                                data-target="#roomModal">Add Room</button>
                            {{-- Export Resort --}}
                            <a href="{{ url('export-room') }}"><button type="button" class="btn btn-primary m-1">Export
                                    Room</button></a>
                            <thead class="table-dark">
                                <tr>
                                    <th><input type="checkbox" name="" id="select_all_ids"
                                            onclick="checkAll(this)"></th>
                                    <th>Room ID</th>
                                    <th>Restaurant Name</th>
                                    <th>Room Name</th>
                                    <th>Room Type</th>
                                    <th>Room Available</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($rooms !== null && $rooms->count() > 0)
                                    @foreach ($rooms as $room)
                                        <tr>
                                            <td><input type="checkbox" name="idss" class="checkbox_idss"
                                                    id="" value="{{ $room->id }}"></td>
                                            <td>Room ID: {{ $room->id }}</td>
                                            <td>{{ $room->hotel->name }}</td>
                                            <td>{{ $room->name }}</td>
                                            <td>{{ $room->type }}</td>
                                            <td>{{ $room->available }}</td>
                                            <td>
                                                <!-- <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></a> -->
                                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#roomeditModal{{ $room->id }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('Are you sure to delete this data?')"
                                                    href="{{ url('deleteRoom/' . $room->id) . '/delete' }}"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
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
                </form>

                <!-- Pagination links -->

            </div>
        </div>
    </div>
</div>

{{-- New Delete Selected All Table --}}
<script>
    // Function to check/uncheck all checkboxes
    function checkAll(checkbox) {
        const checkboxes = document.getElementsByClassName('checkbox_ids');
        for (const cb of checkboxes) {
            cb.checked = checkbox.checked;
        }
    }

    document.getElementById('deleteAllSelectedRecord').addEventListener('click', function() {
        const checkboxes = document.getElementsByClassName('checkbox_ids');
        const selectedIds = [];

        for (const checkbox of checkboxes) {
            if (checkbox.checked) {
                selectedIds.push(parseInt(checkbox.value));
            }
        }

        if (selectedIds.length === 0) {
            alert('Please select at least one restaurant to delete.');
        } else {
            const form = document.getElementById('deleteMultipleForm');
            const idsInput = document.createElement('input');
            idsInput.type = 'hidden';
            idsInput.name = 'ids';
            idsInput.value = JSON.stringify(selectedIds);
            form.appendChild(idsInput);

            form.submit();
        }
    });
</script>

{{-- New Delete Selected All Room --}}
<script>
    // Function to check/uncheck all checkboxes
    function checkAll(checkbox) {
        const checkboxes = document.getElementsByClassName('checkbox_idss');
        for (const cb of checkboxes) {
            cb.checked = checkbox.checked;
        }
    }

    document.getElementById('deleteAllSelectedRecords').addEventListener('click', function() {
        const checkboxes = document.getElementsByClassName('checkbox_idss');
        const selectedIds = [];

        for (const checkbox of checkboxes) {
            if (checkbox.checked) {
                selectedIds.push(parseInt(checkbox.value));
            }
        }

        if (selectedIds.length === 0) {
            alert('Please select at least one room to delete.');
        } else {
            const form = document.getElementById('deleteMultipleForms');
            const idsInput = document.createElement('input');
            idsInput.type = 'hidden';
            idsInput.name = 'idss';
            idsInput.value = JSON.stringify(selectedIds);
            form.appendChild(idsInput);

            form.submit();
        }
    });
</script>

<!-- Show All Location In Google Map -->
<script>
    function initMap() {
        var hotelData = @json($hotels);

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: { lat: parseFloat(hotelData[0].latitude), lng: parseFloat(hotelData[0].longitude) }
        });

        for (var i = 0; i < hotelData.length; i++) {
            var hotel = hotelData[i];

            if (!isNaN(parseFloat(hotel.latitude)) && !isNaN(parseFloat(hotel.longitude))) {
                var marker = new google.maps.Marker({
                    position: { lat: parseFloat(hotel.latitude), lng: parseFloat(hotel.longitude) },
                    map: map,
                    title: hotel.name
                });
            } else {
                console.error('Invalid latitude or longitude values for hotel:', hotel.name);
            }
        }
    }
</script>


<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG2YHIuPJYMOJzS6wSw5eZ0dTYXnhZFLs&callback=initMap"></script>

<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@endsection
