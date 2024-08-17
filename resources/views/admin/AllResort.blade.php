@extends('admin.layout')

@section('admin-section')

    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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

                    <form action="{{ url('/updateResort/' . $resort->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
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
                                <label for="image">Resort Image </label>
                                <input type="file" class="form-control" name="image" id="image"
                                    placeholder="Enter Resort Image" value="{{ $resort->image }}">
                                <span class="text-danger">
                                    @error('image')
                                        {{ $message }}
                                    @enderror
                                </span>
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
                        {{-- <div class="form-group">
                                <label for="latitude">Resort Latitude</label>
                                <input type="text" class="form-control" name="latitude" id="latitude"
                                    value="{{ $resort->latitude }}">
                                <span class="text-danger">
                                    @error('latitude')
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
                            </div> --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Resort</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Show All Resort -->
    <div class="container">
        <br><br><br><br>

        {{-- <div id="map" style="height: 400px;"></div> --}}

        <div class="records table-responsive">
            <div class="record-header">
                <div class="add">
                    <span>Entries</span>
                    <select name="" id="">
                        <option value="">ID</option>
                    </select>
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->
                    <!-- Resort Model -->
                    {{-- <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#adminresortModal">Add Resort</button> --}}
                    <!-- Import Resort Model -->
                    <!-- <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#resortexcelModal">Import Modal</button> -->
                    <!--Export Resort Model -->
                    <a href="{{ url('export-resort') }}"><button type="button" class="btn btn-primary m-1">Export
                            Resort</button></a>
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
                            <th>Resort ID</th>
                            <th>Resort Name</th>
                            <th>Resort Image</th>
                            <th>Resort Price</th>
                            <th>Resort Location</th>
                            <th>Resort Description</th>
                            <th>Open / Close</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($resorts !== null && count($resorts) > 0)
                            @foreach ($resortss as $resort)
                                <tr id="resort_ids{{ $resort->id }}">
                                    <td>{{ $resort->id }}</td>
                                    <td>{{ $resort->name }}</td>
                                    <td><img width="80" src="{{ asset('images/' . $resort->image) }}"
                                            alt="Image" /></td>
                                    <td>{{ $resort->price }}</td>
                                    <td>{{ $resort->location }}</td>
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
                                        <a href="{{ url('admin/viewResort/' . $resort->id) . '/view' }}"
                                            class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="{{ url('editResort/' . $resort->id) . '/edit' }}"
                                            class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#resorteditModal{{ $resort->id }}"><i
                                                class="fa fa-edit"></i></a><br>
                                        <a onclick="return confirm('Are you sure to delete this data?')"
                                            href="{{ url('admin/deleteResort/' . $resort->id) . '/delete' }}"
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
            </div> --}}

            {{-- <div class="container-fluid mt-3">
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
                                        <th>Resort ID</th>
                                        <th>Resort Name</th>
                                        <th>Resort Image</th>
                                        <th>Resort Price</th>
                                        <th>Resort Location</th>
                                        <th>Resort Description</th>
                                        <th>Open / Close</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($resorts !== null && count($resorts) > 0)
                                        @foreach ($resorts as $resort)
                                            <tr id="resort_ids{{ $resort->id }}">
                                                <td>{{ $resort->id }}</td>
                                                <td>{{ $resort->name }}</td>
                                                <td><img width="80" src="{{ asset('images/' . $resort->image) }}"
                                                        alt="Image" /></td>
                                                <td>{{ $resort->price }}</td>
                                                <td>{{ $resort->location }}</td>
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
                                                    <a href="{{ url('admin/viewResort/' . $resort->id) . '/view' }}"
                                                        class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ url('editResort/' . $resort->id) . '/edit' }}"
                                                        class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#resorteditModal{{ $resort->id }}"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                                        href="{{ url('admin/deleteResort/' . $resort->id) . '/delete' }}"
                                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8">No Resorts Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{ $resorts->links() }}
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
                                        <th>Resort ID</th>
                                        <th>Resort Name</th>
                                        <th>Resort Image</th>
                                        <th>Resort Price</th>
                                        <th>Resort Location</th>
                                        <th>Resort Description</th>
                                        <th>Open / Close</th>
                                        <th>Register Status</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="searchResultsContainer">
                                    <!-- Content will be dynamically added here based on search -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="paginationContainer">
                        {{ $resorts->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Admin Real Time Search --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateSearchResults(filteredResorts) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = ''; // Clear previous results

                if (Array.isArray(filteredResorts) && filteredResorts.length > 0) {
                    filteredResorts.forEach(function(resort) {
                        var isDisabled = resort.status === 1;

                        var resortHTML = `<tr class="${isDisabled ? 'disabled' : ''}">
                            <td>${resort.id}</td>
                            <td>${resort.name}</td>
                            <td style="position: relative; width: 100px; height: 100px; overflow: hidden; text-align: center;">
                                ${resort.images && resort.images.length > 0 ?
                                `<div id="carousel${resort.id}" class="carousel slide" data-ride="carousel">
                                                    <div class="carousel-inner" style="width: 100%; height: 100%;">
                                                        ${resort.images.map((image, index) => `
                                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                            <img src="{{ asset('images/') }}/${image.image}" class="d-block w-100" alt="Resort Image" style="max-width: 100%; max-height: 100%; display: block; margin: auto;">
                                        </div>
                                        `).join('')}
                                                    </div>
                                                    <a class="carousel-control-prev" href="#carousel${resort.id}" role="button" data-slide="prev" style="width: 20px;">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carousel${resort.id}" role="button" data-slide="next" style="width: 20px;">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </div>` :
                                `<span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">No Image</span>`}
                            </td>
                            <td>${resort.price}</td>
                            <td>${resort.location}</td>
                            <td>${resort.description}</td>
                            <td>
                                ${isDisabled ?
                                    `<a href="{{ url('changeresort-status/') }}/${resort.id}" class="btn btn-sm btn-danger">Closed</a>` :
                                    `<a href="{{ url('changeresort-status/') }}/${resort.id}" class="btn btn-sm btn-success">Open</a>`
                                }
                            </td>
                            <td>
                                ${resort.register_status === 1
                                    ? `<span class="text-success">Approved</span>`
                                    : resort.register_status === 2
                                        ? `<span class="text-danger">Rejected</span>`
                                        : `<button class="btn btn-sm btn-success" onclick="updateResortRegisterStatus(${resort.id}, 1)">Approve</button>
                                                           <button class="btn btn-sm btn-danger" onclick="rejectResort(${resort.id})">Reject</button>`
                                }
                            </td>
                            <td>
                                <a href="{{ url('admin/viewResort/') }}/${resort.id}/view" class="btn btn-info btn-sm"><i class="fas fa-eye"></i>&nbsp;View</a>
                                <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('admin/deleteResort/') }}/${resort.id}/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                            </td>
                        </tr>`;

                        resultsContainer.innerHTML += resortHTML;
                    });
                } else {
                    resultsContainer.innerHTML = '<tr><td colspan="8">No Resort Found</td></tr>';
                }
            }

            var initialResorts = @json($resorts->items());
            updateSearchResults(initialResorts);

            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var resortsData = @json($resorts->items());

                if (!Array.isArray(resortsData)) {
                    console.error('Invalid resorts data:', resortsData);
                    return;
                }

                var filteredResorts = resortsData.filter(function(resort) {
                    return resort.name.toLowerCase().includes(searchInputValue);
                });

                updateSearchResults(filteredResorts);
            }
        });

        function updateResortRegisterStatus(resortId, status) {
            fetch(`/admin/updateResortRegisterStatus/${resortId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Resort status updated successfully');
                        location.reload(); // Refresh the page to update the table
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }

        function rejectResort(resortId) {
            var rejectionMessage = prompt("Please enter the reason for rejection:");

            if (rejectionMessage) {
                fetch(`/admin/rejectResort/${resortId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: rejectionMessage
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP error ${response.status}: ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Resort rejected and email sent successfully');
                            location.reload(); // 刷新页面以更新表格
                        } else {
                            alert('Failed to reject resort: ' + (data.message || ''));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred: ' + error.message);
                    });
            }
        }
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateSearchResults(filteredResorts) {
                var resultsContainer = document.getElementById('searchResultsContainer');
                resultsContainer.innerHTML = ''; // Clear previous results

                if (Array.isArray(filteredResorts) && filteredResorts.length > 0) {
                    filteredResorts.forEach(function(resort) {
                        var isDisabled = resort.status === 1;

                        var resortHTML = `<tr class="${isDisabled ? 'disabled' : ''}">
                            <td>${resort.id}</td>
                            <td>${resort.name}</td>
                            <td style="position: relative; width: 100px; height: 100px; overflow: hidden; text-align: center;">
                                ${resort.images && resort.images.length > 0 ?
                                `<div id="carousel${resort.id}" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" style="width: 100%; height: 100%;">
                                        ${resort.images.map((image, index) => `
                                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                            <img src="{{ asset('images/') }}/${image.image}" class="d-block w-100" alt="Resort Image"
                                                 style="max-width: 100%; max-height: 100%; display: block; margin: auto;"
                                                 onclick="show360Image('{{ asset('images/') }}/${image.image}')">
                                        </div>
                                        `).join('')}
                                    </div>
                                    <a class="carousel-control-prev" href="#carousel${resort.id}" role="button" data-slide="prev" style="width: 20px;">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel${resort.id}" role="button" data-slide="next" style="width: 20px;">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>` :
                                `<span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">No Image</span>`}
                            </td>
                            <td>${resort.price}</td>
                            <td>${resort.location}</td>
                            <td>${resort.description}</td>
                            <td>
                                ${isDisabled ?
                                    `<a href="{{ url('changeresort-status/') }}/${resort.id}" class="btn btn-sm btn-danger">Closed</a>` :
                                    `<a href="{{ url('changeresort-status/') }}/${resort.id}" class="btn btn-sm btn-success">Open</a>`
                                }
                            </td>
                            <td>
                                ${resort.register_status === 1
                                    ? `<span class="text-success">Approved</span>`
                                    : resort.register_status === 2
                                        ? `<span class="text-danger">Rejected</span>`
                                        : `<button class="btn btn-sm btn-success" onclick="updateResortRegisterStatus(${resort.id}, 1)">Approve</button>
                                                        <button class="btn btn-sm btn-danger" onclick="rejectResort(${resort.id})">Reject</button>`
                                }
                            </td>
                            <td>
                                <a href="{{ url('admin/viewResort/') }}/${resort.id}/view" class="btn btn-info btn-sm"><i class="fas fa-eye"></i>&nbsp;View</a>
                                <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('admin/deleteResort/') }}/${resort.id}/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                            </td>
                        </tr>`;

                        resultsContainer.innerHTML += resortHTML;
                    });
                } else {
                    resultsContainer.innerHTML = '<tr><td colspan="8">No Resort Found</td></tr>';
                }
            }

            var initialResorts = @json($resorts->items());
            updateSearchResults(initialResorts);

            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var resortsData = @json($resorts->items());

                if (!Array.isArray(resortsData)) {
                    console.error('Invalid resorts data:', resortsData);
                    return;
                }

                var filteredResorts = resortsData.filter(function(resort) {
                    return resort.name.toLowerCase().includes(searchInputValue);
                });

                updateSearchResults(filteredResorts);
            }
        });

        function updateResortRegisterStatus(resortId, status) {
            fetch(`/admin/updateResortRegisterStatus/${resortId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Resort status updated successfully');
                        location.reload(); // Refresh the page to update the table
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }

        function rejectResort(resortId) {
            var rejectionMessage = prompt("Please enter the reason for rejection:");

            if (rejectionMessage) {
                fetch(`/admin/rejectResort/${resortId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: rejectionMessage
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP error ${response.status}: ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Resort rejected and email sent successfully');
                            location.reload(); // 刷新页面以更新表格
                        } else {
                            alert('Failed to reject resort: ' + (data.message || ''));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred: ' + error.message);
                    });
            }
        }

        // 显示360度视图
        function show360Image(imageUrl) {
            var modal = document.createElement('div');
            modal.id = 'pannellumModal';
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            modal.style.zIndex = '1000';
            modal.style.display = 'flex';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';
            modal.innerHTML = `
                <div id="panorama" style="width: 80%; height: 80%;"></div>
                <button onclick="close360View()" style="position: absolute; top: 10px; right: 10px; padding: 10px; background: #fff; border: none; cursor: pointer;">Close</button>
            `;
            document.body.appendChild(modal);

            pannellum.viewer('panorama', {
                type: 'equirectangular',
                panorama: imageUrl,
                autoLoad: true
            });
        }

        function close360View() {
            var modal = document.getElementById('pannellumModal');
            if (modal) {
                modal.remove();
            }
        }
    </script>

@endsection
