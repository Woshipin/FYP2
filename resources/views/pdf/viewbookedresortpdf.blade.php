<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    {{-- <div class="container mt-5"> --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
            <caption>List of Booked Resort</caption>
                <thead class="table-primary">
                    <tr>
                        <th class="p-2">User Name</th>
                        <th class="p-2">Resort Name</th>
                        <th class="p-2">Resort Price</th>
                        <th class="p-2">Booking Date</th>
                        <th class="p-2">Booking Check_in Time</th>
                        <th class="p-2">Booking Check_out Time</th>
                        <th class="p-2">User Gender</th>
                        <th class="p-2">User Quantity</th>
                    </tr>
                </thead>
                <tbody class="table-grey">
                    @if(count($resorts) > 0)
                        @foreach($resorts as $resort)
                        <tr>
                            <td>{{ $resort->user_name }}</td>
                            <td>{{ $resort->resort_name }}</td>
                            <td>{{ $resort->resort->price }}</td>
                            <td>{{ \Carbon\Carbon::parse($resort->booking_date)->format('j F Y (l)') }}</td>
                            <td>{{ \Carbon\Carbon::parse($resort->checkin_time)->format('g:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($resort->checkout_time)->format('g:i A') }}</td>
                            <td>{{ $resort->gender }}</td>
                            <td>{{ $resort->quantity }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">No Booked Resorts Found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    {{-- </div> --}}

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
