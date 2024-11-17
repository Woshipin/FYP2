@extends('frontend-auth.newlayout')

@section('frontend-section')
    <!------------------------------------------------------------ Book Area ------------------------------------------------------->

    {{-- Payment Card CSS --}}
    <link rel="stylesheet" href="{{ asset('paymentcard/css/style.css') }}">

    <style>
        input::placeholder {
            color: gray;
        }

        /* 将ID为"card-number-input"的输入框的占位文本颜色设置为灰色 */
        #card-number-input::placeholder {
            color: gray;
        }
    </style>

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
    {{-- <style>
        .custom-tab-content {
            background: rgb(143, 239, 236);
        }

        .h3 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        span {
            /* color: black */
        }
    </style>
    <style>
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

        /* Add any additional custom styles you need */
    </style>
    <style>
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
        }

        .card-extra-details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

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
        }

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
        }

        .submit-button:hover {
            background-color: #2563eb;
        }

        .progress-container {
            margin-top: 1.5rem;
        }

        .progress {
            height: 0.5rem;
            background-color: #e2e8f0;
            border-radius: 9999px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background-color: #3b82f6;
            transition: width 0.3s ease;
        }

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
            color: #64748b;
        }
    </style> --}}
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

    {{-- progress bar CSS --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 在 head 标签中引入 Bootstrap CSS -->
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}

    {{-- sweetalert2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <br><br><br><br><br><br> --}}

    <!------------------------------------------------------------ Book Area ------------------------------------------------------->

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

                <form action="{{ url('bookingsresort') }}" method="post" enctype="multipart/form-data" id="bookingForm">
                    @csrf

                    {{-- Booking Resort Area --}}
                    <div class="custom-tab-content active" data-tab="booking">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{ asset('new/img/book-img.jpg') }}" alt="">
                            </div>
                            <div class="col-md-6">
                                {{-- Hidden Fields --}}
                                <input type="hidden" name="booking_uuid" id="booking_uuid" value="{{ Str::uuid() }}">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                <input type="hidden" name="resort_id" value="{{ $resorts->id }}">
                                <input type="text" class="resort_price" id="resort_price" value="{{ $resorts->price }}">
                                <input type="hidden" name="resort_name" value="{{ $resorts->name }}">
                                <input type="hidden" name="resort_type" value="{{ $resorts->type }}">
                                <input type="hidden" name="owner_id" value="{{ $resorts->user->id }}">
                                <input type="hidden" name="owner_name" value="{{ $resorts->user->name }}">
                                <input type="hidden" name="resort_phone" value="{{ $resorts->phone }}">
                                <input type="hidden" name="resort_email" value="{{ $resorts->email }}">
                                <input type="hidden" name="type_id" value="{{ $resorts->id }}">
                                <input type="hidden" name="type_name" value="{{ $resorts->name }}">
                                <input type="hidden" name="type_category" value="Resort">

                                <div class="inputBox">
                                    <h3>Check-In Date</h3>
                                    <input type="date" required name="checkin_date" id="checkin_date"
                                        class="form-control" onkeydown="return false">
                                </div>

                                <div class="inputBox">
                                    <h3>Check-Out Date</h3>
                                    <input type="date" required name="checkout_date" id="checkout_date"
                                        class="form-control" onkeydown="return false">
                                </div>

                                <div class="inputBox">
                                    <h3>Check-In Time</h3>
                                    <input type="time" required name="checkin_time" id="check_in_time"
                                        class="form-control checkin-time" onkeydown="return false;">
                                </div>

                                <div class="inputBox">
                                    <h3>Check-Out Time</h3>
                                    <input type="time" required name="checkout_time" id="check_out_time"
                                        class="form-control" onkeydown="return false;">
                                </div>

                                <div class="inputBox">
                                    <h3>Select Gender</h3>
                                    <select name="gender" id="gender" class="form-control" required>
                                        @foreach ($genders as $gender)
                                            <option value="{{ $gender->title }}">{{ $gender->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="inputBox">
                                    <h3>Total Quantity Person</h3>
                                    <input type="number" required min="1" max="20" name="quantity"
                                        id="quantity" class="form-control">
                                </div>

                                <div class="inputBox">
                                    <button type="button" id="payment" class="btn">Continue to Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                        <span>Resort Total Price</span>
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

    <br>

    <!------------------------------------------------------------ /.Js Area -------------------------------------------------------->

    <!-- Paypal JS -->
    {{-- <script
        src="https://www.paypal.com/sdk/js?client-id=AeNUnjIv8kLAKJR5ECfdFIfP0TKNb5yHJ1NHamYpTDrDXbf8teHex-lfzlvZHCvxbqeJckM-cDCG2hML&currency=MYR">
    </script> --}}

    {{-- progress bar JS --}}
    <!-- 在 body 标签底部引入 Bootstrap JS 和 jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{-- Toastr New JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <!-- progress bar JS -->
    <script>
        document.getElementById('submit-button').addEventListener('click', function(event) {
            event.preventDefault(); // 阻止表单默认提交行为

            // 显示进度条
            let progressBarContainer = document.getElementById('progressBarContainer');
            progressBarContainer.style.display = 'block';
            let progressBar = document.querySelector('.progress-bar');
            let width = 0;

            let interval = setInterval(function() {
                if (width >= 100) {
                    clearInterval(interval);

                    // 使用 AJAX 提交表单
                    let form = document.getElementById('bookingForm');
                    let formData = new FormData(form);

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Toastify({
                                    text: data.message,
                                    duration: 10000,
                                    style: {
                                        background: "linear-gradient(to right, #00b09b, #96c93d)"
                                    }
                                }).showToast();
                                window.location.href = "{{ route('home') }}";
                            } else {
                                Toastify({
                                    text: data.message,
                                    duration: 10000,
                                    style: {
                                        background: "linear-gradient(to right, #b90000, #c99396)"
                                    }
                                }).showToast();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Toastify({
                                text: 'An error occurred while processing your request.',
                                duration: 10000,
                                style: {
                                    background: "linear-gradient(to right, #b90000, #c99396)"
                                }
                            }).showToast();
                        });
                } else {
                    width += 10;
                    progressBar.style.width = width + '%';
                    progressBar.setAttribute('aria-valuenow', width);
                    progressBar.textContent = width + '%';
                }
            }, 500);
        });
    </script>

    {{-- Calculate Resort Total Price --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkinInput = document.getElementById('checkin_date');
            const checkoutInput = document.getElementById('checkout_date');
            const totalPriceElement = document.getElementById('total_price');
            const resortPrice = parseFloat(document.getElementById('resort_price').value);

            function calculateTotalPrice() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                    const timeDifference = checkoutDate.getTime() - checkinDate.getTime();
                    const dayDifference = timeDifference / (1000 * 3600 * 24);
                    const totalPrice = dayDifference * resortPrice;

                    totalPriceElement.textContent = totalPrice.toFixed(2);

                } else {

                    totalPriceElement.textContent = '0.00';
                }
            }

            checkinInput.addEventListener('change', calculateTotalPrice);
            checkoutInput.addEventListener('change', calculateTotalPrice);
        });
    </script> --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Toastr New JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    {{-- New Toastr --}}
    {{-- <script>
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
    </script> --}}

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

    {{-- Check time --}}
    <script>
        // Define open and close times
        var openTime = '08:00';
        var closeTime = '20:00';

        $('#check_in_time').prop('disabled', true);
        $('#check_out_time').prop('disabled', true);

        //on change booking_date
        $('#checkout_date').change(function() {
            $('#check_in_time').prop('disabled', false);

        });

        //on change check_in_time
        $('#check_in_time').change(function() {

            var check_in_time = $('#check_in_time').val();
            var check_out_time = $('#check_out_time').val();

            if (check_in_time < openTime || check_out_time >= closeTime) {
                alert('Check-in time must be between ' + openTime + ' and ' + closeTime);
                $('#check_in_time').val(''); // Clear the input
                return;
            }

            $('#check_out_time').prop('disabled', false);
        });

        $('#check_out_time').change(function() {
            var check_in_time = $('#check_in_time').val();
            var check_out_time = $('#check_out_time').val();

            if (check_out_time >= closeTime) {
                alert('Check-in time must be between ' + openTime + ' and ' + closeTime);
                $('#check_out_time').val(''); // Clear the input
                return;
            } else if (check_out_time <= check_in_time) {
                alert('Check-out-time must be Grater than ' + check_in_time);
                $('#check_out_time').val(''); // Clear the input
                return;
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

    {{-- New Check and Disabled Calender --}}
    <script>
        var array = {!! json_encode($bookedDates) !!};

        console.log(array);

        // 禁用今天之前的日期
        function disablePastDates() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("checkin_date").setAttribute("min", today);
            document.getElementById("checkout_date").setAttribute("min", today);
        }

        document.getElementById("checkin_date").addEventListener("change", function() {
            var selectedDate = new Date(this.value);
            var formattedDate = selectedDate.getFullYear() + "-" + ("0" + (selectedDate.getMonth() + 1)).slice(-2) +
                "-" + ("0" + selectedDate.getDate()).slice(-2);

            if (array.indexOf(formattedDate) !== -1) {
                this.value = "";
                this.classList.add("custom-disabled-date"); // 添加自定义类
                alert("This day has been booked..");
            } else {
                this.classList.remove("custom-disabled-date"); // 移除自定义类
            }
        });

        document.getElementById("checkout_date").addEventListener("change", function() {
            var selectedDate = new Date(this.value);
            var formattedDate = selectedDate.getFullYear() + "-" + ("0" + (selectedDate.getMonth() + 1)).slice(-2) +
                "-" + ("0" + selectedDate.getDate()).slice(-2);

            if (array.indexOf(formattedDate) !== -1) {
                this.value = "";
                this.classList.add("custom-disabled-date"); // 添加自定义类
                alert("This day has been booked.");
            } else {
                this.classList.remove("custom-disabled-date"); // 移除自定义类
            }
        });

        // 默认加载时禁用过去的日期
        disablePastDates();
    </script>

    <!-- Include jQuery from the CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Pill JS --}}
    <script>
        // JavaScript to handle tab switching
        $(document).ready(function() {
            $('.custom-tab').click(function() {
                console.log('Tab clicked');
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

    <!-- PayPal JS -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=AevCq5WDpuSoYCJlkxHD-N_Yf13gKJmf9sOESVMmYa9lDzN9bVvgfNUqTy4C62CthVk9r5qoEgwDM8Un">
    </script>

    {{-- Final Paypal Payment Method --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkinInput = document.getElementById('checkin_date');
            const checkoutInput = document.getElementById('checkout_date');
            const totalPriceElement = document.getElementById('total_price');
            const resortPrice = parseFloat(document.getElementById('resort_price').value);

            function calculateTotalPrice() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                    const timeDifference = checkoutDate.getTime() - checkinDate.getTime();
                    const dayDifference = timeDifference / (1000 * 3600 * 24);
                    const totalPrice = dayDifference * resortPrice;

                    totalPriceElement.textContent = totalPrice.toFixed(2);
                } else {
                    totalPriceElement.textContent = '0.00';
                }
            }

            checkinInput.addEventListener('change', calculateTotalPrice);
            checkoutInput.addEventListener('change', calculateTotalPrice);

            // Payment method selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            const cardPaymentSection = document.getElementById('card-payment-section');
            const paypalPaymentSection = document.getElementById('paypal-payment-section');
            const paymentMethodInput = document.getElementById('payment_method');

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
                        initializePayPalButtons();
                    }
                });
            });

            function initializePayPalButtons() {
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        const totalPrice = parseFloat(totalPriceElement.innerText.replace('RM ', ''));
                        if (isNaN(totalPrice) || totalPrice <= 0) {
                            alert('Invalid total price. Please check the total price.');
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
                            submitBooking();
                        });
                    }
                }).render('#paypal-button-container');
            }

            document.getElementById('submit-button').addEventListener('click', function(event) {
                event.preventDefault();
                submitBooking();
            });

            function submitBooking() {
                const formData = new FormData(document.getElementById('bookingForm'));
                const paymentMethod = document.getElementById('payment_method').value;

                if (paymentMethod === 'credit_card') {
                    // Add credit card fields to formData
                    formData.append('card_number', document.getElementById('card_number').value);
                    formData.append('card_holder', document.getElementById('card_holder').value);
                    formData.append('card_month', document.getElementById('card_month').value);
                    formData.append('card_year', document.getElementById('card_year').value);
                    formData.append('cvv', document.getElementById('cvv').value);
                } else {
                    // Add dummy values for PayPal
                    formData.append('card_number', '0000000000000000');
                    formData.append('card_holder', 'PayPal User');
                    formData.append('card_month', '01');
                    formData.append('card_year', new Date().getFullYear() + 1);
                    formData.append('cvv', '000');
                }

                fetch('{{ url('bookingsresort') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
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
                    }).catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred while processing your booking.'
                        });
                    });
            }

            // Card input visualization (if needed)
            // const cardNumber = document.querySelector('.card-number-box');
            // const cardHolder = document.querySelector('.card-holder-name');
            // const cardMonth = document.querySelector('.exp-month');
            // const cardYear = document.querySelector('.exp-year');
            // const cardCVV = document.querySelector('.cvv-box');

            // document.querySelector('#card_number').oninput = () => {
            //     cardNumber.innerText = document.querySelector('#card_number').value;
            // }

            // document.querySelector('#card_holder').oninput = () => {
            //     cardHolder.innerText = document.querySelector('#card_holder').value;
            // }

            // document.querySelector('#card_month').oninput = () => {
            //     cardMonth.innerText = document.querySelector('#card_month').value;
            // }

            // document.querySelector('#card_year').oninput = () => {
            //     cardYear.innerText = document.querySelector('#card_year').value;
            // }

            // document.querySelector('#cvv').onmouseenter = () => {
            //     document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)';
            //     document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)';
            // }

            // document.querySelector('#cvv').onmouseleave = () => {
            //     document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)';
            //     document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)';
            // }

            // document.querySelector('#cvv').oninput = () => {
            //     cardCVV.innerText = document.querySelector('#cvv').value;
            // }
        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkinInput = document.getElementById('checkin_date');
            const checkoutInput = document.getElementById('checkout_date');
            const totalPriceElement = document.getElementById('total_price');
            const resortPriceElement = document.getElementById('resort_price');
            const resortPrice = parseFloat(resortPriceElement.value);

            // 将促销日期和价格转换为更易于使用的格式
            const promotionDatesWithPrices = {};
            const rawPromotions = @json($promotionDatesWithPricesObject);
            rawPromotions.forEach(promo => {
                promotionDatesWithPrices[promo.date] = parseFloat(promo.price);
            });

            function calculateTotalPrice() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                    let totalPrice = 0;
                    let currentDate = new Date(checkinDate);

                    while (currentDate < checkoutDate) {
                        const dateString = currentDate.toISOString().split('T')[0];
                        const promotionPrice = promotionDatesWithPrices[dateString];

                        if (promotionPrice !== undefined) {
                            totalPrice += promotionPrice;
                        } else {
                            totalPrice += resortPrice;
                        }

                        console.log('totalPrice',totalPrice)

                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    totalPriceElement.textContent = totalPrice.toFixed(2);
                } else {
                    totalPriceElement.textContent = '0.00';
                }
            }

            function updateResortPrice() {
                const checkinDate = new Date(checkinInput.value);
                // 确保日期格式与促销日期格式匹配
                const dateString = checkinDate.toISOString().split('T')[0];
                const promotionPrice = promotionDatesWithPrices[dateString];

                console.log('Current promotions:', promotionDatesWithPrices);
                console.log('Checking date:', dateString);
                console.log('Found price:', promotionPrice);

                if (promotionPrice !== undefined) {
                    resortPriceElement.value = promotionPrice.toFixed(2);
                } else {
                    resortPriceElement.value = resortPrice.toFixed(2);
                }

                calculateTotalPrice();
            }

            // 监听日期输入变化事件
            checkinInput.addEventListener('change', updateResortPrice);
            checkoutInput.addEventListener('change', calculateTotalPrice);

            // Payment method selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            const cardPaymentSection = document.getElementById('card-payment-section');
            const paypalPaymentSection = document.getElementById('paypal-payment-section');
            const paymentMethodInput = document.getElementById('payment_method');

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
                        initializePayPalButtons();
                    }
                });
            });

            function initializePayPalButtons() {
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        const totalPrice = parseFloat(totalPriceElement.innerText.replace('RM ', ''));
                        if (isNaN(totalPrice) || totalPrice <= 0) {
                            alert('Invalid total price. Please check the total price.');
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
                            submitBooking();
                        });
                    }
                }).render('#paypal-button-container');
            }

            document.getElementById('submit-button').addEventListener('click', function(event) {
                event.preventDefault();
                submitBooking();
            });

            function submitBooking() {
                const formData = new FormData(document.getElementById('bookingForm'));
                const paymentMethod = document.getElementById('payment_method').value;

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

                fetch('{{ url('bookingsresort') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
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
                    }).catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred while processing your booking.'
                        });
                    });
            }
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkinInput = document.getElementById('checkin_date');
            const checkoutInput = document.getElementById('checkout_date');
            const totalPriceElement = document.getElementById('total_price');
            const resortPriceElement = document.getElementById('resort_price');
            const resortPrice = parseFloat(resortPriceElement.value); // 获取原始价格185

            // 将促销日期和价格转换为更易于使用的格式
            // const promotionDatesWithPrices = {};
            // const rawPromotions = @json($promotionDatesWithPricesObject);
            // rawPromotions.forEach(promo => {
            //     promotionDatesWithPrices[promo.date] = parseFloat(promo.price);
            // });

            // function getEarlyBookingDiscount(bookingDate, promotionDate) {
            //     // 计算预订日期与促销日期之间的月份差
            //     const bookingDateTime = new Date(bookingDate);
            //     const promotionDateTime = new Date(promotionDate);
            //     const monthsDiff = (promotionDateTime.getFullYear() - bookingDateTime.getFullYear()) * 12 +
            //         (promotionDateTime.getMonth() - bookingDateTime.getMonth());

            //     // 根据提前预订月数返回折扣比例
            //     if (monthsDiff >= 2) {
            //         return 0.5; // 提前2个月或以上，打5折
            //     } else if (monthsDiff >= 1) {
            //         return 0.7; // 提前1个月，打7折
            //     }
            //     return 1; // 不到1个月，原价
            // }

            // // 新添加的基于住宿天数的折扣函数
            // function getDurationDiscount(nights) {
            //     if (nights >= 7) {
            //         return 0.5; // 住宿7天或以上，打5折
            //     } else if (nights >= 5) {
            //         return 0.7; // 住宿5-6天，打7折
            //     }
            //     return 1; // 少于5天，原价
            // }

            // function calculateTotalPrice() {
            //     const checkinDate = new Date(checkinInput.value);
            //     const checkoutDate = new Date(checkoutInput.value);

            //     if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
            //         let totalPrice = 0;
            //         let currentDate = new Date(checkinDate);

            //         // 计算住宿天数
            //         const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
            //         const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

            //         console.log('Number of nights:', nights);

            //         // 遍历每一天直到退房日期的前一天
            //         for (let i = 0; i < nights; i++) {
            //             const dateString = currentDate.toISOString().split('T')[0];
            //             console.log('Checking date:', dateString);

            //             // 检查是否为促销日期
            //             let dayPrice = promotionDatesWithPrices[dateString];
            //             console.log('Promotion price:', dayPrice);
            //             console.log('Resort price:', resortPrice);

            //             if (dayPrice !== undefined) {
            //                 // 如果是促销日期，先记录原始促销价格
            //                 const originalPromotionPrice = dayPrice;
            //                 console.log('Found promotion price:', originalPromotionPrice);

            //                 // 然后检查是否符合提前预订折扣条件
            //                 const today = new Date();
            //                 const earlyBookingDiscount = getEarlyBookingDiscount(today, dateString);
            //                 dayPrice = originalPromotionPrice * earlyBookingDiscount;

            //                 console.log('Applied early booking discount:', earlyBookingDiscount);
            //                 console.log('Final price after discount:', dayPrice);
            //                 totalPrice += dayPrice;
            //             } else {
            //                 console.log('Using regular price:', resortPrice);
            //                 totalPrice += resortPrice;
            //             }

            //             currentDate.setDate(currentDate.getDate() + 1);
            //         }

            //         // 应用住宿天数折扣
            //         const durationDiscount = getDurationDiscount(nights);
            //         totalPrice = totalPrice * durationDiscount;

            //         console.log('Duration discount applied:', durationDiscount);
            //         console.log('Final total price:', totalPrice);
            //         totalPriceElement.textContent = totalPrice.toFixed(2);
            //     } else {
            //         totalPriceElement.textContent = '0.00';
            //     }
            // }

            // function updateResortPrice() {
            //     const checkinDate = new Date(checkinInput.value);
            //     const dateString = checkinInput.value;

            //     console.log('Current promotions:', promotionDatesWithPrices);
            //     console.log('Selected check-in date:', dateString);

            //     const promotionPrice = promotionDatesWithPrices[dateString];
            //     console.log('Found promotion price:', promotionPrice);

            //     if (promotionPrice !== undefined) {
            //         // 如果是促销日期，检查是否符合提前预订折扣条件
            //         const today = new Date();
            //         const earlyBookingDiscount = getEarlyBookingDiscount(today, dateString);
            //         const finalPrice = promotionPrice * earlyBookingDiscount;
            //         resortPriceElement.value = finalPrice.toFixed(2);
            //         console.log('Applied early booking discount:', earlyBookingDiscount);
            //         console.log('Final price:', finalPrice);
            //     } else {
            //         console.log('Using resort price:', resortPrice);
            //         resortPriceElement.value = resortPrice.toFixed(2);
            //     }

            //     calculateTotalPrice();
            // }

            // // 监听日期输入变化事件
            // checkinInput.addEventListener('change', updateResortPrice);
            // checkoutInput.addEventListener('change', calculateTotalPrice);

            // 将促销日期和价格转换为更易于使用的格式
            const promotionDatesWithPrices = {};
            const rawPromotions = @json($promotionDatesWithPricesObject);
            rawPromotions.forEach(promo => {
                promotionDatesWithPrices[promo.date] = parseFloat(promo.price);
            });

            // 获取度假村折扣信息
            const resortDiscounts = @json($discounts);

            function getEarlyBookingDiscount(bookingDate, promotionDate) {
                // 计算预订日期与促销日期之间的月份差
                const bookingDateTime = new Date(bookingDate);
                const promotionDateTime = new Date(promotionDate);
                const monthsDiff = (promotionDateTime.getFullYear() - bookingDateTime.getFullYear()) * 12 +
                    (promotionDateTime.getMonth() - bookingDateTime.getMonth());

                // 根据提前预订月数返回折扣比例
                if (monthsDiff >= 2) {
                    return 0.5; // 提前2个月或以上，打5折
                } else if (monthsDiff >= 1) {
                    return 0.7; // 提前1个月，打7折
                }
                return 1; // 不到1个月，原价
            }

            // 修改后的基于住宿天数的折扣函数，使用ResortDiscount数据
            function getDurationDiscount(nights) {
                // 按住宿天数从高到低排序折扣
                const sortedDiscounts = resortDiscounts.sort((a, b) => b.nights - a.nights);

                // 遍历排序后的折扣，找到第一个符合条件的折扣
                for (const discount of sortedDiscounts) {
                    if (nights >= discount.nights) {
                        return discount.discount / 100; // 将百分比转换为小数
                    }
                }

                return 1; // 如果没有找到匹配的折扣，返回原价
            }

            function calculateTotalPrice() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                    let totalPrice = 0;
                    let currentDate = new Date(checkinDate);

                    // 计算住宿天数
                    const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
                    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    console.log('Number of nights:', nights);

                    // 遍历每一天直到退房日期的前一天
                    for (let i = 0; i < nights; i++) {
                        const dateString = currentDate.toISOString().split('T')[0];
                        console.log('Checking date:', dateString);

                        // 检查是否为促销日期
                        let dayPrice = promotionDatesWithPrices[dateString];
                        console.log('Promotion price:', dayPrice);
                        console.log('Resort price:', resortPrice);

                        if (dayPrice !== undefined) {
                            // 如果是促销日期，先记录原始促销价格
                            const originalPromotionPrice = dayPrice;
                            console.log('Found promotion price:', originalPromotionPrice);

                            // 然后检查是否符合提前预订折扣条件
                            const today = new Date();
                            const earlyBookingDiscount = getEarlyBookingDiscount(today, dateString);
                            dayPrice = originalPromotionPrice * earlyBookingDiscount;

                            console.log('Applied early booking discount:', earlyBookingDiscount);
                            console.log('Final price after discount:', dayPrice);
                            totalPrice += dayPrice;
                        } else {
                            console.log('Using regular price:', resortPrice);
                            totalPrice += resortPrice;
                        }

                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    // 应用住宿天数折扣
                    const durationDiscount = getDurationDiscount(nights);
                    totalPrice = totalPrice * durationDiscount;

                    console.log('Duration discount applied:', durationDiscount);
                    console.log('Final total price:', totalPrice);
                    totalPriceElement.textContent = totalPrice.toFixed(2);
                } else {
                    totalPriceElement.textContent = '0.00';
                }
            }

            function updateResortPrice() {
                const checkinDate = new Date(checkinInput.value);
                const dateString = checkinInput.value;

                console.log('Current promotions:', promotionDatesWithPrices);
                console.log('Selected check-in date:', dateString);

                const promotionPrice = promotionDatesWithPrices[dateString];
                console.log('Found promotion price:', promotionPrice);

                if (promotionPrice !== undefined) {
                    // 如果是促销日期，检查是否符合提前预订折扣条件
                    const today = new Date();
                    const earlyBookingDiscount = getEarlyBookingDiscount(today, dateString);
                    const finalPrice = promotionPrice * earlyBookingDiscount;
                    resortPriceElement.value = finalPrice.toFixed(2);
                    console.log('Applied early booking discount:', earlyBookingDiscount);
                    console.log('Final price:', finalPrice);
                } else {
                    console.log('Using resort price:', resortPrice);
                    resortPriceElement.value = resortPrice.toFixed(2);
                }

                calculateTotalPrice();
            }

            // 监听日期输入变化事件
            checkinInput.addEventListener('change', updateResortPrice);
            checkoutInput.addEventListener('change', calculateTotalPrice);

            // Payment method selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            const cardPaymentSection = document.getElementById('card-payment-section');
            const paypalPaymentSection = document.getElementById('paypal-payment-section');
            const paymentMethodInput = document.getElementById('payment_method');

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
                        initializePayPalButtons();
                    }
                });
            });

            function initializePayPalButtons() {
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        const totalPrice = parseFloat(totalPriceElement.innerText.replace('RM ', ''));
                        if (isNaN(totalPrice) || totalPrice <= 0) {
                            alert('Invalid total price. Please check the total price.');
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
                            submitBooking();
                        });
                    }
                }).render('#paypal-button-container');
            }

            document.getElementById('submit-button').addEventListener('click', function(event) {
                event.preventDefault();
                submitBooking();
            });

            function submitBooking() {
                const formData = new FormData(document.getElementById('bookingForm'));
                const paymentMethod = document.getElementById('payment_method').value;

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

                fetch('{{ url('bookingsresort') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
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
                    }).catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred while processing your booking.'
                        });
                    });
            }
        });
    </script>

    {{-- Paypal Payment Method --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkinInput = document.getElementById('checkin_date');
            const checkoutInput = document.getElementById('checkout_date');
            const totalPriceElement = document.getElementById('total_price');
            const resortPrice = parseFloat(document.getElementById('resort_price').value);

            function calculateTotalPrice() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                    const timeDifference = checkoutDate.getTime() - checkinDate.getTime();
                    const dayDifference = timeDifference / (1000 * 3600 * 24);
                    const totalPrice = dayDifference * resortPrice;

                    totalPriceElement.textContent = totalPrice.toFixed(2);

                } else {
                    totalPriceElement.textContent = '0.00';
                }
            }

            checkinInput.addEventListener('change', calculateTotalPrice);
            checkoutInput.addEventListener('change', calculateTotalPrice);

            // Payment method selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            const cardPaymentSection = document.getElementById('card-payment-section');
            const paypalPaymentSection = document.getElementById('paypal-payment-section');
            const paymentMethodInput = document.getElementById('payment_method');

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
                        // Initialize PayPal buttons when PayPal is selected
                        initializePayPalButtons();
                    }
                });
            });

            function initializePayPalButtons() {
                paypal.Buttons({
                    createOrder: function(data, actions) {
                        // Get the total price from the total_price span
                        const totalPrice = parseFloat(totalPriceElement.innerText.replace('RM ', ''));
                        if (isNaN(totalPrice) || totalPrice <= 0) {
                            alert('Invalid total price. Please check the total price.');
                            return;
                        }
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: totalPrice.toFixed(2) // Use the actual total price
                                }
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                            alert('Transaction completed by ' + details.payer.name.given_name);
                            // Submit the form after successful payment
                            document.getElementById('bookingForm').submit();
                        });
                    }
                }).render('#paypal-button-container');
            }

            // Handle form submission for PayPal payment
            document.getElementById('bookingForm').addEventListener('submit', function(event) {
                event.preventDefault();

                const paymentMethod = document.getElementById('payment_method').value;

                if (paymentMethod === 'paypal') {
                    // Submit the form via AJAX
                    const formData = new FormData(this);

                    // Fill in valid dummy values for card fields to avoid validation errors
                    formData.append('card_number', '4111 1111 1111 1111'); // Valid test card number
                    formData.append('card_holder', 'John Doe');
                    formData.append('card_month', '12');
                    formData.append('card_year', new Date().getFullYear() + 1);
                    formData.append('cvv', '123');

                    fetch('{{ url('bookingsresort') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            window.location.href = '{{ route('home') }}';
                        } else {
                            alert('Payment failed: ' + data.message);
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while processing your payment.');
                    });
                } else {
                    // Submit the form normally for credit card payment
                    this.submit();
                }
            });
        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables
            const form = document.getElementById('bookingForm');
            const paymentMethod = document.getElementById('payment_method');
            const cardSection = document.getElementById('card-payment-section');
            const paypalSection = document.getElementById('paypal-payment-section');
            const submitButton = document.getElementById('submit-button');
            const progressBar = document.getElementById('progressBarContainer');
            const cardInputs = document.querySelectorAll(
                '#card-payment-section input, #card-payment-section select');
            const resortPrice = parseFloat(document.getElementById('resort_price').value);

            // Payment method selection
            document.querySelectorAll('.payment-option').forEach(option => {
                option.addEventListener('click', function() {
                    const method = this.dataset.method;
                    paymentMethod.value = method;

                    // Update UI
                    document.querySelectorAll('.payment-option').forEach(opt => {
                        opt.classList.remove('active');
                    });
                    this.classList.add('active');

                    // Show/hide relevant sections
                    if (method === 'paypal') {
                        cardSection.style.display = 'none';
                        paypalSection.style.display = 'block';
                        submitButton.style.display = 'none';
                        cardInputs.forEach(input => input.required = false);
                    } else {
                        cardSection.style.display = 'block';
                        paypalSection.style.display = 'none';
                        submitButton.style.display = 'block';
                        cardInputs.forEach(input => input.required = true);
                    }
                });
            });

            // Initialize PayPal
            paypal.Buttons({
                createOrder: function(data, actions) {
                    const totalPrice = document.getElementById('total_price').textContent;
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                currency_code: 'MYR', // 使用货币代码
                                value: totalPrice.toFixed(2) // 确保金额格式正确
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        document.getElementById('progressBarContainer').style.display = 'block';
                        document.querySelector('.progress-bar').style.width = '100%';

                        const form = document.getElementById('bookingForm');
                        const paypalDetailsInput = document.createElement('input');
                        paypalDetailsInput.type = 'hidden';
                        paypalDetailsInput.name = 'paypal_details';
                        paypalDetailsInput.value = JSON.stringify(details);
                        form.appendChild(paypalDetailsInput);
                        form.submit();
                    });
                },
                onError: function(err) {
                    console.error('PayPal Error:', err);
                    alert('There was an error processing your PayPal payment. Please try again.');
                }
            }).render('#paypal-button-container');


            // Calculate total price
            const checkinDate = document.getElementById('checkin_date');
            const checkoutDate = document.getElementById('checkout_date');
            const totalPriceSpan = document.getElementById('total_price');

            function calculateTotalPrice() {
                const checkin = new Date(checkinDate.value);
                const checkout = new Date(checkoutDate.value);
                const days = (checkout - checkin) / (1000 * 60 * 60 * 24);
                const totalPrice = resortPrice * days;
                totalPriceSpan.textContent = totalPrice.toFixed(2);
            }

            checkinDate.addEventListener('change', calculateTotalPrice);
            checkoutDate.addEventListener('change', calculateTotalPrice);

            // Initial calculation
            calculateTotalPrice();
        });
    </script> --}}
@endsection
