<!DOCTYPE html>
<html>

<head>
    <title>Booked Resort Email</title>
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
            <p>Customer Name : <span>{{ $user_name }} </span></p>
            <p>Customer Email: <span>{{ $email }}</span></p>
            <p>Booking_Days: <span>{{ $booking_days }} days</span></p>
            <p>Check-In-Date: <span>{{ \Carbon\Carbon::parse($check_in_date)->format('j F Y (l)') }}</span></p>
            <p>Check-Out-Date: <span>{{ \Carbon\Carbon::parse($check_out_date)->format('j F Y (l)') }}</span></p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($check_in_time)->format('g:i A') }}</span></p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($check_out_time)->format('g:i A') }}</span></p>
        </div>

        <div class="items">
            <table>
                <tr>
                    <th>Resort Type</th>
                    <th>Resort Name</th>
                    <th>Quantity</th>
                </tr>
                <tr>
                    <td>{{ $resort_type }}</td>
                    <td>{{ $resort_name }}</td>
                    <td>{{ $quantity }}</td>
                </tr>
            </table>
        </div>

        <div class="total">
            <p style="font-weight:bold">Deposit Fee: RM100</p>
        </div>

        <div class="total">
            <p style="font-weight:bold">Room 1 day Price: RM{{ $resort_price }}</p>
        </div>

        <div class="total">
            <p style="font-weight:bold">Total_Price: RM{{ $total_price }}</p>
        </div>

        <div class="footer">
            <p>Thank you, {{ $user_name }} for your purchase! Enjoy the Resort!</p>

            <p>If any problem, you can contact phone number ({{ $resort_phone }}) or email
                ({{ $resort_email }}), for your purchase! Enjoy the Resort!</p>
        </div>

    </div>
</body>

</html>
