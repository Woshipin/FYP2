<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Booked Resort Invoice</title>
</head>

<body>
    <div class="invoice">
        <h2>Booked Resort Detail</h2>
        <div class="details">
            <p>User Name: <span>{{ $bookedresorts->user_name }}</span></p>
            <p>Hotel Name: <span>{{ $bookedresorts->resort_name }}</span></p>
            <p>Date: <span>{{ \Carbon\Carbon::parse($bookedresorts->booking_date)->format('j F Y (l)') }}</span></p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($bookedresorts->checkin_time)->format('g:i A') }}</span>
            </p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($bookedresorts->checkout_time)->format('g:i A') }}</span>
            </p>
            @if ($bookedresorts->resort)
                <!-- Check if the hotel relationship exists -->
                <p>Resort Type: <span>{{ $bookedresorts->resort->type }}</span></p>
                <p>Address: <span>{{ $bookedresorts->resort->location }}</span></p>
                <p>State: <span>{{ $bookedresorts->resort->state }}</span></p>
                <p>Country: <span>{{ $bookedresorts->resort->country }}</span></p>
            @endif
        </div>
        <div class="items">
            <table>
                <tr>
                    <th>Resort Name</th>
                    <th>Resort Type</th>
                    <th>Quantity</th>
                </tr>
                <!-- Check if room relationship exists -->
                <tr>
                    @if ($bookedresorts->resort)
                        <td>{{ $bookedresorts->resort->name }}</td>
                        <td>{{ $bookedresorts->resort->type }}</td>
                    @endif
                    <td>{{ $bookedresorts->quantity }}</td>
                </tr>
            </table>
        </div>
        @if ($bookedresorts->resort)
            <!-- Check if room relationship exists -->
            <div class="total">
                <p style="font-weight:bold">Total Price: ${{ $bookedresorts->resort->price }}</p>
            </div>
        @endif

        <div class="footer">
            <p>Thank you, {{ $bookedresorts->user_name }}
                @if ($bookedresorts->user)
                    ({{ $bookedresorts->user->email }}),
                @endif
                for your purchase! Enjoy the Hotel!
            </p>

            @if ($bookedresorts->resort)
                <p>If any problem, you can contact phone number ({{ $bookedresorts->resort->phone }}) or email
                    ({{ $bookedresorts->resort->email }}), for your purchase! Enjoy the Hotel!</p>
            @endif
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
