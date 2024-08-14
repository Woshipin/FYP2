@extends('backend-user.newlayout')

@section('newuser-section')

<title>Booked Hotel Verification</title>

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

@if (isset($VerifyHotel))
    <div class="invoice">
        <h2>Booked Hotel Detail</h2>
        <div class="details">
            <p>User Name: <span>{{ $VerifyHotel->user_name }}</span></p>
            <p>Hotel Name: <span>{{ $VerifyHotel->hotel_name }}</span></p>
            <p>Date: <span>{{ \Carbon\Carbon::parse($VerifyHotel->booking_date)->format('j F Y (l)') }}</span></p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($VerifyHotel->checkin_time)->format('g:i A') }}</span></p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($VerifyHotel->checkout_time)->format('g:i A') }}</span>
            </p>
            @if ($VerifyHotel->hotel)
                <!-- Check if the hotel relationship exists -->
                <p>Address: <span>{{ $VerifyHotel->hotel->address }}</span></p>
                <p>State: <span>{{ $VerifyHotel->hotel->state }}</span></p>
                <p>Country: <span>{{ $VerifyHotel->hotel->country }}</span></p>
            @endif
        </div>
        <div class="items">
            <table>
                <tr>
                    <th>Room Name</th>
                    <th>Room Type</th>
                    <th>Quantity</th>
                </tr>
                @if ($VerifyHotel->room)
                    <!-- Check if room relationship exists -->
                    <tr>
                        <td>{{ $VerifyHotel->room->name }}</td>
                        <td>{{ $VerifyHotel->room->type }}</td>
                        <td>{{ $VerifyHotel->quantity }}</td>
                    </tr>
                @endif
            </table>
        </div>

        <div class="total">
            <p style="font-weight:bold">Deposit Fee: RM {{ $VerifyHotel->deposit_price }}</p>
        </div>

        @if ($VerifyHotel->room)
            <!-- Check if room relationship exists -->
            <div class="total">
                <p style="font-weight:bold">Room Price: RM {{ $VerifyHotel->room->price }}</p>
            </div>
        @endif

        <div class="total">
            <p style="font-weight:bold">Total Room Price: RM {{ $VerifyHotel->total_price }}</p>
        </div>

        <div class="footer">
            <p>Thank you, {{ $VerifyHotel->user_name }}
                @if ($VerifyHotel->user)
                    ({{ $VerifyHotel->user->email }}),
                @endif
                for your purchase! Enjoy the Hotel!
            </p>

            @if ($VerifyHotel->hotel)
                <p>If any problem, you can contact phone number ({{ $VerifyHotel->hotel->phone }}) or email
                    ({{ $VerifyHotel->hotel->email }}), for your purchase! Enjoy the Hotel!</p>
            @endif
        </div>

        <a href="{{ url('/download-bookedhotel-pdf/' . $VerifyHotel->id) }}" class="btn btn-info btn-sm"><i
            class="fas fa-file-pdf"></i>&nbsp;Download</a>

        <a href="{{ url('mybookingshotel') }}" class="btn btn-success btn-sm"><i
            class="fas fa-file-pdf"></i>&nbsp;Continue</a>

    </div>
@else
    <p>No valid hotel found for the scanned QR code.</p>
@endif

<script>
    // Check if the verification is successful and show an alert
    @if (isset($VerifyHotel))
        alert('Verification Hotel complete!');
    @endif
</script>

@endsection
