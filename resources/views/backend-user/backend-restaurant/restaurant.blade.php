@extends('backend-user.newlayout')

@section('newuser-section')

    <style>
        /* Set a maximum height for the modal body */
        .modal-body {
            max-height: 500px;
            /* Adjust the height as needed */
            overflow-y: auto;
            /* Add vertical scroll if content overflows */
        }


        img {
            width: 80px;
            /* 设置所有图片的宽度为 80 像素 */
            height: auto;
            /* 保持宽高比例 */
        }
    </style>

    <!--Add Restaurant Modal -->
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
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">

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
                            <label for="images">Restaurant Images</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple>
                            <span class="text-danger">
                                @if ($errors->has('images'))
                                    {{ $errors->first('images') }}
                                @endif
                                @foreach ($errors->get('images.*') as $messages)
                                    @foreach ($messages as $message)
                                        {{ $message }}<br>
                                    @endforeach
                                @endforeach
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="phone">Restaurant Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone"
                                placeholder="Enter Restaurant Phone">
                            <span class="text-danger">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="type">Restaurant Type</label>
                            <input type="text" class="form-control" name="type" id="type"
                                placeholder="Enter Restaurant Type">
                            <span class="text-danger">
                                @error('type')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="country">Restaurant Country</label>
                            <input type="text" class="form-control" name="country" id="country"
                                placeholder="Enter Restaurant Country">
                            <span class="text-danger">
                                @error('country')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="state">Restaurant State</label>
                            <input type="text" class="form-control" name="state" id="state"
                                placeholder="Enter Restaurant State">
                            <span class="text-danger">
                                @error('state')
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
                            <textarea class="form-control" name="description" id="description" rows="10" placeholder="Enter Hotel Description"></textarea>
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

                        <div class="form-group">
                            <label for="location">Restaurant Latitude</label>
                            <input type="text" class="form-control" name="latitude" id='latitude'
                                placeholder="Enter Latitude">
                            <span class="text-danger">
                                @error('latitude')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="location">Restaurant Longitude</label>
                            <input type="text" class="form-control" name="longitude" id='longitude'
                                placeholder="Enter Longitude">
                            <span class="text-danger">
                                @error('longitude')
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
        <!-- Modal content for each Restaurant -->
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
                                <input type="text" class="form-control" name="name"
                                    id="name"value="{{ $restaurant->name }}">
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="images">Restaurant Images</label>
                                <input type="file" class="form-control" name="images[]" id="images" multiple>
                                <span class="text-danger">
                                    @if ($errors->has('images'))
                                        {{ $errors->first('images') }}
                                    @endif
                                    @foreach ($errors->get('images.*') as $messages)
                                        @foreach ($messages as $message)
                                            {{ $message }}<br>
                                        @endforeach
                                    @endforeach
                                </span>
                            </div>

                            <!-- Combined existing and preview images -->
                            <div class="form-group">
                                <label>Images:</label>
                                <div class="d-flex flex-wrap"
                                    style="border: 5px solid #ddd; padding: 5px; width: 470px; height: 200px; overflow-y: auto; position: relative;">
                                    @foreach ($restaurant->images as $image)
                                        <div style="position: relative; margin: 5px; width: 80px; height: 80px;">
                                            <img src="{{ asset('images/' . $image->image) }}" alt="Restaurant Image"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                            <button type="button" class="btn btn-danger btn-sm delete-image"
                                                data-image-id="{{ $image->id }}"
                                                style="position: absolute; top: 5px; right: 5px;">X</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Restaurant Email </label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="{{ $restaurant->email }}">
                                <span class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Restaurant Phone Number</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="{{ $restaurant->phone }}">
                                <span class="text-danger">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="type">Restaurant Type</label>
                                <input type="text" class="form-control" name="type"
                                    id="type"value="{{ $restaurant->type }}">
                                <span class="text-danger">
                                    @error('map')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="country">Restaurant Country</label>
                                <input type="text" class="form-control" name="country" id="country"
                                    value="{{ $restaurant->country }}">
                                <span class="text-danger">
                                    @error('country')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="state">Restaurant State</label>
                                <input type="text" class="form-control" name="state" id="state"
                                    value="{{ $restaurant->state }}">
                                <span class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="date">Restaurant Open Date</label>
                                <input type="text" class="form-control" name="date"
                                    id="date"value="{{ $restaurant->date }}">
                                <span class="text-danger">
                                    @error('date')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="time">Restaurant Open Time</label>
                                <input type="text" class="form-control" name="time"
                                    id="time"value="{{ $restaurant->time }}">
                                <span class="text-danger">
                                    @error('time')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="address">Restaurant Address</label>
                                <input type="text" class="form-control" name="address"
                                    id="address"value="{{ $restaurant->address }}">
                                <span class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="description">Restaurant Description</label>
                                <textarea class="form-control" name="description" id="description" rows="10">{{ $restaurant->description }}</textarea>
                                <span class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="map">Restaurant Map</label>
                                <input type="text" class="form-control" name="map"
                                    id="map"value="{{ $restaurant->map }}">
                                <span class="text-danger">
                                    @error('map')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="longitude">Restaurant Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude"
                                    value="{{ $restaurant->longitude }}">
                                <span class="text-danger">
                                    @error('longitude')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="latitude">Restaurant Latitude</label>
                                <input type="text" class="form-control" name="latitude" id="latitude"
                                    value="{{ $restaurant->latitude }}">
                                <span class="text-danger">
                                    @error('latitude')
                                        {{ $message }}
                                    @enderror
                                </span>
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

    <!-- Import and Export Modal -->
    <div class="modal fade" id="restaurantexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Restaurant Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('import-restaurant') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label>Select File</label>
                        <input type="file" name="file" class="form-control" />
                        <span class="text-danger">
                            @error('file')
                                {{ $message }}
                            @enderror
                        </span>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-info">Submit</button>
                            <!-- <button onclick="readExcelFile()">Read File</button> -->
                            <!-- <a href="" class="btn btn-primary float-right">Export Excel</a> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Show All Restaurant -->
    <div class="container">

        {{-- <div id="map" style="height: 400px;"></div><br> --}}

        <div class="row">
            <div class="col-12">

                {{-- Search Restaurant Function --}}
                <form action="{{ route('RestaurantSearch') }}" method="GET"
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-white small m-2" name="name"
                            placeholder="Search for Name" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="country"
                            placeholder="Search for Country" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="state"
                            placeholder="Search for State" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="address"
                            placeholder="Search for Address" aria-label="Search" aria-describedby="basic-addon2">
                        {{-- <input type="date" class="form-control bg-white small m-2" name="date" placeholder="Search for Date" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="time" class="form-control bg-white small m-2" name="time" placeholder="Search for Time" aria-label="Search" aria-describedby="basic-addon2"> --}}
                        <div>
                            <button type="submit" class="btn btn-primary pb-2"><i
                                    class="fas fa-search fa-sm"></i></button>
                        </div>
                    </div>
                </form>

                <br>

                <div class="data_table">

                    @if (\Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    @if (\Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif

                    <!-- Button to delete all selected items -->
                    <form action="{{ route('restaurants.deleteMultiplerestaurant') }}" method="post"
                        id="deleteMultipleForm">
                        @csrf
                        <!-- Your table code here -->
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                {{-- Button to delete all selected items --}}
                                <button type="button" class="btn btn-danger m-1" id="deleteAllSelectedRecord">Delete
                                    Selected Restaurants</button>
                                {{-- Add Restaurant --}}
                                <button type="button" class="btn btn-info m-1" data-toggle="modal"
                                    data-target="#restaurantModal">Add Restaurant</button>
                                <!-- Import Restaurant Model -->
                                <button type="button" class="btn btn-primary m-1" data-toggle="modal"
                                    data-target="#restaurantexcelModal">Import Restaurant</button>
                                {{-- Export Restaurant --}}
                                <a href="{{ url('export-restaurant') }}"><button type="button"
                                        class="btn btn-primary m-1">Export Restaurant</button></a>
                                {{-- Restaurant Excel Template --}}
                                <a href="{{ route('Restaurant.Excel.Template') }}"><button type="button"
                                        class="btn btn-dark  m-1">Restaurant Excel Template</button></a>

                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" name="" id="select_all_ids"
                                                onclick="checkAll(this)"></th>
                                        <th>Restaurant ID</th>
                                        <th>Restaurant Name</th>
                                        <th>Restaurant Image</th>
                                        <th>Restaurant Date</th>
                                        <th>Restaurant Time</th>
                                        <th>Restaurant Type</th>
                                        <th>Restaurant Address</th>
                                        <th>Restaurant Description</th>
                                        <th>Open / Close</th>
                                        <th>Register Status</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($restaurantss && count($restaurantss) > 0)
                                        @foreach ($restaurantss as $restaurant)
                                            @if ($restaurant->register_status === 1)
                                                <tr id="restaurant_ids{{ $restaurant->id }}">
                                                    <td><input type="checkbox" name="ids" class="checkbox_ids" value="{{ $restaurant->id }}"></td>
                                                    <td>{{ $restaurant->id }}</td>
                                                    <td>{{ $restaurant->name }}</td>
                                                    <td style="position: relative; width: 100px; height: 100px; overflow: hidden; text-align: center;">
                                                        @if ($restaurant->images->count() > 0)
                                                            <div id="carousel{{ $restaurant->id }}" class="carousel slide" data-ride="carousel">
                                                                <div class="carousel-inner" style="width: 100%; height: 100%;">
                                                                    @foreach ($restaurant->images as $key => $image)
                                                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                                            <img src="{{ asset('images/' . $image->image) }}" class="d-block w-100" alt="Restaurant Image" style="max-width: 100%; max-height: 100%; display: block; margin: auto;">
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <a class="carousel-control-prev" href="#carousel{{ $restaurant->id }}" role="button" data-slide="prev" style="width: 20px;">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#carousel{{ $restaurant->id }}" role="button" data-slide="next" style="width: 20px;">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                    <span class="sr-only">Next</span>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $restaurant->date }}</td>
                                                    <td>{{ $restaurant->time }}</td>
                                                    <td>{{ $restaurant->type }}</td>
                                                    <td>{{ $restaurant->address }}</td>
                                                    <td>{{ $restaurant->description }}</td>
                                                    <td>
                                                        @if ($restaurant->status == 0)
                                                            <a href="{{ url('changerestaurant-status/' . $restaurant->id) }}" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to change this status to close?')">Open</a>
                                                        @else
                                                            <a href="{{ url('changerestaurant-status/' . $restaurant->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to change this status to open?')">Close</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($restaurant->register_status === 1)
                                                            <span class="text-success">Approved</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('viewRestaurant/' . $restaurant->id . '/view') }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i>&nbsp;View</a>
                                                        <a href="{{ url('editRestaurant/' . $restaurant->id . '/edit') }}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#restauranteditModal{{ $restaurant->id }}"><i class="fa fa-edit"></i>&nbsp;Edit</a><br>
                                                        <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('deleteRestaurant/' . $restaurant->id . '/delete') }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="12">No Restaurants Found</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                    </form>

                    <!-- Pagination links -->
                    {{ $restaurantss->links() }}
                </div>
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

    <!-- Import and Export Modal -->
    <div class="modal fade" id="tableexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Table Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('import-table') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label>Select File</label>
                        <input type="file" name="file" class="form-control" />
                        <span class="text-danger">
                            @error('file')
                                {{ $message }}
                            @enderror
                        </span>
                        <div class="mt-5">
                            <button type="submit" class="btn btn-info">Submit</button>
                            <!-- <button onclick="readExcelFile()">Read File</button> -->
                            <!-- <a href="" class="btn btn-primary float-right">Export Excel</a> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Show All Table -->
    <div class="container">

        {{-- <div id="map" style="height: 400px;"></div><br> --}}

        <div class="row">
            <div class="col-12">
                <div class="data_table">

                    @if (\Session::has('tables'))
                        <div class="alert alert-danger">{{ Session::get('tables') }}</div>
                    @endif

                    @if (\Session::has('table'))
                        <div class="alert alert-success">{{ Session::get('table') }}</div>
                    @endif

                    <!-- Button to delete all selected items -->
                    <form action="{{ route('restaurantstable.delete') }}" method="post" id="deleteMultipleForms">
                        @csrf
                        <!-- Your table code here -->
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                {{-- Button to delete all selected items --}}
                                <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecords">Delete
                                    All Selected Tables</button>
                                {{-- Add Table Model--}}
                                <button type="button" class="btn btn-info m-1" data-toggle="modal"
                                    data-target="#tableModal">Add Table</button>
                                <!-- Import Table Model -->
                                <button type="button" class="btn btn-primary m-1" data-toggle="modal"
                                    data-target="#tableexcelModal">Import Table</button>
                                {{-- Export Table --}}
                                <a href="{{ url('export-table') }}"><button type="button"
                                        class="btn btn-primary m-1">Export Table</button></a>
                                {{-- Table Excel Template --}}
                                <a href="{{ route('Table.Excel.Template') }}"><button type="button"
                                        class="btn btn-dark m-1">Table Excel Template</button></a>

                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" name="" id="select_all_ids"
                                                onclick="checkAlls(this)"></th>
                                        <th>Table ID</th>
                                        <th>Restaurant Name</th>
                                        <th>Table Title</th>
                                        <th>Status</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tabless !== null && count($tabless) > 0)
                                        @foreach ($tabless as $table)
                                            <tr>
                                                <td><input type="checkbox" name="ids" class="checkbox_idss"
                                                        id="" value="{{ $table->id }}"></td>
                                                <td>Table ID: {{ $table->id }}</td>
                                                <td>{{ $table->restaurant->name ?? 'No Restaurant' }}</td>
                                                <td>{{ $table->title }}</td>
                                                <td>
                                                    @if ($table->status == 0)
                                                        <a href="{{ url('changetable-status/' . $table->id) }}"
                                                            class="btn btn-sm btn-success"
                                                            onclick="return confirm('Are you sure you want to change this status to close?')">Open</a>
                                                    @else
                                                        <a href="{{ url('changetable-status/' . $table->id) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to change this status to open?')">Close</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></a> -->
                                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#tableeditModal{{ $table->id }}"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                                        href="{{ url('deleteTable/' . $table->id) . '/delete' }}"
                                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9">No Table Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination links -->
                    {{ $tabless->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Table Model -->
    @foreach ($tables as $table)
        <!-- Modal content for each Table -->
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
                            <label for="name">Select Restaurant</label>
                            <select class="form-control" name="restaurant_id">
                                <option value="">-------</option>
                                @foreach ($restaurantd as $restaurant)
                                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="title">Table Title </label>
                                <input type="text" class="form-control" name="title"
                                    id="title"placeholder="Enter Table title" value="{{ $table->title }}">
                                <span class="text-danger">
                                    @error('title')
                                        {{ $message }}
                                    @enderror
                                </span>
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

    {{-- New Delete Selected All Restaurant Table --}}
    <script>
        // Function to check/uncheck all checkboxes
        function checkAlls(checkbox) {
            const checkboxes = document.getElementsByClassName('checkbox_idss');
            for (const cb of checkboxes) {
                cb.checked = checkbox.checked;
            }
        }

        // Add a click event listener to the delete button to submit the form
        document.getElementById('deleteAllSelectedRecords').addEventListener('click', function(e) {
            e.preventDefault();
            const checkboxes = document.getElementsByClassName('checkbox_idss');
            const selectedIds = [];

            // Get the IDs of the selected restaurants
            for (const checkbox of checkboxes) {
                if (checkbox.checked) {
                    selectedIds.push(parseInt(checkbox.value));
                }
            }

            if (selectedIds.length === 0) {
                alert('Please select at least one restaurant to delete.');
            } else {
                // Create a hidden input field to store the selected IDs
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids';
                input.value = JSON.stringify(selectedIds);
                document.getElementById('deleteMultipleForms').appendChild(input);

                // Submit the form
                document.getElementById('deleteMultipleForms').submit();
            }
        });
    </script>

    {{-- New Delete Selected All Restaurant --}}
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

    {{-- Read Excel File Data JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

    {{-- Read Restaurant Excel File Data --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 获取文件输入框和模态框内容区域的元素
            const fileInput = document.querySelector('#restaurantexcelModal input[type="file"]');
            const modalBody = document.querySelector('#restaurantexcelModal .modal-body');

            // 为文件输入框添加事件监听，当用户选择了文件后触发
            fileInput.addEventListener('change', function(event) {
                // 获取用户选择的文件
                const selectedFile = event.target.files[0];

                if (selectedFile) {
                    // 创建一个文件阅读器对象
                    const fileReader = new FileReader();

                    // 当文件加载完成时，会执行这个回调函数
                    fileReader.onload = function(e) {
                        // 获取文件的内容（以二进制形式）
                        const data = e.target.result;

                        // 使用 XLSX 库将二进制内容解析成工作簿对象
                        const workbook = XLSX.read(data, {
                            type: 'binary'
                        });

                        // 假设你使用第一个工作表名字
                        const sheetName = workbook.SheetNames[0];

                        // 将工作表的数据解析成 JSON 格式
                        const sheetData = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
                            header: 1
                        });

                        // 创建一个 HTML 表格元素
                        const table = document.createElement('table');
                        table.classList.add('table', 'table-bordered');

                        // 循环遍历数据，创建表格行和单元格
                        for (let i = 0; i < sheetData.length; i++) {
                            const row = document.createElement('tr');
                            for (let j = 0; j < sheetData[i].length; j++) {
                                const cell = document.createElement(i === 0 ? 'th' : 'td');
                                cell.textContent = sheetData[i][j];
                                row.appendChild(cell);
                            }
                            table.appendChild(row);
                        }

                        console.log(sheetData);

                        // 将表格添加到模态框内容区域中
                        modalBody.appendChild(table);
                    };

                    // 开始读取文件内容（以二进制字符串形式）
                    fileReader.readAsBinaryString(selectedFile);
                }
            });
        });
    </script>

    {{-- Read Table Excel File Data --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 获取文件输入框和模态框内容区域的元素
            const fileInput = document.querySelector('#tableexcelModal input[type="file"]');
            const modalBody = document.querySelector('#tableexcelModal .modal-body');

            // 为文件输入框添加事件监听，当用户选择了文件后触发
            fileInput.addEventListener('change', function(event) {
                // 获取用户选择的文件
                const selectedFile = event.target.files[0];

                if (selectedFile) {
                    // 创建一个文件阅读器对象
                    const fileReader = new FileReader();

                    // 当文件加载完成时，会执行这个回调函数
                    fileReader.onload = function(e) {
                        // 获取文件的内容（以二进制形式）
                        const data = e.target.result;

                        // 使用 XLSX 库将二进制内容解析成工作簿对象
                        const workbook = XLSX.read(data, {
                            type: 'binary'
                        });

                        // 假设你使用第一个工作表名字
                        const sheetName = workbook.SheetNames[0];

                        // 将工作表的数据解析成 JSON 格式
                        const sheetData = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
                            header: 1
                        });

                        // 创建一个 HTML 表格元素
                        const table = document.createElement('table');
                        table.classList.add('table', 'table-bordered');

                        // 循环遍历数据，创建表格行和单元格
                        for (let i = 0; i < sheetData.length; i++) {
                            const row = document.createElement('tr');
                            for (let j = 0; j < sheetData[i].length; j++) {
                                const cell = document.createElement(i === 0 ? 'th' : 'td');
                                cell.textContent = sheetData[i][j];
                                row.appendChild(cell);
                            }
                            table.appendChild(row);
                        }

                        console.log(sheetData);

                        // 将表格添加到模态框内容区域中
                        modalBody.appendChild(table);
                    };

                    // 开始读取文件内容（以二进制字符串形式）
                    fileReader.readAsBinaryString(selectedFile);
                }
            });
        });
    </script>

    {{-- Delete Restaurant Mutliple Image --}}
    <script>
        $(document).ready(function() {
            $('.delete-image').click(function() {
                var imageId = $(this).data('image-id');
                var imageElement = $(this).closest('div'); // 获取图片元素的父级 div
                var modalContent = $(this).closest('.modal-content');
                var modal = modalContent.closest('.modal');
                var modalId = modal.attr('id');

                if (modalId) {
                    var restaurantId = modalId.split('restauranteditModal')[1];
                    console.log('restaurantId', restaurantId);

                    if (restaurantId) {
                        var confirmation = confirm('Are you sure you want to delete this image?');
                        if (confirmation) {
                            $.ajax({
                                url: '/restaurant-image/' + imageId,
                                type: 'DELETE',
                                data: {
                                    "_token": "{{ csrf_token() }}", // Ensure CSRF token is included
                                    "id": imageId,
                                },
                                success: function(data) {
                                    console.log(data.message);
                                    // 从DOM中移除图片元素
                                    imageElement.remove();
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    } else {
                        console.error('Restaurant ID not found in modal ID');
                    }
                } else {
                    console.error('Modal ID not found');
                }
            });
        });
    </script>


@endsection
