@extends('backend-user.newlayout')

@section('newuser-section')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

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
            max-width: 500px;
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
                Extand Booking Day
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
                <button onclick="closeCancelModal()" class="btn btn-cancel">取消</button>
                <form action="{{ route('booking.cancel', $bookingResort->id) }}" method="POST">
                    @csrf
                    <input type="hidden" id="selectedDatesInput" name="selected_dates">
                    <button type="submit" class="btn btn-cancel">确认取消</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Extand and Cancel Resort Booked Date --}}
    <script>
        let bookingDates = @json($bookingDates); // Get dates from backend
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
            const selectedDates = getSelectedDates();
            if (selectedDates.length === 0) {
                alert('Please select dates to extend');
                return;
            }

            document.getElementById('selectedDatesText').innerHTML = selectedDates.join('<br>');
            const modal = document.getElementById('extendModal');
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
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

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.remove('active');
            setTimeout(() => modal.style.display = 'none', 300);
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

        window.onload = initializePage;

        window.onclick = function(event) {
            const modal = document.getElementById('cancelModal');
            if (event.target === modal) {
                closeCancelModal();
            }
        }
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
@endsection
