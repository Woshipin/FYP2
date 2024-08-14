@extends('user.layout')

@section('user-section')
    <!--Add Resort Modal -->
    <div class="modal fade" id="restaurantModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Restaurant Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('addRestaurant') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <!-- {{ Auth::id() }} -->
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <div class="form-group">
                            <label for="name">Restaurant Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Restaurant Name">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="image">Restaurant Image </label>
                            <input type="file" class="form-control" name="image" id="image"
                                placeholder="Enter Restaurant Image">
                            <span class="text-danger">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="date">Restaurant Open Date</label>
                            <input type="text" class="form-control" name="date" id="date"
                                placeholder="Enter Restaurant Open Date">
                            <span class="text-danger">
                                @error('date')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="time">Restaurant Open Time</label>
                            <input type="text" class="form-control" name="time" id="time"
                                placeholder="Enter Restaurant Open Time">
                            <span class="text-danger">
                                @error('time')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="address">Restaurant Address</label>
                            <input type="text" class="form-control" name="address" id="address"
                                placeholder="Enter Restaurant Address">
                            <span class="text-danger">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="description">Restaurant Description</label>
                            <input type="textarea" class="form-control" name="description" id='description'
                                placeholder="Enter Description">
                            <span class="text-danger">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="map">Restaurant Map</label>
                            <input type="text" class="form-control" name="map" id='map'
                                placeholder="Enter Map">
                            <span class="text-danger">
                                @error('map')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add New Restaurant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Restaurant Model -->
    @foreach ($restaurants as $restaurant)
        <!-- Modal content for each Resort -->
        <div class="modal fade" id="restauranteditModal{{ $restaurant->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal header and form -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Restaurant Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ url('/updateRestaurant/' . $restaurant->id) }}" method="POST"
                        enctype="multipart/form-data">
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
                    <button type="button" class="btn btn-info m-1" data-toggle="modal"
                        data-target="#restaurantModal">Add Restaurant</button>
                    <!-- Add Table Model -->
                    <!-- <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#tableModal">Add Tbale</button> -->
                    <!--Export Resort Model -->
                    <a href="{{ url('export-resort') }}"><button type="button" class="btn btn-primary m-1">Export
                            Restaurant</button></a>
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

            @if (\Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            @if (\Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <div>
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
                                    <a href="{{ url('viewRestaurant/' . $restaurant->id) . '/view' }}"
                                        class="btn btn-info btn-sm"><i class="las la-eye"></i></a>
                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#restauranteditModal{{ $restaurant->id }}"><i
                                            class="las la-pencil-alt"></i></a>
                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                        href="{{ url('deleteRestaurant/' . $restaurant->id) . '/delete' }}"
                                        class="btn btn-danger btn-sm"><i class="las la-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No Resorts Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <hr>

    <!--Add Table Modal -->
    <div class="modal fade" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Table Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('addTable') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <!-- {{ Auth::id() }} -->
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <select class="form-control" name="restaurant_id">
                            <option value="">Select Restaurant</option>
                            @foreach ($restaurantd as $restaurant)
                                <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                            @endforeach
                        </select>

                        <br>

                        <div class="form-group">
                            <label for="title">Table Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter Table title">
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add New Table</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Show All Table -->
    <div class="container">

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
                    <!-- <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#restaurantModal">Add Restaurant</button> -->
                    <!-- Add Table Model -->
                    <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#tableModal">Add
                        Table</button>
                    <!--Export Resort Model -->
                    <a href="{{ url('export-resort') }}"><button type="button" class="btn btn-primary m-1">Export
                            Table</button></a>
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

            @if (\Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            @if (\Session::has('table'))
                <div class="alert alert-success">{{ Session::get('table') }}</div>
            @endif

            <div>
                <table width="100%">
                    <thead>
                        <tr>
                            <th class="p-2">Table ID</th>
                            <th class="p-2">Restaurant Name</th>
                            <th class="p-2">Table Title</th>
                            <th class="p-2">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($tables as $table)
                            <tr>
                                <td>Table ID: {{ $table->id }}</td>
                                <td>{{ $table->restaurant->name }}</td>
                                <td>{{ $table->title }}</td>
                                <td>
                                    <!-- <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></a> -->
                                    <a href="{{ url('editTable/' . $table->id) . '/edit' }}"
                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#tableeditModal{{ $table->id }}"><i
                                            class="las la-pencil-alt"></i></a>
                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                        href="{{ url('deleteTable/' . $table->id) . '/delete' }}"
                                        class="btn btn-danger btn-sm"><i class="las la-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Table Model -->
    @foreach ($tables as $table)
        <!-- Modal content for each Resort -->
        <div class="modal fade" id="tableeditModal{{ $table->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal header and form -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Table Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ url('/updateTable/' . $table->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <select class="form-control" name="restaurant_id">
                                <option value="">Select Restaurant</option>
                                @foreach ($restaurantd as $restaurant)
                                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="title">Table Title </label>
                                <input type="text" class="form-control" name="title" id="title"placeholder="Enter Table title" value="{{ $table->title }}">
                                <span class="text-danger">@error('title'){{ $message }}@enderror</span>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Table</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
