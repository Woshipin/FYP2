@extends('admin.layout')

@section('admin-section')
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
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $hotel->name }}">
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="image">Hotel Image </label>
                                <input type="file" class="form-control" name="image" id="image"
                                    value="{{ $hotel->image }}">
                                <span class="text-danger">
                                    @error('image')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="email">Hotel Email </label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="{{ $hotel->email }}">
                                <span class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="price">Hotel Price</label>
                                <input type="text" class="form-control" name="price"
                                    id="price"value="{{ $hotel->price }}">
                                <span class="text-danger">
                                    @error('date')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Hotel Phone Number</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="{{ $hotel->phone }}">
                                <span class="text-danger">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="country">Hotel Country</label>
                                <input type="text" class="form-control" name="country" id="country"
                                    value="{{ $hotel->country }}">
                                <span class="text-danger">
                                    @error('country')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="state">Hotel State</label>
                                <input type="text" class="form-control" name="state" id="state"
                                    value="{{ $hotel->state }}">
                                <span class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="address">Hotel Address</label>
                                <input type="text" class="form-control" name="address" id="address"
                                    value="{{ $hotel->address }}">
                                <span class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="description">Hotel Description</label>
                                <input type="text" class="form-control" name="description" id="description"
                                    value="{{ $hotel->description }}">
                                <span class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="map">Hotel Map</label>
                                <input type="text" class="form-control" name="map"
                                    id="map"value="{{ $hotel->map }}">
                                <span class="text-danger">
                                    @error('map')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            {{-- <div class="form-group">
                            <label for="longitude">Hotel Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="longitude" value="{{ $hotel->longitude }}">
                            <span class="text-danger">@error('longitude'){{ $message }}@enderror</span>
                        </div>

                        <div class="form-group">
                            <label for="latitude">Hotel Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="latitude" value="{{ $hotel->latitude }}">
                            <span class="text-danger">@error('latitude'){{ $message }}@enderror</span>
                        </div> --}}

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


    <!-- Show All Restaurant -->
    <div class="container">
        <br><br><br>

        <!-- <div id="map" style="height: 400px;"></div> -->

        <div class="records table-responsive">
            <div class="record-header">
                <div class="add">
                    <span>Entries</span>
                    <select name="" id="">
                        <option value="">ID</option>
                    </select>
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->
                    <!-- Restaurant Model -->
                    {{-- <button type="button" class="btn btn-info m-1" data-toggle="modal"data-target="#restaurantModal">Add Restaurant</button> --}}
                    <!-- Add Table Model -->
                    <!-- <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#tableModal">Add Tbale</button> -->
                    <!--Export Resort Model -->
                    <a href="{{ url('export-resort') }}"><button type="button" class="btn btn-primary m-1">Export
                            Hotel</button></a>
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

                {{-- Real Time Search --}}
                <div class="browse">
                    <input type="search" id="searchInput" name="name" placeholder="Search Name"
                        class="record-search m-1">
                    <select name="" id="">
                        <option value="">Status</option>
                    </select>
                </div>

            </div>

            @if (\Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            @if (\Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            {{-- <div class="container-fluid mt-3">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hotel List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>Address</th>
                                        <th>Open / Close</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($hotels !== 0 && count($hotels) > 0)
                                        @foreach ($hotels as $hotel)
                                            <tr>
                                                <td>{{ $hotel->name }}</td>
                                                <td><img width="80" src="{{ asset('images/' . $hotel->image) }}"
                                                        alt="Image" /></td>
                                                <td>{{ $hotel->country }}</td>
                                                <td>{{ $hotel->state }}</td>
                                                <td>{{ $hotel->address }}</td>
                                                <td>
                                                    @if ($hotel->status == 0)
                                                        <a href="{{ url('changehotel-status/' . $hotel->id) }}"
                                                            class="btn btn-sm btn-success"
                                                            onclick="return confirm('Are you sure you want to change this status to close?')">Open</a>
                                                    @else
                                                        <a href="{{ url('changehotel-status/' . $hotel->id) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to change this status to open?')">Close</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('admin/viewHotel/' . $hotel->id) . '/view' }}"
                                                        class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#hoteleditModal{{ $hotel->id }}"><i
                                                            class="las la-pencil-alt"></i></a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                                        href="{{ url('admin/deleteHotel/' . $hotel->id) . '/delete' }}"
                                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">No Hotel Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{ $hotels->links() }}
                </div>
            </div> --}}

            <div class="container-fluid mt-3">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hotel List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>Address</th>
                                        <th>Open / Close</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="searchResultsContainer">
                                    <!-- Content will be dynamically added here based on search -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{ $hotels->links() }}
                </div>
            </div>

            {{-- Token Problem --}}
            {{-- <div class="container-fluid mt-3">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hotel List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>Address</th>
                                        <th>Open / Close</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="searchResultsContainer">
                                    <!-- Content will be dynamically added here based on search -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="paginationContainer">
                        {{ $hotels->links() }}
                    </div>
                </div>
            </div> --}}

        </div>
    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Real Time Search --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateSearchResults(filteredHotels) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = ''; // Clear previous results

                if (Array.isArray(filteredHotels) && filteredHotels.length > 0) {
                    filteredHotels.forEach(function(hotel) {
                        var isDisabled = hotel.status === 1;

                        var hotelHTML = '<tr class="' + (isDisabled ? 'disabled' : '') + '">' +
                            '<td>' + hotel.name + '</td>' +
                            '<td><img width="80" src="{{ asset('images/') }}/' + hotel.image +
                            '" alt="Image" /></td>' +
                            '<td>' + hotel.country + '</td>' +
                            '<td>' + hotel.state + '</td>' +
                            '<td>' + hotel.address + '</td>' +
                            '<td>' +
                            (isDisabled ?
                                '<a href="{{ url('Hoteldetail/') }}/' + hotel.id +
                                '/view" class="btn btn-sm btn-danger">Closed</a>' :
                                '<a href="{{ url('Hoteldetail/') }}/' + hotel.id +
                                '/view" class="btn btn-sm btn-success">Open</a>'
                            ) +
                            '</td>' +
                            '<td>' +
                            '<a href="{{ url('admin/viewHotel/') }}/' + hotel.id +
                            '/view" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>' +
                            '<a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#hoteleditModal' +
                            hotel.id + '"><i class="las la-pencil-alt"></i></a>' +
                            '<a onclick="return confirm("Are you sure to delete this data?")" href="{{ url('admin/deleteHotel/') }}/' +
                            hotel.id +
                            '/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>' +
                            '</td>' +
                            '</tr>';

                        resultsContainer.innerHTML += hotelHTML;
                    });
                } else {
                    resultsContainer.innerHTML =
                        '<tr><td colspan="7">No Hotel Found</td></tr>';
                }
            }

            var initialHotels = <?php echo json_encode($hotels->items()); ?>;
            updateSearchResults(initialHotels);

            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var hotelsData = <?php echo json_encode($hotels->items()); ?>;

                if (!Array.isArray(hotelsData)) {
                    console.error('Invalid hotels data:', hotelsData);
                    return;
                }

                var filteredHotels = hotelsData.filter(function(hotel) {
                    return hotel.name.toLowerCase().includes(searchInputValue);
                });

                updateSearchResults(filteredHotels);
            }
        });
    </script>

@endsection
