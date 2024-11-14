<!DOCTYPE html>
<html>

<head>
    <title>Booked Restaurant Verification</title>

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

<body>

    @if (isset($VerifyRestaurant))
        <div class="invoice">
            <h2>Booked Restaurant Detail</h2>
            <div class="details">
                <p>User Name: <span>{{ $VerifyRestaurant->user_name }}</span></p>
                <p>Restaurant Name: <span>{{ $VerifyRestaurant->restaurant_name }}</span></p>
                <p>Booking Date:
                    <span>{{ \Carbon\Carbon::parse($VerifyRestaurant->booking_date)->format('j F Y (l)') }}</span>
                </p>
                <p>Check-In-Time:
                    <span>{{ \Carbon\Carbon::parse($VerifyRestaurant->checkin_time)->format('g:i A') }}</span>
                </p>
                <p>Check-In-Time:
                    <span>{{ \Carbon\Carbon::parse($VerifyRestaurant->checkout_time)->format('g:i A') }}</span>
                </p>
                @if ($VerifyRestaurant->restaurant)
                    <!-- Check if the hotel relationship exists -->
                    <p>Address: <span>{{ $VerifyRestaurant->restaurant->address }}</span></p>
                    <p>State: <span>{{ $VerifyRestaurant->restaurant->state }}</span></p>
                    <p>Country: <span>{{ $VerifyRestaurant->restaurant->country }}</span></p>
                @endif
            </div>
            <div class="items">
                <table>
                    <tr>
                        <th>Restaurant Name</th>
                        <th>Restaurant Quantity</th>
                        <th>Booking Date</th>
                        <th>Check-In-Time:</th>
                        <th>Check-In-Time:</th>
                        <th>Table Type</th>
                    </tr>
                    <!-- Check if room relationship exists -->
                    <tr>
                        <td>{{ $VerifyRestaurant->restaurant_name }}</td>
                        <td>{{ $VerifyRestaurant->quantity }}</td>
                        <td>{{ \Carbon\Carbon::parse($VerifyRestaurant->booking_date)->format('j F Y (l)') }}</td>
                        <td>{{ \Carbon\Carbon::parse($VerifyRestaurant->checkin_time)->format('g:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($VerifyRestaurant->checkout_time)->format('g:i A') }}</td>
                        @if ($VerifyRestaurant->table)
                            <td>{{ $VerifyRestaurant->table->title }}</td>
                        @endif
                    </tr>
                </table>
            </div>

            <div class="total">
                <p style="font-weight:bold">Deposit Fee: RM {{ $VerifyRestaurant->deposit_price }}</p>
            </div>

            <div class="footer">
                <p>Thank you, {{ $VerifyRestaurant->user_name }}
                    @if ($VerifyRestaurant->user)
                        ({{ $VerifyRestaurant->user->email }}),
                    @endif
                    for your purchase! Enjoy the Hotel!
                </p>

                @if ($VerifyRestaurant->restaurant)
                    <p>If any problem, you can contact phone number ({{ $VerifyRestaurant->restaurant->phone }}) or
                        email
                        ({{ $VerifyRestaurant->restaurant->email }}), for your purchase! Enjoy the Restaurant!</p>
                @endif
            </div>

            <a href="{{ url('/download-bookedrestaurant-pdf/' . $VerifyRestaurant->id) }}" class="btn btn-info btn-sm"><i
                    class="fas fa-file-pdf"></i>&nbsp;Download</a>

            <a href="{{ url('mybookingsrestaurant') }}" class="btn btn-success btn-sm"><i
                    class="fas fa-file-pdf"></i>&nbsp;Continue</a>

        </div>
    @else
        <p>No valid restaurant found for the scanned QR code.</p>
    @endif

    <script>
        // Check if the verification is successful and show an alert
        @if (isset($bookedrestaurants))
            alert('Verification Restaurant complete!');
        @endif
    </script>

</body>

</html>
