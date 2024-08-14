@extends('frontend-auth.newlayout')

@section('frontend-section')
    <!------------------------------------------------------------ Book Area ------------------------------------------------------->

    {{-- Stripe JS --}}
    {{-- <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const stripe = Stripe('pk_test_51OKaMXGHH2qMLoYnU9V61SH1I7XXSo6nmBfkFSNl4V7RIv17azq7OTT4iwBkT4zQVlVYsRl5X7YrVgSaibcIEyxs003vb0y483');
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');

            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                // Make an AJAX request to the server to create the PaymentIntent
                const response = await fetch('/bookingresort', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        card_number: '4242 4242 4242 4242', // Example data
                        card_holder: 'John Doe',
                        card_month: '12',
                        card_year: '23',
                        cvv: '123',
                        checkin_date: '2023-07-01',
                        checkout_date: '2023-07-05',
                        checkin_time: '14:00',
                        checkout_time: '12:00',
                        gender: 'male',
                        quantity: 1,
                        resort_price: 100, // Example data
                        resort_name: 'Example Resort',
                        type_name: 'Example Type',
                        deposit_price: 50,
                        owner_name: 'Owner Name',
                        resort_phone: '123456789',
                        resort_email: 'resort@example.com',
                        resort_type: 'Example Type'
                    })
                });

                const data = await response.json();
                const clientSecret = data.client_secret;

                if (clientSecret) {
                    const { paymentIntent, error } = await stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: 'John Doe',
                            },
                        }
                    });

                    if (error) {
                        console.error('Error:', error.message);
                        alert('Payment failed: ' + error.message);
                    } else if (paymentIntent.status === 'succeeded') {
                        alert('Payment succeeded!');
                        window.location.href = '/payment-success';
                    }
                } else {
                    console.error('Error creating PaymentIntent:', data.message);
                    alert('Error creating PaymentIntent: ' + data.message);
                }
            });
        });
    </script> --}}

    {{-- <script>
        var stripe = Stripe('{{ $stripeKey }}');
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    document.getElementById('stripeToken').value = result.token.id;
                    form.submit();
                }
            });
        });
    </script> --}}

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
        .custom-tab-content {
            background: rgb(143, 239, 236);
        }

        .h3 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        span {
            color: black
        }
    </style>

    {{-- Date Disabled CSS --}}
    {{-- <style>
        /* 自定义禁用日期的颜色 */
        .custom-disabled-date {
            color: #999 !important;
            /* 修改日期文字颜色 */
            background-color: #f5f5f5 !important;
            /* 修改日期背景色 */
            /* 其他样式 */
        }
    </style> --}}

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

    <br><br><br><br><br><br>

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

                <form action="{{ url('bookingsresort') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    {{-- Booking Resort Area --}}
                    <div class="custom-tab-content active" data-tab="booking">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{ asset('new/img/book-img.jpg') }}" alt="">
                            </div>
                            <div class="col-md-6">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="user_name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                <input type="hidden" name="resort_id" value="{{ $resorts->id }}">
                                {{-- <input type="hidden" name="type_name" value="{{ $resorts->name }}"> --}}
                                <input type="hidden" name="resort_price" id="resort_price" value="{{ $resorts->price }}">
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
                                        class="form-control" placeholder="Select Your Booking Check In Date">
                                </div>

                                <div class="inputBox">
                                    <h3>Check-Out Date</h3>
                                    <input type="date" required name="checkout_date" id="checkout_date"
                                        class="form-control" placeholder="Select Your Booking Check Out Date">
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
                                        id="quantity" type="text" class="form-control"
                                        placeholder="Enter Total Quantity" oninput="validateQuantity(this)">
                                </div>
                                <div class="inputBox">
                                    <p id="payment" class="btn">Done</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    {{-- Card Payment Area --}}
                    <div class="container-payment custom-tab-content " data-tab="payment">

                        <div class="row">
                            <div class="col-md-5">
                                <img src="{{ asset('new/img/book-img.jpg') }}" alt="">
                            </div>

                            <div class="col-md-6">
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
                                <br>

                                <h3>Deposit Fee RM100</h3>
                                <input type="hidden" name="deposit_price" value="100">
                                <h3>Resort Total Price : RM<span id="total_price">0.00</span></h3>

                                <div class="inputBox">
                                    <span>Card Number</span>
                                    <input type="text" id="card_number" name="card_number" maxlength="19"
                                        class="card-number-input" placeholder="0000 0000 0000 0000" required
                                        inputmode="numeric">
                                </div>

                                <div class="inputBox">
                                    <span>Card Holder</span>
                                    <input type="text" name="card_holder" class="card-holder-input">
                                </div>

                                <div class="flexbox">
                                    <div class="inputBox">
                                        <span>expiration mm</span>
                                        <select name="card_month" id="" class="month-input">
                                            <option value="month" selected disabled>month</option>
                                            <option value="01">01</option>
                                            <option value="02">02</option>
                                            <option value="03">03</option>
                                            <option value="04">04</option>
                                            <option value="05">05</option>
                                            <option value="06">06</option>
                                            <option value="07">07</option>
                                            <option value="08">08</option>
                                            <option value="09">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="inputBox">
                                        <span>expiration yy</span>
                                        <select name="card_year" id="" class="year-input">
                                            <option value="year" selected disabled>year</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                        </select>
                                    </div>
                                    <div class="inputBox">
                                        <span>cvv</span>
                                        <input type="text" name="cvv" maxlength="4" class="cvv-input">
                                    </div>
                                </div>

                                <input type="submit" class="btn" id="submit-button">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
    <!-- Book Section Ends -->

    <!------------------------------------------------------------ /.Js Area -------------------------------------------------------->

    {{-- Calculate Resort Total Price --}}
    <script>
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
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Toastr New JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    {{-- New Toastr --}}
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
                console.log('aaa');
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

@endsection
