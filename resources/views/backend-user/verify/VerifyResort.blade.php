@extends('backend-user.newlayout')

@section('newuser-section')

<title>Booked Resort Verification</title>

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

@if (isset($VerifyResort))
    <div class="invoice">
        <h2>Booked Resort Detail</h2>
        <div class="details">
            <p>User Name: <span>{{ $VerifyResort->user_name }}</span></p>
            <p>Resort Name: <span>{{ $VerifyResort->resort_name }}</span></p>
            <p>Date: <span>{{ \Carbon\Carbon::parse($VerifyResort->booking_date)->format('j F Y (l)') }}</span></p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($VerifyResort->checkin_time)->format('g:i A') }}</span>
            </p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($VerifyResort->checkout_time)->format('g:i A') }}</span>
            </p>
            @if ($VerifyResort->resort)
                <!-- Check if the resort relationship exists -->
                <p>Resort Type: <span>{{ $VerifyResort->resort->type }}</span></p>
                <p>Address: <span>{{ $VerifyResort->resort->location }}</span></p>
                <p>State: <span>{{ $VerifyResort->resort->state }}</span></p>
                <p>Country: <span>{{ $VerifyResort->resort->country }}</span></p>
            @endif
        </div>
        <div class="items">
            <table>
                <tr>
                    <th>Resort Name</th>
                    <th>Resort Type</th>
                    <th>Quantity People</th>
                </tr>
                <!-- Check if resort relationship exists -->
                <tr>
                    @if ($VerifyResort->resort)
                        <td>{{ $VerifyResort->resort->name }}</td>
                        <td>{{ $VerifyResort->resort->type }}</td>
                    @endif
                    <td>{{ $VerifyResort->quantity }}</td>
                </tr>
            </table>
        </div>

        <div class="total">
            <p style="font-weight:bold">Deposit Fee: RM {{ $VerifyResort->deposit_price }}/p>
        </div>

        @if ($VerifyResort->resort)
            <!-- Check if resort relationship exists -->
            <div class="total">
                <p style="font-weight:bold">Total Price: RM {{ $VerifyResort->total_price }}</p>
            </div>
        @endif

        <div class="footer">
            <p>Thank you, {{ $VerifyResort->user_name }}
                @if ($VerifyResort->user)
                    ({{ $VerifyResort->user->email }}),
                @endif
                for your purchase! Enjoy the Hotel!
            </p>

            @if ($VerifyResort->resort)
                <p>If any problem, you can contact phone number ({{ $VerifyResort->resort->phone }}) or email
                    ({{ $VerifyResort->resort->email }}), for your purchase! Enjoy the Hotel!</p>
            @endif
        </div>

        <a href="{{ url('/download-bookedresort-pdf/' . $VerifyResort->id) }}" class="btn btn-info btn-sm"><i
            class="fas fa-file-pdf"></i>&nbsp;Download</a>

        <a href="{{ url('mybookingsresort') }}" class="btn btn-success btn-sm"><i
            class="fas fa-file-pdf"></i>&nbsp;Continue</a>

    </div>
@else
    <p>No valid resort found for the scanned QR code.</p>
@endif

<script>
    // Check if the verification is successful and show an alert
    @if (isset($VerifyResort))
        alert('Verification Resort complete!');
    @endif
</script>

@endsection
