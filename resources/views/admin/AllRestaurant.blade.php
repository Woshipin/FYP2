@extends('admin.layout')

@section('admin-section')
    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Edit Restaurant Model -->
    @foreach ($restaurants as $restaurant)
        <!-- Modal content for each Resort -->
        <div class="modal fade" id="restauranteditModal{{ $restaurant->id }}" tabindex="-1"
            role="dialog"aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal header and form -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Restaurant Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ url('admin/updateRestaurant/' . $restaurant->id) }}" method="POST"
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
                                <label for="image">Restaurant Image </label>
                                <input type="file" class="form-control" name="image"
                                    id="image"placeholder="Enter Resort Image" value="{{ $restaurant->image }}">
                                <span class="text-danger">
                                    @error('image')
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
                                <input type="text" class="form-control" name="description"
                                    id="description"value="{{ $restaurant->description }}">
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
                                        <th class="p-2">Open / Close</th>
                                        <th class="p-2">Register Status</th>
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
                        var isDisabled = restaurant.status === 1;

                        var restaurantHTML = `<tr class="${isDisabled ? 'disabled' : ''}">
                            <td>${restaurant.id}</td>
                            <td>${restaurant.name}</td>
                            <td style="position: relative; width: 100px; height: 100px; overflow: hidden; text-align: center;">
                                ${restaurant.images && restaurant.images.length > 0 ?
                                `<div id="carousel${restaurant.id}" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" style="width: 100%; height: 100%;">
                                        ${restaurant.images.map((image, index) => `
                                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                            <img src="{{ asset('images/') }}/${image.image}" class="d-block w-100" alt="Restaurant Image"
                                                 style="max-width: 100%; max-height: 100%; display: block; margin: auto;"
                                                 onclick="show360Image('{{ asset('images/') }}/${image.image}')">
                                        </div>
                                        `).join('')}
                                    </div>
                                    <a class="carousel-control-prev" href="#carousel${restaurant.id}" role="button" data-slide="prev" style="width: 20px;">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel${restaurant.id}" role="button" data-slide="next" style="width: 20px;">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>` :
                                `<span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">No Image</span>`}
                            </td>
                            <td>${restaurant.date}</td>
                            <td>${restaurant.time}</td>
                            <td>${restaurant.address}</td>
                            <td>${restaurant.description}</td>
                            <td>
                                ${isDisabled ?
                                    `<a href="{{ url('changerestaurant-status/') }}/${restaurant.id}" class="btn btn-sm btn-danger">Closed</a>` :
                                    `<a href="{{ url('changerestaurant-status/') }}/${restaurant.id}" class="btn btn-sm btn-success">Open</a>`
                                }
                            </td>
                            <td>
                                ${restaurant.register_status === 1
                                    ? `<span class="text-success">Approved</span>`
                                    : restaurant.register_status === 2
                                        ? `<span class="text-danger">Rejected</span>`
                                        : `<button class="btn btn-sm btn-success" onclick="updateRestaurantRegisterStatus(${restaurant.id}, 1)">Approve</button>
                                           <button class="btn btn-sm btn-danger" onclick="rejectRestaurant(${restaurant.id})">Reject</button>`
                                }
                            </td>
                            <td>
                                <a href="{{ url('admin/viewRestaurant/') }}/${restaurant.id}/view" class="btn btn-info btn-sm"><i class="fas fa-eye"></i>&nbsp;View</a>
                                <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('admin/deleteRestaurant/') }}/${restaurant.id}/delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                            </td>
                        </tr>`;

                        resultsContainer.innerHTML += restaurantHTML;
                    });
                } else {
                    resultsContainer.innerHTML = '<tr><td colspan="8">No Restaurant Found</td></tr>';
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

        function updateRestaurantRegisterStatus(restaurantId, status) {
            fetch(`/admin/updateRestaurantRegisterStatus/${restaurantId}`, {
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
                        alert('Restaurant status updated successfully');
                        location.reload(); // Refresh the page to update the table
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }

        function rejectRestaurant(restaurantId) {
            var rejectionMessage = prompt("Please enter the reason for rejection:");

            if (rejectionMessage) {
                fetch(`/admin/rejectRestaurant/${restaurantId}`, {
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
                            alert('Restaurant rejected and email sent successfully');
                            location.reload(); // Refresh the page to update the table
                        } else {
                            alert('Failed to reject restaurant: ' + (data.message || ''));
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
