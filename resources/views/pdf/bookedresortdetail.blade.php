<!DOCTYPE html>
<html>

<head>
    <title>Booked Resort Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .invoice {
            border: 1px solid #ddd;
            padding: 20px;
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .invoice h2 {
            text-align: center;
            color: #333;
        }

        .invoice .details {
            margin-top: 20px;
        }

        .invoice .details p {
            margin: 5px 0;
            color: #555;
            font-weight: bold
        }

        .invoice .details span {
            font-weight: normal;
        }

        .invoice .items {
            margin-top: 20px;
        }

        .invoice .items table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .invoice .items th,
        .invoice .items td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .invoice .items th {
            background-color: #f2f2f2;
        }

        .invoice .total {
            margin-top: 20px;
            text-align: right;
        }

        .invoice .total p {
            color: #555;
            font-size: 18px;
            margin: 5px 0;
        }

        .invoice .footer {
            margin-top: 20px;
            text-align: center;
            color: #888;
        }
    </style>
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

        <div class="total">
            <p style="font-weight:bold">Deposit Fee: $100</p>
        </div>

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
</body>

</html>
