@extends('backend-user.newlayout')

@section('newuser-section')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- BookingStatus Pusher --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // 启用Pusher日志记录 - 在生产中不要包括这个
        Pusher.logToConsole = true;

        var pusher = new Pusher('66e2c17903cc96af1475', {
            cluster: 'ap1'
        });

        var audio = new Audio('/sound/notification.mp3');

        var channel = pusher.subscribe('bookingstatus');
        channel.bind('booking-status', function() {
            // 在这里处理实时更新
            audio.play(); // 播放通知声音
            // 您可以在这里添加代码来更新UI或获取新数据
            // 例如，您可能希望重新加载页面或通过AJAX获取更新的数据
            location.reload(); // 重新加载页面以进行演示
        });
    </script>

    <style>
        .custom-col {
            width: 200px;
            /* Adjust the width as needed */
        }
    </style>

    {{-- Table CSS --}}
    <style>
        /* Custom CSS for better aesthetics */
        .data_table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
            border: 1px solid #dee2e6;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            background-color: #343a40;
            color: #ffffff;
            font-weight: bold;
            padding: 12px;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody tr.table-light:hover {
            background-color: #e9ecef;
        }

        .table tbody td {
            border-top: 1px solid #dee2e6;
            padding: 12px;
        }

        .table tbody tr:first-child td {
            border-top: none;
        }

        .table tbody tr:last-child td {
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: rgba(255, 255, 255, 1);
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-success:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }
    </style>

    <!-- Show All Restaurant -->
    <div class="container">

        {{-- <div id="map" style="height: 400px;"></div><br> --}}

        <div class="row">
            <div class="col-12">

                {{-- Search Has Booked Resort Function --}}
                <form action="{{ route('hasresortSearch') }}" method="GET"
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-white small m-2" name="user_name"
                            placeholder="User Name" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="resort_name"
                            placeholder="Resort Name" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="date" class="form-control bg-white small m-2" name="booking_date"
                            placeholder="booking_date" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="time" class="form-control bg-white small m-2" name="check_in_time"
                            placeholder="check_in_time" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="time" class="form-control bg-white small m-2" name="check_out_time"
                            placeholder="check_out_time" aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary pb-2"><i class="fas fa-search fa-sm"></i></button>
                        </div>
                    </div>
                </form>

                <br>

                <div class="data_table">

                    @if (\Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    @if (\Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-2">
                            <form action="{{ route('viewresort-pdf') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info m-1">View In PDF</button>
                            </form>
                        </div>
                        <div class="col" style="margin-left: -60px">
                            <form action="{{ route('downloadbookedresort-pdf') }}" method="POST" target="__blank">
                                @csrf
                                <button type="submit" class="btn btn-info m-1">Download PDF</button>
                            </form>
                        </div>
                    </div>

                    <hr>

                    {{-- Button to delete all selected items --}}
                    {{-- <form action="{{ route('resorts.deleteMultiplebookedresort') }}" method="post"
                        id="deleteMultipleForm">
                        @csrf --}}
                    {{-- Your table code here --}}
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                            {{-- <div class="row"> --}}
                            {{-- Button to delete all selected items --}}
                            <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecord">Delete All
                                Selected Booked Resorts</button>
                            {{-- Add Resort --}}
                            {{-- <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#tableModal">Add Table</button> --}}
                            {{-- Export Resort --}}
                            <a href="{{ url('export-bookedResort') }}"><button type="button"
                                    class="btn btn-primary m-1">Export Booked Resorts</button></a>
                            {{-- <form action="{{ route('viewresort-pdf') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info m-1">View In PDF</button>
                            </form>
                            <!-- Export Resort PDF Model -->
                            <form action="{{ route ('downloadbookedresort-pdf') }}" method="POST" target="__blank">
                                @csrf
                                <button type="submit" class="btn btn-info m-1">Download PDF</button>
                            </form> --}}

                            <!-- Button to delete all selected items -->
                            <thead class="table-dark">
                                <tr>
                                    <th><input type="checkbox" name="" id="select_all_ids" onclick="checkAll(this)">
                                    </th>
                                    <th class="p-2">User Name</th>
                                    <th class="p-2">Resort Name</th>
                                    <th class="p-2">Resort Price</th>
                                    <th class="p-2">Booking Date</th>
                                    <th class="p-2">Booking Check_in Time</th>
                                    <th class="p-2">Booking Check_out Time</th>
                                    <th class="p-2">User Gender</th>
                                    <th class="p-2">User Quantity</th>
                                    <th class="p-2">Payment Status</th>
                                    <th class="p-2">ACTIONS</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($resortbookeds !== null && count($resortbookeds) > 0)
                                    @foreach ($resortbookeds as $resort)
                                        <tr>
                                            <td><input type="checkbox" name="ids" class="checkbox_ids" id=""
                                                    value="{{ $resort->id }}"></td>
                                            <td>{{ $resort->user_name }}</td>
                                            <td>{{ $resort->resort_name }}</td>
                                            <td>{{ $resort->resort->price }}</td>
                                            <td>{{ \Carbon\Carbon::parse($resort->booking_date)->format('j F Y (l)') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($resort->checkin_time)->format('g:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($resort->checkout_time)->format('g:i A') }}</td>
                                            <td>{{ $resort->gender }}</td>
                                            <td>{{ $resort->quantity }}</td>
                                            <td>
                                                @if ($resort->payment_status == 0)
                                                    <span class="badge badge-primary" style="font-size:15px">Paid, Pending Check-in</span>
                                                @elseif ($resort->payment_status == 1)
                                                    <span class="badge badge-success" style="font-size:15px">Checked In</span>
                                                @elseif ($resort->payment_status == 2)
                                                    <span class="badge badge-secondary" style="font-size:15px">Checked Out</span>
                                                @elseif ($resort->payment_status == 3)
                                                    <span class="badge badge-secondary" style="font-size:15px">User cancelled the Booking</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('viewBookedResort/' . $resort->id) . '/view' }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i>&nbsp;View
                                                    Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9">No Resort Has Booked</td>
                                    </tr>
                                @endif
                            </tbody>

                        </table>
                    </div>
                    {{-- </form> --}}

                    <!-- Pagination links -->
                    {{ $resortbookeds->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- New Delete Selected All Restaurant Has Booked --}}
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

    {{-- Customer Check Out Function --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var paymentForm = document.getElementById('paymentForm');

            paymentForm.addEventListener('submit', function(event) {
                event.preventDefault();

                var resortId = paymentForm.querySelector('.payment-link').getAttribute('data-resort-id');

                // 发送 POST 请求
                fetch('/paymentresort/' + resortId + '/view', {
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
    </script>


@endsection
