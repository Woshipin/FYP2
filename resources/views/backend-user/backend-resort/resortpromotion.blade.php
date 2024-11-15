@extends('backend-user.newlayout')

@section('newuser-section')
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
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save Promotion Dates</button>
                        <button type="button" id="reset-dates" class="btn btn-secondary">Reset</button>
                    </div>
                </form>

                <!-- 显示现有促销日期 -->
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
                                                    <li>{{ Carbon\Carbon::parse($date->date)->format('j F Y') }}</li>
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
                defaultDate: existingDates, // 设置默认选中的日期
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
            });

            // 重置按钮功能
            $('#reset-dates').on('click', function() {
                fp.clear();
                $('#hidden-dates-container').empty();
                $('#promotion_dates_display').val('');
            });

            // 设置最小日期为今天
            fp.set('minDate', 'today');
        });
    </script> --}}

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
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Save Promotion Dates</button>
                        <button type="button" id="reset-dates" class="btn btn-secondary">Reset</button>
                    </div>
                </form>

                <!-- 显示现有促销日期 -->
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
                                                        {{ Carbon\Carbon::parse($date->date)->format('j F Y') }}
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
                // 不要将现有的日期作为默认值
                // defaultDate: existingDates,
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
            });

            // 重置按钮功能
            $('#reset-dates').on('click', function() {
                fp.clear();
                $('#hidden-dates-container').empty();
                $('#promotion_dates_display').val('');
            });

            // 设置最小日期为今天
            fp.set('minDate', 'today');
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
@endsection
