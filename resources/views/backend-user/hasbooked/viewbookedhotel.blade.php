@extends('backend-user.newlayout')

@section('newuser-section')
    <title>Booked Hotel Invoice</title>

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

    <div class="invoice">
        <h2>Booked Hotel Detail</h2>
        <div class="details">
            <p>User Name: <span>{{ $bookedhotels->user_name }}</span></p>
            <p>Hotel Name: <span>{{ $bookedhotels->hotel_name }}</span></p>
            <p>Date: <span>{{ \Carbon\Carbon::parse($bookedhotels->booking_date)->format('j F Y (l)') }}</span></p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($bookedhotels->checkin_time)->format('g:i A') }}</span></p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($bookedhotels->checkout_time)->format('g:i A') }}</span></p>
            @if ($bookedhotels->hotel)
                <!-- Check if the hotel relationship exists -->
                <p>Address: <span>{{ $bookedhotels->hotel->address }}</span></p>
                <p>State: <span>{{ $bookedhotels->hotel->state }}</span></p>
                <p>Country: <span>{{ $bookedhotels->hotel->country }}</span></p>
            @endif
        </div>
        <div class="items">
            <table>
                <tr>
                    <th>Room Name</th>
                    <th>Room Type</th>
                    <th>Quantity</th>
                </tr>
                @if ($bookedhotels->room)
                    <!-- Check if room relationship exists -->
                    <tr>
                        <td>{{ $bookedhotels->room->name }}</td>
                        <td>{{ $bookedhotels->room->type }}</td>
                        <td>{{ $bookedhotels->quantity }}</td>
                    </tr>
                @endif
            </table>
        </div>
        @if ($bookedhotels->room)
            <!-- Check if room relationship exists -->
            <div class="total">
                <p style="font-weight:bold">Total Price: ${{ $bookedhotels->room->price }}</p>
            </div>
        @endif

        <div class="total">
            <p style="font-weight:bold">Deposit Fee: $100</p>
        </div>

        <div class="footer">
            <p>Thank you, {{ $bookedhotels->user_name }}
                @if ($bookedhotels->user)
                    ({{ $bookedhotels->user->email }}),
                @endif
                for your purchase! Enjoy the Hotel!
            </p>

            @if ($bookedhotels->hotel)
                <p>If any problem, you can contact phone number ({{ $bookedhotels->hotel->phone }}) or email
                    ({{ $bookedhotels->hotel->email }}), for your purchase! Enjoy the Hotel!</p>
            @endif
        </div>

        <a href="{{ url('/download-bookedhotel-pdf/' . $bookedhotels->id) }}" class="btn btn-info btn-sm"><i
                class="fas fa-file-pdf"></i>&nbsp;Download</a>

    </div>
    
@endsection
