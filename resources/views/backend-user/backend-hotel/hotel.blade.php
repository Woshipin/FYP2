@extends('backend-user.newlayout')

@section('newuser-section')

    {{-- Modal CSS --}}
    <style>
        .modal-dialog {
            max-width: 80%;
            width: 80%;
            margin: 30px auto;
        }

        .modal-content {
            height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-header,
        .modal-footer {
            flex-shrink: 0;
        }

        .modal-body {
            flex: 1 1 auto;
            overflow-y: auto;
            max-height: calc(90vh - 120px);
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
        }

        /* 调整预览区域 */
        .preview-add-image {
            width: 100%;
            height: 300px;
            /* 可以根据需要调整 */
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        #preview-container {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
        }

        #preview-container img {
            width: 100px;
            /* 调整预览图片的大小 */
            height: 100px;
            object-fit: cover;
            margin: 5px;
        }

        @media (max-height: 600px) {
            .modal-dialog {
                margin: 10px auto;
            }

            .modal-content {
                height: 95vh;
            }

            .modal-body {
                max-height: calc(95vh - 100px);
            }

            .preview-add-image {
                height: 200px;
                /* 在小屏幕上减小高度 */
            }
        }
    </style>

    {{-- Table CSS --}}
    <style>
        /* Custom CSS for better aesthetics */
        .data_table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
            border: 1px solid #dee2e6;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            background-color: #343a40;
            color: #ffffff;
            font-weight: bold;
            padding: 12px;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody tr.table-light:hover {
            background-color: #e9ecef;
        }

        .table tbody td {
            border-top: 1px solid #dee2e6;
            padding: 12px;
        }

        .table tbody tr:first-child td {
            border-top: none;
        }

        .table tbody tr:last-child td {
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: rgba(255, 255, 255, 1);
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-success:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }
    </style>

    {{-- Hotel Area --}}
    {{-- Add new hotels --}}
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
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Hotel Name">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <!-- Add Image Form -->
                        <div class="form-group">
                            <label for="images">Hotel Images</label>
                            <input type="file" class="form-control" name="images[]" id="images" multiple>
                            <span class="text-danger">
                                @error('images')
                                    {{ $message }}
                                @enderror
                                @foreach ($errors->get('images.*') as $message)
                                    {{ $message }}
                                @endforeach
                            </span>
                        </div>

                        <div class="preview-add-image"
                            style="border: 5px solid #ddd; padding: 5px; width: 470px; height: 200px; overflow-y: auto;">
                            <label>Preview:</label>
                            <div id="preview-container" class="d-flex flex-wrap"
                                style="border: 1px solid #ddd; padding: 5px; width: 100%; height: 100%; overflow-y: auto;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="type">Hotel Type</label>
                            <input type="text" class="form-control" name="type" id="type"
                                placeholder="Enter Hotel Type">
                            <span class="text-danger">
                                @error('type')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="phone">Hotel Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone"
                                placeholder="Enter Hotel Phone">
                            <span class="text-danger">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="country">Hotel Country</label>
                            <input type="text" class="form-control" name="country" id="country"
                                placeholder="Enter Hotel Country">
                            <span class="text-danger">
                                @error('country')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="state">Hotel State</label>
                            <input type="text" class="form-control" name="state" id="state"
                                placeholder="Enter Hotel State">
                            <span class="text-danger">
                                @error('state')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="address">Hotel Address</label>
                            <textarea class="form-control" name="address" id="address" rows="10" placeholder="Enter Hotel Address"></textarea>
                            <span class="text-danger">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="latitude">Hotel Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="latitude"
                                placeholder="Enter Latitude">
                            <span class="text-danger">
                                @error('latitude')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="longitude">Hotel Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="longitude"
                                placeholder="Enter Longitude">
                            <span class="text-danger">
                                @error('longitude')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="description">Hotel Description</label>
                            <textarea class="form-control" name="description" id="description" rows="10"
                                placeholder="Enter Hotel Description"></textarea>
                            <span class="text-danger">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="map">Hotel Map</label>
                            <textarea class="form-control" name="map" id="map" rows="10" placeholder="Enter Hotel Map"></textarea>
                            <span class="text-danger">
                                @error('map')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="state">Hotel Digital_Lock_Password</label>
                            <input type="text" class="form-control" name="digital_lock_password"
                                id="digital_lock_password" placeholder="Enter Hotel Digital_Lock_Password">
                            <span class="text-danger">
                                @error('digital_lock_password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="state">Hotel Email_Box_Password</label>
                            <input type="text" class="form-control" name="emailbox_password" id="emailbox_password"
                                placeholder="Enter Hotel Email_Box_Password">
                            <span class="text-danger">
                                @error('emailbox_password')
                                    {{ $message }}
                                @enderror
                            </span>
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
        <!-- Modal content for each Hotel -->
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
                                    value="{{ old('name', $hotel->name) }}">
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="images">Hotel Images</label>
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
                                    @foreach ($hotel->images as $image)
                                        <div style="position: relative; margin: 5px; width: 80px; height: 80px;">
                                            <img src="{{ asset('images/' . $image->image) }}" alt="Hotel Image"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                            <button type="button" class="btn btn-danger btn-sm delete-image"
                                                data-image-id="{{ $image->id }}"
                                                style="position: absolute; top: 5px; right: 5px;">X</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Hotel Email </label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="{{ old('email', $hotel->email) }}">
                                <span class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="type">Hotel Type</label>
                                <input type="text" class="form-control" name="type" id="type"
                                    value="{{ old('type', $hotel->type) }}">
                                <span class="text-danger">
                                    @error('type')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="phone">Hotel Phone Number</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="{{ old('phone', $hotel->phone) }}">
                                <span class="text-danger">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="country">Hotel Country</label>
                                <input type="text" class="form-control" name="country" id="country"
                                    value="{{ old('country', $hotel->country) }}">
                                <span class="text-danger">
                                    @error('country')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="state">Hotel State</label>
                                <input type="text" class="form-control" name="state" id="state"
                                    value="{{ old('state', $hotel->state) }}">
                                <span class="text-danger">
                                    @error('state')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="address">Hotel Address</label>
                                <input type="text" class="form-control" name="address" id="address"
                                    value="{{ old('address', $hotel->address) }}">
                                <span class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="description">Hotel Description</label>
                                <textarea class="form-control" name="description" id="description" rows="10">{{ old('description', $hotel->description) }}</textarea>
                                <span class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="map">Hotel Map</label>
                                <textarea class="form-control" name="map" id="map" rows="10">{{ old('map', $hotel->map) }}</textarea>
                                <span class="text-danger">
                                    @error('map')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="longitude">Hotel Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude"
                                    value="{{ old('longitude', $hotel->longitude) }}">
                                <span class="text-danger">
                                    @error('longitude')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="latitude">Hotel Latitude</label>
                                <input type="text" class="form-control" name="latitude" id="latitude"
                                    value="{{ old('latitude', $hotel->latitude) }}">
                                <span class="text-danger">
                                    @error('latitude')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="digital_lock_password">Hotel Digital Lock Password</label>
                                <input type="text" class="form-control" name="digital_lock_password"
                                    id="digital_lock_password"
                                    value="{{ old('digital_lock_password', $hotel->digital_lock_password) }}">
                                <span class="text-danger">
                                    @error('digital_lock_password')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="emailbox_password">Hotel Email Box Password</label>
                                <input type="text" class="form-control" name="emailbox_password"
                                    id="emailbox_password"
                                    value="{{ old('emailbox_password', $hotel->emailbox_password) }}">
                                <span class="text-danger">
                                    @error('emailbox_password')
                                        {{ $message }}
                                    @enderror
                                </span>
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

    <!-- Import and Export Modal -->
    <div class="modal fade" id="hotelexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Hotel Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('import-hotel') }}" method="POST" enctype="multipart/form-data">
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

    {{-- show all hotels --}}
    <div class="container mt-5">
        {{-- <div id="map" style="height: 400px;"></div><br> --}}

        <div class="row">
            <div class="col-12">

                {{-- Search Hotel Function --}}
                <form action="{{ route('HotelSearch') }}" method="GET"
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
                        <input type="text" class="form-control bg-white small m-2" name="type"
                            placeholder="Search for Type" aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary pb-2"><i
                                    class="fas fa-search fa-sm"></i></button>
                        </div>
                    </div>
                </form>

                <br>

                <div class="data_table card shadow-sm p-4">

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
                                <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecord">Delete All
                                    Selected Hotels</button>
                                {{-- Add Hotel --}}
                                <button type="button" class="btn btn-info m-1" data-toggle="modal"
                                    data-target="#hotelModal">Add Hotel</button>
                                <!-- Import Hotel Model -->
                                <button type="button" class="btn btn-primary m-1" data-toggle="modal"
                                    data-target="#hotelexcelModal">Import Hotel</button>
                                {{-- Export Hotel --}}
                                <a href="{{ url('export-hotel') }}"><button type="button"
                                        class="btn btn-primary m-1">Export Hotel</button></a>
                                {{-- Hotel Excel Template --}}
                                <a href="{{ route('Hotel.Excel.Template') }}"><button type="button"
                                        class="btn btn-dark m-1">Hotel Excel Template</button></a>

                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" name="" id="select_all_ids"
                                                onclick="checkAll(this)"></th>
                                        <th>Hotel ID</th>
                                        <th>Hotel Name</th>
                                        <th>Hotel Image</th>
                                        <th>Hotel Type</th>
                                        <th>Hotel Country</th>
                                        <th>Hotel State</th>
                                        <th>Hotel Address</th>
                                        <th>Open / Close</th>
                                        <th>Register Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($hotelss !== null && count($hotelss) > 0)
                                        @foreach ($hotelss as $hotel)
                                            <tr id="hotel_ids{{ $hotel->id }}">
                                                <td><input type="checkbox" name="ids" class="checkbox_ids"
                                                        value="{{ $hotel->id }}"></td>
                                                <td>{{ $hotel->id }}</td>
                                                <td>{{ $hotel->name }}</td>
                                                <td
                                                    style="position: relative; width: 100px; height: 100px; overflow: hidden; text-align: center;">
                                                    @if ($hotel->images->count() > 0)
                                                        <div id="carousel{{ $hotel->id }}" class="carousel slide"
                                                            data-ride="carousel">
                                                            <div class="carousel-inner"
                                                                style="width: 100%; height: 100%;">
                                                                @foreach ($hotel->images as $key => $image)
                                                                    <div
                                                                        class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                                        <img src="{{ asset('images/' . $image->image) }}"
                                                                            class="d-block w-100" alt="Hotel Image"
                                                                            style="max-width: 100%; max-height: 100%; display: block; margin: auto;">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <a class="carousel-control-prev"
                                                                href="#carousel{{ $hotel->id }}" role="button"
                                                                data-slide="prev" style="width: 20px;">
                                                                <span class="carousel-control-prev-icon"
                                                                    aria-hidden="true"></span>
                                                                <span class="sr-only">Previous</span>
                                                            </a>
                                                            <a class="carousel-control-next"
                                                                href="#carousel{{ $hotel->id }}" role="button"
                                                                data-slide="next" style="width: 20px;">
                                                                <span class="carousel-control-next-icon"
                                                                    aria-hidden="true"></span>
                                                                <span class="sr-only">Next</span>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span
                                                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">No
                                                            Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $hotel->type }}</td>
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
                                                    @if ($hotel->register_status === 1)
                                                        <span class="text-success">Approved</span>
                                                    @elseif ($hotel->register_status === 2)
                                                        <span class="text-danger">Rejected</span>
                                                    @elseif ($hotel->register_status === 0)
                                                        <span class="text-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('viewHotel/' . $hotel->id) . '/view' }}"
                                                        class="btn btn-info btn-sm"><i
                                                            class="fas fa-eye"></i>&nbsp;View</a>
                                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#hoteleditModal{{ $hotel->id }}"><i
                                                            class="fa fa-edit"></i>&nbsp;Edit</a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                                        href="{{ url('deleteHotel/' . $hotel->id) . '/delete' }}"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="fa fa-trash"></i>&nbsp;Delete</a>
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
                    {{ $hotelss->links() }}
                </div>
            </div>
        </div>
    </div>

    <br>
    <hr>

    {{-- Room Area --}}
    {{-- Add New Room Model --}}
    <div class="modal fade" id="roomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

                        <label for="name">Select Hotel Name</label>
                        <select class="form-control" name="hotel_id">
                            <option value="">---------Select Hotel---------</option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="name">Room Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Room title">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="type">Room Type</label>
                            <input type="text" class="form-control" name="type" id="type"
                                placeholder="Enter Room title">
                            <span class="text-danger">
                                @error('type')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="available">Room Available</label>
                            <input type="number" class="form-control" name="available" id="available"
                                placeholder="Enter Room title">
                            <span class="text-danger">
                                @error('available')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="price">Room Price</label>
                            <input type="number" class="form-control" name="price" id="price"
                                placeholder="Enter Room Price">
                            <span class="text-danger">
                                @error('price')
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
        <!-- Modal content for each Hotel -->
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
                            <label for="name">Select Hotel</label>
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

                            <div class="form-group">
                                <label for="price">Room Price </label>
                                <input type="number" class="form-control" name="price" id="price"
                                    placeholder="Enter Table title" value="{{ $room->price }}">
                                <span class="text-danger">
                                    @error('price')
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

    <!-- Import and Export Modal -->
    <div class="modal fade" id="roomexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Hotel Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('import-room') }}" method="POST" enctype="multipart/form-data">
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
                                <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecords">Delete
                                    All Selected Rooms</button>
                                {{-- Add Room --}}
                                <button type="button" class="btn btn-info m-1" data-toggle="modal"
                                    data-target="#roomModal">Add Room</button>
                                <!-- Import Room Model -->
                                <button type="button" class="btn btn-primary m-1" data-toggle="modal"
                                    data-target="#roomexcelModal">Import Room</button>
                                {{-- Export Room --}}
                                <a href="{{ url('export-room') }}"><button type="button"
                                        class="btn btn-primary m-1">Export Room</button></a>
                                {{-- Room Excel Template --}}
                                <a href="{{ route('Room.Excel.Template') }}"><button type="button"
                                        class="btn btn-dark m-1">Room Excel Template</button></a>
                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" name="" id="select_all_ids"
                                                onclick="checkAll(this)"></th>
                                        <th>Room ID</th>
                                        <th>Restaurant Name</th>
                                        <th>Room Name</th>
                                        <th>Room Type</th>
                                        <th>Room Available</th>
                                        <th>Room Price</th>
                                        <th>Status</th>

                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($roomss !== null && $roomss->count() > 0)
                                        @foreach ($roomss as $room)
                                            <tr>
                                                <td><input type="checkbox" name="idss" class="checkbox_idss"
                                                        id="" value="{{ $room->id }}"></td>
                                                <td>Room ID: {{ $room->id }}</td>
                                                <td>{{ $room->hotel->name ?? 'No Hotel' }}</td>
                                                <td>{{ $room->name }}</td>
                                                <td>{{ $room->type }}</td>
                                                <td>{{ $room->available }}</td>
                                                <td>RM{{ $room->price }}</td>
                                                <td>
                                                    @if ($room->status == 0)
                                                        <a href="{{ url('changeroom-status/' . $room->id) }}"
                                                            class="btn btn-sm btn-success"
                                                            onclick="return confirm('Are you sure you want to change this status to close?')">Open</a>
                                                    @else
                                                        <a href="{{ url('changeroom-status/' . $room->id) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to change this status to open?')">Close</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></a> -->
                                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#roomeditModal{{ $room->id }}"><i
                                                            class="fa fa-edit"></i>&nbsp;Edit</a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                                        href="{{ url('deleteRoom/' . $room->id) . '/delete' }}"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="fa fa-trash"></i>&nbsp;Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9">No Hotels Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination links -->
                    {{ $roomss->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- JavaScript for Add Image Preview -->
    <script>
        function previewAddImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var imgElement = document.getElementById('add-preview');
                imgElement.style.display = 'block'; // 显示预览图像
                imgElement.src = reader.result; // 更新预览图像的src
            }
            reader.readAsDataURL(input.files[0]);
        }
    </script>

    <!-- JavaScript for Edit Image Preview -->
    <script>
        function previewEditImage(event, hotelId) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var imgElement = document.getElementById('edit-preview_' + hotelId);
                imgElement.style.display = 'block'; // 显示预览图像
                imgElement.src = reader.result; // 更新预览图像的src
            }
            reader.readAsDataURL(input.files[0]);
        }
    </script>

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

    {{-- Read Excel File Data JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

    {{-- Read Hotel Excel File Data --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 获取文件输入框和模态框内容区域的元素
            const fileInput = document.querySelector('#hotelexcelModal input[type="file"]');
            const modalBody = document.querySelector('#hotelexcelModal .modal-body');

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

    {{-- Read Room Excel File Data --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 获取文件输入框和模态框内容区域的元素
            const fileInput = document.querySelector('#roomexcelModal input[type="file"]');
            const modalBody = document.querySelector('#roomexcelModal .modal-body');

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

    {{-- Delete Hotel Mutliple Image --}}
    <script>
        $(document).ready(function() {
            $('.delete-image').click(function() {
                var imageId = $(this).data('image-id');
                var imageElement = $(this).closest('div'); // 获取图片元素的父级 div
                var modalContent = $(this).closest('.modal-content');
                var modal = modalContent.closest('.modal');
                var modalId = modal.attr('id');

                if (modalId) {
                    var hotelId = modalId.split('hoteleditModal')[1];
                    console.log('hotelId', hotelId);

                    if (hotelId) {
                        var confirmation = confirm('Are you sure you want to delete this image?');
                        if (confirmation) {
                            $.ajax({
                                url: '/hotel-image/' + imageId,
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
                        console.error('Hotel ID not found in modal ID');
                    }
                } else {
                    console.error('Modal ID not found');
                }
            });
        });
    </script>

    {{-- View Selected Image --}}
    <script>
        document.getElementById('images').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = ''; // Clear previous previews

            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const image = document.createElement('img');
                    image.src = e.target.result;
                    image.style.width = '80px';
                    image.style.height = '80px';
                    image.style.objectFit = 'cover';
                    image.style.margin = '5px';
                    previewContainer.appendChild(image);
                };

                reader.readAsDataURL(file);
            });
        });
    </script>

    {{-- Get Coordinates --}}
    <script>
        document.getElementById('address').addEventListener('input', function() {
            const address = this.value;
            if (address.trim() === '') {
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
                return;
            }

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`, {
                    headers: {
                        'User-Agent': 'YourAppName/1.0 (YourContactEmail)'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const location = data[0];
                        document.getElementById('latitude').value = location.lat; // 设置纬度
                        document.getElementById('longitude').value = location.lon; // 设置经度
                    } else {
                        document.getElementById('latitude').value = '';
                        document.getElementById('longitude').value = '';
                        console.error('No results found for the given address.');
                    }
                })
                .catch(error => {
                    document.getElementById('latitude').value = '';
                    document.getElementById('longitude').value = '';
                    console.error('Error fetching geocoding data:', error);
                });
        });
    </script>

@endsection
