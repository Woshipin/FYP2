@extends('backend-user.newlayout')

@section('newuser-section')

    <!-- Ticket Card -->
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
            color: white;
            /* 在 hover 时文字变成黑色 */
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

    <section class="ticket-section">
        @if ($mybookeds->isEmpty())
            <p style="text-align: center; font-size: 24px; color: #666;">No Resort Found</p>
        @else
            @foreach ($mybookeds as $resort)
                <div class="ticket">
                    <div class="left">
                        <div class="image">
                            @if ($resort->resort->images->count() > 0)
                                <img src="{{ asset('images/' . $resort->resort->images->first()->image) }}"
                                    class="ticket-image" alt="Resort Image">
                            @else
                                <div class="ticket-image"
                                    style="background-color: #eee; display: flex; align-items: center; justify-content: center;">
                                    <span style="color: #999;">No Image Available</span>
                                </div>
                            @endif
                        </div>
                        <div class="ticket-info">
                            <div class="ticket-date">
                                <span
                                    class="month-day">{{ \Carbon\Carbon::parse($resort->booking_date)->format('Y') }}</span>
                                <span
                                    class="month-day">{{ \Carbon\Carbon::parse($resort->booking_date)->format('F j') }}</span>
                                <span
                                    class="month-day">{{ \Carbon\Carbon::parse($resort->booking_date)->format('l') }}</span>
                            </div>
                            <div class="ticket-show-name">
                                <h5>{{ $resort->resort_name }}</h5>
                                <p>Resort Price: RM{{ $resort->total_price }}</p>
                            </div>
                            <div class="ticket-details">
                                <div class="detail-item">
                                    <span class="detail-label">Gender</span>
                                    <span class="detail-value">{{ $resort->gender }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Person</span>
                                    <span class="detail-value">{{ $resort->quantity }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Booking Days</span>
                                    <span class="detail-value">{{ $resort->booking_days }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="right-info-container">
                            <div class="ticket-time">
                                <div class="time-item">
                                    <span class="time-label">Check-In Date:</span>
                                    <span
                                        class="time-value">{{ \Carbon\Carbon::parse($resort->checkin_date)->format('j F Y') }}</span>
                                </div>
                                <div class="time-item">
                                    <span class="time-label">Check-Out Date:</span>
                                    <span
                                        class="time-value">{{ \Carbon\Carbon::parse($resort->checkout_date)->format('j F Y') }}</span>
                                </div>
                                <div class="time-item">
                                    <span class="time-label">Check-In Time:</span>
                                    <span
                                        class="time-value">{{ \Carbon\Carbon::parse($resort->checkin_time)->format('g:i A') }}</span>
                                </div>
                                <div class="time-item">
                                    <span class="time-label">Check-Out Time:</span>
                                    <span
                                        class="time-value">{{ \Carbon\Carbon::parse($resort->checkout_time)->format('g:i A') }}</span>
                                </div>
                            </div>
                            <div class="ticket-barcode">
                                <?php
                                $ipAddress = '192.168.50.154';
                                $url =
                                    'http://' .
                                    $ipAddress .
                                    ':8000' .
                                    route('verify.resort', ['resortId' => $resort->id], false) .
                                    '?' .
                                    http_build_query([
                                        'user_id' => $resort->user_id,
                                        'resort_id' => $resort->resort_id,
                                        'checkin_date' => $resort->checkin_date,
                                        'checkout_date' => $resort->checkout_date,
                                        'checkin_time' => $resort->checkin_time,
                                        'checkout_time' => $resort->checkout_time,
                                        'total_price' => $resort->total_price,
                                        'verify_code' => $resort->verify_code,
                                    ]);
                                ?>
                                {!! QrCode::size(120)->generate($url) !!}
                            </div>
                            <div class="action-buttons">
                                <a href="{{ url('viewBookedResort/' . $resort->id) . '/view' }}" target="_blank"
                                    class="navy-blue-button">View Detail</a>

                                @if ($resort->payment_status == 0)
                                    {{-- <form action="{{ route('booking.cancel.resort', $resort->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to Cancel this Booking?')"
                                            class="navy-blue-button"
                                            style="background: linear-gradient(to right, #dc2626, #991b1b);">
                                            Cancel Booking
                                        </button>
                                    </form> --}}

                                    <a href="{{ route('ExtandorCancelResort', ['id' => $resort->id]) }}"
                                        class="navy-blue-button"
                                        style="background: linear-gradient(to right, #dc2626, #991b1b);">Extand or Cancel Booking</a>

                                @elseif($resort->payment_status == 1)
                                    <form action="{{ route('booking.checkout.resort', $resort->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            onclick="return confirm('Are you sure you want to check out this resort?')"
                                            class="navy-blue-button">Check Out</button>
                                    </form>
                                @elseif($resort->payment_status == 2)
                                    <span class="status-badge status-checked-out">Checked Out</span>
                                @elseif($resort->payment_status == 3)
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
