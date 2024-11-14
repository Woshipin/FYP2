@extends('admin.layout')

@section('admin-section')
    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                                        <th>Hotel ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>Address</th>
                                        <th>Open / Close</th>
                                        <th>Register Status</th>
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

                        var hotelHTML = `<tr class="${isDisabled ? 'disabled' : ''}">
                            <td>${hotel.id}</td>
                            <td>${hotel.name}</td>
                            <td style="position: relative; width: 100px; height: 100px; overflow: hidden; text-align: center;">
                                ${hotel.images && hotel.images.length > 0 ?
                                `<div id="carousel${hotel.id}" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner" style="width: 100%; height: 100%;">
                                                    ${hotel.images.map((image, index) => `
                                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                            <img src="{{ asset('images/') }}/${image.image}" class="d-block w-100" alt="Hotel Image"
                                                 style="max-width: 100%; max-height: 100%; display: block; margin: auto;"
                                                 onclick="show360Image('{{ asset('images/') }}/${image.image}')">
                                        </div>
                                        `).join('')}
                                                </div>
                                                <a class="carousel-control-prev" href="#carousel${hotel.id}" role="button" data-slide="prev" style="width: 20px;">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carousel${hotel.id}" role="button" data-slide="next" style="width: 20px;">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>` :
                                `<span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">No Image</span>`}
                            </td>
                            <td>${hotel.country}</td>
                            <td>${hotel.address}</td>
                            <td>${hotel.description}</td>
                            <td>
                                ${isDisabled ?
                                    `<a href="{{ url('changehotel-status/') }}/${hotel.id}" class="btn btn-sm btn-danger">Closed</a>` :
                                    `<a href="{{ url('changehotel-status/') }}/${hotel.id}" class="btn btn-sm btn-success">Open</a>`
                                }
                            </td>
                            <td>
                                ${hotel.register_status === 1
                                    ? `<span class="text-success">Approved</span>`
                                    : hotel.register_status === 2
                                        ? `<span class="text-danger">Rejected</span>`
                                        : `<button class="btn btn-sm btn-success" onclick="updateHotelRegisterStatus(${hotel.id}, 1)">Approve</button>
                                                        <button class="btn btn-sm btn-danger" onclick="rejectHotel(${hotel.id})">Reject</button>`
                                }
                            </td>
                            <td>
                                <a href="{{ url('admin/viewHotel/') }}/${hotel.id}/view" class="btn btn-info btn-sm"><i class="fas fa-eye"></i>&nbsp;View</a>
                                <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('admin/deleteHotel/') }}/${hotel.id}/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                            </td>
                        </tr>`;

                        resultsContainer.innerHTML += hotelHTML;
                    });
                } else {
                    resultsContainer.innerHTML = '<tr><td colspan="8">No Hotel Found</td></tr>';
                }
            }

            var initialHotels = @json($hotels->items());
            updateSearchResults(initialHotels);

            document.getElementById('searchInput').addEventListener('input', function() {
                performSearch();
            });

            function performSearch() {
                var searchInputValue = document.getElementById('searchInput').value.toLowerCase();
                var hotelsData = @json($hotels->items());

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

        function updateHotelRegisterStatus(hotelId, status) {
            fetch(`/admin/updateHotelRegisterStatus/${hotelId}`, {
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
                        alert('Hotel status updated successfully');
                        location.reload(); // Refresh the page to update the table
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }

        function rejectHotel(hotelId) {
            var rejectionMessage = prompt("Please enter the reason for rejection:");

            if (rejectionMessage) {
                fetch(`/admin/rejectHotel/${hotelId}`, {
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
                            alert('Hotel rejected and email sent successfully');
                            location.reload(); // Refresh the page to update the table
                        } else {
                            alert('Failed to reject hotel: ' + (data.message || ''));
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
