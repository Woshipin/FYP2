{{-- @extends('backend-user.newlayout')

@section('newuser-section')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background: #59596f;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        span {
            color: white;
        }

        .container {
            overflow: hidden;
            border-radius: 30px;
            width: 300px;
            height: 650px;
            background: linear-gradient(to right, #202140, #2D2E48);
        }

        i.logo {
            color: #c0c4df;
        }

        span.account-label {
            font-size: 14px;
            color: #747598;
            font-weight: 700;
        }

        span.balance {
            font-size: 30px;
            color: #f5f4f1;
            font-weight: 600;
        }

        div.rounded-border {
            border: 6px solid transparent;
            background-origin: border-box;
            background-clip: padding-box, border-box;
            border-radius: 30px;
            position: relative;
        }

        .grey-color {
            background-image: linear-gradient(to top right, #181930 50%, #3b3c58), linear-gradient(145deg, transparent 75%, #3b4065);
        }

        .plain-color {
            z-index: 1;
            background-image: linear-gradient(to top right, #181930 50%, #3b3c58);
        }

        .green-color {
            background-image: linear-gradient(to top right, #181930 50%, #3b3c58), linear-gradient(145deg, transparent 75%, #00c6c4);
        }

        .yellow-color {
            background-image: linear-gradient(to top right, #181930 50%, #3b3c58), linear-gradient(220deg, transparent 75%, #f5b300);
        }

        .yellow-color::before {
            left: -48px;
            bottom: -48px;
            transform: rotate(-45deg);
            content: '';
            position: absolute;
            width: 100px;
            height: 100px;
            background: conic-gradient(#00c6c40f 0 12.5%, #f5b300af 0 37.5%, #f5b4000f 0 100%);
            filter: blur(15px);
        }

        .green-color::before {
            right: -98px;
            bottom: -68px;
            transform: rotate(225deg);
            content: '';
            position: absolute;
            width: 170px;
            height: 170px;
            background: conic-gradient(#00c6c40f 0 12.5%, #00c6c4af 0 37.5%, #00c6c40f 0 100%);
            filter: blur(30px);
        }

        span.currency-name {
            font-size: 16px;
            color: #f5f4f1;
            letter-spacing: 1px;
        }

        span.currency-value {
            font-size: 10px;
            font-weight: 700;
            color: #747598;
        }

        i.bitcoin {
            color: #f5b300;
        }

        i.ethereum {
            color: #878FAF;
        }

        i.ripple {
            color: #00C6C4;
        }

        div.menu>i {
            color: #494b64;
            font-size: 1.3em;
        }

        div.menu>i.active {
            color: #c0c4df;
            border-bottom: 4px solid #c0c4df;
            border-radius: 3px;
            padding-bottom: 20px;
        }
    </style>

    <div class="container">

        <div class="d-flex flex-row pt-5">
            <i class="fab fa-affiliatetheme logo"></i>
        </div>

        <h3 style="color: white">{{ $user->name }}'s Wallet</h3>

        @if ($wallet)
            <div class="mt-4 d-flex flex-column rounded-border grey-color py-4 px-3">
                <span class="account-label">My Account</span>
                <span class="balance">RM{{ $wallet->balance ?? '0.00' }}</span>
            </div>

            <div class="mt-2 d-flex flex-row justify-content-between rounded-border yellow-color px-3 py-4">
                <div class="d-flex flex-column">
                    <span class="currency-name">Profit</span>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <span>RM{{ $wallet->profit ?? '0.00' }}</span>
                </div>
            </div>

            <div class="mt-2 d-flex flex-row justify-content-between rounded-border plain-color px-3 py-4">
                <div class="d-flex flex-column">
                    <span class="currency-name">Refund Price</span>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <span>RM{{ $wallet->refund_price ?? '0.00' }}</span>
                </div>
            </div>

            <div class="mt-2 d-flex flex-row justify-content-between rounded-border green-color px-3 py-4">
                <div class="d-flex flex-column">
                    <span class="currency-name">Refund Deposit</span>
                </div>
                <div class="d-flex flex-column align-items-end">
                    <span>RM{{ $wallet->refund_deposit ?? '0.00' }}</span>
                </div>
            </div>
        @else
            <p>Wallet information is not available.</p>
        @endif

    </div>
@endsection --}}

@extends('backend-user.newlayout')

@section('newuser-section')

    <br><br><br><br><br><br>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            align-items: center;
            min-height: 100vh;
            color: var(--text-color);
        }

        .container {
            width: 100%;
            max-width: 1200px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            padding: 30px 20px;
            background: var(--bg-color);
            transition: background-color 0.3s ease, color 0.3s ease;
            position: relative;
            margin-top: -150px;
        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 26px;
            font-weight: 700;
        }

        .wallet-card-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .wallet-card {
            flex: 1;
            margin: 0 10px;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: var(--wallet-bg-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .wallet-card.grey-color {
            border: 2px solid #a2c2e2;
            box-shadow: 0 0 15px rgba(162, 194, 226, 0.7);
        }

        .wallet-card.yellow-color {
            border: 2px solid #f6e6a1;
            box-shadow: 0 0 15px rgba(246, 230, 161, 0.7);
        }

        .wallet-card.plain-color {
            border: 2px solid #f0f0f0;
            box-shadow: 0 0 15px rgba(240, 240, 240, 0.7);
        }

        .wallet-card .info {
            color: var(--text-color);
        }

        .wallet-card .info .title {
            font-size: 16px;
            font-weight: 600;
        }

        .wallet-card .info .amount {
            font-size: 24px;
            font-weight: 700;
            margin-top: 10px;
        }

        .wallet-card .icon {
            font-size: 40px;
            opacity: 0.8;
        }

        .wallet-card .icon-background {
            position: absolute;
            width: 120px;
            height: 120px;
            filter: blur(20px);
            border-radius: 50%;
            top: -40px;
            right: -40px;
            transform: rotate(45deg);
            z-index: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table,
        th,
        td {
            border: 1px solid #747598;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: var(--table-header-bg-color);
        }

        tr:nth-child(even) {
            background-color: var(--table-row-even-bg-color);
        }

        tr:nth-child(odd) {
            background-color: var(--table-row-odd-bg-color);
        }

        .toggle-btn {
            position: absolute;
            top: 10%;
            right: 20px;
            transform: translateY(-50%);
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .toggle-btn i {
            margin-right: 8px;
            font-size: 20px;
        }

        .dark-mode {
            background-color: #59596f;
            color: white;
        }

        .dark-mode .toggle-btn {
            background: black;
            color: white;
        }

        .dark-mode .toggle-btn i {
            color: white;
        }

        .light-mode {
            background-color: #f0f0f0;
            color: black;
        }

        .light-mode .toggle-btn {
            background: white;
            color: black;
        }

        .light-mode .toggle-btn i {
            color: black;
        }

        .night {
            color: var(--text-color);
        }
    </style>

    <div class="container">
        <h3>My Wallet Dashboard</h3>

        @if ($walletRecords->count() > 0)
            <div class="wallet-card-container">
                <div class="wallet-card grey-color">
                    <div class="info">
                        <span class="title">My Account Balance</span>
                        <div class="amount">RM{{ $totalBalance ?? '0.00' }}</div>
                    </div>
                    <div class="icon">💰</div>
                    <div class="icon-background"></div>
                </div>

                <div class="wallet-card yellow-color">
                    <div class="info">
                        <span class="title">Profit</span>
                        <div class="amount">RM{{ $totalProfit ?? '0.00' }}</div>
                    </div>
                    <div class="icon">💵</div>
                    <div class="icon-background"></div>
                </div>

                <div class="wallet-card plain-color">
                    <div class="info">
                        <span class="title">My Deposit</span>
                        <div class="amount">RM{{ $totalRefundDeposit ?? '0.00' }}</div>
                    </div>
                    <div class="icon">📊</div>
                    <div class="icon-background"></div>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th class="night">ID</th>
                        <th class="night">Profit</th>
                        <th class="night">My Deposit</th>
                        <th class="night">Transfer Date</th>
                        <th class="night">Transfer Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($adminwallets as $wallet)
                        <tr>
                            <td class="night" style="padding-left: 10px">{{ $wallet->id }}</td>
                            <td class="night" style="padding-left: 10px">RM{{ $wallet->refund_user_balance }}</td>
                            <td class="night" style="padding-left: 10px">RM{{ $wallet->refund_user_deposit }}</td>
                            <td class="night" style="padding-left: 10px">{{ \Carbon\Carbon::parse($wallet->created_at)->format('Y-m-d') }}</td>
                            <td class="night" style="padding-left: 10px">{{ \Carbon\Carbon::parse($wallet->updated_at)->format('H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center;">Wallet information is not available.</p>
        @endif

        <button class="toggle-btn" id="toggle-mode">
            <i class="fas fa-moon"></i>
        </button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById("toggle-mode");
            const body = document.body;

            const darkMode = {
                "--bg-color": "#59596f",
                "--wallet-bg-color": "linear-gradient(145deg, #202140, #2D2E48)",
                "--table-header-bg-color": "#3b3c58",
                "--table-row-even-bg-color": "#202140",
                "--table-row-odd-bg-color": "#292c3b",
                "--text-color": "white"
            };

            const lightMode = {
                "--bg-color": "#f0f0f0",
                "--wallet-bg-color": "linear-gradient(145deg, #ffffff, #eaeaea)",
                "--table-header-bg-color": "#dcdcdc",
                "--table-row-even-bg-color": "#eaeaea",
                "--table-row-odd-bg-color": "#f0f0f0",
                "--text-color": "black"
            };

            function applyMode(mode, className) {
                for (const [key, value] of Object.entries(mode)) {
                    document.documentElement.style.setProperty(key, value);
                }
                body.classList.toggle('dark-mode', className === 'dark-mode');
                body.classList.toggle('light-mode', className === 'light-mode');
            }

            toggleBtn.addEventListener("click", function() {
                const isDarkMode = body.classList.contains('dark-mode');
                if (isDarkMode) {
                    applyMode(lightMode, 'light-mode');
                    toggleBtn.style.backgroundColor = "white";
                    toggleBtn.style.color = "black";
                } else {
                    applyMode(darkMode, 'dark-mode');
                    toggleBtn.style.backgroundColor = "#f5b300";
                    toggleBtn.style.color = "#202140";
                }
            });

            const initialMode = localStorage.getItem('mode') || 'dark-mode';
            applyMode(initialMode === 'dark-mode' ? darkMode : lightMode, initialMode);
        });
    </script>

@endsection

