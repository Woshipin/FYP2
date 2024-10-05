@extends('backend-user.newlayout')

@section('newuser-section')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- BookingStatus Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // 启用Pusher日志记录 - 在生产中不要包括这个
        Pusher.logToConsole = true;

        var pusher = new Pusher('66e2c17903cc96af1475', {
            cluster: 'ap1'
        });

        var audio = new Audio('/sound/notification.mp3');

        var channel = pusher.subscribe('bookingstatus');
        channel.bind('booking-status', function() {
            // 在这里处理实时更新
            audio.play(); // 播放通知声音
            // 您可以在这里添加代码来更新UI或获取新数据
            // 例如，您可能希望重新加载页面或通过AJAX获取更新的数据
            location.reload(); // 重新加载页面以进行演示
        });
    </script>

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

    <!-- Show All Restaurant -->
    <div class="container">

        {{-- <div id="map" style="height: 400px;"></div><br> --}}

        <div class="row">
            <div class="col-12">

                {{-- Search Has Booked Restaurant Function --}}
                <form action="{{ route('hasrestaurantSearch') }}" method="GET"
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-white small m-2" name="user_name"
                            placeholder="User Name" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="restaurant_name"
                            placeholder="Restaurant Name" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="date" class="form-control bg-white small m-2" name="booking_date"
                            placeholder="booking_date" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="time" class="form-control bg-white small m-2" name="check_in_time"
                            placeholder="check_in_time" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="time" class="form-control bg-white small m-2" name="check_out_time"
                            placeholder="check_out_time" aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary pb-2"><i class="fas fa-search fa-sm"></i></button>
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

                    <div class="row">
                        <div class="col-2">
                            <form action="{{ route('viewrestaurant-pdf') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info m-1">View In PDF</button>
                            </form>
                        </div>
                        <div class="col" style="margin-left: -60px">
                            <form action="{{ route('downloadbookedrestaurant-pdf') }}" method="POST" target="__blank">
                                @csrf
                                <button type="submit" class="btn btn-info m-1">Download PDF</button>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <!-- Your table code here -->
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                            {{-- Button to delete all selected items --}}
                            <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecord">Delete All
                                Selected Booked Restaurants</button>

                            <a href="{{ url('export-bookedRestaurant') }}"><button type="button"
                                    class="btn btn-primary m-1">Export Booked Restaurants</button></a>

                            <thead class="table-dark">
                                <tr>
                                    <th><input type="checkbox" name="" id="select_all_ids" onclick="checkAll(this)">
                                    </th>
                                    <th class="p-2">User Name</th>
                                    <th class="p-2">Restaurant Name</th>
                                    <th class="p-2">Booking Table</th>
                                    <th class="p-2">Booking Date</th>
                                    <th class="p-2">Booking Check_in Time</th>
                                    <th class="p-2">Booking Check_out Time</th>
                                    <th class="p-2">User Gender</th>
                                    <th class="p-2">User Quantity</th>
                                    <th class="p-2">Payment Status</th>
                                    <th class="p-2">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($restaurantbookeds !== null && count($restaurantbookeds) > 0)
                                    @foreach ($restaurantbookeds as $restaurant)
                                        <tr>
                                            <td><input type="checkbox" name="ids" class="checkbox_ids" id=""
                                                    value="{{ $restaurant->id }}"></td>
                                            <td>{{ $restaurant->user_name }}</td>
                                            <td>{{ $restaurant->restaurant_name }}</td>
                                            <td>{{ $restaurant->table_id }}</td>
                                            <td>{{ \Carbon\Carbon::parse($restaurant->booking_date)->format('j F Y (l)') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($restaurant->checkin_time)->format('g:i A') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($restaurant->checkout_time)->format('g:i A') }}
                                            </td>
                                            <td>{{ $restaurant->gender }}</td>
                                            <td>{{ $restaurant->quantity }}</td>
                                            <td>
                                                @if ($restaurant->payment_status == 0)
                                                    <span class="badge badge-primary" style="font-size:15px">Paid, Pending Check-in</span>
                                                @elseif ($restaurant->payment_status == 1)
                                                    <span class="badge badge-success" style="font-size:15px">Checked In</span>
                                                @elseif ($restaurant->payment_status == 2)
                                                    <span class="badge badge-secondary" style="font-size:15px">Checked Out</span>
                                                @elseif ($restaurant->payment_status == 3)
                                                    <span class="badge badge-secondary" style="font-size:15px">User cancelled the Booking</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('viewBookedRestaurant/' . $restaurant->id) . '/view' }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i>&nbsp;View
                                                    Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9">No Restaurant Has Booked</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- </form> --}}

                    <!-- Pagination links -->
                    {{ $restaurantbookeds->links() }}
                </div>
            </div>
        </div>
    </div>
    
    {{-- New Delete Selected All Restaurant Has Booked --}}
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

@endsection
