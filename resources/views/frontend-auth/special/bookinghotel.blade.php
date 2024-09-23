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

    <br><br><br><br><br><br>

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

                <form action="{{ url('bookingshotel') }}" method="post" enctype="multipart/form-data">
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
                                {{-- <input type="hidden" name="room_price" value="{{ $restaurants->price }}"> --}}

                                <input type="hidden" name="owner_id" value="{{ $hotels->user->id }}">
                                <input type="hidden" name="owner_name" value="{{ $hotels->user->name }}">
                                <input type="hidden" name="hotel_email" value="{{ $hotels->email }}">
                                <input type="hidden" name="hotel_phone" value="{{ $hotels->phone }}">

                                <input type="hidden" name="hotel_name" value="{{ $hotels->name }}">
                                <input type="hidden" name="hotel_type" value="{{ $hotels->type }}">

                                {{-- <input type="text" name="room_id" id="room_id_select" value=""> --}}
                                <input type="text" id="room_name_input" value="">
                                <input type="text" id="room_type_input" value="">
                                <input type="text" name="room_price" id="room_price_input" value="">

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

                                {{-- <div class="inputBox">
                                    <h3>Select Room</h3>
                                    <div class="custom-select-container">
                                        <select class="form-control custom-select" id="room-select" name="room_id"
                                            required>
                                            @if (count($rooms) > 0)
                                                <option value="0" selected disabled>--- Choose a Room ---</option>
                                                @foreach ($rooms as $room)
                                                    @php
                                                        $roomBooked = false;
                                                        $roomCheckinDate = \Carbon\Carbon::parse($room->checkin_date);
                                                        $roomCheckoutDate = \Carbon\Carbon::parse($room->checkout_date);

                                                        foreach ($bookedDates as $bookedDate) {
                                                            $checkDate = \Carbon\Carbon::parse($bookedDate['date']); // Extract date from the array
                                                            if (
                                                                $checkDate->between($roomCheckinDate, $roomCheckoutDate)
                                                            ) {
                                                                $roomBooked = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    @if (!$roomBooked)
                                                        <option value="{{ $room->id }}">
                                                            <span class="room-name">{{ $room->name }}</span> |
                                                            <span class="room-details">
                                                                Type: {{ $room->type }} |
                                                                Price: ${{ $room->price }}
                                                            </span>
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option value="0" selected disabled>No rooms available.</option>
                                            @endif
                                        </select>
                                        <div class="select-arrow"></div>
                                    </div>
                                </div> --}}

                                <div class="inputBox">
                                    <h3>Select Room</h3>
                                    <div class="custom-select-container">
                                        <select class="form-control custom-select" id="room-select" name="room_id"
                                            required>
                                            @if (count($rooms) > 0)
                                                <option value="0" selected disabled>--- Choose a Room ---</option>
                                                @foreach ($rooms as $room)
                                                    @php
                                                        $roomBooked = false;
                                                        $roomCheckinDate = \Carbon\Carbon::parse($room->checkin_date);
                                                        $roomCheckoutDate = \Carbon\Carbon::parse($room->checkout_date);

                                                        foreach ($bookedDates as $bookedDate) {
                                                            $checkDate = \Carbon\Carbon::parse($bookedDate['date']);
                                                            if (
                                                                $checkDate->between($roomCheckinDate, $roomCheckoutDate)
                                                            ) {
                                                                $roomBooked = true;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    @if (!$roomBooked)
                                                        <option value="{{ $room->id }}"
                                                            data-name="{{ $room->name }}"
                                                            data-type="{{ $room->type }}"
                                                            data-price="{{ $room->price }}">
                                                            Name: {{ $room->type }} | Type: {{ $room->name }} | Price:
                                                            ${{ $room->price }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                <option value="0" selected disabled>No rooms available.</option>
                                            @endif
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
                                <h3>Hotel Room Price : RM<span id="room_price_display">0.00</span></h3>
                                <h3>Hotel Room Total Price : RM<span name="room_total_price" id="total_price_display">0.00</span></h3>

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
                                        <input type="number" name="cvv" maxlength="4" class="cvv-input">
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

    <!-- /.container-fluid -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Calculate Total Room Price --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const roomSelect = document.getElementById('room-select');
            const roomPriceInput = document.getElementById('room_price_input');
            const roomNameInput = document.getElementById('room_name_input');
            const roomTypeInput = document.getElementById('room_type_input');
            const roomPriceDisplay = document.getElementById('room_price_display');
            const totalPriceDisplay = document.getElementById('total_price_display');
            const checkinDateInput = document.getElementById('checkin_date');
            const checkoutDateInput = document.getElementById('checkout_date');

            // 检查元素是否存在
            // console.log('Elements:', {
            //     roomSelect,
            //     roomPriceInput,
            //     roomNameInput,
            //     roomTypeInput,
            //     roomPriceDisplay,
            //     totalPriceDisplay,
            //     checkinDateInput,
            //     checkoutDateInput
            // });

            function calculateTotalPrice() {

                const checkinDate = new Date(checkinDateInput.value);
                console.log('checkinDate', checkinDate);

                const checkoutDate = new Date(checkoutDateInput.value);
                console.log('checkoutDate', checkoutDate);

                const roomPrice = parseFloat(roomPriceInput.value);
                console.log('roomPrice', roomPrice);

                if (checkinDate && checkoutDate && !isNaN(roomPrice)) {

                    const timeDiff = checkoutDate - checkinDate;
                    console.log('timeDiff', timeDiff);

                    const dayDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
                    console.log('dayDiff', dayDiff);

                    if (dayDiff > 0) {

                        const totalPrice = roomPrice * dayDiff;
                        console.log('totalPrice', totalPrice);

                        totalPriceDisplay.textContent = totalPrice.toFixed(2);

                    } else {

                        totalPriceDisplay.textContent = '0.00';
                    }

                } else {

                    totalPriceDisplay.textContent = '0.00';
                }
            }

            roomSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                if (selectedOption.value !== '0') {
                    const roomName = selectedOption.dataset.name;
                    const roomType = selectedOption.dataset.type;
                    const roomPrice = selectedOption.dataset.price;

                    console.log('选中的房间信息：', {
                        roomName,
                        roomType,
                        roomPrice
                    });

                    roomNameInput.value = roomName || '';
                    roomTypeInput.value = roomType || '';
                    roomPriceInput.value = roomPrice || '';

                    console.log('更新后的输入字段：', {
                        name: roomNameInput.value,
                        type: roomTypeInput.value,
                        price: roomPriceInput.value
                    });

                    // document.getElementById('room_id_select').value = selectedOption.value;
                    // document.getElementById('room_price_select').value = roomPrice || '';
                    // document.getElementById('room_name_select').value = roomName || '';
                    // document.getElementById('room_type_select').value = roomType || '';

                    if (roomPrice) {
                        roomPriceDisplay.textContent = parseFloat(roomPrice).toFixed(2);
                    } else {
                        roomPriceDisplay.textContent = '0.00';
                    }

                    calculateTotalPrice();
                }
            });

            checkinDateInput.addEventListener('change', calculateTotalPrice);
            checkoutDateInput.addEventListener('change', calculateTotalPrice);
        });

        var bookedDates = {!! json_encode($bookedDates) !!};
        var rooms = {!! json_encode($rooms) !!};

        // console.log('bookedDates', bookedDates);
        // console.log('rooms', rooms);

        function disablePastDates() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("checkin_date").setAttribute("min", today);
            document.getElementById("checkout_date").setAttribute("min", today);
        }

        function getSelectedDates() {
            var checkinDate = document.getElementById("checkin_date").value;
            var checkoutDate = document.getElementById("checkout_date").value;

            // console.log('checkinDate', checkinDate);
            // console.log('checkoutDate', checkoutDate);

            var selectedDates = [];
            if (checkinDate && checkoutDate) {
                var currentDate = new Date(checkinDate);

                while (currentDate <= new Date(checkoutDate)) {
                    selectedDates.push(currentDate.toISOString().slice(0, 10));
                    currentDate.setDate(currentDate.getDate() + 1);
                }
            }

            return selectedDates;
        }

        function isRoomAvailable(roomId, selectedDates) {
            for (var i = 0; i < bookedDates.length; i++) {
                var bookedDate = bookedDates[i];
                if (bookedDate.room_id === roomId && selectedDates.includes(bookedDate.date)) {
                    return false;
                }
            }
            return true;
        }

        function updateRoomOptions() {
            var selectedDates = getSelectedDates();
            var availableRooms = [];

            console.log('selectedDates', selectedDates);

            for (var i = 0; i < rooms.length; i++) {
                var room = rooms[i];
                if (isRoomAvailable(room.id, selectedDates)) {
                    availableRooms.push(room);
                }
            }

            var roomSelect = document.getElementById("room-select");

            roomSelect.innerHTML = "";

            var defaultOption = document.createElement("option");
            defaultOption.text = "--- Select A Room ---";
            defaultOption.value = "0";
            defaultOption.disabled = true;
            defaultOption.selected = true;
            roomSelect.appendChild(defaultOption);

            for (var k = 0; k < availableRooms.length; k++) {
                var option = document.createElement("option");
                option.text = availableRooms[k].type + " | Type: " + availableRooms[k].name + " | Price: $" +
                    availableRooms[k].price;
                option.value = availableRooms[k].id;
                option.dataset.name = availableRooms[k].name;
                option.dataset.type = availableRooms[k].type;
                option.dataset.price = availableRooms[k].price;
                roomSelect.appendChild(option);
            }

            console.log('availableRooms', availableRooms);
        }

        document.getElementById("checkin_date").addEventListener("change", updateRoomOptions);
        document.getElementById("checkout_date").addEventListener("change", updateRoomOptions);

        updateRoomOptions();
        disablePastDates();
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

    {{-- Jian An Slove Booking Hotel Cheked --}}
    {{-- <script>
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
            $('#table-select').prop('disabled', true);

            //on change booking_date
            $('#booking_date').change(function() {
                $('#check_in_time').prop('disabled', false);

            });

            //on change check_in_time and get value from BookingController
            $('#check_in_time').change(function() {
                var date = $('#booking_date').val();
                var time = $('#check_in_time').val();
                var booked = @json($booked);
                var results = @json($results);
                var dateTime = date + ' ' + time + ':00';

                console.log('booked', booked);
                console.log('time', time);
                console.log('datetime', dateTime);
                console.log('results', results);

                //Array
                var excludedTableIds = [];

                for (var key in booked) {
                    if (booked.hasOwnProperty(key)) {
                        var bookingDate = key;
                        var tableIds = booked[key]; // Assuming tableIds is an array

                        for (var i = 0; i < tableIds.length; i++) {
                            if (bookingDate == dateTime) {
                                excludedTableIds.push(tableIds[i]);
                            }
                        }
                    }
                }
                console.log("Excluded Table IDs:", excludedTableIds);

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

                var intExcludedTableIds = stringToIntegerArray(excludedTableIds);
                console.log("Excluded Table IDs as Integers:", intExcludedTableIds);

                var selectOptions = '<option value="" disabled selected>Choose a table</option>';
                selectOptions += Object.entries(results).reduce(function(options, [id, title]) {
                    if (!intExcludedTableIds.includes(+title)) {
                        return options + '<option value="' + title + '">' + id + '</option>';
                    }
                    return options;
                }, '');

                if (selectOptions === '') {
                    selectOptions =
                        '<option disabled selected> No available table. Please select another time. Thank You. </option>';
                }

                $('#check_out_time').prop('disabled', false);
                $('#table-select').html(selectOptions);

                var selectedTableTitle, selectedTableId;

                $('#table-select').change(function() {
                    // 获取所选表格的标题和id
                    selectedTableTitle = $(this).val();
                    selectedTableId = $(this).find(':selected').data(
                        'id'); // Use data('id') to get the data-id attribute

                    // 将所选表格标题和id设置为隐藏输入字段的值
                    $('input[name="table_title"]').val(selectedTableTitle);
                    // $('input[name="table_id"]').val(selectedTableId);

                    console.log('Selected Table Title:', selectedTableTitle);
                    // console.log('Selected Table Id:', selectedTableId);
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
                    alert('Check-out time must be Grater than ' + checkInTime);
                    $('#check_out_time').val(''); // Clear the input
                    return;
                }
                $('#table-select').prop('disabled', false);
            });
        });
    </script> --}}

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

    {{-- Special Check --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to date, check-in time, and check-out time elements
            var bookingDate = document.getElementById('checkout_date');
            var checkInTime = document.getElementById('check_in_time');
            var checkOutTime = document.getElementById('check_out_time');
            var roomselect = document.getElementById('room-select');

            // Disable check-in time initially
            checkInTime.disabled = true;
            checkOutTime.disabled = true;
            roomselect.disabled = true;

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
                // Enable check-out time once check-out time is selected
                roomselect.disabled = false;
                // Validate check-out time based on check-in time
                validateCheckOutTime();
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

    {{-- New Full Check and Disabled Calender --}}
    {{-- <script>
        var bookedDates = {!! json_encode($bookedDates) !!}; // 预订日期数组
        var rooms = {!! json_encode($rooms) !!}; // 房间信息数组

        console.log('bookedDates', bookedDates);
        console.log('rooms', rooms);

        // 禁用今天之前的日期
        function disablePastDates() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById("checkin_date").setAttribute("min", today);
            document.getElementById("checkout_date").setAttribute("min", today);
        }

        // 获取选择的日期范围
        function getSelectedDates() {
            var checkinDate = document.getElementById("checkin_date").value;
            var checkoutDate = document.getElementById("checkout_date").value;

            console.log('checkinDate', checkinDate);
            console.log('checkoutDate', checkoutDate);

            var selectedDates = [];
            if (checkinDate && checkoutDate) {
                var currentDate = new Date(checkinDate);

                while (currentDate <= new Date(checkoutDate)) {
                    selectedDates.push(currentDate.toISOString().slice(0, 10));
                    currentDate.setDate(currentDate.getDate() + 1);
                }
            }

            return selectedDates;
        }

        // 检查房间在所选日期内是否被预订
        function isRoomAvailable(roomId, selectedDates) {
            for (var i = 0; i < bookedDates.length; i++) {
                var bookedDate = bookedDates[i];
                if (bookedDate.room_id === roomId && selectedDates.includes(bookedDate.date)) {
                    return false;
                }
            }
            return true;
        }

        // 更新房间选项
        function updateRoomOptions() {
            var selectedDates = getSelectedDates();
            var availableRooms = [];

            console.log('selectedDates', selectedDates);

            for (var i = 0; i < rooms.length; i++) {
                var room = rooms[i];
                if (isRoomAvailable(room.id, selectedDates)) {
                    availableRooms.push(room);
                }
            }

            var roomSelect = document.getElementById("room-select");

            // 清空现有选项
            roomSelect.innerHTML = "";

            // 添加默认选项
            var defaultOption = document.createElement("option");
            defaultOption.text = "--- 选择一个房间 ---";
            defaultOption.value = "0";
            defaultOption.disabled = true;
            defaultOption.selected = true;
            roomSelect.appendChild(defaultOption);

            // 添加可用房间选项
            for (var k = 0; k < availableRooms.length; k++) {
                var option = document.createElement("option");
                option.text = availableRooms[k].type + " | Type: " + availableRooms[k].name + " | Price: $" +
                    availableRooms[k].price;
                option.value = availableRooms[k].id;
                roomSelect.appendChild(option);
            }

            console.log('availableRooms', availableRooms);
        }

        // 监听日期变化事件
        document.getElementById("checkin_date").addEventListener("change", updateRoomOptions);
        document.getElementById("checkout_date").addEventListener("change", updateRoomOptions);

        // 默认加载时更新房间选项
        updateRoomOptions();

        // 默认加载时禁用过去的日期
        disablePastDates();
    </script> --}}

    {{-- New Check and Disabled Calender --}}
    {{-- <script>
        var bookedDates = {!! json_encode($bookedDates) !!}; // 预订日期数组
        var rooms = {!! json_encode($rooms) !!}; // 房间信息数组

        console.log('bookedDates', bookedDates);
        console.log('rooms', rooms);

        // 获取选择的日期范围
        function getSelectedDates() {
            var checkinDate = document.getElementById("checkin_date").value;
            var checkoutDate = document.getElementById("checkout_date").value;

            console.log('checkinDate', checkinDate);
            console.log('checkoutDate', checkoutDate);

            var selectedDates = [];
            var currentDate = new Date(checkinDate);

            while (currentDate <= new Date(checkoutDate)) {
                selectedDates.push(currentDate.toISOString().slice(0, 10));
                currentDate.setDate(currentDate.getDate() + 1);
            }

            return selectedDates;
        }

        // 检查房间在所选日期内是否被预订
        function isRoomAvailable(roomId, selectedDates) {
            for (var i = 0; i < bookedDates.length; i++) {
                var bookedDate = bookedDates[i];
                if (bookedDate.room_id === roomId && selectedDates.includes(bookedDate.date)) {
                    return false;
                }
            }
            return true;
        }

        // 更新房间选项
        function updateRoomOptions() {
            var selectedDates = getSelectedDates();
            var availableRooms = [];

            console.log('selectedDates', selectedDates);

            for (var i = 0; i < rooms.length; i++) {
                var room = rooms[i];
                if (isRoomAvailable(room.id, selectedDates)) {
                    availableRooms.push(room);
                }
            }

            var roomSelect = document.getElementById("room-select");

            // 清空现有选项
            roomSelect.innerHTML = "";

            // 添加默认选项
            var defaultOption = document.createElement("option");
            defaultOption.text = "--- 选择一个房间 ---";
            defaultOption.value = "0";
            defaultOption.disabled = true;
            defaultOption.selected = true;
            roomSelect.appendChild(defaultOption);

            // 添加可用房间选项
            for (var k = 0; k < availableRooms.length; k++) {
                var option = document.createElement("option");
                option.text = availableRooms[k].type + " | 名称: " + availableRooms[k].name + " | 价格: $" + availableRooms[k].price;
                option.value = availableRooms[k].id;
                roomSelect.appendChild(option);
            }

            console.log('availableRooms', availableRooms);
        }

        // 监听日期变化事件
        document.getElementById("checkin_date").addEventListener("change", updateRoomOptions);
        document.getElementById("checkout_date").addEventListener("change", updateRoomOptions);

        // 默认加载时更新房间选项
        updateRoomOptions();
    </script> --}}

@endsection
