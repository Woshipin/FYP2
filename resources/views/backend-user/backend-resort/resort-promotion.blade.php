@extends('backend-user.newlayout')

@section('newuser-section')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Flatpickr CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    {{-- New Toastr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Load jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Load Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Load Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Load Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Load FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- 在页面头部添加 moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <style>
        .card-header {
            font-weight: bold;
        }

        .list-unstyled li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .list-unstyled li:last-child {
            border-bottom: none;
        }
    </style>

    {{-- back-arrow-circle css --}}
    <style>
        .back-arrow-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            margin-left: 15px; /* 与容器的左边距对齐 */
            margin-top: 10px; /* 进一步缩短上边距 */
        }

        .back-arrow-circle a {
            color: #007bff;
            text-decoration: none;
            font-size: 20px;
        }

        .container {
            margin-top: 0; /* 完全去除容器的上边距 */
        }
    </style>

    {{-- -------------------------------------------------------- HTML Area ---------------------------------------------------------- --}}

    {{-- <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h1 class="mb-0">Promotion Dates for {{ $resort->name }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('resort.promotion.save', $resort->id) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="promotion_dates_display" class="form-label">Select Promotion Dates</label>
                        <div class="input-group">
                            <input type="text" id="promotion_dates_display" class="form-control" readonly>
                            <div id="hidden-dates-container"></div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="calendar-icon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div id="calendar-container" class="mt-3" style="display: none;"></div>
                    </div>

                    <!-- 添加价格输入框 -->
                    <div class="form-group mb-3">
                        <label for="promotion_price" class="form-label">Enter Promotion Price</label>
                        <div class="input-group">
                            <input type="number" id="promotion_price" name="promotion_price" class="form-control"
                                placeholder="Enter price for selected dates">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save Promotion Dates</button>
                        <button type="button" id="reset-dates" class="btn btn-secondary">Reset</button>
                    </div>
                </form>

                <!-- 显示现有促销日期和价格 -->
                <div class="mt-4">
                    <h3>Current Promotion Dates</h3>
                    @if ($promotionDates->count() > 0)
                        <div class="row">
                            @foreach ($promotionDates as $month => $dates)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            {{ $month }}
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled">
                                                @foreach ($dates as $date)
                                                    <li>
                                                        {{ Carbon\Carbon::parse($date->date)->format('j F Y') }} -
                                                        RM{{ $date->price }}
                                                        <a href="#" class="btn btn-link text-primary edit-price"
                                                            data-date-id="{{ $date->id }}"
                                                            data-date="{{ $date->date }}"
                                                            data-price="{{ $date->price }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('resort.promotion.delete', ['id' => $resort->id, 'date_id' => $date->id]) }}"
                                                            onclick="return confirm('Are you sure to delete this date?')"
                                                            class="btn btn-link text-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            No promotion dates set yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

    <div class="back-arrow-circle">
        <a href="{{ url('/showResort') }}">
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h1 class="mb-0">Promotion Dates for {{ $resort->name }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('resort.promotion.save', $resort->id) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="promotion_dates_display" class="form-label">Select Promotion Dates</label>
                        <div class="input-group">
                            <input type="text" id="promotion_dates_display" class="form-control" readonly>
                            <div id="hidden-dates-container"></div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="calendar-icon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div id="calendar-container" class="mt-3" style="display: none;"></div>
                    </div>

                    <!-- 添加价格输入框 -->
                    <div class="form-group mb-3">
                        <label for="promotion_price" class="form-label">Enter Promotion Price</label>
                        <div class="input-group">
                            <input type="number" id="promotion_price" name="promotion_price" class="form-control"
                                placeholder="Enter price for selected dates">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save Promotion Dates</button>
                        <button type="button" id="reset-dates" class="btn btn-secondary">Reset</button>
                    </div>
                </form>

                <!-- 显示现有促销日期和价格 -->
                <div class="mt-4">
                    <h3>Current Promotion Dates</h3>
                    @if ($promotionDates->count() > 0)
                        <div class="row">
                            @foreach ($promotionDates as $month => $dates)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            {{ $month }}
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-unstyled">
                                                @foreach ($dates as $date)
                                                    <li>
                                                        {{ Carbon\Carbon::parse($date->date)->format('j F Y') }} -
                                                        RM{{ $date->price }}
                                                        <a href="#" class="btn btn-link text-primary edit-price"
                                                            data-date-id="{{ $date->id }}"
                                                            data-date="{{ $date->date }}"
                                                            data-price="{{ $date->price }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="{{ route('resort.promotion.delete', ['id' => $resort->id, 'date_id' => $date->id]) }}"
                                                            onclick="return confirm('Are you sure to delete this date?')"
                                                            class="btn btn-link text-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            No promotion dates set yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- 编辑价格的模态框 -->
    <div class="modal fade" id="editPriceModal" tabindex="-1" aria-labelledby="editPriceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPriceModalLabel">Edit Promotion Price</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPriceForm">
                        @csrf
                        <input type="hidden" id="edit_date_id" name="date_id">
                        <div class="form-group mb-3">
                            <label for="edit_date" class="form-label">Date</label>
                            <input type="text" id="edit_date" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_price" class="form-label">Price</label>
                            <input type="number" id="edit_price" name="price" class="form-control"
                                placeholder="Enter new price">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEditPrice">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- -------------------------------------------------------- JS Area ---------------------------------------------------------- --}}
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- Moment JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    {{-- Full Pormotion Calander and Price FUnction --}}
    <script>
        $(document).ready(function() {
            // 获取现有的促销日期
            var existingDates = [
                @foreach ($promotionDates->flatten() as $date)
                    "{{ Carbon\Carbon::parse($date->date)->format('Y-m-d') }}",
                @endforeach
            ];

            // 初始化 Flatpickr
            var fp = flatpickr("#promotion_dates_display", {
                mode: "multiple",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "F j, Y",
                inline: true,
                // 禁用现有的日期
                disable: existingDates,
                appendTo: document.getElementById('calendar-container'),
                time_24hr: true,
                onChange: function(selectedDates, dateStr, instance) {
                    $('#hidden-dates-container').empty();

                    selectedDates.forEach(date => {
                        let formattedDate = moment(date).format('YYYY-MM-DD');
                        $('#hidden-dates-container').append(
                            `<input type="hidden" name="promotion_dates[]" value="${formattedDate}">`
                        );
                    });

                    // 不更新输入框的值，以免显示已选择日期
                    if (selectedDates.length === 0) {
                        $('#promotion_dates_display').val('');
                    }
                }
            });

            // 日历图标点击事件
            $('#calendar-icon').on('click', function() {
                $('#calendar-container').toggle();
            });

            // 点击文档其他地方时关闭日历
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#calendar-container, #calendar-icon, .flatpickr-calendar')
                    .length) {
                    $('#calendar-container').hide();
                }
            });

            // 表单提交验证
            $('form').on('submit', function(e) {
                let selectedDatesInputs = $('input[name="promotion_dates[]"]');
                let promotionPriceInput = $('#promotion_price');

                if (selectedDatesInputs.length === 0) {
                    e.preventDefault();
                    Toastify({
                        text: "Please select at least one promotion date",
                        duration: 3000,
                        style: {
                            background: "linear-gradient(to right, #b90000, #c99396)"
                        }
                    }).showToast();
                    return false;
                }

                if (promotionPriceInput.val() === '' || isNaN(promotionPriceInput.val())) {
                    e.preventDefault();
                    Toastify({
                        text: "Please enter a valid promotion price",
                        duration: 3000,
                        style: {
                            background: "linear-gradient(to right, #b90000, #c99396)"
                        }
                    }).showToast();
                    return false;
                }
            });

            // 重置按钮功能
            $('#reset-dates').on('click', function() {
                fp.clear();
                $('#hidden-dates-container').empty();
                $('#promotion_dates_display').val('');
                $('#promotion_price').val('');
            });

            // 设置最小日期为今天
            fp.set('minDate', 'today');

            // 编辑价格按钮点击事件
            $('.edit-price').on('click', function(e) {
                e.preventDefault();
                let dateId = $(this).data('date-id');
                let date = $(this).data('date');
                let price = $(this).data('price');

                $('#edit_date_id').val(dateId);
                $('#edit_date').val(moment(date).format('D MMMM YYYY'));
                $('#edit_price').val(price);

                $('#editPriceModal').modal('show');
            });

            // 保存编辑价格
            $('#saveEditPrice').on('click', function() {
                let dateId = $('#edit_date_id').val();
                let newPrice = $('#edit_price').val();

                if (newPrice === '' || isNaN(newPrice)) {
                    Toastify({
                        text: "Please enter a valid promotion price",
                        duration: 3000,
                        style: {
                            background: "linear-gradient(to right, #b90000, #c99396)"
                        }
                    }).showToast();
                    return false;
                }

                $.ajax({
                    url: "{{ route('resort.promotion.update') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        date_id: dateId,
                        price: newPrice
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#editPriceModal').modal('hide');
                            Toastify({
                                text: "Promotion price updated successfully!",
                                duration: 3000,
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)"
                                }
                            }).showToast();
                            location.reload();
                        } else {
                            Toastify({
                                text: "Failed to update promotion price: " + response
                                    .message,
                                duration: 3000,
                                style: {
                                    background: "linear-gradient(to right, #b90000, #c99396)"
                                }
                            }).showToast();
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = "Failed to update promotion price";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += ": " + xhr.responseJSON.message;
                        } else {
                            errorMessage += ": " + error;
                        }
                        Toastify({
                            text: errorMessage,
                            duration: 3000,
                            style: {
                                background: "linear-gradient(to right, #b90000, #c99396)"
                            }
                        }).showToast();
                    }
                });
            });
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

    {{-- <script>
        function goBack() {
            window.history.back();
        }
    </script> --}}

@endsection
