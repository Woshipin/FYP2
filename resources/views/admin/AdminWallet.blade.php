@extends('admin.layout')

@section('admin-section')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
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
            /* Light blue border */
            box-shadow: 0 0 15px rgba(162, 194, 226, 0.7);
            /* Light blue glow */
        }

        .wallet-card.yellow-color {
            border: 2px solid #f6e6a1;
            /* Light yellow border */
            box-shadow: 0 0 15px rgba(246, 230, 161, 0.7);
            /* Light yellow glow */
        }

        .wallet-card.plain-color {
            border: 2px solid #f0f0f0;
            /* Light white border */
            box-shadow: 0 0 15px rgba(240, 240, 240, 0.7);
            /* Light white glow */
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

        /* Toggle Button */
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

        /* Dark mode styles */
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

        /* Light mode styles */
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
        <h3>Admin Wallet Dashboard</h3>

        @if ($adminwallets)
            <div class="wallet-card-container">
                <div class="wallet-card grey-color">
                    <div class="info">
                        <span class="title">Admin Account Balance</span>
                        <div class="amount">RM{{ $totalBalance ?? '0.00' }}</div>
                    </div>
                    <div class="icon">💰</div>
                    <div class="icon-background"></div>
                </div>

                <div class="wallet-card yellow-color">
                    <div class="info">
                        <span class="title">Tax</span>
                        <div class="amount">RM{{ $totalTax ?? '0.00' }}</div>
                    </div>
                    <div class="icon">💵</div>
                    <div class="icon-background"></div>
                </div>

                <div class="wallet-card plain-color">
                    <div class="info">
                        <span class="title">User Deposit</span>
                        <div class="amount">RM{{ $totalUserDeposit ?? '0.00' }}</div>
                    </div>
                    <div class="icon">📊</div>
                    <div class="icon-background"></div>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th class="night">Transaction ID</th>
                        <th class="night">Type</th>
                        <th class="night">Amount</th>
                        <th class="night">Date</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($transactions as $transaction) --}}
                    <tr>
                        <td class="night" style="padding-left: 10px">aaa</td>
                        <td class="night" style="padding-left: 10px">aaa</td>
                        <td class="night" style="padding-left: 10px">aaa</td>
                        <td class="night" style="padding-left: 10px">aaa</td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        @else
            <p style="text-align: center;">Admin Wallet information is not available.</p>
        @endif

        <button class="toggle-btn" id="toggle-mode">
            <i class="fas fa-moon"></i>
        </button>
    </div>

    {{-- Dark Mode and White Mode --}}
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

            // Set initial mode to dark mode or light mode based on preference
            const initialMode = localStorage.getItem('mode') || 'dark-mode';
            applyMode(initialMode === 'dark-mode' ? darkMode : lightMode, initialMode);
        });
    </script>

@endsection
