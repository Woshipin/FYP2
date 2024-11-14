@extends('admin.layout')

@section('admin-section')

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- CSS --}}
    <style>
        .card-header{
            background: rgb(63,251,239);
            background: radial-gradient(circle, rgba(63,251,239,1) 0%, rgba(70,252,88,1) 100%);
        }
    </style>

    <main>
        <div class="page-header">
            <h1>Dashboard</h1>
            <small>Home / Dashboard</small>
        </div>

        <div class="page-content">
            <div class="analytics">

                {{-- User Count --}}
                <div class="card">
                    <div class="card-head">
                        <h2>{{ App\Models\User::count() }}</h2>
                        <span class="las la-user"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total User </small>
                        <div class="card-indicator">
                            <div class="indicator one" style="width: 60%"></div>
                        </div>
                    </div>
                </div>

                {{-- Admin Count --}}
                <div class="card">
                    <div class="card-head">
                        <h2>{{ App\Models\Admin::count() }}</h2>
                        <span class="las la-user-tie"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total Admin </small>
                        <div class="card-indicator">
                            <div class="indicator one" style="width: 60%"></div>
                        </div>
                    </div>
                </div>

                <br>
                <hr>

                {{-- Restaurant Count --}}
                <div class="card">
                    <div class="card-head">
                        <h2>{{ App\Models\Restaurant::count() }}</h2>
                        <span class="fas fa-utensils"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total Restaurant</small>
                        <div class="card-indicator">
                            <div class="indicator two" style="width: 80%"></div>
                        </div>
                    </div>
                </div>

                {{-- Resort Count --}}
                <div class="card">
                    <div class="card-head">
                        <h2>{{ App\Models\Resort::count() }}</h2>
                        <span class="fas fa-umbrella-beach"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total Resort</small>
                        <div class="card-indicator">
                            <div class="indicator two" style="width: 80%"></div>
                        </div>
                    </div>
                </div>

                {{-- Hotel Count --}}
                <div class="card">
                    <div class="card-head">
                        <h2>{{ App\Models\Hotel::count() }}</h2>
                        <span class="fas fa-hotel"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total Hotel</small>
                        <div class="card-indicator">
                            <div class="indicator two" style="width: 80%"></div>
                        </div>
                    </div>
                </div>

                <br>

                {{-- Restaurant Booked Count --}}
                <div class="card">
                    <div class="card-head">
                        <h2>{{ $totalbookedrestaurant }}</h2>
                        <span class="fas fa-calendar-check"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total Booked Restaurant</small>
                        <div class="card-indicator">
                            <div class="indicator three" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>{{ $todaybookedrestaurant }}</h2>
                        <span class="fas fa-calendar-day"></span>
                    </div>
                    <div class="card-progress">
                        <small>Today Booked Restaurant</small>
                        <div class="card-indicator">
                            <div class="indicator three" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>{{ $thisMonthbookedrestaurant }}</h2>
                        <span class="fas fa-calendar-alt"></span>
                    </div>
                    <div class="card-progress">
                        <small>This Month Booked Restaurant</small>
                        <div class="card-indicator">
                            <div class="indicator three" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>{{ $thisYearbookedrestaurant }}</h2>
                        <span class="fas fa-calendar"></span>
                    </div>
                    <div class="card-progress">
                        <small>This Year Booked Restaurant</small>
                        <div class="card-indicator">
                            <div class="indicator three" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                {{-- Resort Booked Count --}}
                <div class="card">
                    <div class="card-head">
                        <h2>{{ $totalbookedresort }}</h2>
                        <span class="fas fa-calendar-check"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total Booked Resort</small>
                        <div class="card-indicator">
                            <div class="indicator four" style="width: 90%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>{{ $todaybookedresort }}</h2>
                        <span class="fas fa-calendar-day"></span>
                    </div>
                    <div class="card-progress">
                        <small>Today Booked Resort</small>
                        <div class="card-indicator">
                            <div class="indicator four" style="width: 90%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>{{ $thisMonthbookedresort }}</h2>
                        <span class="fas fa-calendar-alt"></span>
                    </div>
                    <div class="card-progress">
                        <small>This Month Booked Resort</small>
                        <div class="card-indicator">
                            <div class="indicator four" style="width: 90%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>{{ $thisYearbookedresort }}</h2>
                        <span class="fas fa-calendar"></span>
                    </div>
                    <div class="card-progress">
                        <small>This Year Booked Resort</small>
                        <div class="card-indicator">
                            <div class="indicator four" style="width: 90%"></div>
                        </div>
                    </div>
                </div>

                {{-- Hotel Booked Count --}}
                <div class="card">
                    <div class="card-head">
                        <h2>{{ $totalbookedrestaurant }}</h2>
                        <span class="fas fa-calendar-check"></span>
                    </div>
                    <div class="card-progress">
                        <small>Total Booked Restaurant</small>
                        <div class="card-indicator">
                            <div class="indicator five" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>{{ $todaybookedhotel }}</h2>
                        <span class="fas fa-calendar-day"></span>
                    </div>
                    <div class="card-progress">
                        <small>Today Booked Restaurant</small>
                        <div class="card-indicator">
                            <div class="indicator five" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>{{ $thisMonthbookedhotel }}</h2>
                        <span class="fas fa-calendar-alt"></span>
                    </div>
                    <div class="card-progress">
                        <small>This Month Booked Restaurant</small>
                        <div class="card-indicator">
                            <div class="indicator five" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">
                        <h2>{{ $thisYearbookedhotel }}</h2>
                        <span class="fas fa-calendar"></span>
                    </div>
                    <div class="card-progress">
                        <small>This Year Booked Restaurant</small>
                        <div class="card-indicator">
                            <div class="indicator five" style="width: 65%"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Begin Page Content -->
            {{-- Area Chart and Pie Chart --}}
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Charts</h1>
                <p class="mb-4">Chart.js is a third party plugin that is used to generate the charts in this theme.
                    The charts below have been customized - for further customization options, please visit the <a
                        target="_blank" href="https://www.chartjs.org/docs/latest/">official Chart.js
                        documentation</a>.</p>

                <!-- Content Row -->
                <div class="row">

                    <div class="col-xl-8 col-lg-7">

                        <!-- Restaurant Area Chart -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Restaurant Area Chart</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myRestaurantAreaChart"></canvas>
                                </div>
                                {{-- {{-- <hr> --}}
                                {{-- Styling for the area chart can be found in the
                                <code>/js/demo/chart-area-demo.js</code> file. --}}
                            </div>
                        </div>

                        <!-- Resort Area Chart -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Resort Area Chart</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myResortAreaChart"></canvas>
                                </div>
                                {{-- {{-- <hr> --}}
                                {{-- Styling for the area chart can be found in the
                                <code>/js/demo/chart-area-demo.js</code> file. --}}
                            </div>
                        </div>

                        <!-- Hotel Area Chart -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Hotel Area Chart</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myHotelAreaChart"></canvas>
                                </div>
                                {{-- {{-- <hr> --}}
                                {{-- Styling for the area chart can be found in the
                                <code>/js/demo/chart-area-demo.js</code> file. --}}
                            </div>
                        </div>

                        <!-- Bar Chart -->
                        {{-- <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-bar">
                                    <canvas id="myBarChart"></canvas>
                                </div>
                                <hr>
                                Styling for the bar chart can be found in the
                                <code>/js/demo/chart-bar-demo.js</code> file.
                            </div>
                        </div> --}}

                    </div>

                    <!-- Donut Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Has Booked Chart</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-pie pt-4">
                                    <canvas id="myPieChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-primary"></i> Restaurant
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-success"></i> Resort
                                    </span>
                                    <span class="mr-2">
                                        <i class="fas fa-circle text-info"></i> Hotel
                                    </span>
                                </div>
                                {{-- <hr>
                                Styling for the donut chart can be found in the
                                <code>/js/demo/chart-pie-demo.js</code> file. --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

            {{-- Control User Table --}}
            <div class="records table-responsive">
                <div class="record-header">
                    <div class="add">
                        <span>Entries</span>
                        <select name="" id="">
                            <option value="">ID</option>
                        </select>
                        <button>Add record</button>
                    </div>

                    <div class="browse">
                        <input type="search" placeholder="Search" class="record-search">
                        <select name="" id="">
                            <option value="">Status</option>
                        </select>
                    </div>
                </div>

                <div>
                    <table width="100%">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th><span class="las la-sort"></span> User Name</th>
                                <th><span class="las la-sort"></span> User Email</th>
                                <th><span class="las la-sort"></span> User Status</th>
                                <th><span class="las la-sort"></span> ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($users) > 0)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <div class="client">
                                                @if ($user->status == 0)
                                                    <a href="{{ url('change-status/' . $user->id) }}"
                                                        class="btn btn-sm btn-success"
                                                        onclick="return confirm('Are you sure you want to change this status?')">Active</a>
                                                @else
                                                    <a href="{{ url('change-status/' . $user->id) }}"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to change this status?')">InActive</a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <span class="lab la-telegram-plane"></span>
                                                <span class="las la-eye"></span>
                                                <span class="las la-ellipsis-v"></span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9">No Meetings Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    {{-- Chart Js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    {{-- All Booked Area Chart --}}
    {{-- Restaurant Area Chart --}}
    <script type="text/javascript">
        var _restaurantlabels = {!! json_encode($restaurantLabels) !!};
        var _restaurantcounts = {!! json_encode($restaurantPopularCounts) !!};
    </script>

    {{-- Resort Area Chart --}}
    <script type="text/javascript">
        var _resortlabels = {!! json_encode($resortLabels) !!};
        var _resortcounts = {!! json_encode($resortPopularCounts) !!};
    </script>

    {{-- Hotel Area Chart --}}
    <script type="text/javascript">
        var _hotellabels = {!! json_encode($hotelLabels) !!};
        var _hotelcounts = {!! json_encode($hotelPopularCounts) !!};
    </script>

    {{-- All Booked Pie Chart --}}
    <script type="text/javascript">
        var _labels = {!! json_encode($labels) !!};
        var _data = {!! json_encode($data) !!};
    </script>

    <!-- Page level plugins -->
    <script src="{{ asset('charts/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('charts/demo/admin/restaurantchart-area-demo.js') }}"></script>
    <script src="{{ asset('charts/demo/admin/resortchart-area-demo.js') }}"></script>
    <script src="{{ asset('charts/demo/admin/hotelchart-area-demo.js') }}"></script>
    <script src="{{ asset('charts/demo/admin/chart-pie-demo.js') }}"></script>
    <script src="{{ asset('charts/demo/chart-bar-demo.js') }}"></script>

    {{-- Toastr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    {{-- Toastr Alert JS --}}
    <script>
        @if (Session::has('success'))
            Toastify({
                text: "{{ Session::get('success') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)"
                }
            }).showToast();
        @elseif (Session::has('fail'))
            Toastify({
                text: "{{ Session::get('fail') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #b90000, #c99396)"
                }
            }).showToast();
        @endif

        @if (Session::has('error'))
            Toastify({
                text: "{{ Session::get('error') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #b90000, #c99396)"
                }
            }).showToast();
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toastify({
                    text: "{{ $error }}",
                    duration: 10000,
                    style: {
                        background: "linear-gradient(to right, #b90000, #c99396)"
                    }
                }).showToast();
            @endforeach
        @endif
    </script>

@endsection
