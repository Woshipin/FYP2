@extends('admin.layout')

@section('admin-section')

<!-- Edit Restaurant Model -->
@foreach ($restaurants as $restaurant)
<!-- Modal content for each Resort -->
<div class="modal fade" id="restauranteditModal{{ $restaurant->id }}" tabindex="-1" role="dialog"aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header and form -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Restaurant Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

             <form action="{{ url('admin/updateRestaurant/' . $restaurant->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Restaurant Name</label>
                        <input type="text" class="form-control" name="name" id="name"value="{{ $restaurant->name }}">
                        <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="image">Restaurant Image </label>
                        <input type="file" class="form-control" name="image" id="image"placeholder="Enter Resort Image" value="{{ $restaurant->image }}">
                        <span class="text-danger">@error('image'){{ $message }}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="date">Restaurant Open Date</label>
                        <input type="text" class="form-control" name="date" id="date"value="{{ $restaurant->date }}">
                        <span class="text-danger">@error('date'){{ $message }}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="time">Restaurant Open Time</label>
                        <input type="text" class="form-control" name="time" id="time"value="{{ $restaurant->time }}">
                        <span class="text-danger">@error('time'){{ $message }}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="address">Restaurant Address</label>
                        <input type="text" class="form-control" name="address" id="address"value="{{ $restaurant->address }}">
                        <span class="text-danger">@error('address'){{ $message }}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="description">Restaurant Description</label>
                        <input type="text" class="form-control" name="description" id="description"value="{{ $restaurant->description }}">
                        <span class="text-danger">@error('description'){{ $message }}@enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="map">Restaurant Map</label>
                        <input type="text" class="form-control" name="map" id="map"value="{{ $restaurant->map }}">
                        <span class="text-danger">@error('map'){{ $message }}@enderror</span>
                    </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Update Restaurant</button>
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
                <!--Export Restaurant Model -->
                <a href="{{ url('export-resort') }}"><button type="button" class="btn btn-primary m-1">Export Restaurant</button></a>
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

        {{-- <div>
            <table width="100%">
                <thead>
                    <tr>
                        <th class="p-2">Restaurant ID</th>
                        <th class="p-2">Restaurant Name</th>
                        <th class="p-2">Restaurant Image</th>
                        <th class="p-2">Restaurant Date</th>
                        <th class="p-2">Restaurant Time</th>
                        <th class="p-2">Restaurant Address</th>
                        <th class="p-2">Restaurant Description</th>
                        <th class="p-2">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($restaurants as $restaurant)
                        <tr>
                            <td>{{ $restaurant->id }}</td>
                            <td>{{ $restaurant->name }}</td>
                            <td><img width="80" src="{{ asset('images/' . $restaurant->image) }}"
                                    alt="Image" /></td>
                            <td>{{ $restaurant->date }}</td>
                            <td>{{ $restaurant->time }}</td>
                            <td>{{ $restaurant->address }}</td>
                            <td>{{ $restaurant->description }}</td>
                            <td>
                                <a href="{{ url('admin/viewRestaurant/' . $restaurant->id) . '/view' }}"
                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#restauranteditModal{{ $restaurant->id }}"><i
                                        class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Are you sure to delete this data?')"
                                    href="{{ url('admin/deleteRestaurant/' . $restaurant->id) . '/delete' }}"
                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No Resorts Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> --}}

        {{-- <div class="container-fluid mt-3">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Restaurant List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="p-2">Restaurant ID</th>
                                    <th class="p-2">Restaurant Name</th>
                                    <th class="p-2">Restaurant Image</th>
                                    <th class="p-2">Restaurant Date</th>
                                    <th class="p-2">Restaurant Time</th>
                                    <th class="p-2">Restaurant Address</th>
                                    <th class="p-2">Restaurant Description</th>
                                    <th class="p-2">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($restaurants as $restaurant)
                                    <tr>
                                        <td>{{ $restaurant->id }}</td>
                                        <td>{{ $restaurant->name }}</td>
                                        <td><img width="80" src="{{ asset('images/' . $restaurant->image) }}"
                                                alt="Image" /></td>
                                        <td>{{ $restaurant->date }}</td>
                                        <td>{{ $restaurant->time }}</td>
                                        <td>{{ $restaurant->address }}</td>
                                        <td>{{ $restaurant->description }}</td>
                                        <td>
                                            <a href="{{ url('admin/viewRestaurant/' . $restaurant->id) . '/view' }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#restauranteditModal{{ $restaurant->id }}"><i
                                                    class="fa fa-edit"></i></a>
                                            <a onclick="return confirm('Are you sure to delete this data?')"
                                                href="{{ url('admin/deleteRestaurant/' . $restaurant->id) . '/delete' }}"
                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No Restaurants Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $restaurants->links() }}
            </div>
        </div> --}}

        <div class="container-fluid mt-3">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Resort List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="p-2">Restaurant ID</th>
                                    <th class="p-2">Restaurant Name</th>
                                    <th class="p-2">Restaurant Image</th>
                                    <th class="p-2">Restaurant Date</th>
                                    <th class="p-2">Restaurant Time</th>
                                    <th class="p-2">Restaurant Address</th>
                                    <th class="p-2">Restaurant Description</th>
                                    <th class="p-2">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody id="searchResultsContainer">
                                <!-- Content will be dynamically added here based on search -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="paginationContainer">
                    {{ $restaurants->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Real Time Search --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateSearchResults(filteredRestaurants) {
            var resultsContainer = document.getElementById('searchResultsContainer');
            resultsContainer.innerHTML = ''; // Clear previous results

            if (Array.isArray(filteredRestaurants) && filteredRestaurants.length > 0) {
                filteredRestaurants.forEach(function(restaurant) {
                    var restaurantHTML = '<tr>' +
                        '<td>' + restaurant.id + '</td>' +
                        '<td>' + restaurant.name + '</td>' +
                        '<td><img width="80" src="{{ asset('images/') }}/' + restaurant.image +
                        '" alt="Image" /></td>' +
                        '<td>' + restaurant.date + '</td>' +
                        '<td>' + restaurant.time + '</td>' +
                        '<td>' + restaurant.address + '</td>' +
                        '<td>' + restaurant.description + '</td>' +
                        '<td>' +
                        '<a href="{{ url('admin/viewRestaurant/') }}/' + restaurant.id +
                        '/view" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>' +
                        '<a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#restauranteditModal' +
                        restaurant.id + '"><i class="las la-pencil-alt"></i></a>' +
                        '<a onclick="return confirm("Are you sure to delete this data?")" href="{{ url('admin/deleteRestaurant/') }}/' +
                        restaurant.id +
                        '/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>' +
                        '</td>' +
                        '</tr>';

                    resultsContainer.innerHTML += restaurantHTML;
                });
            } else {
                resultsContainer.innerHTML =
                    '<tr><td colspan="8">No Restaurant Found</td></tr>';
            }
        }

        var initialRestaurants = @json($restaurants->items());
        updateSearchResults(initialRestaurants);

        document.getElementById('searchInput').addEventListener('input', function() {
            performSearch();
        });

        function performSearch() {
            var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
            var restaurantsData = @json($restaurants->items());

            if (!Array.isArray(restaurantsData)) {
                console.error('Invalid restaurants data:', restaurantsData);
                return;
            }

            var filteredRestaurants = restaurantsData.filter(function(restaurant) {
                return restaurant.name.toLowerCase().includes(searchInputValue);
            });

            updateSearchResults(filteredRestaurants);
        }
    });
</script>


@endsection
