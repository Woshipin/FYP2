@extends('backend-user.newlayout')

@section('newuser-section')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- Flatpickr CSS for Date Picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --gradient-start: #4086f4;
            --gradient-end: #2dd4bf;
            --primary-color: #4086f4;
            --secondary-color: #2dd4bf;
            --danger-color: #ef4444;
            --text-color: #1f2937;
            --background-color: #f9fafb;
            --card-background: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            width: 100%;
        }

        .booking-info {
            background-color: var(--card-background);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            opacity: 0;
            transform: translateY(20px);
        }

        .booking-header {
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
            padding: 24px;
            color: white;
        }

        .booking-header h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .booking-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .booking-content {
            padding: 24px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            padding: 16px;
            border-radius: 12px;
            opacity: 0;
            transform: translateX(-20px);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-item.resort-name {
            background-color: #eff6ff;
        }

        .info-item.resort-type {
            background-color: #f0fdfa;
        }

        .info-item.resort-price {
            background-color: #ecfdf5;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .resort-name .info-icon {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .resort-type .info-icon {
            background-color: #ccfbf1;
            color: #0d9488;
        }

        .resort-price .info-icon {
            background-color: #d1fae5;
            color: #059669;
        }

        .info-text {
            flex: 1;
        }

        .info-label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: var(--text-color);
        }

        .dates-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
            margin: 30px 0;
            opacity: 0;
            transform: translateY(20px);
        }

        .date-card {
            background-color: var(--card-background);
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .date-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color);
        }

        .date-card.selected {
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
            color: white;
            border: none;
        }

        .date-icon {
            width: 32px;
            height: 32px;
            margin-bottom: 8px;
        }

        .date-text {
            font-size: 14px;
            font-weight: 500;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 16px;
            opacity: 0;
            transform: translateY(20px);
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-extend {
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
            color: white;
        }

        .btn-cancel {
            background-color: #fef2f2;
            color: var(--danger-color);
            border: 1px solid #fee2e2;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background-color: var(--card-background);
            padding: 24px;
            border-radius: 16px;
            width: 90%;
            max-width: 800px;
            /* 增加最大宽度 */
            max-height: 90vh;
            /* 设置最大高度 */
            overflow-y: auto;
            /* 添加垂直滚动条 */
            box-shadow: var(--shadow);
            transform: scale(0.9);
            opacity: 0;
            transition: var(--transition);
        }

        .modal.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .modal-header {
            margin-bottom: 20px;
        }

        .modal-header h3 {
            font-size: 20px;
            color: var(--text-color);
            font-weight: 600;
        }

        .modal-body {
            margin-bottom: 24px;
        }

        .date-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            transition: var(--transition);
            margin-top: 12px;
        }

        .date-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(64, 134, 244, 0.1);
        }

        .show {
            opacity: 1;
            transform: translateY(0) translateX(0) scale(1);
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .dates-container {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        .payment-method-selector {
            margin-bottom: 20px;
        }

        .payment-options {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
        }

        .payment-option:hover {
            border-color: var(--primary-color);
        }

        .payment-option img {
            width: 32px;
            height: 32px;
        }

        .payment-option span {
            font-size: 14px;
            font-weight: 500;
        }

        .card-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-container .front,
        .card-container .back {
            width: 300px;
            height: 180px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-container .front .image {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .card-container .front .image img {
            width: 40px;
            height: 40px;
        }

        .card-container .front .card-number-box {
            font-size: 18px;
            font-weight: 500;
            margin: 20px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-container .front .flexbox {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .card-container .front .flexbox .box {
            text-align: left;
        }

        .card-container .front .flexbox .box span {
            font-size: 12px;
            color: #6b7280;
        }

        .card-container .front .flexbox .box .card-holder-name,
        .card-container .front .flexbox .box .expiration {
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-container .back .stripe {
            width: 100%;
            height: 40px;
            background-color: #e5e7eb;
            margin-bottom: 20px;
        }

        .card-container .back .box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .card-container .back .box span {
            font-size: 12px;
            color: #6b7280;
        }

        .card-container .back .box .cvv-box {
            width: 60px;
            height: 40px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-input-section {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .card-input-section .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .card-input-section .input-group label {
            font-size: 14px;
            font-weight: 500;
        }

        .card-input-section .input-group .card-input {
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            transition: var(--transition);
        }

        .card-input-section .input-group .card-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(64, 134, 244, 0.1);
        }

        .card-extra-details {
            display: flex;
            justify-content: space-between;
            gap: 16px;
        }

        .card-extra-details .input-group {
            flex: 1;
        }

        .payment-summary {
            background-color: #ffffff;
            /* 背景颜色 */
            border: 1px solid #e5e7eb;
            /* 边框 */
            border-radius: 12px;
            /* 圆角 */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            /* 阴影 */
            padding: 20px;
            /* 内边距 */
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .summary-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            text-align: center;
        }

        .summary-item span:first-child {
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            /* 标题颜色 */
        }

        .summary-item span:last-child {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
            /* 价格颜色 */
        }

        .submit-button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="container">
        <div class="booking-info">
            <div class="booking-header">
                <h2>Resort Booking Detail</h2>
            </div>
            <div class="booking-content">
                <div class="info-grid">
                    <div class="info-item resort-name">
                        <div class="info-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path
                                    d="M3 21h18M3 7v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7M7 21V11M17 21V11M5 21h14M4 7l2-4h12l2 4" />
                            </svg>
                        </div>
                        <div class="info-text">
                            <div class="info-value" id="resortName"></div>
                        </div>
                    </div>
                    <div class="info-item resort-type">
                        <div class="info-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M2 12h20M2 12l10-10M2 12l10 10M22 12l-10-10M22 12l-10 10" />
                            </svg>
                        </div>
                        <div class="info-text">
                            <div class="info-value" id="resortType"></div>
                        </div>
                    </div>
                    <div class="info-item resort-price">
                        <div class="info-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                        </div>
                        <div class="info-text">
                            <div class="info-value">RM<span id="resortPrice"></span>/days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dates-container" id="datesContainer"></div>

        <div class="actions">
            <button class="btn btn-extend" onclick="handleExtend()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 10H3M21 6H3M21 14H3M21 18H3" />
                </svg>
                Extend Booking Day
            </button>
            <button class="btn btn-cancel" onclick="handleCancel()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
                Cancel Booking Day
            </button>
        </div>
    </div>

    {{-- <div class="modal" id="extendModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>选择延长日期</h3>
            </div>
            <div class="modal-body">
                <div>您选择要延长的日期：</div>
                <input type="text" id="extendDatePicker" class="date-input" placeholder="Select dates">
                <div style="margin-top: 15px;">延长的总价格：RM <span id="totalExtendPrice">0</span></div>
            </div>
            <div class="modal-footer">
                <button onclick="closeExtendModal()" class="btn btn-cancel">取消</button>
                <button onclick="continueExtend()" class="btn btn-extend">继续</button>
            </div>
        </div>
    </div>

    <div class="modal" id="paymentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Select You Payment Method</h3>
            </div>
            <div class="modal-body">
                <div class="payment-method-selector">
                    <h3>Select Payment Method</h3>
                    <div class="payment-options">
                        <div class="payment-option" data-method="credit_card">
                            <img src="{{ asset('new/img/card-icon.png') }}" alt="Card">
                            <span>Credit/Debit Card</span>
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
                            <div class="card-number-box" id="card-number-display">################</div>
                            <div class="flexbox">
                                <div class="box">
                                    <span>Card Holder</span>
                                    <div class="card-holder-name" id="card-holder-display">FULL NAME</div>
                                </div>
                                <div class="box">
                                    <span>Expires</span>
                                    <div class="expiration">
                                        <span class="exp-month" id="exp-month-display">MM</span>
                                        <span class="exp-year" id="exp-year-display">YY</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-input-section">
                        <div class="input-group">
                            <label>Card Number</label>
                            <input type="text" id="card_number" name="card_number" maxlength="19" class="card-input"
                                placeholder="0000 0000 0000 0000" oninput="updateCardNumberDisplay()">
                        </div>

                        <div class="input-group">
                            <label>Card Holder Name</label>
                            <input type="text" name="card_holder" id="card_holder" class="card-input"
                                oninput="updateCardHolderDisplay()">
                        </div>

                        <div class="card-extra-details">
                            <div class="input-group">
                                <label>Expiry Month</label>
                                <select name="card_month" id="card_month" class="card-input"
                                    onchange="updateExpiryMonthDisplay()">
                                    <option value="" selected disabled>MM</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}">
                                            {{ sprintf('%02d', $i) }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="input-group">
                                <label>Expiry Year</label>
                                <select name="card_year" id="card_year" class="card-input"
                                    onchange="updateExpiryYearDisplay()">
                                    <option value="" selected disabled>YY</option>
                                    @for ($i = date('Y'); $i <= date('Y') + 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="input-group">
                                <label>CVV</label>
                                <input type="text" name="cvv" id="cvv" maxlength="4" class="card-input"
                                    oninput="updateCVVDisplay()">
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <!-- Common Payment Information -->
                <div class="payment-summary">
                    <div class="summary-item">
                        <span>Deposit Fee</span>
                        <span>RM 100.00</span>
                        <input type="hidden" name="deposit_price" value="100">
                    </div>
                    <div class="summary-item">
                        <span>Resort Total Price</span>
                        <span>RM <span id="total_price">0.00</span></span>
                    </div>
                </div>

                <!-- Submit Button (for card payment) -->
                <button type="submit" class="submit-button" id="submit-button">
                    Complete Payment
                </button>

                <!-- Progress Bar -->
                <div class="progress-container" id="progressBarContainer" style="display: none;">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="modal" id="extendModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>选择延长日期</h3>
            </div>
            <div class="modal-body">
                <div>您选择要延长的日期：</div>
                <input type="text" id="extendDatePicker" class="date-input" placeholder="Select dates">
                <div style="margin-top: 15px;">延长的总价格：RM <span id="totalExtendPrice">0</span></div>
            </div>
            <div class="modal-footer">
                <button onclick="closeExtendModal()" class="btn btn-cancel">取消</button>
                <button onclick="continueExtend()" class="btn btn-extend">继续</button>
            </div>
        </div>
    </div>

    <div class="modal" id="paymentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Select Your Payment Method</h3>
            </div>
            <div class="modal-body">
                <form id="paymentForm" action="{{ route('booking.extend', $bookingResort->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="extend_dates" id="extendDatesInput">
                    <input type="hidden" name="payment_information" id="paymentInformationInput">
                    <!-- 其他支付信息输入框 -->
                    <div class="card-input-section">
                        <div class="input-group">
                            <label>Card Number</label>
                            <input type="text" id="card_number" name="card_number" maxlength="19" class="card-input"
                                placeholder="0000 0000 0000 0000" oninput="updateCardNumberDisplay()">
                        </div>

                        <div class="input-group">
                            <label>Card Holder Name</label>
                            <input type="text" name="card_holder" id="card_holder" class="card-input"
                                oninput="updateCardHolderDisplay()">
                        </div>

                        <div class="card-extra-details">
                            <div class="input-group">
                                <label>Expiry Month</label>
                                <select name="card_month" id="card_month" class="card-input"
                                    onchange="updateExpiryMonthDisplay()">
                                    <option value="" selected disabled>MM</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}">
                                            {{ sprintf('%02d', $i) }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="input-group">
                                <label>Expiry Year</label>
                                <select name="card_year" id="card_year" class="card-input"
                                    onchange="updateExpiryYearDisplay()">
                                    <option value="" selected disabled>YY</option>
                                    @for ($i = date('Y'); $i <= date('Y') + 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="input-group">
                                <label>CVV</label>
                                <input type="text" name="cvv" id="cvv" maxlength="4" class="card-input"
                                    oninput="updateCVVDisplay()">
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- Common Payment Information -->
                    <div class="payment-summary">
                        <div class="summary-item">
                            <span>Deposit Fee</span>
                            <span>RM 100.00</span>
                            <input type="hidden" name="deposit_price" value="100">
                        </div>
                        <div class="summary-item">
                            <span>Resort Total Price</span>
                            <span>RM <span id="total_price">0.00</span></span>
                        </div>
                    </div>

                    <!-- Submit Button (for card payment) -->
                    <button type="submit" class="submit-button" id="submit-button">
                        Complete Payment
                    </button>

                    <!-- Progress Bar -->
                    <div class="progress-container" id="progressBarContainer" style="display: none;">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal" id="cancelModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>选择取消日期</h3>
            </div>
            <div class="modal-body">
                <div>您选择要取消的日期：</div>
                <div id="selectedDatesText"></div>
                <div style="margin-top: 15px;">取消的总价格：RM <span id="totalCancelPrice">0</span></div>
            </div>
            <div class="modal-footer">
                <button onclick="closeCancelModal()" class="btn btn-cancel">Close</button>
                <form action="{{ route('booking.cancel', $bookingResort->id) }}" method="POST">
                    @csrf
                    <input type="hidden" id="selectedDatesInput" name="selected_dates">
                    <button type="submit" class="btn btn-cancel">Comfirm Cancel Booking</button>
                </form>
            </div>
        </div>
    </div>

    {{-- --------------------------------------------- JS Area --------------------------------------------- --}}

    {{-- Flatpickr JS for Date Picker --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- Extend and Cancel Resort Booked Date --}}
    {{-- <script>
        let bookingDates = @json($bookingDates); // Get dates from backend

        console.log(bookingDates)

        const resortInfo = {
            name: "{{ $bookingResort->resort->name }}",
            type: "{{ $bookingResort->resort->type }}",
            price: {{ $bookingResort->resort->price }}
        };

        function initializePage() {
            // Set resort basic information
            document.getElementById('resortName').textContent = resortInfo.name;
            document.getElementById('resortType').textContent = resortInfo.type;
            document.getElementById('resortPrice').textContent = resortInfo.price;

            renderDates();
            animatePageLoad();
        }

        function renderDates() {
            const container = document.getElementById('datesContainer');
            container.innerHTML = '';

            bookingDates.forEach((dateStr, index) => {
                const date = new Date(dateStr);
                const dateCard = document.createElement('div');
                dateCard.className = 'date-card';
                dateCard.innerHTML = `
                <svg class="date-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span class="date-text">${formatDate(date)}</span>
            `;
                dateCard.onclick = () => toggleDateSelection(dateCard, index);
                container.appendChild(dateCard);
            });
        }

        function formatDate(date) {
            const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const weekday = weekdays[date.getDay()];
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Add leading zero if needed
            const day = date.getDate().toString().padStart(2, '0'); // Add leading zero if needed

            return `${year}-${month}-${day} ${weekday}`;
        }

        function toggleDateSelection(dateCard, index) {
            dateCard.classList.toggle('selected');
            if (!bookingDates[index].selected) {
                bookingDates[index] = {
                    date: bookingDates[index],
                    selected: true
                };
            } else {
                bookingDates[index] = {
                    date: bookingDates[index],
                    selected: false
                };
            }
        }

        function getSelectedDates() {
            return bookingDates
                .filter(dateObj => dateObj.selected)
                .map(dateObj => formatDate(new Date(dateObj.date)));
        }

        function handleExtend() {
            const modal = document.getElementById('extendModal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);

            // Initialize Flatpickr for date selection
            flatpickr("#extendDatePicker", {
                mode: "multiple",
                dateFormat: "Y-m-d",
                minDate: "today", // Disable past dates
                disable: bookingDates.map(date => date.date), // Disable already booked dates
                onChange: function(selectedDates, dateStr, instance) {
                    const totalExtendPrice = selectedDates.length * resortInfo.price;
                    document.getElementById('totalExtendPrice').textContent = totalExtendPrice;
                }
            });
        }

        function handleCancel() {
            const selectedDates = getSelectedDates();
            if (selectedDates.length === 0) {
                alert('Please select dates to cancel');
                return;
            }

            const totalCancelPrice = selectedDates.length * resortInfo.price;
            document.getElementById('selectedDatesText').innerHTML = selectedDates.join('<br>');
            document.getElementById('totalCancelPrice').textContent = totalCancelPrice;
            document.getElementById('selectedDatesInput').value = JSON.stringify(selectedDates);

            const modal = document.getElementById('cancelModal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
        }

        function closeExtendModal() {
            const modal = document.getElementById('extendModal');
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
        }

        function continueExtend() {
            const selectedDates = document.getElementById('extendDatePicker').value.split(',');
            if (selectedDates.length === 0) {
                alert('Please select dates to extend');
                return;
            }

            const totalExtendPrice = selectedDates.length * resortInfo.price;
            document.getElementById('total_price').textContent = totalExtendPrice;

            closeExtendModal();

            const paymentModal = document.getElementById('paymentModal');
            paymentModal.style.display = 'flex';
            setTimeout(() => paymentModal.classList.add('active'), 10);
        }

        function animatePageLoad() {
            const bookingInfo = document.querySelector('.booking-info');
            const infoItems = document.querySelectorAll('.info-item');
            const datesContainer = document.querySelector('.dates-container');
            const dateCards = document.querySelectorAll('.date-card');
            const actions = document.querySelector('.actions');

            setTimeout(() => {
                bookingInfo.classList.add('show');
            }, 100);

            infoItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('show');
                }, 300 + index * 100);
            });

            setTimeout(() => {
                datesContainer.classList.add('show');
            }, 600);

            dateCards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('show');
                }, 800 + index * 50);
            });

            setTimeout(() => {
                actions.classList.add('show');
            }, 1200);
        }

        function updateCardNumberDisplay() {
            const cardNumber = document.getElementById('card_number').value;
            document.getElementById('card-number-display').textContent = cardNumber.replace(/\s/g, '').replace(/(.{4})/g,
                '$1 ').trim();
        }

        function updateCardHolderDisplay() {
            const cardHolder = document.getElementById('card_holder').value;
            document.getElementById('card-holder-display').textContent = cardHolder.toUpperCase();
        }

        function updateExpiryMonthDisplay() {
            const expiryMonth = document.getElementById('card_month').value;
            document.getElementById('exp-month-display').textContent = expiryMonth;
        }

        function updateExpiryYearDisplay() {
            const expiryYear = document.getElementById('card_year').value;
            document.getElementById('exp-year-display').textContent = expiryYear;
        }

        function updateCVVDisplay() {
            const cvv = document.getElementById('cvv').value;
            document.getElementById('cvv-display').textContent = cvv;
        }

        window.onload = initializePage;

        window.onclick = function(event) {
            const modal = document.getElementById('cancelModal');
            if (event.target === modal) {
                closeCancelModal();
            }

            const extendModal = document.getElementById('extendModal');
            if (event.target === extendModal) {
                closeExtendModal();
            }

            const paymentModal = document.getElementById('paymentModal');
            if (event.target === paymentModal) {
                paymentModal.classList.remove('active');
                setTimeout(() => paymentModal.style.display = 'none', 300);
            }
        }
    </script> --}}

    {{-- processing --}}
    <script>
        let bookingDates = @json($bookingDates); // Get dates from backend
        let allBookingDates = @json($allBookingDates); // Get all booking dates from backend

        console.log(allBookingDates)

        const resortInfo = {
            name: "{{ $bookingResort->resort->name }}",
            type: "{{ $bookingResort->resort->type }}",
            price: {{ $bookingResort->resort->price }}
        };

        function initializePage() {
            // Set resort basic information
            document.getElementById('resortName').textContent = resortInfo.name;
            document.getElementById('resortType').textContent = resortInfo.type;
            document.getElementById('resortPrice').textContent = resortInfo.price;

            renderDates();
            animatePageLoad();
        }

        function renderDates() {
            const container = document.getElementById('datesContainer');
            container.innerHTML = '';

            bookingDates.forEach((dateStr, index) => {
                const date = new Date(dateStr);
                const dateCard = document.createElement('div');
                dateCard.className = 'date-card';
                dateCard.innerHTML = `
                <svg class="date-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span class="date-text">${formatDate(date)}</span>
            `;
                dateCard.onclick = () => toggleDateSelection(dateCard, index);
                container.appendChild(dateCard);
            });
        }

        function formatDate(date) {
            const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const weekday = weekdays[date.getDay()];
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Add leading zero if needed
            const day = date.getDate().toString().padStart(2, '0'); // Add leading zero if needed

            return `${year}-${month}-${day} ${weekday}`;
        }

        function toggleDateSelection(dateCard, index) {
            dateCard.classList.toggle('selected');
            if (!bookingDates[index].selected) {
                bookingDates[index] = {
                    date: bookingDates[index],
                    selected: true
                };
            } else {
                bookingDates[index] = {
                    date: bookingDates[index],
                    selected: false
                };
            }
        }

        function getSelectedDates() {
            return bookingDates
                .filter(dateObj => dateObj.selected)
                .map(dateObj => formatDate(new Date(dateObj.date)));
        }

        function handleExtend() {
            const modal = document.getElementById('extendModal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);

            // Initialize Flatpickr for date selection
            flatpickr("#extendDatePicker", {
                mode: "multiple",
                dateFormat: "Y-m-d",
                minDate: "today", // Disable past dates
                disable: allBookingDates, // Disable all booked dates
                onChange: function(selectedDates, dateStr, instance) {
                    const totalExtendPrice = selectedDates.length * resortInfo.price;
                    document.getElementById('totalExtendPrice').textContent = totalExtendPrice;
                }
            });
        }

        function handleCancel() {
            const selectedDates = getSelectedDates();
            if (selectedDates.length === 0) {
                alert('Please select dates to cancel');
                return;
            }

            const totalCancelPrice = selectedDates.length * resortInfo.price;
            document.getElementById('selectedDatesText').innerHTML = selectedDates.join('<br>');
            document.getElementById('totalCancelPrice').textContent = totalCancelPrice;
            document.getElementById('selectedDatesInput').value = JSON.stringify(selectedDates);

            const modal = document.getElementById('cancelModal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
        }

        function closeExtendModal() {
            const modal = document.getElementById('extendModal');
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
        }

        function continueExtend() {
            const selectedDates = document.getElementById('extendDatePicker').value.split(',');
            if (selectedDates.length === 0) {
                alert('Please select dates to extend');
                return;
            }

            const totalExtendPrice = selectedDates.length * resortInfo.price;

            // 检查元素是否存在
            const totalPriceElement = document.getElementById('total_price');
            if (totalPriceElement) {
                totalPriceElement.textContent = totalExtendPrice;
            } else {
                console.error('Element with id "total_price" not found');
            }

            // 设置延长日期和支付信息
            const extendDatesInput = document.getElementById('extendDatesInput');
            const paymentInformationInput = document.getElementById('paymentInformationInput');

            if (extendDatesInput && paymentInformationInput) {
                extendDatesInput.value = selectedDates.join(','); // 确保日期以逗号分隔
                paymentInformationInput.value = JSON.stringify({
                    card_number: document.getElementById('card_number').value,
                    card_holder: document.getElementById('card_holder').value,
                    card_month: document.getElementById('card_month').value,
                    card_year: document.getElementById('card_year').value,
                    cvv: document.getElementById('cvv').value,
                });
            } else {
                console.error('Element with id "extendDatesInput" or "paymentInformationInput" not found');
            }

            closeExtendModal();

            const paymentModal = document.getElementById('paymentModal');
            if (paymentModal) {
                paymentModal.style.display = 'flex';
                setTimeout(() => paymentModal.classList.add('active'), 10);
            } else {
                console.error('Element with id "paymentModal" not found');
            }
        }


        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            event.preventDefault();
            // 处理支付逻辑
            // 支付成功后提交表单
            this.submit();
        });

        document.getElementById('paymentForm').addEventListener('submit', function(event) {
            event.preventDefault();
            // 处理支付逻辑
            // 支付成功后提交表单
            this.submit();
        });


        function animatePageLoad() {
            const bookingInfo = document.querySelector('.booking-info');
            const infoItems = document.querySelectorAll('.info-item');
            const datesContainer = document.querySelector('.dates-container');
            const dateCards = document.querySelectorAll('.date-card');
            const actions = document.querySelector('.actions');

            setTimeout(() => {
                bookingInfo.classList.add('show');
            }, 100);

            infoItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('show');
                }, 300 + index * 100);
            });

            setTimeout(() => {
                datesContainer.classList.add('show');
            }, 600);

            dateCards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('show');
                }, 800 + index * 50);
            });

            setTimeout(() => {
                actions.classList.add('show');
            }, 1200);
        }

        function updateCardNumberDisplay() {
            const cardNumber = document.getElementById('card_number').value;
            document.getElementById('card-number-display').textContent = cardNumber.replace(/\s/g, '').replace(/(.{4})/g,
                '$1 ').trim();
        }

        function updateCardHolderDisplay() {
            const cardHolder = document.getElementById('card_holder').value;
            document.getElementById('card-holder-display').textContent = cardHolder.toUpperCase();
        }

        function updateExpiryMonthDisplay() {
            const expiryMonth = document.getElementById('card_month').value;
            document.getElementById('exp-month-display').textContent = expiryMonth;
        }

        function updateExpiryYearDisplay() {
            const expiryYear = document.getElementById('card_year').value;
            document.getElementById('exp-year-display').textContent = expiryYear;
        }

        function updateCVVDisplay() {
            const cvv = document.getElementById('cvv').value;
            document.getElementById('cvv-display').textContent = cvv;
        }

        window.onload = initializePage;

        window.onclick = function(event) {
            const modal = document.getElementById('cancelModal');
            if (event.target === modal) {
                closeCancelModal();
            }

            const extendModal = document.getElementById('extendModal');
            if (event.target === extendModal) {
                closeExtendModal();
            }

            const paymentModal = document.getElementById('paymentModal');
            if (event.target === paymentModal) {
                paymentModal.classList.remove('active');
                setTimeout(() => paymentModal.style.display = 'none', 300);
            }
        }
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            let bookingDates = @json($bookingDates); // Get dates from backend
            let allBookingDates = @json($allBookingDates); // Get all booking dates from backend

            console.log(allBookingDates);

            const resortInfo = {
                name: "{{ $bookingResort->resort->name }}",
                type: "{{ $bookingResort->resort->type }}",
                price: {{ $bookingResort->resort->price }}
            };

            // 定义所有函数
            function initializePage() {
                // Set resort basic information
                const resortNameElement = document.getElementById('resortName');
                const resortTypeElement = document.getElementById('resortType');
                const resortPriceElement = document.getElementById('resortPrice');

                if (resortNameElement) resortNameElement.textContent = resortInfo.name;
                if (resortTypeElement) resortTypeElement.textContent = resortInfo.type;
                if (resortPriceElement) resortPriceElement.textContent = resortInfo.price;

                renderDates();
                animatePageLoad();
            }

            function renderDates() {
                const container = document.getElementById('datesContainer');
                if (container) {
                    container.innerHTML = '';

                    bookingDates.forEach((dateStr, index) => {
                        const date = new Date(dateStr);
                        const dateCard = document.createElement('div');
                        dateCard.className = 'date-card';
                        dateCard.innerHTML = `
                <svg class="date-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span class="date-text">${formatDate(date)}</span>
            `;
                        dateCard.onclick = () => toggleDateSelection(dateCard, index);
                        container.appendChild(dateCard);
                    });
                }
            }

            function formatDate(date) {
                const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                const weekday = weekdays[date.getDay()];
                const year = date.getFullYear();
                const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Add leading zero if needed
                const day = date.getDate().toString().padStart(2, '0'); // Add leading zero if needed

                return `${year}-${month}-${day} ${weekday}`;
            }

            function toggleDateSelection(dateCard, index) {
                dateCard.classList.toggle('selected');
                if (!bookingDates[index].selected) {
                    bookingDates[index] = {
                        date: bookingDates[index],
                        selected: true
                    };
                } else {
                    bookingDates[index] = {
                        date: bookingDates[index],
                        selected: false
                    };
                }
            }

            function getSelectedDates() {
                return bookingDates
                    .filter(dateObj => dateObj.selected)
                    .map(dateObj => formatDate(new Date(dateObj.date)));
            }

            function handleExtend() {
                const modal = document.getElementById('extendModal');
                if (modal) {
                    modal.style.display = 'flex';
                    setTimeout(() => modal.classList.add('active'), 10);

                    // Initialize Flatpickr for date selection
                    flatpickr("#extendDatePicker", {
                        mode: "multiple",
                        dateFormat: "Y-m-d",
                        minDate: "today", // Disable past dates
                        disable: allBookingDates, // Disable all booked dates
                        onChange: function(selectedDates, dateStr, instance) {
                            const totalExtendPrice = selectedDates.length * resortInfo.price;
                            const totalExtendPriceElement = document.getElementById('totalExtendPrice');
                            if (totalExtendPriceElement) {
                                totalExtendPriceElement.textContent = totalExtendPrice;
                            }
                        }
                    });
                }
            }

            function handleCancel() {
                const selectedDates = getSelectedDates();
                if (selectedDates.length === 0) {
                    alert('Please select dates to cancel');
                    return;
                }

                const totalCancelPrice = selectedDates.length * resortInfo.price;
                const selectedDatesTextElement = document.getElementById('selectedDatesText');
                const totalCancelPriceElement = document.getElementById('totalCancelPrice');
                const selectedDatesInputElement = document.getElementById('selectedDatesInput');

                if (selectedDatesTextElement) selectedDatesTextElement.innerHTML = selectedDates.join('<br>');
                if (totalCancelPriceElement) totalCancelPriceElement.textContent = totalCancelPrice;
                if (selectedDatesInputElement) selectedDatesInputElement.value = JSON.stringify(selectedDates);

                const modal = document.getElementById('cancelModal');
                if (modal) {
                    modal.style.display = 'flex';
                    setTimeout(() => modal.classList.add('active'), 10);
                }
            }

            function closeExtendModal() {
                const modal = document.getElementById('extendModal');
                if (modal) {
                    modal.classList.remove('active');
                    setTimeout(() => modal.style.display = 'none', 300);
                }
            }

            function closeCancelModal() {
                const modal = document.getElementById('cancelModal');
                if (modal) {
                    modal.classList.remove('active');
                    setTimeout(() => modal.style.display = 'none', 300);
                }
            }

            function continueExtend() {
                const selectedDates = document.getElementById('extendDatePicker').value.split(',');
                if (selectedDates.length === 0) {
                    alert('Please select dates to extend');
                    return;
                }

                const totalExtendPrice = selectedDates.length * resortInfo.price;

                // 检查元素是否存在
                const totalPriceElement = document.getElementById('total_price');
                if (totalPriceElement) {
                    totalPriceElement.textContent = totalExtendPrice;
                } else {
                    console.error('Element with id "total_price" not found');
                }

                // 设置延长日期和支付信息
                const extendDatesInput = document.getElementById('extendDatesInput');
                const paymentInformationInput = document.getElementById('paymentInformationInput');

                if (extendDatesInput && paymentInformationInput) {
                    extendDatesInput.value = selectedDates;
                    paymentInformationInput.value = JSON.stringify({
                        card_number: document.getElementById('card_number').value,
                        card_holder: document.getElementById('card_holder').value,
                        card_month: document.getElementById('card_month').value,
                        card_year: document.getElementById('card_year').value,
                        cvv: document.getElementById('cvv').value,
                    });
                } else {
                    console.error('Element with id "extendDatesInput" or "paymentInformationInput" not found');
                }

                closeExtendModal();

                const paymentModal = document.getElementById('paymentModal');
                if (paymentModal) {
                    paymentModal.style.display = 'flex';
                    setTimeout(() => paymentModal.classList.add('active'), 10);
                } else {
                    console.error('Element with id "paymentModal" not found');
                }
            }

            function animatePageLoad() {
                const bookingInfo = document.querySelector('.booking-info');
                const infoItems = document.querySelectorAll('.info-item');
                const datesContainer = document.querySelector('.dates-container');
                const dateCards = document.querySelectorAll('.date-card');
                const actions = document.querySelector('.actions');

                setTimeout(() => {
                    if (bookingInfo) bookingInfo.classList.add('show');
                }, 100);

                infoItems.forEach((item, index) => {
                    setTimeout(() => {
                        if (item) item.classList.add('show');
                    }, 300 + index * 100);
                });

                setTimeout(() => {
                    if (datesContainer) datesContainer.classList.add('show');
                }, 600);

                dateCards.forEach((card, index) => {
                    setTimeout(() => {
                        if (card) card.classList.add('show');
                    }, 800 + index * 50);
                });

                setTimeout(() => {
                    if (actions) actions.classList.add('show');
                }, 1200);
            }

            function updateCardNumberDisplay() {
                const cardNumber = document.getElementById('card_number').value;
                const cardNumberDisplay = document.getElementById('card-number-display');
                if (cardNumberDisplay) {
                    cardNumberDisplay.textContent = cardNumber.replace(/\s/g, '').replace(/(.{4})/g, '$1 ').trim();
                } else {
                    console.error('Element with id "card-number-display" not found');
                }
            }

            function updateCardHolderDisplay() {
                const cardHolder = document.getElementById('card_holder').value;
                const cardHolderDisplay = document.getElementById('card-holder-display');
                if (cardHolderDisplay) {
                    cardHolderDisplay.textContent = cardHolder.toUpperCase();
                } else {
                    console.error('Element with id "card-holder-display" not found');
                }
            }

            function updateExpiryMonthDisplay() {
                const expiryMonth = document.getElementById('card_month').value;
                const expMonthDisplay = document.getElementById('exp-month-display');
                if (expMonthDisplay) {
                    expMonthDisplay.textContent = expiryMonth;
                } else {
                    console.error('Element with id "exp-month-display" not found');
                }
            }

            function updateExpiryYearDisplay() {
                const expiryYear = document.getElementById('card_year').value;
                const expYearDisplay = document.getElementById('exp-year-display');
                if (expYearDisplay) {
                    expYearDisplay.textContent = expiryYear;
                } else {
                    console.error('Element with id "exp-year-display" not found');
                }
            }

            function updateCVVDisplay() {
                const cvv = document.getElementById('cvv').value;
                const cvvDisplay = document.getElementById('cvv-display');
                if (cvvDisplay) {
                    cvvDisplay.textContent = cvv;
                } else {
                    console.error('Element with id "cvv-display" not found');
                }
            }

            document.getElementById('paymentForm').addEventListener('submit', function(event) {
                event.preventDefault();
                // 处理支付逻辑
                // 支付成功后提交表单
                this.submit();
            });

            window.onclick = function(event) {
                const modal = document.getElementById('cancelModal');
                if (event.target === modal) {
                    closeCancelModal();
                }

                const extendModal = document.getElementById('extendModal');
                if (event.target === extendModal) {
                    closeExtendModal();
                }

                const paymentModal = document.getElementById('paymentModal');
                if (event.target === paymentModal) {
                    paymentModal.classList.remove('active');
                    setTimeout(() => paymentModal.style.display = 'none', 300);
                }
            }

            // 初始化页面
            initializePage();
        });
    </script> --}}

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
@endsection
