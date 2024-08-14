@extends('frontend-auth.newlayout')

@section('frontend-section')
    <!-- Begin Page Content -->
    {{-- <div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Booking
                <a href="" class="float-right btn btn-success btn-sm">View All</a>
            </h6>
        </div>
        <div class="card-body">

            @if (Session::has('success'))
                <p class="text-success">{{ session('success') }}</p>
            @endif
            @if (Session::has('fail'))
                <p class="text-success">{{ session('fail') }}</p>
            @endif

            <div class="table-responsive">
                <form action="{{ url('bookings') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <table class="table table-bordered">
                        <tr>
                            <th>Booking Date <span class="text-danger">*</span></th>
                            <td><input name="booking_date" id="booking_date" type="date" class="form-control"
                                    placeholder="Select Your Booking Date" /></td>
                        </tr>
                        <tr>
                            <th>Check-In Time <span class="text-danger">*</span></th>
                            <td><input name="checkin_time" id="check_in_time" type="time"
                                    class="form-control checkin-time" placeholder="Select Your Check-In Time" /></td>
                        </tr>
                        <tr>
                            <th>Check-Out Time <span class="text-danger">*</span></th>
                            <td><input name="checkout_time" id="check_out_time" type="time" class="form-control"
                                    placeholder="Select Your Check-Out Time" /></td>
                        </tr>
                        <tr>
                            <th>Select Table <span class="text-danger">*</span></th>
                            <td>
                                <select class="custom-select" id="table-select" name="table_id">
                                    <option value="0" selected>--- Choose ---</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Gender<span class="text-danger">*</span></th>
                            <td><input name="gender" id="gender" type="text" class="form-control"
                                    placeholder="Enter Your Gender" /></td>
                        </tr>
                        <tr>
                            <th>Total Quantity</th>
                            <td><input name="quantity" id="quantity" type="text" class="form-control"
                                    placeholder="Enter Total Quantity" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="restaurant_id" value="{{ $restaurants->id }}">
                                <!-- <input type="hidden" name="roomprice" class="room-price" value="" />
                                                                                <input type="hidden" name="ref" value="admin" /> -->
                                <input type="submit" class="btn btn-primary" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div> --}}

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
            color: black
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

            {{-- <div class="row">
                @if (Session::has('success'))
                    <p class="text-success">{{ session('success') }}</p>
                @endif

                @if (Session::has('fail'))
                    <p class="text-success">{{ session('fail') }}</p>
                @endif
            </div> --}}
        </h1>

        <div class="row">

            <div class="col-md-12">

                <ul class="nav nav-tabs custom-tabs">
                    <li class="custom-tab active" data-tab="booking">Booking</li>
                    <li class="custom-tab" data-tab="payment">Payment</li>
                </ul>

                <form action="{{ url('bookings') }}" method="post" enctype="multipart/form-data">
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
                                {{-- <input type="hidden" name="restaurant_price" value="{{ $restaurants->price }}"> --}}

                                <input type="hidden" name="owner_id" value="{{ $restaurants->user->id }}">
                                <input type="hidden" name="owner_name" value="{{ $restaurants->user->name }}">
                                <input type="hidden" name="restaurant_email" value="{{ $restaurants->email }}">
                                <input type="hidden" name="restaurant_phone" value="{{ $restaurants->phone }}">

                                <input type="hidden" name="restaurant_name" value="{{ $restaurants->name }}">
                                <input type="hidden" name="restaurant_type" value="{{ $restaurants->type }}">
                                {{-- <input type="text" name="table_title" value=""> --}}
                                {{-- <input type="text" name="table_id" value=""> --}}

                                <div class="inputBox">
                                    <h3>Booking Date</h3>
                                    <input type="date" required name="booking_date" id="booking_date"
                                        class="form-control" placeholder="Select Your Booking Date">
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
                                    <h3>Select Table</h3>
                                    <select class="form-control custom-select" id="table-select" name="table_id" required>
                                        <option value="0" selected>--- Choose ---</option>
                                    </select>
                                </div> --}}
                                <div class="inputBox">
                                    <h3>Select Table</h3>
                                    <select class="form-control custom-select" id="table-select" name="table_id" required>
                                        <option value="0" selected>--- Choose ---</option>
                                        <!-- 其他选项 -->
                                    </select>
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
                                    <input type="number" required min="1" max="20" name="quantity" id="quantity" class="form-control"
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

    {{-- Jian An Slove Booking Restaurant Cheked --}}
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

                // var selectOptions = Object.entries(results).reduce(function(options, [title, id]) {
                //     if (!intExcludedTableIds.includes(+id)) {
                //         return options + `<option value="${title}">${title}</option>`;
                //     }
                //     return options;
                // }, '');

                // var selectOptions = '<option value="" disabled selected>Choose a table</option>';
                // selectOptions += Object.entries(results).reduce(function(options, [title, id]) {
                //     if (!intExcludedTableIds.includes(+id)) {
                //         return options + `<option value="${title}">${title}</option>`;
                //     }
                //     return options;
                // }, '');

                // var selectOptions = '<option value="" disabled selected>Choose a table</option>';
                // selectOptions += Object.entries(results).reduce(function(options, [title, id]) {
                //     if (!intExcludedTableIds.includes(+id)) {
                //         return options +
                //             `<option value="${title}" data-id="${id}">${title}</option>`;
                //     }
                //     return options;
                // }, '');

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

    {{-- Toastr JS --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script> --}}

    {{-- @if (Session::has('success'))
        <script>
            toastr.success("{!! Session::get('success') !!}");
        </script>
    @endif

    @if (Session::has('fail'))
        <script>
            toastr.danger("{!! Session::get('fail') !!}");
        </script>
    @endif --}}

    {{-- @foreach ($catgories as $category) 1, 2
        <div class="card">
            @foreach ($foods->where('category_id', $category->id) as $food)
                food 1, 2, 4 <div class="card">

                </div>
                food 3
                <input type="hidden" value="{{$category -> id}}" name="category_id">
                <input type="text" value="{{$cate}}">
        @endforeach
        </div>

    @endforeach --}}
    {{-- Check Date --}}
    {{-- <script>
        $(document).ready(function() {
            $('#booking_date').change(function() {
                $('#check_in_time').prop('disabled', false);
                $('#check_out_time').prop('disabled', false);
            });
        })
    </script> --}}
    {{-- <script>
        $(document).ready(function() {
            var selectedTime;
            var selectedTable;

            $('#booking_date').change(function() {
                var selectedDate = $('#booking_date').val();
                var availableTables = @json($tables);
                var bookedTables = @json($bookeddate);
                var results = @json($results);

                var filteredTables = availableTables.filter(function(tableId) {
                    if (!selectedTime) {
                        return !(tableId in bookedTables && bookedTables[tableId].date ===
                            selectedDate);
                    } else {
                        return !(tableId in bookedTables && bookedTables[tableId].date ===
                            selectedDate && bookedTables[tableId].time === selectedTime);
                    }
                });

                console.log(filteredTables);

                var selectOptions = '';
                filteredTables.forEach(function(tableId) {
                    var table = results.find(function(result) {
                        return result.id === tableId;
                    });

                    if (table) {
                        selectOptions += '<option value="' + table.id + '">' + table.title +
                            '</option>';
                    }
                });

                $('#table-select').html(selectOptions);
                $('#check_in_time').prop('disabled', false);
                $('#gender').prop('disabled', true);
                $('#quantity').prop('disabled', true);

                selectedTable = null;
            });

            $('#check_in_time').change(function() {
                var selectedDate = $('#booking_date').val();
                selectedTime = $('#check_in_time').val();
                var availableTables = @json($tables);
                var bookedTables = @json($bookeddate);
                var results = @json($results);

                var filteredTables = availableTables.filter(function(tableId) {
                    if (!selectedTime) {
                        return !(tableId in bookedTables && bookedTables[tableId].date ===
                            selectedDate);
                    } else {
                        return !(tableId in bookedTables && bookedTables[tableId].date ===
                            selectedDate && bookedTables[tableId].time === selectedTime);
                    }
                });

                console.log(filteredTables);

                var selectOptions = '';
                filteredTables.forEach(function(tableId) {
                    var table = results.find(function(result) {
                        return result.id === tableId;
                    });

                    if (table) {
                        selectOptions += '<option value="' + table.id + '">' + table.title +
                            '</option>';
                    }
                });

                $('#table-select').html(selectOptions);
                $('#gender').prop('disabled', true);
                $('#quantity').prop('disabled', true);

                selectedTable = null;
            });

            $('#table-select').change(function() {
                selectedTable = $(this).val();
                $('#gender').prop('disabled', false);
                $('#quantity').prop('disabled', false);
            });

            $('#booking-form').submit(function(event) {
                event.preventDefault();

                // Perform booking validation and submission logic here
                if (selectedTable && selectedTime) {
                    // Booking is successful, perform necessary actions
                    console.log("Booking Successful");
                    console.log("Selected Date: " + $('#booking_date').val());
                    console.log("Selected Time: " + selectedTime);
                    console.log("Selected Table: " + selectedTable);

                    // Reset form fields and selectedTable variable
                    $(this)[0].reset();
                    selectedTable = null;
                } else {
                    // Handle error, booking is incomplete
                    console.log("Error: Incomplete Booking");
                }
            });
        });
    </script> --}}

    {{-- Jian an Testing --}}
    {{-- <script>
        $(document).ready(function(){
            var data = ['1','2','3'];
            var intarray = data.map(str => +str);

            console.log(intarray);
        })
    </script> --}}

    {{-- Double Save --}}
    {{-- <script>
        $(document).ready(function() {

            function stringToIntegerArray(array){
                return array.map(function(str){
                    return parseInt(str, 10);
                });
            }

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

                var intExcludedTableIds = stringToIntegerArray(excludedTableIds);
                console.log("Excluded Table IDs as Integers:", intExcludedTableIds);

                var selectOptions = Object.entries(results).reduce(function(options, [id, title]) {
                    if (!intExcludedTableIds.includes(+title)) {
                        return options + '<option value="' + title + '">' + id + '</option>';
                    }
                    return options;
                }, '');

                if(selectOptions === ''){
                    selectOptions = '<option disabled selected> No available table. Please select another time. Thank You. </option>';
                }

                $('#check_out_time').prop('disabled', false);
                $('#table-select').html(selectOptions);
            });


            $('#check_out_time').change(function() {
                $('#table-select').prop('disabled', false);
            });
        });
    </script> --}}
@endsection
