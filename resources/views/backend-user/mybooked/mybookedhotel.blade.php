@extends('backend-user.newlayout')

@section('newuser-section')

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Staatliches&display=swap");
        @import url("https://fonts.googleapis.com/css2?family=Nanum+Pen+Script&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Staatliches", cursive;
            color: black;
        }

        .breadcumb-area {
            background-image: url(booked/bg-img/breadcumb3.jpg);
            background-size: cover;
            background-position: center;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }

        .bradcumbContent {
            max-width: 600px;
        }

        .bradcumbContent p {
            font-size: 18px;
        }

        /* .bradcumbContent h2 {
                            font-size: 36px;
                            font-family: "Nanum Pen Script", cursive;
                            font-weight: 700;
                            letter-spacing: 0.1em;
                            color: #4a437e;
                        } */

        .ticket-section {
            margin: 60px 0;
            display: grid;
            gap: 50px;
        }

        .ticket {
            margin: auto;
            display: flex;
            background: white;
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
        }

        .left {
            display: flex;
        }

        .ticket-image {
            height: 375px;
            width: 250px;
            /* background-image: url("https://media.pitchfork.com/photos/60db53e71dfc7ddc9f5086f9/1:1/w_1656,h_1656,c_limit/Olivia-Rodrigo-Sour-Prom.jpg"); */
            background-size: contain;
            opacity: 0.85;
        }

        .admit-one {
            position: absolute;
            color: darkgray;
            height: 250px;
            padding: 0 4px;
            letter-spacing: 0.15em;
            display: flex;
            text-align: center;
            justify-content: space-around;
            writing-mode: vertical-rl;
            transform: rotate(-180deg);
        }

        .admit-one span:nth-child(2) {
            color: white;
            font-weight: 700;
        }

        .left .ticket-number {
            height: 250px;
            width: 250px;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            padding: 5px;
        }

        .ticket-info {
            max-width: 550px;
            padding: 10px 30px;
            display: flex;
            flex-direction: column;
            text-align: center;
            justify-content: space-between;
            align-items: center;
        }

        .navy-blue-button {
            display: inline-block;
            padding: 6px 40px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: none;
            border-radius: 10px;
            color: #fff;
            background-color: navy;
            transition: background-color 0.3s ease;
        }

        .navy-blue-button:hover {
            background-color: #001f3f;
            color: #fff;
        }

        .ticket-date {
            width: 500px;
            border-top: 1px solid gray;
            border-bottom: 1px solid gray;
            padding: 5px 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        .ticket-date span {
            width: 100px;
            font-family: "Staatliches", cursive;
            color: black;
        }

        .ticket-date span:first-child {
            text-align: left;
        }

        .ticket-date span:last-child {
            text-align: right;
        }

        .ticket-date .month-day {
            color: #d83565;
            font-size: 20px;
        }

        .ticket-show-name h2 {
            font-size: 32px;
            font-family: "Nanum Pen Script", cursive;
            color: #d83565;
        }

        .ticket-show-name h1 {
            font-size: 48px;
            font-weight: 700;
            letter-spacing: 0.1em;
            font-family: "Nanum Pen Script", cursive;
            color: #4a437e;
        }

        .ticket-time {
            display: flex;
            flex-direction: column;
        }

        .ticket-time p {
            color: #4a437e;
            padding: 3px 0;
            color: #4a437e;
            text-align: center;
            font-weight: 700;
            font-family: "Staatliches", cursive;
        }

        .ticket-time span {
            font-weight: 400;
            color: gray;
        }

        .left .ticket-time {
            font-size: 16px;
        }

        .ticket-location {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100%;
            padding-top: 8px;
            color: rgb(23, 14, 14);
            font-weight: bold;
            border-top: 1px solid gray;
        }

        .ticket-location .separator {
            font-size: 20px;
        }

        .right {
            width: 180px;
            height: 350px;
            border-left: 1px dashed #404040;
        }

        .right .admit-one {
            color: darkgray;
        }

        .right .admit-one span:nth-child(2) {
            color: gray;
        }

        .right .right-info-container {
            height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }

        .right .ticket-show-name h1 {
            font-size: 18px;
        }

        .ticket-barcode {
            height: 100px;
        }

        .ticket-barcode img {
            height: 100%;
        }

        .right .ticket-number {
            color: gray;
        }
    </style>

    {{-- Toastify CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay"
        style="background-image: url(booked/bg-img/breadcumb3.jpg); height: 200px;">
        <div class="bradcumbContent">
            <p>See what you have purchased </p>
            <h2>Hotel Booked History</h2>
        </div>
    </section>

    <!-- ##### Breadcumb Area End ##### -->
    <section class="ticket-section">
        @if ($mybookeds->isEmpty())
            <p style="text-align: center; font-size:24px">No Hotel Found</p>
        @else
            @foreach ($mybookeds as $hotel)
                <div class="ticket created-by-anniedotexe">
                    <div class="left">

                        <div class="ticket-image"
                            @if ($hotel->hotel->image == null)
                                style="background-color: #ccc;">
                                No Image
                            @else
                                @php
                                    $imagePath = asset('images/' . $hotel->hotel->image);
                                @endphp
                                style="background-image: url('{{ $imagePath }}');">
                                <!-- Debugging output -->
                                {{-- <p>{{ $imagePath }}</p> --}}
                            @endif
                        </div>

                        <div class="ticket-info">
                            <p class="ticket-date">
                                <span>{{ \Carbon\Carbon::parse($hotel->booking_date)->format('l') }}</span>
                                <!--format('l') returns the day of the week (e.g., Tuesday). -->
                                <span
                                    class="month-day">{{ \Carbon\Carbon::parse($hotel->booking_date)->format('F j') }}</span>
                                <!--format('F j') returns the month (e.g., June) and day (e.g., 29). -->
                                <span>{{ \Carbon\Carbon::parse($hotel->booking_date)->format('Y') }}</span>
                                <!-- format('Y') returns the year. -->
                            </p>

                            <div class="ticket-show-name">
                                <p class="ticket-location">Hotel Name : {{ $hotel->hotel_name }}</p>
                                <p class="ticket-location">Room Type : {{ $hotel->room->type }}</p>
                            </div>

                            <p class="ticket-location">Gender : {{ $hotel->gender }}</p>
                            <p class="ticket-location">Person : {{ $hotel->quantity }}</p>

                            {{-- <div class="ticket-time">
                                <p class="ticket-location">{{ \Carbon\Carbon::parse($hotel->checkin_time)->diffForHumans() }}</p>
                            </div> --}}

                        </div>
                    </div>
                    <div class="right">
                        <div class="right-info-container">
                            <div class="ticket-time">
                                <p style="font-weight:500;margin-top:10px;">Check_In_Time : <span
                                        style=" color: #d83565; font-weight:bold">{{ \Carbon\Carbon::parse($hotel->checkin_time)->format('g:i A') }}</span>
                                </p>
                                <p style="font-weight:500;margin-top:-10px;">Check_Out_Time : <span
                                    style=" color: #d83565; font-weight:bold">{{ \Carbon\Carbon::parse($hotel->checkout_time)->format('g:i A') }}</span>
                                </p>
                            </div>

                            <div class="ticket-barcode">
                                {!! QrCode::size(100)->generate(route('verify.hotel', ['hotelId' => $hotel->id])) !!}
                                {{-- {!! QrCode::size(100)->generate('https://www.douyin.com/video/7194920128637603105') !!} --}}
                                {{-- <img src="https://external-preview.redd.it/cg8k976AV52mDvDb5jDVJABPrSZ3tpi1aXhPjgcDTbw.png?auto=webp&s=1c205ba303c1fa0370b813ea83b9e1bddb7215eb"
                                    alt="QR code"> --}}
                            </div>

                            <div class="ticket-time">
                                <p style="color: #d83565; font-weight:bold">
                                    @if ($hotel->payment_status == 'Unpaid')
                                        <span>Unpaid</span>
                                    @elseif($hotel->payment_status == 'Paid')
                                        <span>Paid</span>
                                    @endif
                                </p>
                            </div>

                            <a href="{{ url('viewBookedHotel/' . $hotel->id) . '/view' }}" target="_blank"
                                class="navy-blue-button">View Detail</a><br>

                                @if($hotel->payment_status == 0)
                                <form action="{{ route('booking.verify.hotel', $hotel->id) }}" method="POST">

                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $hotel->user_id }}">
                                    <input type="hidden" name="hotel_id" value="{{ $hotel->hotel_id }}">
                                    <input type="hidden" name="checkin_date" value="{{ $hotel->checkin_date }}">
                                    <input type="hidden" name="checkout_date" value="{{ $hotel->checkout_date }}">
                                    <input type="hidden" name="total_price" value="{{ $hotel->total_price }}">
                                    <input type="hidden" name="verify_code" value="{{ $hotel->verify_code }}">

                                    <button type="submit" onclick="return confirm('Are you sure you want to verify this booking?')" class="navy-blue-button">Verify</button>
                                </form>

                                <br>

                                <form action="{{ route('booking.cancel.hotel', $hotel->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure you want to Cancel this Booking?')" class="btn btn-sm btn-danger">Cancelled The Booking</button>
                                </form>

                            @elseif($hotel->payment_status == 1)

                                <form action="{{ route('booking.checkout.hotel', $hotel->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Are you sure you want to check out this hotel?')" class="btn btn-sm btn-danger">Check Out</button>
                                </form>

                            @elseif($hotel->payment_status == 2)

                                <span class="badge badge-secondary" style="font-size:15px">Checked Out</span>

                            @elseif($hotel->payment_status == 3)

                                <span class="badge badge-secondary" style="font-size:15px">Your cancelled the Booking</span>

                            @endif

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- New Delete Selected All Hotel Has Booked --}}
    <script>
        // Function to check/uncheck all checkboxes
        function checkAll(checkbox) {
            const checkboxes = document.getElementsByClassName('checkbox_ids');
            for (const cb of checkboxes) {
                cb.checked = checkbox.checked;
            }
        }

        document.getElementById('deleteAllSelectedRecord').addEventListener('click', function() {
            const checkboxes = document.getElementsByClassName('checkbox_ids');
            const selectedIds = [];

            for (const checkbox of checkboxes) {
                if (checkbox.checked) {
                    selectedIds.push(parseInt(checkbox.value));
                }
            }

            if (selectedIds.length === 0) {
                alert('Please select at least one restaurant to delete.');
            } else {
                const form = document.getElementById('deleteMultipleForm');
                const idsInput = document.createElement('input');
                idsInput.type = 'hidden';
                idsInput.name = 'ids';
                idsInput.value = JSON.stringify(selectedIds);
                form.appendChild(idsInput);

                form.submit();
            }
        });
    </script>

    {{-- Toastr JS --}}
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

    <!-- 在模板底部添加以下 JavaScript 代码 -->
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var paymentLinks = document.querySelectorAll('.payment-link');

            paymentLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    var restaurantId = this.getAttribute('data-restaurant-id');
                    var tableId = this.getAttribute('data-table-id');

                    // 发送 POST 请求
                    fetch('/paymentrestaurant/' + restaurantId + '/view/' + tableId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content')
                        },
                        // 如果需要传递额外的数据，可以添加 body 属性
                        // body: JSON.stringify({ key: 'value' })
                    }).then(response => {
                        // 处理响应
                        if (response.ok) {
                            // 请求成功，可以执行成功的处理
                            console.log('Payment processed successfully.');
                        } else {
                            // 请求失败，可以执行失败的处理
                            console.error('Payment processing failed.');
                        }
                    }).catch(error => {
                        // 处理异常
                        console.error('Error processing payment:', error);
                    });
                });
            });
        });
    </script> --}}

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var paymentLinks = document.querySelectorAll('.payment-link');

            paymentLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    var restaurantId = this.getAttribute('data-restaurant-id');
                    var tableId = this.getAttribute('data-table-id');

                    // 发送 POST 请求
                    fetch('/paymentrestaurant/' + restaurantId + '/view/' + tableId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content')
                        },
                        // 如果需要传递额外的数据，可以添加 body 属性
                        // body: JSON.stringify({ key: 'value' })
                    }).then(response => {
                        // 处理响应
                        if (response.ok) {
                            // 请求成功，可以执行成功的处理
                            console.log('Payment processed successfully.');

                            // 显示成功消息
                            var successMessage = document.createElement('div');
                            successMessage.className = 'alert alert-success';
                            successMessage.textContent = 'Payment processed successfully.';

                            // 插入到适当的位置
                            document.body.appendChild(successMessage);
                        } else {
                            // 请求失败，可以执行失败的处理
                            console.error('Payment processing failed.');
                        }
                    }).catch(error => {
                        // 处理异常
                        console.error('Error processing payment:', error);
                    });
                });
            });
        });
    </script> --}}

    {{-- Customer Check Out Function --}}
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var paymentForm = document.getElementById('paymentForm');

            paymentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                var hotelId = paymentForm.querySelector('.payment-link').getAttribute(
                    'data-hotel-id');
                var tableId = paymentForm.querySelector('.payment-link').getAttribute('data-table-id');

                // 发送 POST 请求
                fetch('/paymenthotel/' + hotelId + '/view/' + tableId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                    })
                    .then(response => {
                        // 检查响应状态码
                        if (response.ok) {
                            // 返回 JSON 数据
                            return response.json();
                        } else {
                            throw new Error('网络响应失败');
                        }
                    })
                    .then(data => {
                        // 处理成功的响应数据
                        console.log('支付成功。');

                        // 显示成功消息
                        var successMessage = document.createElement('div');
                        successMessage.className = 'alert alert-success';
                        successMessage.textContent = '支付成功。';

                        // 插入到适当的位置
                        document.body.appendChild(successMessage);

                        // 这里你可能需要根据实际情况更新页面的其他部分，例如隐藏或禁用按钮等
                    })
                    .catch(error => {
                        // 处理异常
                        console.error('支付处理出错:', error);
                    })
                    .finally(() => {
                        // 提交表单，如果不手动提交，表单将不会被提交
                        paymentForm.submit();
                    });
            });
        });
    </script> --}}

    {{-- JS --}}
    {{-- <script>
        function processPayment(restaurantId, tableId) {
            // 发送 POST 请求
            fetch('{{ route("process.payment.restaurant", ["id" => ":id", "table_id" => ":table_id"]) }}'.replace(':id', restaurantId).replace(':table_id', tableId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                // 处理响应
                if (response.ok) {
                    // 请求成功，可以执行成功的处理
                    console.log('Payment processed successfully.');

                    // 显示成功消息
                    var successMessage = document.createElement('div');
                    successMessage.className = 'alert alert-success';
                    successMessage.textContent = 'Payment processed successfully.';

                    // 插入到适当的位置
                    document.body.appendChild(successMessage);
                } else {
                    // 请求失败，可以执行失败的处理
                    console.error('Payment processing failed.');
                }
            }).catch(error => {
                // 处理异常
                console.error('Error processing payment:', error);
            });
        }
    </script> --}}

    {{-- Used Checkbox Mutliple Delete Records --}}
    {{-- <script>
        function checkAll() {
            var checkboxes = document.querySelectorAll('.checkbox_ids');
            var selectAllCheckbox = document.getElementById('select_all_ids');

            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        function checkAndDelete(restaurantId, tableId) {
            var checkbox = document.querySelector('.checkbox_ids[value="' + restaurantId + '"]');
            checkbox.checked = true; // Check the checkbox

            deleteSelectedRecords();
        }

        function deleteSelectedRecords() {
            var checkboxes = document.querySelectorAll('.checkbox_ids:checked');

            if (checkboxes.length > 0) {
                var ids = Array.from(checkboxes).map(function (checkbox) {
                    return checkbox.value;
                });

                // AJAX request to delete multiple records
                fetch('/restaurants/deleteMultiplebookedrestaurant', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error('Network response failed');
                    }
                })
                .then(data => {
                    // Handle the response data, e.g., show success message
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error deleting records:', error);
                });
            } else {
                alert('Please select at least one record to delete.');
            }
        }
    </script> --}}

    {{-- <script>
        // Function to delete selected records using AJAX
        function deleteSelectedRecords() {
            var selectedIds = [];
            var checkboxes = document.getElementsByClassName('checkbox_ids');

            // Collect selected IDs
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    selectedIds.push(checkboxes[i].value);
                }
            }

            // Check if any record is selected
            if (selectedIds.length > 0) {
                // Create a new FormData object
                var formData = new FormData();
                formData.append('ids', selectedIds.join(','));

                // Create a new XMLHttpRequest object
                var xhr = new XMLHttpRequest();

                // Configure it to make a POST request
                xhr.open('POST', "{{ route('customer.deleteMultiplebookedrestaurant') }}", true);

                // Set the appropriate headers
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                // Set the onload callback
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Successful response, you can handle success here
                        alert('Selected Customer Booked Restaurants have been deleted successfully!');
                        location.reload(); // Refresh the page or update the UI as needed
                    } else {
                        // Handle the error here
                        alert('Error deleting Customer Booked Restaurants.');
                    }
                };

                // Send the request with the FormData
                xhr.send(formData);
            } else {
                alert("Please select at least one record to delete.");
            }
        }
    </script> --}}



@endsection
