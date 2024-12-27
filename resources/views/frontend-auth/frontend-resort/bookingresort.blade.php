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

    {{-- Notification CSS --}}
    <style>
        .notifications {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .notification {
            flex: 1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            /* Enable vertical scrolling */
            max-height: 200px;
            /* Set a maximum height for scrolling */
        }

        .notification h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .promotion {
            background-color: #e6f3ff;
            margin-right: 15px;
        }

        .discount {
            background-color: #e6ffe6;
            margin-left: 15px;
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

        {{-- Promotion and Discount Notification --}}
        <div class="notifications">
            <div class="notification promotion">
                <h2>Current Promotion</h2>
                <div id="promotion-content"></div>
            </div>
            <div class="notification discount">
                <h2>Special Discount</h2>
                <div id="discount-content"></div>
            </div>
        </div>

        {{-- Booking Form --}}
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
                                {{-- <input type="hidden" name="booking_uuid" id="booking_uuid" value="{{ Str::uuid() }}"> --}}
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                <input type="hidden" name="resort_id" value="{{ $resorts->id }}">
                                <input type="hidden" class="resort_price" id="resort_price" value="{{ $resorts->price }}">
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
    {{-- <script>
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
    </script> --}}

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
            const resortPriceElement = document.getElementById('resort_price');
            const resortPrice = parseFloat(resortPriceElement.value); // 获取原始价格185

            // JavaScript 部分
            // 从 Blade 模板中获取促销日期和价格对象
            const promotionDatesWithPricesObject = @json($promotionDatesWithPricesObject);

            console.log(promotionDatesWithPricesObject);

            // 将促销日期和价格转换为更易于使用的格式
            const promotionDatesWithPrices = {};
            promotionDatesWithPricesObject.forEach(promo => {
                promotionDatesWithPrices[promo.date] = Number(promo.price);
            });

            // 获取度假村折扣信息
            const resortDiscounts = @json($discounts);

            console.log(resortDiscounts);

            // Handle and insert promotion data
            const promotionContent = document.getElementById('promotion-content');
            if (Object.keys(promotionDatesWithPrices).length === 0) {
                const p = document.createElement('p');
                p.className = 'no-content';
                p.innerText = 'No promotions available';
                promotionContent.appendChild(p);
            } else {
                for (const [date, price] of Object.entries(promotionDatesWithPrices)) {
                    const p = document.createElement('p');
                    p.innerText = `[Date: ${date} ] - [Price now is ${price}]`;
                    promotionContent.appendChild(p);
                }
            }

            // Handle and insert discount data
            const discountContent = document.getElementById('discount-content');
            if (resortDiscounts.length === 0) {
                const p = document.createElement('p');
                p.className = 'no-content';
                p.innerText = 'No discounts available';
                discountContent.appendChild(p);
            } else {
                resortDiscounts.forEach(discount => {
                    const p = document.createElement('p');
                    p.innerText =
                        `Booking dates more than or equal ${discount.nights} days discount ${discount.discount}%`;
                    discountContent.appendChild(p);
                });
            }

            function getEarlyBookingDiscount(bookingDate, promotionDate) {
                const bookingDateTime = new Date(bookingDate);
                const promotionDateTime = new Date(promotionDate);
                const monthsDiff = (promotionDateTime.getFullYear() - bookingDateTime.getFullYear()) * 12 +
                    (promotionDateTime.getMonth() - bookingDateTime.getMonth());

                if (monthsDiff >= 2) {
                    return 0.5;
                } else if (monthsDiff >= 1) {
                    return 0.7;
                }
                return 1;
            }

            function getDurationDiscount(nights) {
                const sortedDiscounts = resortDiscounts.sort((a, b) => b.nights - a.nights);

                for (const discount of sortedDiscounts) {
                    if (nights >= discount.nights) {
                        return discount.discount / 100;
                    }
                }
                return 1;
            }

            function calculateTotalPrice() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                    let totalPrice = 0;
                    let currentDate = new Date(checkinDate);

                    const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
                    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    console.log('Number of nights:', nights);

                    for (let i = 0; i < nights; i++) {
                        const dateString = currentDate.toISOString().split('T')[0];
                        console.log('Checking date:', dateString);

                        let dayPrice = promotionDatesWithPrices[dateString];
                        console.log('Promotion price:', dayPrice);
                        console.log('Resort price:', resortPrice);

                        if (dayPrice !== undefined) {
                            const originalPromotionPrice = dayPrice;
                            console.log('Found promotion price:', originalPromotionPrice);

                            const today = new Date();
                            const earlyBookingDiscount = getEarlyBookingDiscount(today, dateString);
                            dayPrice = originalPromotionPrice * earlyBookingDiscount;

                            console.log('Applied early booking discount:', earlyBookingDiscount);
                            console.log('Final price after discount:', dayPrice);
                            totalPrice += dayPrice;
                        } else {
                            console.log('Using regular price:', resortPrice);
                            totalPrice += Number(resortPrice);
                        }

                        currentDate.setDate(currentDate.getDate() + 1);
                    }

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
                const dateString = checkinInput.value;

                console.log('Current promotions:', promotionDatesWithPrices);
                console.log('Selected check-in date:', dateString);

                const promotionPrice = promotionDatesWithPrices[dateString];
                console.log('Found promotion price:', promotionPrice);

                if (promotionPrice !== undefined) {
                    const today = new Date();
                    const earlyBookingDiscount = getEarlyBookingDiscount(today, dateString);
                    const finalPrice = promotionPrice * earlyBookingDiscount;
                    resortPriceElement.value = finalPrice.toFixed(2);
                    console.log('Applied early booking discount:', earlyBookingDiscount);
                    console.log('Final price:', finalPrice);
                } else {
                    console.log('Using resort price:', resortPrice);
                    resortPriceElement.value = Number(resortPrice).toFixed(2);
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

            let isSubmitting = false; // 防止重复提交的标志

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

            function submitBooking(source = 'button') {
                if (isSubmitting) {
                    console.log('Submission in progress, please wait...');
                    return;
                }

                isSubmitting = true;

                const formData = new FormData(document.getElementById('bookingForm'));
                const paymentMethod = document.getElementById('payment_method').value;

                // 添加价格数据
                const totalPrice = parseFloat(totalPriceElement.textContent);
                formData.append('total_price', totalPrice);

                const currentResortPrice = parseFloat(resortPriceElement.value);
                formData.append('resort_price', currentResortPrice);

                // 添加提交来源
                formData.append('submission_source', source);

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
                    })
                    .then(response => response.json())
                    .then(data => {
                        isSubmitting = false;
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
                        isSubmitting = false;
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
            const resortPrice = parseFloat(resortPriceElement.value);
            const depositFee = 100.00; // Fixed deposit fee

            // Get promotion dates and prices from Blade template
            const promotionDatesWithPricesObject = @json($promotionDatesWithPricesObject);
            const promotionDatesWithPrices = {};
            promotionDatesWithPricesObject.forEach(promo => {
                promotionDatesWithPrices[promo.date] = Number(promo.price);
            });

            // Get resort discounts
            const resortDiscounts = @json($discounts);

            // Handle promotions display
            const promotionContent = document.getElementById('promotion-content');
            if (Object.keys(promotionDatesWithPrices).length === 0) {
                promotionContent.innerHTML = '<p class="no-content">No promotions available</p>';
            } else {
                promotionContent.innerHTML = Object.entries(promotionDatesWithPrices)
                    .map(([date, price]) => `<p>[Date: ${date}] - [Price now is ${price}]</p>`)
                    .join('');
            }

            // Handle discounts display
            const discountContent = document.getElementById('discount-content');
            if (resortDiscounts.length === 0) {
                discountContent.innerHTML = '<p class="no-content">No discounts available</p>';
            } else {
                discountContent.innerHTML = resortDiscounts
                    .map(discount =>
                        `<p>Booking dates more than or equal ${discount.nights} days discount ${discount.discount}%</p>`
                    )
                    .join('');
            }

            function getEarlyBookingDiscount(bookingDate, promotionDate) {
                const bookingDateTime = new Date(bookingDate);
                const promotionDateTime = new Date(promotionDate);
                const monthsDiff = (promotionDateTime.getFullYear() - bookingDateTime.getFullYear()) * 12 +
                    (promotionDateTime.getMonth() - bookingDateTime.getMonth());

                if (monthsDiff >= 2) return 0.5;
                if (monthsDiff >= 1) return 0.7;
                return 1;
            }

            function getDurationDiscount(nights) {
                const sortedDiscounts = resortDiscounts.sort((a, b) => b.nights - a.nights);
                for (const discount of sortedDiscounts) {
                    if (nights >= discount.nights) {
                        return discount.discount / 100;
                    }
                }
                return 1;
            }

            function calculateTotalPrice() {
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkinDate && checkoutDate && checkoutDate > checkinDate) {
                    let subtotal = 0;
                    let currentDate = new Date(checkinDate);

                    const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
                    const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    for (let i = 0; i < nights; i++) {
                        const dateString = currentDate.toISOString().split('T')[0];
                        let dayPrice = promotionDatesWithPrices[dateString];

                        if (dayPrice !== undefined) {
                            const today = new Date();
                            const earlyBookingDiscount = getEarlyBookingDiscount(today, dateString);
                            dayPrice = dayPrice * earlyBookingDiscount;
                            subtotal += dayPrice;
                        } else {
                            subtotal += Number(resortPrice);
                        }

                        currentDate.setDate(currentDate.getDate() + 1);
                    }

                    const durationDiscount = getDurationDiscount(nights);
                    subtotal = subtotal * durationDiscount;

                    // Add deposit fee to final total
                    const finalTotal = subtotal + depositFee;

                    totalPriceElement.textContent = finalTotal.toFixed(2);
                    return finalTotal;
                } else {
                    totalPriceElement.textContent = '0.00';
                    return 0;
                }
            }

            function updateResortPrice() {
                const dateString = checkinInput.value;
                const promotionPrice = promotionDatesWithPrices[dateString];

                if (promotionPrice !== undefined) {
                    const today = new Date();
                    const earlyBookingDiscount = getEarlyBookingDiscount(today, dateString);
                    const finalPrice = promotionPrice * earlyBookingDiscount;
                    resortPriceElement.value = finalPrice.toFixed(2);
                } else {
                    resortPriceElement.value = Number(resortPrice).toFixed(2);
                }

                calculateTotalPrice();
            }

            // Event listeners for date inputs
            checkinInput.addEventListener('change', updateResortPrice);
            checkoutInput.addEventListener('change', calculateTotalPrice);

            // Payment method handling
            const paymentOptions = document.querySelectorAll('.payment-option');
            const cardPaymentSection = document.getElementById('card-payment-section');
            const paypalPaymentSection = document.getElementById('paypal-payment-section');
            const paymentMethodInput = document.getElementById('payment_method');

            // Submission state tracking
            let isSubmitting = false;
            let hasSubmitted = false;

            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    if (isSubmitting) return;

                    paymentOptions.forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                    const method = this.getAttribute('data-method');
                    paymentMethodInput.value = method;

                    cardPaymentSection.style.display = method === 'credit_card' ? 'block' : 'none';
                    paypalPaymentSection.style.display = method === 'paypal' ? 'block' : 'none';

                    if (method === 'paypal') {
                        initializePayPalButtons();
                    }
                });
            });

            function initializePayPalButtons() {
                if (document.querySelector('#paypal-button-container').children.length > 0) {
                    return; // Prevent multiple PayPal button initializations
                }

                paypal.Buttons({
                    createOrder: function(data, actions) {
                        const displayedTotalPrice = parseFloat(document.getElementById('total_price')
                            .textContent);
                        const totalPrice = displayedTotalPrice || 0;

                        if (isNaN(totalPrice) || totalPrice <= 0) {
                            alert('Invalid total price. Please check your booking details.');
                            return null;
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
                            if (!hasSubmitted) {
                                submitBooking('paypal');
                            }
                        });
                    }
                }).render('#paypal-button-container');
            }

            function submitBooking(source = 'credit_card') {
                if (isSubmitting || hasSubmitted) {
                    console.log('Submission already in progress or completed');
                    return;
                }

                isSubmitting = true;
                hasSubmitted = true;

                // Disable the submit button to prevent multiple submissions
                const submitButton = document.getElementById('submit-button');
                submitButton.disabled = true;

                // Show progress bar
                const progressBarContainer = document.getElementById('progressBarContainer');
                progressBarContainer.style.display = 'block';
                const progressBar = document.querySelector('.progress-bar');
                let width = 0;

                const interval = setInterval(function () {
                    if (width >= 100) {
                        clearInterval(interval);
                    } else {
                        width += 10;
                        progressBar.style.width = width + '%';
                        progressBar.setAttribute('aria-valuenow', width);
                        progressBar.textContent = width + '%';
                    }
                }, 500);

                const formData = new FormData(document.getElementById('bookingForm'));
                const paymentMethod = document.getElementById('payment_method').value;

                // Get the total price directly from the display element
                const displayedTotalPrice = parseFloat(document.getElementById('total_price').textContent);
                const totalPrice = displayedTotalPrice || 0;

                // Add price data
                formData.append('total_price', totalPrice);

                // console.log(totalPrice);

                formData.append('resort_price', resortPriceElement.value);
                formData.append('submission_source', source);

                // Handle payment details
                if (paymentMethod === 'credit_card') {
                    formData.append('card_number', document.getElementById('card_number').value);
                    formData.append('card_holder', document.getElementById('card_holder').value);
                    formData.append('card_month', document.getElementById('card_month').value);
                    formData.append('card_year', document.getElementById('card_year').value);
                    formData.append('cvv', document.getElementById('cvv').value);
                } else {
                    // PayPal placeholder data
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
                        hasSubmitted = false; // Allow retry on failure
                        Swal.fire({
                            icon: 'error',
                            title: 'Booking Failed',
                            text: data.message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hasSubmitted = false; // Allow retry on error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while processing your booking.'
                    });
                })
                .finally(() => {
                    isSubmitting = false;
                    // Re-enable the submit button
                    submitButton.disabled = false;
                    // Hide progress bar
                    progressBarContainer.style.display = 'none';
                    progressBar.style.width = '0%';
                    progressBar.setAttribute('aria-valuenow', 0);
                    progressBar.textContent = '0%';
                });
            }

            // Add event listener to the submit button
            document.getElementById('submit-button').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default form submission
                submitBooking();
            }, { once: true }); // Ensure the event listener is only added once
        });
    </script>

@endsection
