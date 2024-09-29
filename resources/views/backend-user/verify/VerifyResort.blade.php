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
            <p>Resort Name: <span>{{ $VerifyResort->resort->name }}</span></p>
            <p>Date: <span>{{ \Carbon\Carbon::parse($VerifyResort->booking_date)->format('j F Y (l)') }}</span></p>
            <p>Check-In-Time: <span>{{ \Carbon\Carbon::parse($VerifyResort->checkin_time)->format('g:i A') }}</span></p>
            <p>Check-Out-Time: <span>{{ \Carbon\Carbon::parse($VerifyResort->checkout_time)->format('g:i A') }}</span></p>
            <p>Resort Type: <span>{{ $VerifyResort->resort->type }}</span></p>
            <p>Address: <span>{{ $VerifyResort->resort->location }}</span></p>
            <p>State: <span>{{ $VerifyResort->resort->state }}</span></p>
            <p>Country: <span>{{ $VerifyResort->resort->country }}</span></p>
        </div>
        <div class="items">
            <table>
                <tr>
                    <th>Resort Name</th>
                    <th>Resort Type</th>
                    <th>Quantity People</th>
                </tr>
                <tr>
                    <td>{{ $VerifyResort->resort->name }}</td>
                    <td>{{ $VerifyResort->resort->type }}</td>
                    <td>{{ $VerifyResort->quantity }}</td>
                </tr>
            </table>
        </div>

        <div class="total">
            <p style="font-weight:bold">Deposit Fee: RM {{ $VerifyResort->deposit_price }}</p>
        </div>

        <div class="total">
            <p style="font-weight:bold">Total Price: RM {{ $VerifyResort->total_price }}</p>
        </div>

        <div class="total">
            <p style="font-weight:bold">Digital-Lock-Password: {{ $VerifyResort->resort->digital_lock_password ?? 'Not available' }}</p>
        </div>

        <div class="total">
            <p style="font-weight:bold">Email-Box_Password: {{ $VerifyResort->resort->emailbox_password ?? 'Not available' }}</p>
        </div>
        
        <div class="footer">
            <p>Thank you, {{ $VerifyResort->user_name }}
                @if ($VerifyResort->user)
                    ({{ $VerifyResort->user->email }}),
                @endif
                for your purchase! Enjoy the Hotel!
            </p>

            <p>If any problem, you can contact phone number ({{ $VerifyResort->resort->phone }}) or email
                ({{ $VerifyResort->resort->email }}), for your purchase! Enjoy the Hotel!</p>
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
