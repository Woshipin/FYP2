@extends('backend-user.newlayout')

@section('newuser-section')

<style>
    @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;600&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: "Open Sans", sans-serif;
        color: #333;
        background-color: #f9f9f9;
    }

    .breadcumb-area {
        background-image: url(booked/bg-img/breadcumb3.jpg);
        background-size: cover;
        background-position: center;
        height: 250px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        position: relative;
    }

    .breadcumb-area::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }

    .bradcumbContent {
        position: relative;
        z-index: 1;
        max-width: 800px;
        padding: 20px;
    }

    .bradcumbContent h2 {
        font-family: "Montserrat", sans-serif;
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .bradcumbContent p {
        font-size: 20px;
        opacity: 0.9;
    }

    .ticket-section {
        margin: 60px auto;
        max-width: 1200px;
        display: grid;
        gap: 30px;
        padding: 0 20px;
    }

    .ticket {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        display: flex;
    }

    .ticket:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .left {
        flex: 1.5;
        display: flex;
        flex-direction: column;
    }

    .right {
        flex: 1;
        background-color: #f8f9fa;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-left: 1px solid #eee;
    }

    .ticket-image {
        height: 300px;
        width: 100%;
        object-fit: cover;
    }

    .ticket-info {
        padding: 25px;
    }

    .ticket-date {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 20px;
    }

    .month-day {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
    }

    .ticket-show-name {
        margin-bottom: 20px;
    }

    .ticket-show-name h5 {
        font-family: "Montserrat", sans-serif;
        font-size: 20px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .ticket-show-name p {
        font-size: 18px;
        color: #3498db;
        font-weight: 600;
    }

    .ticket-details {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .detail-item {
        text-align: center;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .detail-item span {
        display: block;
    }

    .detail-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
    }

    .right-info-container {
        text-align: center;
    }

    .ticket-time {
        margin-bottom: 25px;
    }

    .time-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        padding: 10px;
        background: white;
        border-radius: 8px;
    }

    .time-label {
        font-weight: 500;
        color: #666;
    }

    .time-value {
        font-weight: 600;
        color: #2c3e50;
    }

    .ticket-barcode {
        margin: 25px 0;
        display: flex;
        justify-content: center;
    }

    .ticket-barcode img {
        width: 120px;
        height: 120px;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
    }

    .navy-blue-button {
        display: inline-block;
        padding: 12px 24px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        border: none;
        border-radius: 8px;
        color: #fff;
        background: linear-gradient(to right, #3498db, #2c3e50);
        transition: all 0.3s ease;
        width: 100%;
    }

    .navy-blue-button:hover {
        background: linear-gradient(to right, #2c3e50, #3498db);
        transform: translateY(-2px);
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
        margin-top: 15px;
    }

    .status-checked-out {
        background-color: #e9ecef;
        color: #495057;
    }

    .status-cancelled {
        background-color: #fee2e2;
        color: #dc2626;
    }

    @media (max-width: 768px) {
        .ticket {
            flex-direction: column;
        }

        .right {
            border-left: none;
            border-top: 1px solid #eee;
        }

        .ticket-details {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- Breadcumb Area -->
<section class="breadcumb-area bg-img bg-overlay">
    <div class="bradcumbContent">
        <p>See what you have purchased</p>
        <h2>Hotel Booked History</h2>
    </div>
</section>

<!-- Ticket Section -->
<section class="ticket-section">
    @if ($mybookeds->isEmpty())
        <p style="text-align: center; font-size: 24px; color: #666;">No Hotel Found</p>
    @else
        @foreach ($mybookeds as $hotel)
            <div class="ticket">
                <div class="left">
                    <div class="image">
                        @if ($hotel->hotel->images->count() > 0)
                            <img src="{{ asset('images/' . $hotel->hotel->images->first()->image) }}"
                                class="ticket-image" alt="Hotel Image">
                        @else
                            <div class="ticket-image"
                                style="background-color: #eee; display: flex; align-items: center; justify-content: center;">
                                <span style="color: #999;">No Image Available</span>
                            </div>
                        @endif
                    </div>
                    <div class="ticket-info">
                        <div class="ticket-date">
                            <span class="month-day">{{ \Carbon\Carbon::parse($hotel->booking_date)->format('Y') }}</span>
                            <span class="month-day">{{ \Carbon\Carbon::parse($hotel->booking_date)->format('F j') }}</span>
                            <span class="month-day">{{ \Carbon\Carbon::parse($hotel->booking_date)->format('l') }}</span>
                        </div>
                        <div class="ticket-show-name">
                            <h5>{{ $hotel->hotel_name }}</h5>
                            <p>Room Number: {{ $hotel->room->id }}</p>
                            <p>Room Type: {{ $hotel->room->type }}</p>
                        </div>
                        <div class="ticket-details">
                            <div class="detail-item">
                                <span class="detail-label">Gender</span>
                                <span class="detail-value">{{ $hotel->gender }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Person</span>
                                <span class="detail-value">{{ $hotel->quantity }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Booking Days</span>
                                <span class="detail-value">{{ $hotel->booking_days }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="right-info-container">
                        <div class="ticket-time">
                            <div class="time-item">
                                <span class="time-label">Check-In Date:</span>
                                <span class="time-value">{{ \Carbon\Carbon::parse($hotel->checkin_date)->format('j F Y') }}</span>
                            </div>
                            <div class="time-item">
                                <span class="time-label">Check-Out Date:</span>
                                <span class="time-value">{{ \Carbon\Carbon::parse($hotel->checkout_date)->format('j F Y') }}</span>
                            </div>
                            <div class="time-item">
                                <span class="time-label">Check-In Time:</span>
                                <span class="time-value">{{ \Carbon\Carbon::parse($hotel->checkin_time)->format('g:i A') }}</span>
                            </div>
                            <div class="time-item">
                                <span class="time-label">Check-Out Time:</span>
                                <span class="time-value">{{ \Carbon\Carbon::parse($hotel->checkout_time)->format('g:i A') }}</span>
                            </div>
                        </div>
                        <div class="ticket-barcode">
                            <?php
                            $ipAddress = '192.168.50.154';
                            $url = 'http://' . $ipAddress . ':8000' . route('verify.hotel', ['hotelId' => $hotel->id], false) . '?' . http_build_query([
                                'user_id' => $hotel->user_id,
                                'hotel_id' => $hotel->hotel_id,
                                'checkin_date' => $hotel->checkin_date,
                                'checkout_date' => $hotel->checkout_date,
                                'checkin_time' => $hotel->checkin_time,
                                'checkout_time' => $hotel->checkout_time,
                                'total_price' => $hotel->total_price,
                                'verify_code' => $hotel->verify_code,
                            ]);
                            ?>
                            {!! QrCode::size(120)->generate($url) !!}
                        </div>
                        <div class="action-buttons">
                            <a href="{{ url('viewBookedHotel/' . $hotel->id) . '/view' }}" target="_blank"
                                class="navy-blue-button">View Detail</a>

                            @if ($hotel->payment_status == 0)
                                <form action="{{ route('booking.cancel.hotel', $hotel->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to Cancel this Booking?')"
                                        class="navy-blue-button" style="background: linear-gradient(to right, #dc2626, #991b1b);">
                                        Cancel Booking
                                    </button>
                                </form>
                            @elseif($hotel->payment_status == 1)
                                <form action="{{ route('booking.checkout.hotel', $hotel->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to check out this hotel?')"
                                        class="navy-blue-button">Check Out</button>
                                </form>
                            @elseif($hotel->payment_status == 2)
                                <span class="status-badge status-checked-out">Checked Out</span>
                            @elseif($hotel->payment_status == 3)
                                <span class="status-badge status-cancelled">Booking Cancelled</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</section>

{{-- Toastify CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

{{-- Toastify JS --}}
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    @if (Session::has('success'))
        Toastify({
            text: "{{ Session::get('success') }}",
            duration: 10000,
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)"
            }
        }).showToast();
    @elseif (Session::has('fail'))
        Toastify({
            text: "{{ Session::get('fail') }}",
            duration: 10000,
            style: {
                background: "linear-gradient(to right, #b90000, #c99396)"
            }
        }).showToast();
    @endif

    @if (Session::has('error'))
        Toastify({
            text: "{{ Session::get('error') }}",
            duration: 10000,
            style: {
                background: "linear-gradient(to right, #b90000, #c99396)"
            }
        }).showToast();
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            Toastify({
                text: "{{ $error }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #b90000, #c99396)"
                }
            }).showToast();
        @endforeach
    @endif
</script>

@endsection
