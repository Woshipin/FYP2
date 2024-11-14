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
                            <!-- 显示用的输入框 -->
                            <input type="text" id="promotion_dates_display" class="form-control" readonly>
                            <!-- 用于存放隐藏日期输入框的容器 -->
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
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // 初始化 Flatpickr
            var fp = flatpickr("#promotion_dates_display", {
                mode: "multiple",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "F j, Y",
                inline: true,
                appendTo: document.getElementById('calendar-container'),
                onChange: function(selectedDates, dateStr, instance) {
                    // 为每个选择的日期创建一个隐藏的输入框
                    $('#hidden-dates-container').empty(); // 清空现有的隐藏输入框

                    selectedDates.forEach(date => {
                        let formattedDate = date.toISOString().split('T')[0];
                        $('#hidden-dates-container').append(
                            `<input type="hidden" name="promotion_dates[]" value="${formattedDate}">`
                        );
                    });

                    // 更新显示的日期
                    if (selectedDates.length > 0) {
                        let displayDates = selectedDates.map(date => {
                            return date.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });
                        }).join(', ');
                        $('#promotion_dates_display').val(displayDates);
                    } else {
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

                // 检查是否选择了日期
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

                // 记录提交的日期（用于调试）
                console.log('Submitting dates:', selectedDatesInputs.map(function() {
                    return $(this).val();
                }).get());
            });

            // 重置按钮功能
            $('#reset-dates').on('click', function() {
                fp.clear();
                $('#hidden-dates-container').empty();
                $('#promotion_dates_display').val('');
            });

            // 可选：禁用过去的日期
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
