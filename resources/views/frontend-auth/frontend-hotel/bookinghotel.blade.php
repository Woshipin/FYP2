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

    {{-- Hotel Form CSS --}}
    <style>
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

    {{-- progress bar CSS --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- 在 head 标签中引入 Bootstrap CSS -->
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}


    <br><br><br><br><br><br><br><br>

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

                <form action="{{ url('bookingshotel') }}" method="post" enctype="multipart/form-data" id="booking-form">
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
                                <input type="hidden" name="hotel_name" value="{{ $hotels->name }}">
                                <input type="hidden" name="type_category" value="Hotel">

                                <input type="hidden" name="owner_id" value="{{ $hotels->user->id }}">
                                <input type="hidden" name="owner_name" value="{{ $hotels->user->name }}">
                                <input type="hidden" name="hotel_phone" value="{{ $hotels->phone }}">
                                <input type="hidden" name="hotel_email" value="{{ $hotels->email }}">

                                <input type="hidden" name="room_price" value="">
                                <input type="hidden" name="room_name" value="">
                                <input type="hidden" name="room_type" value="">

                                <input type="hidden" name="type_id" value="{{ $hotels->id }}">
                                <input type="hidden" name="type_name" value="{{ $hotels->name }}">

                                {{-- <input type="hidden" name="total_price" id="total_price" value="{{ $resorts->price }}"> --}}

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
                                    <h3>Select Room</h3>
                                    <select class="form-control custom-select" id="room_select" name="room_id" required>
                                        <option value="0" selected>--- Choose ---</option>
                                    </select>
                                </div>

                                {{-- <div class="inputBox">
                                    <h3>Room Price</h3>
                                    <select class="form-control custom-select" id="room_price" name="room_price" required>
                                        <option value="0" selected>--- Choose ---</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}" data-price="{{ $room->price }}">{{ $room->name }} (Price: {{ $room->price }})</option>
                                        @endforeach
                                    </select>
                                </div> --}}

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
                                <h3>Hotel Room Price : RM<span id="room_price">0.00</span></h3>
                                <h3>Hotel Room Total Price : RM<span name="total_price" id="total_price">0.00</span></h3>

                                <div class="inputBox">
                                    <span>Card Number</span>
                                    <input type="text" id="card_number" name="card_number" maxlength="16"
                                        class="card-number-input" placeholder="0000 0000 0000 0000" required>
                                </div>

                                <div class="inputBox">
                                    <span>Card Holder</span>
                                    <input type="text" name="card_holder" class="card-holder-input">
                                </div>

                                <div class="flexbox">
                                    <div class="inputBox">
                                        <span>expiration mm</span>
                                        <select name="card_month" id="" class="month-input">
                                            <option value="" selected disabled>month</option>
                                            <option value="1">01</option>
                                            <option value="2">02</option>
                                            <option value="3">03</option>
                                            <option value="4">04</option>
                                            <option value="5">05</option>
                                            <option value="6">06</option>
                                            <option value="7">07</option>
                                            <option value="8">08</option>
                                            <option value="9">09</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                    </div>
                                    <div class="inputBox">
                                        <span>expiration yy</span>
                                        <select name="card_year" id="" class="year-input">
                                            <option value="" selected disabled>year</option>
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

                    <!-- 进度条 -->
                    <div class="progress mt-3" id="progressBarContainer" style="display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                            aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>

                </form>
            </div>
        </div>
        {{-- </div> --}}
    </section>

    <!-- Book Section Ends -->

    <!-- /.container-fluid -->

    <!------------------------------------------------------------ /.Js Area -------------------------------------------------------->

    {{-- progress bar JS --}}
    <!-- 在 body 标签底部引入 Bootstrap JS 和 jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    {{-- progress bar JS --}}
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Calculate Total Room Price --}}
    <script>
        function calculateTotalPrice() {
            const checkinDate = new Date(document.getElementById('checkin_date').value);
            const checkoutDate = new Date(document.getElementById('checkout_date').value);
            const roomPrice = parseFloat(document.getElementById('room_price').value);
            const totalPriceField = document.getElementById('total_price');

            if (checkinDate && checkoutDate && roomPrice) {
                const timeDifference = checkoutDate - checkinDate;
                const dayDifference = timeDifference / (1000 * 3600 * 24);
                const totalPrice = dayDifference * roomPrice;
                totalPriceField.value = totalPrice.toFixed(2); // 保留两位小数
            }
        }

        function onRoomSelect() {
            const roomSelect = document.getElementById('room_select');
            const roomPriceInput = document.getElementById('room_price');

            // 在这里，你可以根据选择的房间ID来设置相应的房间价格
            // 例如，假设 room_select 选项值和房间价格的对应关系存储在一个对象中
            const roomPrices = {
                1: 100, // 房间ID 1 对应的价格
                2: 150, // 房间ID 2 对应的价格
                3: 200 // 房间ID 3 对应的价格
            };

            const selectedRoomId = roomSelect.value;
            if (selectedRoomId in roomPrices) {
                roomPriceInput.value = roomPrices[selectedRoomId];
                calculateTotalPrice();
            } else {
                roomPriceInput.value = '';
                document.getElementById('total_price').value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('checkin_date').addEventListener('change', calculateTotalPrice);
            document.getElementById('checkout_date').addEventListener('change', calculateTotalPrice);
            document.getElementById('room_select').addEventListener('change', onRoomSelect);
        });
    </script>

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

    {{-- Full Check Hotel Room Code --}}
    <script>
        $(document).ready(function() {

            function stringToIntegerArray(array) {
                return array.map(function(str) {
                    return parseInt(str, 10);
                });
            }

            // Define open and close times
            var openTime = '08:00';
            var closeTime = '20:00';

            //disable
            $('#check_in_time').prop('disabled', true);
            $('#check_out_time').prop('disabled', true);
            $('#room_select').prop('disabled', true);

            //on change booking_date
            $('#booking_date').change(function() {
                $('#check_in_time').prop('disabled', false);

            });

            //on change check_in_time and get value from BookingController
            $('#check_in_time').change(function() {
                var date = $('#booking_date').val();
                var time = $('#check_in_time').val();
                var booked = @json($collectionBooked);
                var results = @json($collectionResults);
                var dateTime = date + ' ' + time + ':00';

                console.log('booked:', booked);
                console.log('time:', time);
                console.log('datetime :', dateTime);
                console.log('results :', results);

                // Array to store excluded room IDs
                var excludedRoomIds = [];

                for (var key in booked) {
                    if (booked.hasOwnProperty(key)) {
                        var bookingDate = key;
                        var roomIds = booked[key];

                        console.log('bookingDate:', bookingDate);
                        console.log('roomIds:', roomIds);

                        for (var i = 0; i < roomIds.length; i++) {
                            if (bookingDate === dateTime) {
                                excludedRoomIds.push(roomIds[i]);
                            }
                        }
                    }
                }
                console.log("Excluded Room IDs:", excludedRoomIds);

                // Convert check_in_time to a Date object for comparison
                var checkInDateTime = new Date(dateTime);
                var openTimeDateTime = new Date(date + ' ' + openTime);
                var closeTimeDateTime = new Date(date + ' ' + closeTime);

                // Check if check_in_time is within open and close times
                if (checkInDateTime < openTimeDateTime || checkInDateTime >= closeTimeDateTime) {
                    alert('Check-in time must be between ' + openTime + ' and ' + closeTime);
                    $('#check_in_time').val(''); // Clear the input
                    return;
                }

                // Change room IDs to integers
                var intExcludedRoomIds = stringToIntegerArray(excludedRoomIds);
                console.log("Excluded Room IDs as Integers:", intExcludedRoomIds);

                // Object.entries(results).forEach(function([id, name, price]) {
                //     if (!intExcludedRoomIds.includes(+name)) {
                //         selectOptions += '<option value="' + name + '-' + price + '">' + name + ' (Price: ' + price + ') - ' + id + '</option>';
                //     }
                // });

                var selectOptions = '';

                var filteredResults = results.filter(function(item) {
                    return !intExcludedRoomIds.includes(item.id);
                });

                console.log(filteredResults);

                // Generate the selectOptions based on filteredResults
                // var selectOptions = filteredResults.map(function(item) {
                //     console.log(item.id, item.name, item.price, item.type);
                //     return '<option value="' + item.id + '">' + item.type + ' - ' + item.name +
                //         ' - ' + item.price + '</option>';
                // }).join('');

                // Generate the selectOptions based on filteredResults
                // var selectOptions = filteredResults.map(function(item) {
                //     console.log(item.id, item.name, item.price, item.type);
                //     return '<option value="' + item.id + '" data-room_type="' + item.type +
                //         '" data-room_price="' + item.price + '">' + item.type + ' - ' + item.name +
                //         ' - ' + item.price + '</option>';
                // }).join('');

                // 正版
                // Generate the selectOptions based on filteredResults
                var selectOptions = '<option value="" disabled selected>Choose a room</option>';
                selectOptions += filteredResults.map(function(item) {
                    console.log(item.id, item.name, item.price, item.type);
                    return '<option value="' + item.id + '" data-room_type="' + item.type +
                        '" data-room_price="' + item.price + '">' + item.type + ' - ' + item.name +
                        ' - ' + item.price + '</option>';
                }).join('');

                // var selectOptions = '<option value="" disabled selected>Choose a room</option>';
                // selectOptions += filteredResults.map(function(item) {
                //     console.log(item.id, item.name, item.price, item.type);
                //     return '<option value="' + item.id + '" data-room_type="' + item.type +
                //         '" data-room_name="' + item.name +
                //         '" data-room_price="' + item.price + '">' + item.type + ' - ' + item.name +
                //         ' - ' + item.price + '</option>';
                // }).join('');

                if (selectOptions === '') {
                    selectOptions =
                        '<option disabled selected>No available rooms. Please select another time.</option>';
                }

                $('#check_out_time').prop('disabled', false);
                $('#room_select').html(selectOptions);


                // Add change event listener for room selection
                // $('#room_select').change(function() {
                //     // Get the selected option
                //     var selectedOption = $(this).find('option:selected');

                //     // Extract room name, type, and price from the selected option
                //     var roomId = selectedOption.val();
                //     var roomName = selectedOption.text();
                //     var roomType = selectedOption.data('room_type');
                //     var roomPrice = selectedOption.data('room_price');

                //     // Update the input fields
                //     $('input[name="room_name"]').val(roomName);
                //     $('input[name="room_type"]').val(roomType);
                //     $('input[name="room_price"]').val(roomPrice);
                // });

                // Add change event listener using event delegation
                $(document).on('change', '#room_select', function() {
                    // Get the selected option
                    var selectedOption = $(this).find('option:selected');

                    // Extract room name, type, and price from the selected option
                    var roomId = selectedOption.val();
                    var roomName = selectedOption.text();
                    var roomType = selectedOption.data('room_type');
                    var roomPrice = selectedOption.data('room_price');

                    // Update the input fields
                    $('input[name="room_name"]').val(roomName);
                    $('input[name="room_type"]').val(roomType);
                    $('input[name="room_price"]').val(roomPrice);
                });

            });

            $('#check_out_time').change(function() {
                var date = $('#booking_date').val();
                var checkInTime = $('#check_in_time').val();
                var checkOutTime = $('#check_out_time').val();
                var closeTimeDateTime = new Date(date + ' ' + closeTime);

                // Convert check_out_time to a Date object for comparison
                var checkOutDateTime = new Date(date + ' ' + checkOutTime);

                // Check if check_out_time is greater than check_in_time
                if (checkOutDateTime >= closeTimeDateTime) {
                    alert('Check-out time must be less than ' + closeTime);
                    $('#check_out_time').val(''); // Clear the input
                    return;
                } else if (checkOutTime <= checkInTime) {
                    alert('Check-out-time must be Grater than ' + checkInTime);
                    $('#check_out_time').val(''); // Clear the input
                    return;
                }
                $('#room_select').prop('disabled', false);

            });

        });
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

@endsection
