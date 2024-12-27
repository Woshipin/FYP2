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

                <form action="{{ url('bookingsrestaurant') }}" method="post" enctype="multipart/form-data" id="bookingForm">
                    @csrf

                    {{-- Booking Restaurant Area --}}
                    <div class="custom-tab-content active" data-tab="booking">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{ asset('new/img/book-img.jpg') }}" alt="">
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                <input type="hidden" name="restaurant_id" value="{{ $restaurants->id }}">
                                <input type="hidden" name="type_name" value="{{ $restaurants->name }}">
                                <input type="hidden" name="owner_id" value="{{ $restaurants->user->id }}">
                                <input type="hidden" name="owner_name" value="{{ $restaurants->user->name }}">
                                <input type="hidden" name="restaurant_email" value="{{ $restaurants->email }}">
                                <input type="hidden" name="restaurant_phone" value="{{ $restaurants->phone }}">
                                <input type="hidden" name="restaurant_name" value="{{ $restaurants->name }}">
                                <input type="hidden" name="restaurant_type" value="{{ $restaurants->type }}">
                                <input type="hidden" name="type_id" value="{{ $restaurants->id }}">
                                <input type="hidden" name="type_name" value="{{ $restaurants->name }}">
                                <input type="hidden" name="type_category" value="Restaurant">

                                <div class="inputBox">
                                    <h3>Booking Date</h3>
                                    <input type="date" required name="booking_date" id="booking_date" class="form-control" placeholder="Select Your Booking Date">
                                </div>
                                <div class="inputBox">
                                    <h3>Check-In Time</h3>
                                    <input type="time" required name="checkin_time" id="checkin_time" class="form-control checkin-time" placeholder="Select Your Check-In Time">
                                </div>
                                <div class="inputBox">
                                    <h3>Check-Out Time</h3>
                                    <input type="time" required name="checkout_time" id="checkout_time" class="form-control" placeholder="Select Your Check-Out Time">
                                </div>
                                <div class="inputBox">
                                    <h3>Select Table</h3>
                                    <select class="form-control custom-select" id="table-select" name="table_id" required>
                                        <option value="0" selected disabled>--- Select A Table ---</option>
                                    </select>
                                </div>
                                <div class="inputBox">
                                    <h3>Select Gender</h3>
                                    <select name="gender" id="gender" class="form-control custom-select" required>
                                        @foreach (\$genders as \$gender)
                                            <option value="{{ \$gender->title }}">{{ \$gender->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="inputBox">
                                    <h3>Total Quantity Person</h3>
                                    <input type="number" required min="1" max="20" name="quantity" id="quantity" class="form-control" placeholder="Enter Total Quantity" oninput="validateQuantity(this)">
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
                                            <input type="text" id="card_number" name="card_number" maxlength="19" class="card-input" placeholder="0000 0000 0000 0000">
                                        </div>
                                        <div class="input-group">
                                            <label>Card Holder Name</label>
                                            <input type="text" name="card_holder" id="card_holder" class="card-input">
                                        </div>
                                        <div class="card-extra-details">
                                            <div class="input-group">
                                                <label>Expiry Month</label>
                                                <select name="card_month" id="card_month" class="card-input">
                                                    <option value="" selected disabled>MM</option>
                                                    @for (\$i = 1; \$i <= 12; \$i++)
                                                        <option value="{{ sprintf('%02d', \$i) }}">{{ sprintf('%02d', \$i) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="input-group">
                                                <label>Expiry Year</label>
                                                <select name="card_year" id="card_year" class="card-input">
                                                    <option value="" selected disabled>YY</option>
                                                    @for (\$i = date('Y'); \$i <= date('Y') + 10; \$i++)
                                                        <option value="{{ \$i }}">{{ \$i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="input-group">
                                                <label>CVV</label>
                                                <input type="text" name="cvv" id="cvv" maxlength="4" class="card-input">
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
                                        <p class="paypal-description">Click the button below to pay securely with PayPal</p>
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
                                </div>

                                <!-- Submit Button (for card payment) -->
                                <button type="submit" class="submit-button" id="submit-button">Complete Payment</button>

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

    <!-- /.container-fluid -->

    <!------------------------------------------------------------ /.Js Area -------------------------------------------------------->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AevCq5WDpuSoYCJlkxHD-N_Yf13gKJmf9sOESVMmYa9lDzN9bVvgfNUqTy4C62CthVk9r5qoEgwDM8Un">
    </script>

    {{-- Toastify JS --}}
    {{-- <script>
        @if (Session::has('success'))
            Toastify({
                text: "{{ Session::get('success') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)"
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

    {{-- Payment with Credit Card or Paypal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // State management
            const state = {
                isSubmitting: false,
                hasSubmitted: false
            };

            // Payment method selection
            const paymentOptions = document.querySelectorAll('.payment-option');
            const cardPaymentSection = document.getElementById('card-payment-section');
            const paypalPaymentSection = document.getElementById('paypal-payment-section');
            const paymentMethodInput = document.getElementById('payment_method');
            const bookingForm = document.getElementById('bookingForm');
            const submitButton = document.getElementById('submit-button');

            function handlePaymentMethodSelection(option) {
                if (state.isSubmitting) return;

                paymentOptions.forEach(opt => opt.classList.remove('active'));
                option.classList.add('active');

                const method = option.getAttribute('data-method');
                paymentMethodInput.value = method;

                cardPaymentSection.style.display = method === 'credit_card' ? 'block' : 'none';
                paypalPaymentSection.style.display = method === 'paypal' ? 'block' : 'none';

                if (method === 'paypal') {
                    initializePayPalButtons();
                }
            }

            paymentOptions.forEach(option => {
                option.addEventListener('click', () => handlePaymentMethodSelection(option));
            });

            function initializePayPalButtons() {
                const container = document.querySelector('#paypal-button-container');
                if (container.children.length > 0) return;

                paypal.Buttons({
                    createOrder: (data, actions) => {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: '100.00'
                                }
                            }]
                        });
                    },
                    onApprove: (data, actions) => {
                        return actions.order.capture().then(function(details) {
                            if (!state.hasSubmitted) {
                                handleSubmission('paypal');
                            }
                        });
                    }
                }).render('#paypal-button-container');
            }

            function updateProgressBar(show = true) {
                const progressBarContainer = document.getElementById('progressBarContainer');
                const progressBar = progressBarContainer.querySelector('.progress-bar');

                if (show) {
                    progressBarContainer.style.display = 'block';
                    let width = 0;
                    const interval = setInterval(() => {
                        if (width >= 100) {
                            clearInterval(interval);
                        } else {
                            width += 10;
                            progressBar.style.width = width + '%';
                            progressBar.setAttribute('aria-valuenow', width);
                            progressBar.textContent = width + '%';
                        }
                    }, 500);
                    return interval;
                } else {
                    progressBarContainer.style.display = 'none';
                    progressBar.style.width = '0%';
                    progressBar.setAttribute('aria-valuenow', 0);
                    progressBar.textContent = '0%';
                }
            }

            async function handleSubmission(source = 'credit_card') {
                if (state.isSubmitting || state.hasSubmitted) {
                    console.log('Submission already in progress or completed');
                    return;
                }

                state.isSubmitting = true;
                state.hasSubmitted = true;
                submitButton.disabled = true;

                const progressInterval = updateProgressBar(true);

                try {
                    const formData = new FormData(bookingForm);

                    if (source === 'credit_card') {
                        // Add card details only for credit card payments
                        ['card_number', 'card_holder', 'card_month', 'card_year', 'cvv'].forEach(field => {
                            formData.append(field, document.getElementById(field).value);
                        });
                    } else {
                        // PayPal placeholder data
                        formData.append('card_number', '0000000000000000');
                        formData.append('card_holder', 'PayPal User');
                        formData.append('card_month', '01');
                        formData.append('card_year', new Date().getFullYear() + 1);
                        formData.append('cvv', '000');
                    }

                    const response = await fetch('<?php echo url('bookingsrestaurant'); ?>', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Booking Successful!',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        window.location.href = '<?php echo route('home'); ?>';
                    } else {
                        state.hasSubmitted = false;
                        throw new Error(data.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    state.hasSubmitted = false;
                    await Swal.fire({
                        icon: 'error',
                        title: 'Booking Failed',
                        text: error.message || 'An error occurred while processing your booking.'
                    });
                } finally {
                    state.isSubmitting = false;
                    submitButton.disabled = false;
                    clearInterval(progressInterval);
                    updateProgressBar(false);
                }
            }

            // Single event listener for form submission
            bookingForm.addEventListener('submit', function(event) {
                event.preventDefault();
                if (!state.isSubmitting && !state.hasSubmitted) {
                    handleSubmission(paymentMethodInput.value);
                }
            });
        });
    </script>

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

    {{-- Pill JS --}}
    <script>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to date, check-in time, and check-out time elements
            var bookingDate = document.getElementById('booking_date');
            var checkInTime = document.getElementById('checkin_time');
            var checkOutTime = document.getElementById('checkout_time');
            var tableSelect = document.getElementById('table-select');

            // Disable check-in time initially
            checkInTime.disabled = true;
            checkOutTime.disabled = true;
            tableSelect.disabled = true;

            // Event listener for booking date selection
            bookingDate.addEventListener('change', function() {
                // Enable check-in time once the date is selected
                checkInTime.disabled = false;
            });

            // Event listener for check-in time selection
            checkInTime.addEventListener('change', function() {
                // Enable check-out time once check-in time is selected
                checkOutTime.disabled = false;
                // Validate check-out time based on check-in time
                validateCheckOutTime();
            });

            // Event listener for check-out time selection
            checkOutTime.addEventListener('change', function() {
                // Validate check-out time based on check-in time
                validateCheckOutTime();
                tableSelect.disabled = false;
            });

            // Function to validate check-out time based on check-in time
            function validateCheckOutTime() {
                var checkInTimeValue = convertToMinutes(checkInTime.value);
                var checkOutTimeValue = convertToMinutes(checkOutTime.value);

                // Define time boundaries (7:00 AM to 10:00 PM)
                var startTime = convertToMinutes('07:00');
                var endTime = convertToMinutes('22:00');

                // Check if check-out time is within the allowed range and not earlier than check-in time
                // Check if check-in time is within the allowed range (7:00 AM to 10:00 PM)
                if (checkInTimeValue < startTime || checkInTimeValue > endTime) {
                    alert('You selected check-in time outside the allowed range (7:00 AM to 10:00 PM)');
                    checkInTime.value = '';
                } else if (checkOutTimeValue < startTime || checkOutTimeValue > endTime) {
                    alert('You selected check-out time outside the allowed range (7:00 AM to 10:00 PM)');
                    checkOutTime.value = '';
                } else if (checkOutTimeValue < checkInTimeValue) {
                    alert('You selected check-out time before check-in time');
                    checkOutTime.value = '';
                } else if (checkOutTimeValue == checkInTimeValue) {
                    alert('You selected check-out time equal to check-in time');
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var bookings = {!! json_encode($bookings) !!};
            var tables = {!! json_encode($tables) !!};

            // 禁用今天之前的日期
            function disablePastDates() {
                var today = new Date().toISOString().split('T')[0];
                document.getElementById("booking_date").setAttribute("min", today);
            }

            function getSelectedDateTime() {
                var bookingDate = document.getElementById("booking_date").value;
                var checkinTime = document.getElementById("checkin_time").value;
                var checkoutTime = document.getElementById("checkout_time").value;

                if (bookingDate && checkinTime && checkoutTime) {
                    return {
                        date: bookingDate,
                        checkin: checkinTime,
                        checkout: checkoutTime
                    };
                }
                return null;
            }

            function parseTime(date, time) {
                return new Date(date + 'T' + time);
            }

            function isTableAvailable(tableId, selectedDateTime) {
                var selectedCheckin = parseTime(selectedDateTime.date, selectedDateTime.checkin);
                var selectedCheckout = parseTime(selectedDateTime.date, selectedDateTime.checkout);

                for (var i = 0; i < bookings.length; i++) {
                    var booking = bookings[i];

                    if (booking.table_id == tableId && booking.booking_date === selectedDateTime.date) {
                        var bookingCheckin = parseTime(booking.booking_date, booking.checkin_time);
                        var bookingCheckout = parseTime(booking.booking_date, booking.checkout_time);

                        if (!(selectedCheckout <= bookingCheckin || selectedCheckin >= bookingCheckout)) {
                            return false;
                        }
                    }
                }
                return true;
            }

            function updateTableOptions() {
                var selectedDateTime = getSelectedDateTime();

                if (!selectedDateTime) {
                    return;
                }

                var availableTables = tables.filter(function(table) {
                    return isTableAvailable(table.id, selectedDateTime);
                });

                var tableSelect = document.getElementById("table-select");
                tableSelect.innerHTML = "";

                var defaultOption = document.createElement("option");
                defaultOption.text = "--- Select A Table ---";
                defaultOption.value = "0";
                defaultOption.disabled = true;
                defaultOption.selected = true;
                tableSelect.appendChild(defaultOption);

                availableTables.forEach(function(table) {
                    var option = document.createElement("option");
                    option.text = table.title;
                    option.value = table.id;
                    tableSelect.appendChild(option);
                });
            }

            document.getElementById("booking_date").addEventListener("change", updateTableOptions);
            document.getElementById("checkin_time").addEventListener("change", updateTableOptions);
            document.getElementById("checkout_time").addEventListener("change", updateTableOptions);

            updateTableOptions();

            // 默认加载时禁用过去的日期
            disablePastDates();
        });
    </script>

@endsection
