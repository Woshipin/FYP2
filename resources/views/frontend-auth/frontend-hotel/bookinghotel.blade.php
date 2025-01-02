@extends('frontend-auth.newlayout')

@section('frontend-section')
    {{-- Payment Card CSS --}}
    <link rel="stylesheet" href="{{ asset('paymentcard/css/style.css') }}">

    {{-- BookingStatus Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('66e2c17903cc96af1475', {
            cluster: 'ap1'
        });

        var audio = new Audio('/sound/notification.mp3');

        var channel = pusher.subscribe('bookingstatus');
        channel.bind('booking-status', function() {
            audio.play(); // 播放音频
        });
    </script>

    {{-- Pill CSS --}}
    <style>
        /* Custom CSS for tabs */
        .custom-tabs {
            display: flex;
            list-style: none;
            /* Remove list bullet points */
            padding: 0;
        }

        .custom-tab {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
        }

        .custom-tab.active {
            background-color: #007BFF;
            color: #fff;
        }

        .custom-tab-content {
            display: none;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .custom-tab-content.active {
            display: block;
        }
    </style>

    {{-- Form CSS --}}
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: black;
            /* 确保所有文本颜色为黑色 */
            background-color: #f8fafc;
            /* 确保背景颜色显示 */
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: bold;
            margin-bottom: 1rem;
            color: black;
            /* 确保标题颜色为黑色 */
        }

        h1 {
            font-size: 2.5rem;
        }

        h2 {
            font-size: 2rem;
        }

        h3 {
            font-size: 1.75rem;
        }

        h4 {
            font-size: 1.5rem;
        }

        h5 {
            font-size: 1.25rem;
        }

        h6 {
            font-size: 1rem;
        }

        /* Form CSS */
        .custom-tab-content {
            background: rgb(143, 239, 236);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .h3 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        span {
            color: black;
        }

        #paypal-payment-section {
            padding: 20px;
            text-align: center;
        }

        #paypal-button-container {
            max-width: 400px;
            margin: 0 auto;
        }

        .payment-method-select {
            margin-bottom: 20px;
        }

        /* Payment Method Selector */
        .payment-method-selector {
            margin-bottom: 2rem;
        }

        .payment-options {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .payment-option {
            flex: 1;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            color: black;
            /* 确保文本颜色为黑色 */
        }

        .payment-option.active {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .payment-option img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        /* Card Payment Section */
        .card-container {
            perspective: 1000px;
            margin-bottom: 2rem;
        }

        .card-input-section {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .card-input {
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 1rem;
            width: 100%;
            color: black;
            /* 确保文本颜色为黑色 */
        }

        .card-extra-details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        /* Payment Summary */
        .payment-summary {
            margin-top: 2rem;
            padding: 1rem;
            background-color: #f8fafc;
            border-radius: 0.5rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            color: black;
            /* 确保文本颜色为黑色 */
        }

        /* Submit Button */
        .submit-button {
            width: 100%;
            padding: 1rem;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 1.5rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Arial', sans-serif;
        }

        .submit-button:hover {
            background-color: orange;
        }

        /* Progress Bar */
        .progress-container {
            margin-top: 1.5rem;
        }

        .progress {
            height: 1rem;
            /* 增加进度条的高度 */
            background-color: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }

        .progress-percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            /* 确保百分比颜色为白色 */
            font-weight: bold;
            font-size: 0.875rem;
            /* 调整百分比字体大小 */
        }

        /* PayPal Section */
        .paypal-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            padding: 2rem;
        }

        .paypal-logo img {
            width: 200px;
            height: auto;
        }

        .paypal-description {
            text-align: center;
            color: black;
            /* 确保文本颜色为黑色 */
        }

        /* Input Boxes */
        .inputBox {
            margin-bottom: 1.5rem;
        }

        .inputBox h3 {
            margin-bottom: 0.5rem;
            font-family: 'Arial', sans-serif;
            font-size: 1.25rem;
            font-weight: bold;
            color: black;
            /* 确保文本颜色为黑色 */
        }

        .inputBox input,
        .inputBox select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 1rem;
            height: 40px;
            /* 确保高度足够 */
            font-family: 'Arial', sans-serif;
            color: black;
            /* 确保文本颜色为黑色 */
        }

        /* Custom Tabs */
        .custom-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .custom-tab {
            padding: 0.75rem 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Arial', sans-serif;
            font-size: 1.25rem;
            font-weight: bold;
            color: black;
            /* 确保文本颜色为黑色 */
        }

        .custom-tab.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        /* Images */
        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        /* Continue to Payment Button */
        .inputBox .btn {
            width: 100%;
            padding: 1rem;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-family: 'Arial', sans-serif;
        }

        .inputBox .btn:hover {
            background-color: orange;
        }
    </style>

    {{-- progress bar CSS --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 在 head 标签中引入 Bootstrap CSS -->
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}

    {{-- sweetalert2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Book Section Starts -->
    <section class="book" id="book">
        <h1 class="heading">
            <span>B</span>
            <span>o</span>
            <span>o</span>
            <span>k</span>
            <span class="space"></span>
            <span>n</span>
            <span>o</span>
            <span>w</span>
        </h1>

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs custom-tabs">
                    <li class="custom-tab active" data-tab="booking">Booking</li>
                    <li class="custom-tab" data-tab="payment">Payment</li>
                </ul>

                <form action="{{ url('bookingshotel') }}" method="post" enctype="multipart/form-data" id="bookingForm">
                    @csrf

                    {{-- Booking Hotel Area --}}
                    <div class="custom-tab-content active" data-tab="booking">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{ asset('new/img/book-img.jpg') }}" alt="">
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                <input type="hidden" name="hotel_id" value="{{ $hotels->id }}">
                                <input type="hidden" name="type_name" value="{{ $hotels->name }}">
                                <input type="hidden" name="owner_id" value="{{ $hotels->user->id }}">
                                <input type="hidden" name="owner_name" value="{{ $hotels->user->name }}">
                                <input type="hidden" name="hotel_email" value="{{ $hotels->email }}">
                                <input type="hidden" name="hotel_phone" value="{{ $hotels->phone }}">
                                <input type="hidden" name="hotel_name" value="{{ $hotels->name }}">
                                <input type="hidden" name="hotel_type" value="{{ $hotels->type }}">
                                <input type="hidden" id="room_name_input" value="">
                                <input type="hidden" id="room_type_input" value="">
                                <input type="hidden" name="room_price" id="room_price_input" value="">
                                <input type="hidden" name="type_id" value="{{ $hotels->id }}">
                                <input type="hidden" name="type_name" value="{{ $hotels->name }}">
                                <input type="hidden" name="type_category" value="Hotel">

                                <div class="inputBox">
                                    <h3>Check-In Date</h3>
                                    <input type="date" required name="checkin_date" id="checkin_date"
                                        class="form-control" placeholder="Select Your Booking Check In Date"
                                        min="YYYY-MM-DD" max="YYYY-MM-DD">
                                </div>

                                <div class="inputBox">
                                    <h3>Check-Out Date</h3>
                                    <input type="date" required name="checkout_date" id="checkout_date"
                                        class="form-control" placeholder="Select Your Booking Check Out Date"
                                        min="YYYY-MM-DD" max="YYYY-MM-DD">
                                </div>

                                <div class="inputBox">
                                    <h3>Check-In Time</h3>
                                    <input type="time" required name="checkin_time" id="check_in_time"
                                        class="form-control checkin-time" placeholder="Select Your Check-In Time">
                                </div>
                                <div class="inputBox">
                                    <h3>Check-Out Time</h3>
                                    <input type="time" required name="checkout_time" id="check_out_time"
                                        class="form-control" placeholder="Select Your Check-Out Time">
                                </div>

                                <div class="inputBox">
                                    <h3>Select Room</h3>
                                    <div class="custom-select-container">
                                        <select class="form-control custom-select" id="room_select" name="room_id"
                                            required>
                                            <option value="0" selected disabled>--- Choose a Room ---</option>
                                            @foreach ($rooms as $room)
                                                <option value="{{ $room->id }}" data-name="{{ $room->name }}"
                                                    data-type="{{ $room->type }}" data-price="{{ $room->price }}">
                                                    Name: {{ $room->type }} | Type: {{ $room->name }} | Price:
                                                    ${{ $room->price }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="select-arrow"></div>
                                    </div>
                                </div>

                                <div class="inputBox">
                                    <h3>Select Gender</h3>
                                    <select name="gender" id="gender" class="form-control custom-select" required>
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender->title }}">{{ $gender->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="inputBox">
                                    <h3>Total Quantity Person</h3>
                                    <input type="number" required min="1" max="20" name="quantity"
                                        id="quantity" class="form-control" placeholder="Enter Total Quantity"
                                        oninput="validateQuantity(this)">
                                </div>
                                <div class="inputBox">
                                    <p id="payment" class="btn">Continue to Payment</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    {{-- Payment Area --}}
                    <div class="container-payment custom-tab-content" data-tab="payment">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{ asset('new/img/book-img.jpg') }}" alt="">
                            </div>

                            <div class="col-md-6">
                                <!-- Payment Method Selection -->
                                <div class="payment-method-selector">
                                    <h3>Select Payment Method</h3>
                                    <div class="payment-options">
                                        <div class="payment-option" data-method="credit_card">
                                            <img src="{{ asset('new/img/card-icon.png') }}" alt="Card">
                                            <span>Credit/Debit Card</span>
                                        </div>
                                        <div class="payment-option" data-method="paypal">
                                            <img src="{{ asset('new/img/paypal-icon.png') }}" alt="PayPal">
                                            <span>PayPal</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="payment_method" id="payment_method" value="credit_card">
                                </div>

                                <!-- Card Payment Section -->
                                <div id="card-payment-section" class="payment-section">
                                    <div class="card-container">
                                        <div class="front">
                                            <div class="image">
                                                <img src="{{ asset('new/img/image/chip.png') }}" alt="">
                                                <img src="{{ asset('new/img/image/visa.png') }}" alt="">
                                            </div>
                                            <div class="card-number-box">################</div>
                                            <div class="flexbox">
                                                <div class="box">
                                                    <span>card holder</span>
                                                    <div class="card-holder-name">full name</div>
                                                </div>
                                                <div class="box">
                                                    <span>expires</span>
                                                    <div class="expiration">
                                                        <span class="exp-month">mm</span>
                                                        <span class="exp-year">yy</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="back">
                                            <div class="stripe"></div>
                                            <div class="box">
                                                <span>cvv</span>
                                                <div class="cvv-box"></div>
                                                <img src="{{ asset('new/img/image/visa.png') }}" alt="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-input-section">
                                        <div class="input-group">
                                            <label>Card Number</label>
                                            <input type="text" id="card_number" name="card_number" maxlength="19"
                                                class="card-input" placeholder="0000 0000 0000 0000">
                                        </div>

                                        <div class="input-group">
                                            <label>Card Holder Name</label>
                                            <input type="text" name="card_holder" id="card_holder"
                                                class="card-input">
                                        </div>

                                        <div class="card-extra-details">
                                            <div class="input-group">
                                                <label>Expiry Month</label>
                                                <select name="card_month" id="card_month" class="card-input">
                                                    <option value="" selected disabled>MM</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option value="{{ sprintf('%02d', $i) }}">
                                                            {{ sprintf('%02d', $i) }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="input-group">
                                                <label>Expiry Year</label>
                                                <select name="card_year" id="card_year" class="card-input">
                                                    <option value="" selected disabled>YY</option>
                                                    @for ($i = date('Y'); $i <= date('Y') + 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="input-group">
                                                <label>CVV</label>
                                                <input type="text" name="cvv" id="cvv" maxlength="4"
                                                    class="card-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PayPal Payment Section -->
                                <div id="paypal-payment-section" class="payment-section" style="display: none;">
                                    <div class="paypal-container">
                                        <div class="paypal-logo">
                                            <img src="{{ asset('new/img/paypal-logo.png') }}" alt="PayPal">
                                        </div>
                                        <p class="paypal-description">Click the button below to pay securely with PayPal
                                        </p>
                                        <div id="paypal-button-container"></div>
                                    </div>
                                </div>

                                <!-- Common Payment Information -->
                                <div class="payment-summary">
                                    <div class="summary-item">
                                        <span>Deposit Fee</span>
                                        <span>RM 100.00</span>
                                        <input type="hidden" name="deposit_price" value="100">
                                    </div>
                                    <div class="summary-item">
                                        <span>Hotel Room Total Price</span>
                                        <span>RM <span id="total_price">0.00</span></span>
                                    </div>
                                </div>

                                <!-- Submit Button (for card payment) -->
                                <button type="submit" class="submit-button" id="submit-button">
                                    Complete Payment
                                </button>

                                <!-- Progress Bar -->
                                <div class="progress-container" id="progressBarContainer" style="display: none;">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
    <!-- Book Section Ends -->

    <!-- /.container-fluid -->

    <!------------------------------------------------------------ /.Js Area -------------------------------------------------------->

    {{-- progress bar JS --}}
    <!-- 在 body 标签底部引入 Bootstrap JS 和 jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Check Date Valid and Past Date Check --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to date, check-in time, and check-out time elements
            var checkinDate = document.getElementById('checkin_date');
            var checkoutDate = document.getElementById('checkout_date');
            var checkInTime = document.getElementById('check_in_time');
            var checkOutTime = document.getElementById('check_out_time');
            var roomSelect = document.getElementById('room_select');

            // Disable check-in time, check-out time, and room select initially
            // checkInTime.disabled = true;
            // checkOutTime.disabled = true;
            roomSelect.disabled = true;

            // Set the min attribute for check-in date to today's date
            var today = new Date().toISOString().split('T')[0];
            checkinDate.setAttribute('min', today);

            // Event listener for check-in date selection
            checkinDate.addEventListener('change', function() {
                console.log('Check-in date changed:', checkinDate.value);
                // Enable check-in time once the date is selected
                checkInTime.disabled = false;
                // Validate check-in date
                validateCheckinDate();
                // Set the min attribute for check-out date to check-in date
                checkoutDate.setAttribute('min', checkinDate.value);
            });

            // Event listener for check-out date selection
            checkoutDate.addEventListener('change', function() {
                console.log('Check-out date changed:', checkoutDate.value);
                // Enable check-out time once the date is selected
                checkOutTime.disabled = false;
                // Validate check-out date
                validateCheckoutDate();
            });

            // Event listener for check-in time selection
            checkInTime.addEventListener('change', function() {
                console.log('Check-in time changed:', checkInTime.value);
                // Validate check-out time based on check-in time
                validateCheckOutTime();
            });

            // Event listener for check-out time selection
            checkOutTime.addEventListener('change', function() {
                console.log('Check-out time changed:', checkOutTime.value);
                // Enable room select once check-out time is selected
                roomSelect.disabled = false;
                // Validate check-out time based on check-in time
                validateCheckOutTime();
            });

            // Function to validate check-in date
            function validateCheckinDate() {
                var today = new Date();
                today.setHours(0, 0, 0, 0); // Set time to 00:00:00
                var selectedDate = new Date(checkinDate.value);

                if (selectedDate < today) {
                    alert('Check-in date cannot be in the past');
                    checkinDate.value = '';
                    checkInTime.disabled = true;
                }
            }

            // Function to validate check-out date
            function validateCheckoutDate() {
                var checkinDateValue = new Date(checkinDate.value);
                var checkoutDateValue = new Date(checkoutDate.value);

                if (checkoutDateValue <= checkinDateValue) {
                    alert('Check-out Date must be after Check-in Date');
                    checkoutDate.value = '';
                    checkOutTime.disabled = true;
                }

                if (checkoutDateValue.getTime() === checkinDateValue.getTime()) {
                    alert('Check-out Date cannot be the same as Check-in Date');
                    checkoutDate.value = '';
                    checkOutTime.disabled = true;
                }
            }

            // Function to validate check-out time based on check-in time
            function validateCheckOutTime() {
                var checkInTimeValue = convertToMinutes(checkInTime.value);
                var checkOutTimeValue = convertToMinutes(checkOutTime.value);

                // Define time boundaries (7:00 AM to 10:00 PM)
                var startTime = convertToMinutes('07:00');
                var endTime = convertToMinutes('22:00');

                // Check if check-in time is within the allowed range (7:00 AM to 10:00 PM)
                if (checkInTimeValue < startTime || checkInTimeValue > endTime) {
                    alert('You selected check-in time outside the allowed range (7:00 AM to 10:00 PM)');
                    checkInTime.value = '';
                    checkOutTime.disabled = true;
                } else if (checkOutTimeValue < startTime || checkOutTimeValue > endTime) {
                    alert('You selected check-out time outside the allowed range (7:00 AM to 10:00 PM)');
                    checkOutTime.value = '';
                } else if (checkOutTimeValue <= checkInTimeValue) {
                    alert('You selected check-out time before or equal to check-in time');
                    checkOutTime.value = '';
                }
            }

            // Function to convert time strings to minutes
            function convertToMinutes(timeString) {
                var timeArray = timeString.split(':');
                return parseInt(timeArray[0]) * 60 + parseInt(timeArray[1]);
            }
        });
    </script>

    {{-- Toastr New JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- Check Quantity 1-20 --}}
    <script>
        function validateQuantity(input) {
            // 仅允许数字
            input.value = input.value.replace(/\D/g, '');

            // 获取用户输入的值
            var value = parseInt(input.value, 10);

            // 如果值小于最小值，则设置为最小值
            if (value < parseInt(input.min, 10)) {
                input.value = input.min;
            }

            // 如果值大于最大值，则设置为最大值
            if (value > parseInt(input.max, 10)) {
                input.value = input.max;
            }
        }
    </script>

    <!-- Include jQuery from the CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Pill JS --}}
    <script>
        // JavaScript to handle tab switching
        $(document).ready(function() {
            $('.custom-tab').click(function() {
                var tab = $(this).data('tab');
                $('.custom-tab').removeClass('active');
                $('.custom-tab[data-tab="' + tab + '"]').toggleClass('active');
                $('.custom-tab-content').removeClass('active');
                $('.custom-tab-content[data-tab="' + tab + '"]').toggleClass('active');
            });
            $('#payment').click(function(e) {
                e.preventDefault();
                $('.custom-tab').removeClass('active');
                $('.custom-tab[data-tab="payment"]').toggleClass('active');
                $('.custom-tab-content').removeClass('active');
                $('.custom-tab-content[data-tab="payment"]').toggleClass('active');
            })
        });
    </script>

    {{-- Check Date Valid and Past Date Check --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to date, check-in time, and check-out time elements
            var checkinDate = document.getElementById('checkin_date');
            var checkoutDate = document.getElementById('checkout_date');
            var checkInTime = document.getElementById('check_in_time');
            var checkOutTime = document.getElementById('check_out_time');
            var roomSelect = document.getElementById('room_select');

            // Disable check-in time, check-out time, and room select initially
            // checkInTime.disabled = true;
            // checkOutTime.disabled = true;
            roomSelect.disabled = true;

            // Event listener for check-in date selection
            checkinDate.addEventListener('change', function() {
                console.log('Check-in date changed:', checkinDate.value);
                // Enable check-in time once the date is selected
                checkInTime.disabled = false;
                // Validate check-in date
                validateCheckinDate();
            });

            // Event listener for check-out date selection
            checkoutDate.addEventListener('change', function() {
                console.log('Check-out date changed:', checkoutDate.value);
                // Enable check-out time once the date is selected
                checkOutTime.disabled = false;
                // Validate check-out date
                validateCheckoutDate();
            });

            // Event listener for check-in time selection
            checkInTime.addEventListener('change', function() {
                console.log('Check-in time changed:', checkInTime.value);
                // Validate check-out time based on check-in time
                validateCheckOutTime();
            });

            // Event listener for check-out time selection
            checkOutTime.addEventListener('change', function() {
                console.log('Check-out time changed:', checkOutTime.value);
                // Enable room select once check-out time is selected
                roomSelect.disabled = false;
                // Validate check-out time based on check-in time
                validateCheckOutTime();
            });

            // Function to validate check-in date
            function validateCheckinDate() {
                var today = new Date();
                today.setHours(0, 0, 0, 0); // Set time to 00:00:00
                var selectedDate = new Date(checkinDate.value);

                if (selectedDate < today) {
                    alert('Check-in date cannot be in the past');
                    checkinDate.value = '';
                    checkInTime.disabled = true;
                }
            }

            // Function to validate check-out date
            function validateCheckoutDate() {
                var checkinDateValue = new Date(checkinDate.value);
                var checkoutDateValue = new Date(checkoutDate.value);

                if (checkoutDateValue <= checkinDateValue) {
                    alert('Check-out Date must be after Check-in Date');
                    checkoutDate.value = '';
                    checkOutTime.disabled = true;
                }

                if (checkoutDateValue.getTime() === checkinDateValue.getTime()) {
                    alert('Check-out Date cannot be the same as Check-in Date');
                    checkoutDate.value = '';
                    checkOutTime.disabled = true;
                }
            }

            // Function to validate check-out time based on check-in time
            function validateCheckOutTime() {
                var checkInTimeValue = convertToMinutes(checkInTime.value);
                var checkOutTimeValue = convertToMinutes(checkOutTime.value);

                // Define time boundaries (7:00 AM to 10:00 PM)
                var startTime = convertToMinutes('07:00');
                var endTime = convertToMinutes('22:00');

                // Check if check-in time is within the allowed range (7:00 AM to 10:00 PM)
                if (checkInTimeValue < startTime || checkInTimeValue > endTime) {
                    alert('You selected check-in time outside the allowed range (7:00 AM to 10:00 PM)');
                    checkInTime.value = '';
                    checkOutTime.disabled = true;
                } else if (checkOutTimeValue < startTime || checkOutTimeValue > endTime) {
                    alert('You selected check-out time outside the allowed range (7:00 AM to 10:00 PM)');
                    checkOutTime.value = '';
                } else if (checkOutTimeValue <= checkInTimeValue) {
                    alert('You selected check-out time before or equal to check-in time');
                    checkOutTime.value = '';
                }
            }

            // Function to convert time strings to minutes
            function convertToMinutes(timeString) {
                var timeArray = timeString.split(':');
                return parseInt(timeArray[0]) * 60 + parseInt(timeArray[1]);
            }
        });
    </script>

    {{-- Payment Card Check --}}
    <script>
        var cardNumberInput = document.getElementById('card_number');
        var cardHolderInput = document.getElementsByName('card_holder')[0];
        var cvvInput = document.getElementsByName('cvv')[0];

        // 使用变量保存定时器的引用
        var validationTimer;

        // 添加 input 事件监听器
        cardNumberInput.addEventListener('input', function() {
            // 清除之前的定时器
            clearTimeout(validationTimer);

            // 延迟一定时间执行验证
            validationTimer = setTimeout(function() {
                var cardNumber = cardNumberInput.value;

                // 去除卡号中的非数字字符
                var cardNumberWithoutNonDigits = cardNumber.replace(/\D/g, '');

                // 如果输入的卡号不足16位数字，不执行验证
                if (cardNumberWithoutNonDigits.length < 16) {
                    return;
                }

                // 验证 card_number 是否符合格式
                if (!/^\d{16}$/.test(cardNumberWithoutNonDigits)) {
                    alert('Please enter a valid card number.');
                    cardNumberInput.value = ''; // 清空输入框
                    return;
                }

                // 格式化 card_number，模拟现实中的卡号显示
                var formattedCardNumber = cardNumberWithoutNonDigits.replace(/(\d{4})/g, '$1 ').trim();
                cardNumberInput.value = formattedCardNumber;

                // 如果输入的卡号带有空格，则需要保留这些空格以便正确显示
                if (cardNumber.includes(' ')) {
                    cardNumberInput.value = cardNumber.replace(/(\d{4})/g, '$1 ').trim();
                }

                if (cardNumberInput.value.length > 19) {
                    cardNumberInput.value = cardNumberInput.value.substring(0, 19);
                }
            }, 500); // 设置延迟时间，单位为毫秒
        });

        // 添加 input 事件监听器，只允许输入数字
        cardNumberInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, ''); // 去除非数字字符
        });

        // 添加 input 事件监听器
        cardHolderInput.addEventListener('input', function() {
            var cardHolder = this.value;

            // 验证 card_holder 是否只包含英文字母
            if (!/^[a-zA-Z]+$/.test(cardHolder)) {
                alert('Card holder must contain only letters.');
                this.value = ''; // 清空输入框
            }
        });

        // 添加 input 事件监听器
        cvvInput.addEventListener('input', function() {
            var cvv = this.value;

            // 验证 cvv 是否只包含数字且不超过3位数
            if (!/^\d{1,3}$/.test(cvv)) {
                alert('CVV must contain only digits and be up to 3 digits.');
                this.value = ''; // 清空输入框
            }
        });
    </script>

    {{-- Check Date --}}
    <script>
        $('#checkin_date').change(function() {
            var checkinDate = new Date($('#checkin_date').val());
            var checkoutDate = new Date($('#checkout_date').val());

            // Check if Check-out Date is less than or equal to Check-in Date
            if (checkoutDate <= checkinDate) {
                alert('Check-out Date must be after Check-in Date');
                $('#checkout_date').val('');
            }

            // Check if Check-out Date is the same as Check-in Date
            if (checkoutDate.getTime() === checkinDate.getTime()) {
                alert('Check-out Date cannot be the same as Check-in Date');
                $('#checkout_date').val('');
            }
        });

        $('#checkout_date').change(function() {
            var checkinDate = new Date($('#checkin_date').val());
            var checkoutDate = new Date($('#checkout_date').val());

            // Check if Check-out Date is less than or equal to Check-in Date
            if (checkoutDate <= checkinDate) {
                alert('Check-out Date must be after Check-in Date');
                $('#checkout_date').val('');
            }

            // Check if Check-out Date is the same as Check-in Date
            if (checkoutDate.getTime() === checkinDate.getTime()) {
                alert('Check-out Date cannot be the same as Check-in Date');
                $('#checkout_date').val('');
            }
        });
    </script>

    <!-- PayPal JS -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=AevCq5WDpuSoYCJlkxHD-N_Yf13gKJmf9sOESVMmYa9lDzN9bVvgfNUqTy4C62CthVk9r5qoEgwDM8Un">
    </script>

    <script>
        // 从后端传递的数据
        const bookedDates = @json($bookedDates);
        const rooms = @json($rooms);

        console.log(bookedDates);
        console.log(rooms);

        document.addEventListener('DOMContentLoaded', function() {
            const roomSelect = document.getElementById('room_select');
            const roomPriceInput = document.getElementById('room_price_input');
            const roomNameInput = document.getElementById('room_name_input');
            const roomTypeInput = document.getElementById('room_type_input');
            const totalPriceDisplay = document.getElementById('total_price');
            const checkinDateInput = document.getElementById('checkin_date');
            const checkoutDateInput = document.getElementById('checkout_date');
            const DEPOSIT_AMOUNT = 100;

            // Payment related elements
            const paymentOptions = document.querySelectorAll('.payment-option');
            const cardPaymentSection = document.getElementById('card-payment-section');
            const paypalPaymentSection = document.getElementById('paypal-payment-section');
            const paymentMethodInput = document.getElementById('payment_method');
            let isSubmitting = false;

            // Calculate number of nights between two dates
            function calculateNights(checkinDate, checkoutDate) {
                const oneDay = 24 * 60 * 60 * 1000;
                const diffDays = Math.round(Math.abs((checkoutDate - checkinDate) / oneDay));
                return diffDays;
            }

            // Calculate total price based on room price and number of nights
            function calculateTotalPrice() {
                const checkinDate = new Date(checkinDateInput.value);
                const checkoutDate = new Date(checkoutDateInput.value);
                const roomPrice = parseFloat(roomPriceInput.value);

                // Reset total price if dates or room price are invalid
                if (!checkinDateInput.value || !checkoutDateInput.value || isNaN(roomPrice)) {
                    totalPriceDisplay.textContent = '0.00';
                    return;
                }

                // Validate dates
                if (checkoutDate <= checkinDate) {
                    alert('Checkout date must be after check-in date');
                    checkoutDateInput.value = '';
                    totalPriceDisplay.textContent = '0.00';
                    return;
                }

                const numberOfNights = calculateNights(checkinDate, checkoutDate);
                const roomTotalPrice = roomPrice * numberOfNights;
                const totalPriceWithDeposit = roomTotalPrice + DEPOSIT_AMOUNT;

                // Update total price display
                totalPriceDisplay.textContent = totalPriceWithDeposit.toFixed(2);
            }

            // Handle room selection change
            roomSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                if (selectedOption.value !== '0') {
                    roomNameInput.value = selectedOption.dataset.name || '';
                    roomTypeInput.value = selectedOption.dataset.type || '';
                    roomPriceInput.value = selectedOption.dataset.price || '0';
                    calculateTotalPrice();
                } else {
                    roomNameInput.value = '';
                    roomTypeInput.value = '';
                    roomPriceInput.value = '0';
                    totalPriceDisplay.textContent = '0.00';
                }
            });

            // Update available rooms and prices when dates change
            function updateRoomOptions() {
                const selectedDates = getSelectedDates();
                const availableRooms = rooms.filter(room => isRoomAvailable(room.id, selectedDates));

                roomSelect.innerHTML = '<option value="0" disabled selected>--- Choose a Room ---</option>';

                availableRooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.dataset.name = room.name;
                    option.dataset.type = room.type;
                    option.dataset.price = room.price;
                    option.textContent = `Name: ${room.type} | Type: ${room.name} | Price: $${room.price}`;
                    roomSelect.appendChild(option);
                });

                calculateTotalPrice();
            }

            // Get array of dates between checkin and checkout
            function getSelectedDates() {
                const dates = [];
                const checkinDate = new Date(checkinDateInput.value);
                const checkoutDate = new Date(checkoutDateInput.value);

                if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                    let currentDate = new Date(checkinDate);
                    while (currentDate < checkoutDate) {
                        dates.push(currentDate.toISOString().slice(0, 10));
                        currentDate.setDate(currentDate.getDate() + 1);
                    }
                }
                return dates;
            }

            // Check if room is available for selected dates
            function isRoomAvailable(roomId, selectedDates) {
                // Check if any booked date overlaps with selected dates for the given room
                return !bookedDates.some(booking => {
                    const isRoomMatch = booking.room_id === roomId;
                    const isDateOverlap = selectedDates.includes(booking.date);
                    return isRoomMatch && isDateOverlap;
                });
            }

            // Disable past dates in date inputs
            function disablePastDates() {
                const today = new Date().toISOString().split('T')[0];
                checkinDateInput.setAttribute('min', today);
                checkoutDateInput.setAttribute('min', today);
            }

            // Payment method selection handling
            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    paymentOptions.forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                    const method = this.getAttribute('data-method');
                    paymentMethodInput.value = method;

                    if (method === 'credit_card') {
                        cardPaymentSection.style.display = 'block';
                        paypalPaymentSection.style.display = 'none';
                    } else if (method === 'paypal') {
                        cardPaymentSection.style.display = 'none';
                        paypalPaymentSection.style.display = 'block';
                        initialisePayPalButtons();
                    }
                });
            });

            // Initialize PayPal buttons
            function initialisePayPalButtons() {
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        const totalPrice = parseFloat(totalPriceDisplay.textContent);
                        if (isNaN(totalPrice) || totalPrice <= 0) {
                            alert('Invalid total price. Please check room selection and dates.');
                            return;
                        }
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: totalPrice.toFixed(2)
                                }
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                            if (!isSubmitting) {
                                startProgressBarAndSubmit();
                            }
                        });
                    }
                }).render('#paypal-button-container');
            }

            // Submit button handler
            document.getElementById('submit-button').addEventListener('click', function(event) {
                event.preventDefault();
                if (!isSubmitting) {
                    startProgressBarAndSubmit();
                }
            });

            // Progress bar and submission handling
            function startProgressBarAndSubmit() {
                if (isSubmitting) return;
                isSubmitting = true;
                let progressBarContainer = document.getElementById('progressBarContainer');
                progressBarContainer.style.display = 'block';
                let progressBar = document.querySelector('.progress-bar');
                let width = 0;
                let interval = setInterval(function() {
                    if (width >= 100) {
                        clearInterval(interval);
                        submitBooking();
                    } else {
                        width += 5;
                        progressBar.style.width = width + '%';
                        progressBar.setAttribute('aria-valuenow', width);
                        progressBar.textContent = width + '%';
                    }
                }, 50);
            }

            // Form submission
            function submitBooking() {
                const formData = new FormData(document.getElementById('bookingForm'));
                const paymentMethod = paymentMethodInput.value;
                const totalPrice = parseFloat(totalPriceDisplay.textContent);

                formData.append('total_price', totalPrice.toFixed(2));
                formData.append('deposit_amount', DEPOSIT_AMOUNT.toFixed(2));

                if (paymentMethod === 'credit_card') {
                    formData.append('card_number', document.getElementById('card_number').value);
                    formData.append('card_holder', document.getElementById('card_holder').value);
                    formData.append('card_month', document.getElementById('card_month').value);
                    formData.append('card_year', document.getElementById('card_year').value);
                    formData.append('cvv', document.getElementById('cvv').value);
                } else {
                    formData.append('card_number', '0000000000000000');
                    formData.append('card_holder', 'PayPal User');
                    formData.append('card_month', '01');
                    formData.append('card_year', new Date().getFullYear() + 1);
                    formData.append('cvv', '000');
                }

                fetch('{{ url('bookingshotel') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Booking Successful!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.href = '{{ route('home') }}';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Booking Failed',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred while processing your booking.'
                        });
                    })
                    .finally(() => {
                        document.getElementById('progressBarContainer').style.display = 'none';
                        isSubmitting = false;
                    });
            }

            // Event listeners for date changes
            checkinDateInput.addEventListener('change', function() {
                if (this.value) {
                    const minCheckout = new Date(this.value);
                    minCheckout.setDate(minCheckout.getDate() + 1);
                    checkoutDateInput.setAttribute('min', minCheckout.toISOString().split('T')[0]);

                    if (checkoutDateInput.value && new Date(checkoutDateInput.value) <= new Date(this
                            .value)) {
                        checkoutDateInput.value = '';
                    }
                }
                updateRoomOptions();
            });

            checkoutDateInput.addEventListener('change', function() {
                updateRoomOptions();
            });

            // Initialize
            disablePastDates();
            updateRoomOptions();
        });
    </script>

@endsection
