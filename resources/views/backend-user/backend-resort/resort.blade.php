@extends('backend-user.newlayout')

@section('newuser-section')

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    {{-- Modal CSS --}}
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

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Add Resort Modal -->
    <div class="modal fade" id="resortModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Resort</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('addResort') }}" method="POST" enctype="multipart/form-data" id="searchMap2">
                    @csrf
                    <div class="modal-body">

                        <!-- {{ Auth::id() }} -->
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">

                        <div class="form-group">
                            <label for="name">Resort Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Resort Name">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="images">Resort Images</label>
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
                            <label for="price">Resort Price</label>
                            <input type="number" class="form-control" name="price" id="price"
                                placeholder="Enter Resort Price">
                            <span class="text-danger">
                                @error('price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="phone">Resort Phone</label>
                            <input type="number" class="form-control" name="phone" id="phone"
                                placeholder="Enter Resort Phone">
                            <span class="text-danger">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="type">Resort Type</label>
                            <input type="text" class="form-control" name="type" id="type"
                                placeholder="Enter Resort Type">
                            <span class="text-danger">
                                @error('type')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="country">Resort Country</label>
                            <input type="text" class="form-control" name="country" id="country"
                                placeholder="Enter Resort Country">
                            <span class="text-danger">
                                @error('country')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="state">Resort State</label>
                            <input type="text" class="form-control" name="state" id="state"
                                placeholder="Enter Resort State">
                            <span class="text-danger">
                                @error('state')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="location">Resort Location</label>
                            <input type="text" class="form-control" name="location" id="location"
                                placeholder="Enter Resort Address">
                            <span class="text-danger">
                                @error('location')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="description">Resort Description</label>
                            <input type="text" class="form-control" name="description" id="description"
                                placeholder="Enter Description ">
                            <span class="text-danger">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="map">Hotel Map</label>
                            <input type="text" class="form-control" name="map" id='map'
                                placeholder="Enter Hotel Map">
                            <span class="text-danger">
                                @error('map')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="location">Resort Latitude</label>
                            <input type="text" class="form-control" name="latitude" id='latitude'
                                placeholder="Enter Latitude">
                            <span class="text-danger">
                                @error('latitude')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="location">Resort Longitude</label>
                            <input type="text" class="form-control" name="longitude" id='longitude'
                                placeholder="Enter Longitude">
                            <span class="text-danger">
                                @error('longitude')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <!-- <input type="text" id="latitude" name="latitude">
                                    <input type="text" id="longitude" name="longitude"> -->

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
    @foreach ($resorts as $resort)
        <!-- Modal content for each Resort -->
        <div class="modal fade" id="resorteditModal{{ $resort->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal header and form -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Resort Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ url('/updateResort/' . $resort->id) }}" method="POST" id="model"
                        enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Resort Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $resort->name }}">
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="images">Resort Images</label>
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
                                    @foreach ($resort->images as $image)
                                        <div style="position: relative; margin: 5px; width: 80px; height: 80px;">
                                            <img src="{{ asset('images/' . $image->image) }}" alt="Resort Image"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                            <button type="button" class="btn btn-danger btn-sm delete-image"
                                                data-image-id="{{ $image->id }}"
                                                style="position: absolute; top: 5px; right: 5px;">X</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="price">Resort Price</label>
                                <input type="number" class="form-control" name="price" id="price"
                                    value="{{ $resort->price }}">
                                <span class="text-danger">
                                    @error('price')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="type">Resort Type</label>
                                <input type="text" class="form-control" name="type" id="type"
                                    value="{{ $resort->type }}">
                                <span class="text-danger">
                                    @error('type')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="email">Resort Email </label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="{{ $resort->email }}">
                                <span class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Resort Phone Number</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="{{ $resort->phone }}">
                                <span class="text-danger">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="country">Resort Country</label>
                                <input type="text" class="form-control" name="country" id="country"
                                    value="{{ $resort->country }}">
                                <span class="text-danger">
                                    @error('country')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="state">Resort State</label>
                                <input type="text" class="form-control" name="state" id="state"
                                    value="{{ $resort->state }}">
                                <span class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="location">Resort Location</label>
                                <input type="text" class="form-control" name="location" id="location"
                                    value="{{ $resort->location }}">
                                <span class="text-danger">
                                    @error('location')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="description">Resort Description</label>
                                <input type="text" class="form-control" name="description" id="description"
                                    value="{{ $resort->description }}">
                                <span class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="map">Resort Map</label>
                                <input type="text" class="form-control" name="map"
                                    id="map"value="{{ $resort->map }}">
                                <span class="text-danger">
                                    @error('map')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="longitude">Resort Longitude</label>
                                <input type="text" class="form-control" name="longitude" id="longitude"
                                    value="{{ $resort->longitude }}">
                                <span class="text-danger">
                                    @error('longitude')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="latitude">Resort Latitude</label>
                                <input type="text" class="form-control" name="latitude" id="latitude"
                                    value="{{ $resort->latitude }}">
                                <span class="text-danger">
                                    @error('latitude')
                                        {{ $message }}
                                    @enderror
                                </span>
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
    <div class="modal fade" id="resortexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Resort Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('import-resort') }}" method="POST" enctype="multipart/form-data">
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

    {{-- Show All Resort --}}
    <div class="container">
        <div class="row">
            <div class="col-12">

                {{-- Search Resort Function --}}
                <form action="{{ route('ResortSearch') }}" method="GET"
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-white small m-2" name="name"
                            placeholder="Search for Name" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="country"
                            placeholder="Search for Country" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="state"
                            placeholder="Search for State" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="location"
                            placeholder="Search for Address" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="price"
                            placeholder="Search for Price" aria-label="Search" aria-describedby="basic-addon2">
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
                    <form action="{{ route('resorts.deleteMultiple') }}" method="post" id="deleteMultipleForm">
                        @csrf
                        <!-- Your table code here -->
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered table-striped" width="100%"
                                cellspacing="0">
                                {{-- Button to delete all selected items --}}
                                <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecord">Delete All
                                    Selected Resorts</button>
                                {{-- Add Resort --}}
                                <button type="button" class="btn btn-info m-1" data-toggle="modal"
                                    data-target="#resortModal">Add Resort</button>
                                <!-- Import Resort Model -->
                                <button type="button" class="btn btn-primary m-1" data-toggle="modal"
                                    data-target="#resortexcelModal">Import Resort</button>
                                {{-- Export Resort --}}
                                <a href="{{ url('export-resort') }}"><button type="button"
                                        class="btn btn-primary m-1">Export Resort</button></a>
                                {{-- Resort Excel Template --}}
                                <a href="{{ route('Resort.Excel.Template') }}"><button type="button"
                                        class="btn btn-dark m-1">Resort Excel Template</button></a>

                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" name="" id="select_all_ids"
                                                onclick="checkAll(this)"></th>
                                        <th>Resort ID</th>
                                        <th>Resort Name</th>
                                        <th>Resort Image</th>
                                        <th>Resort Price</th>
                                        <th>Resort Address</th>
                                        <th>Resort Description</th>
                                        <th>Open / Close</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($resortss !== null && count($resortss) > 0)
                                        @foreach ($resortss as $resort)
                                            <tr id="resort_ids{{ $resort->id }}">
                                                <td><input type="checkbox" name="ids" class="checkbox_ids"
                                                        id="" value="{{ $resort->id }}"></td>
                                                <td>{{ $resort->id }}</td>
                                                <td>{{ $resort->name }}</td>
                                                <td
                                                    style="position: relative; width: 100px; height: 100px; overflow: hidden; text-align: center;">
                                                    @if ($resort->images->count() > 0)
                                                        <div id="carousel{{ $resort->id }}" class="carousel slide"
                                                            data-ride="carousel">
                                                            <div class="carousel-inner"
                                                                style="width: 100%; height: 100%;">
                                                                @foreach ($resort->images as $key => $image)
                                                                    <div
                                                                        class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                                        <img src="{{ asset('images/' . $image->image) }}"
                                                                            class="d-block w-100" alt="Resort Image"
                                                                            style="max-width: 100%; max-height: 100%; display: block; margin: auto;">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <a class="carousel-control-prev"
                                                                href="#carousel{{ $resort->id }}" role="button"
                                                                data-slide="prev" style="width: 20px;">
                                                                <span class="carousel-control-prev-icon"
                                                                    aria-hidden="true"></span>
                                                                <span class="sr-only">Previous</span>
                                                            </a>
                                                            <a class="carousel-control-next"
                                                                href="#carousel{{ $resort->id }}" role="button"
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
                                                <td>{{ $resort->price }}</td>
                                                <td>{{ $resort->location }}</td>
                                                {{-- <td>{{ $resort->latitude }}</td>
                                                    <td>{{ $resort->longitude }}</td> --}}
                                                <td>{{ $resort->description }}</td>
                                                <td>
                                                    @if ($resort->status == 0)
                                                        <a href="{{ url('changeresort-status/' . $resort->id) }}"
                                                            class="btn btn-sm btn-success"
                                                            onclick="return confirm('Are you sure you want to change this status to close?')">Open</a>
                                                    @else
                                                        <a href="{{ url('changeresort-status/' . $resort->id) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to change this status to open?')">Close</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('showResortMap/' . $resort->id) . '/map' }}"
                                                        class="btn btn-info btn-sm"><i
                                                            class="fas fa-eye"></i>&nbsp;View</a>
                                                    <a href="{{ url('editResort/' . $resort->id) . '/edit' }}"
                                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#resorteditModal{{ $resort->id }}"><i
                                                            class="fa fa-edit"></i>&nbsp;Edit</a><br>
                                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                                        href="{{ url('deleteResort/' . $resort->id) . '/delete' }}"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="fa fa-trash"></i>&nbsp;Delete</a>
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
                    {{ $resortss->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- =======  Data-Table  = End  ===================== -->
    <!-- ============ Java Script Files  ================== -->

    <!-- Show All Location In Google Map -->
    <script>
        function initMap() {

            // var kualaLumpur = new google.maps.LatLng(3.1390, 101.6869);
            // var johorBahru = new google.maps.LatLng(1.4927, 103.7414);

            var resorts = @json($resorts);

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: {
                    lat: 1.4927,
                    lng: 103.7414
                }
            });

            resorts.forEach(function(resort) {
                var marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(resort.latitude),
                        lng: parseFloat(resort.longitude)
                    },
                    map: map,
                    title: resort.name
                });
            });
        }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG2YHIuPJYMOJzS6wSw5eZ0dTYXnhZFLs&callback=initMap"></script>

    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    {{-- New Delete Selected Resort --}}
    <script>
        // Add a click event listener to the delete button to submit the form
        document.getElementById("deleteAllSelectedRecord").addEventListener("click", function(e) {
            e.preventDefault();
            const checkboxes = document.getElementsByClassName("checkbox_ids");
            const selectedIds = [];

            // Get the IDs of the selected resorts
            for (const checkbox of checkboxes) {
                if (checkbox.checked) {
                    selectedIds.push(checkbox.value);
                }
            }

            if (selectedIds.length === 0) {
                alert("Please select at least one resort to delete.");
            } else {
                // Set the selected IDs to a hidden input field in the form
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "ids";
                input.value = JSON.stringify(selectedIds);
                document.getElementById("deleteMultipleForm").appendChild(input);

                // Submit the form
                document.getElementById("deleteMultipleForm").submit();
            }
        });
    </script>

    {{-- New Delete Selected All Resort --}}
    <script>
        // Function to check/uncheck all checkboxes
        function checkAll(checkbox) {
            const checkboxes = document.getElementsByClassName('checkbox_ids');
            for (const cb of checkboxes) {
                cb.checked = checkbox.checked;
            }
        }

        // Add a click event listener to the delete button to submit the form
        document.getElementById('deleteAllSelectedRecord').addEventListener('click', function(e) {
            e.preventDefault();
            const checkboxes = document.getElementsByClassName('checkbox_ids');
            const selectedIds = [];

            // Get the IDs of the selected resorts
            for (const checkbox of checkboxes) {
                if (checkbox.checked) {
                    selectedIds.push(checkbox.value);
                }
            }

            if (selectedIds.length === 0) {
                alert('Please select at least one resort to delete.');
            } else {
                // Create a hidden input field to store the selected IDs
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids';
                input.value = JSON.stringify(selectedIds);
                document.getElementById('deleteMultipleForm').appendChild(input);

                // Submit the form
                document.getElementById('deleteMultipleForm').submit();
            }
        });
    </script>

    {{-- Read Excel File Data JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

    {{-- Read Excel File Data --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 获取文件输入框和模态框内容区域的元素
            const fileInput = document.querySelector('#resortexcelModal input[type="file"]');
            const modalBody = document.querySelector('#resortexcelModal .modal-body');

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

    {{-- Delete Mutliple Image --}}
    <script>
        $(document).ready(function() {
            $('.delete-image').click(function() {
                var imageId = $(this).data('image-id');
                var imageElement = $(this).closest('div'); // 获取图片元素的父级 div
                var modalContent = $(this).closest('.modal-content');
                var modal = modalContent.closest('.modal');
                var modalId = modal.attr('id');

                if (modalId) {
                    var resortId = modalId.split('resorteditModal')[1];
                    console.log('resortId', resortId);

                    if (resortId) {
                        var confirmation = confirm('Are you sure you want to delete this image?');
                        if (confirmation) {
                            $.ajax({
                                url: '/resort-image/' + imageId,
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
                        console.error('Resort ID not found in modal ID');
                    }
                } else {
                    console.error('Modal ID not found');
                }
            });
        });
    </script>

    <!-- Delete Selected Resort -->
    {{-- <script>
        $(function(e){

            $("#select_all_ids").click(function(){
                $('.checkbox_ids').prop('checked',$(this).prop('checked'));
            });

            $('#deleteAllSelectedRecord').click(function(e){
                e.preventDefault();
                var all_ids = [];
                $('input:checkbox[name=ids]:checked').each(function(){
                    all_ids.push($(this).val());
                });

                $.ajax({
                    url:"{{ route('resort.delete') }}",
                    type:"DELETE",
                    data:{
                        ids:all_ids,
                        _token:'{{ csrf_token() }}'
                    },
                    success:function(response){
                        $.each(all_ids,function(key,val){
                            $('resort_ids'+val).remove();
                        });
                    }
                });
            });
        });
    </script> --}}

    {{-- Backend JS --}}
    <script src="{{ asset('table/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('table/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('table/assets/js/datatables.min.js') }}"></script>
    <script src="{{ asset('table/assets/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('table/assets/js/vfs_fonts.js') }}"></script>
    {{-- <script src="{{ asset('table/assets/js/custom.js') }}"></script> --}}
@endsection
