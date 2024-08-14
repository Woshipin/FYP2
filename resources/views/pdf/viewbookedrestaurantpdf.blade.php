<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    {{-- <div class="container mt-5"> --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
            <caption>List of Booked Restaurant</caption>
                <thead class="table-primary">
                    <tr>
                        <th class="p-2">User Name</th>
                        <th class="p-2">Restaurant Name</th>
                        <th class="p-2">Booking Table</th>
                        <th class="p-2">Booking Date</th>
                        <th class="p-2">Booking Check_in Time</th>
                        <th class="p-2">Booking Check_out Time</th>
                        <th class="p-2">User Gender</th>
                        <th class="p-2">User Quantity</th>
                    </tr>
                </thead>
                <tbody class="table-grey">
                    @if(count($restaurants) > 0)
                        @foreach($restaurants as $restaurant)
                        <tr>
                            <td>{{ $restaurant->user_name }}</td>
                            <td>{{ $restaurant->restaurant_name }}</td>
                            <td>{{ $restaurant->table_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($restaurant->booking_date)->format('j F Y (l)') }}</td>
                            <td>{{ \Carbon\Carbon::parse($restaurant->checkin_time)->format('g:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($restaurant->checkout_time)->format('g:i A') }}</td>
                            <td>{{ $restaurant->gender }}</td>
                            <td>{{ $restaurant->quantity }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">No Booked Hotel Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    {{-- </div> --}}

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
