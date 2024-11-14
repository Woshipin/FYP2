@extends('backend-user.newlayout')

@section('newuser-section')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap');

        .container {
            width: 95%;
            max-width: 1400px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
            background: var(--bg-color);
            transition: background-color 0.5s, color 0.5s;
            position: relative;
            margin: 20px auto;
            overflow-x: auto;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
        }

        .wallet-card-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .wallet-card {
            flex: 1 1 calc(33.333% - 20px);
            margin: 10px;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
            background: var(--wallet-bg-color);
            transition: background-color 0.5s, color 0.5s;
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
            font-size: 14px;
            font-weight: 600;
        }

        .wallet-card .info .amount {
            font-size: 20px;
            font-weight: 700;
            margin-top: 10px;
        }

        .wallet-card .icon {
            font-size: 30px;
            opacity: 0.8;
        }

        .wallet-card .icon-background {
            position: absolute;
            width: 100px;
            height: 100px;
            filter: blur(20px);
            border-radius: 50%;
            top: -30px;
            right: -30px;
            transform: rotate(45deg);
            z-index: 0;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        table, th, td {
            border: 1px solid #747598;
        }

        th, td {
            padding: 10px;
            text-align: left;
            white-space: nowrap;
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
            top: 10px;
            right: 10px;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: background-color 0.5s, color 0.5s;
        }

        .toggle-btn i {
            margin-right: 8px;
            font-size: 16px;
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

        @media (max-width: 768px) {
            .wallet-card {
                flex: 1 1 calc(50% - 20px);
            }

            .container {
                padding: 15px;
            }

            h3 {
                font-size: 20px;
            }

            .wallet-card .info .title {
                font-size: 12px;
            }

            .wallet-card .info .amount {
                font-size: 18px;
            }

            .wallet-card .icon {
                font-size: 24px;
            }

            .wallet-card .icon-background {
                width: 80px;
                height: 80px;
                top: -20px;
                right: -20px;
            }

            table {
                font-size: 12px;
            }

            .toggle-btn {
                padding: 6px 12px;
                font-size: 12px;
            }

            .toggle-btn i {
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .wallet-card {
                flex: 1 1 100%;
            }

            .container {
                padding: 10px;
            }

            h3 {
                font-size: 18px;
            }

            .wallet-card .info .title {
                font-size: 10px;
            }

            .wallet-card .info .amount {
                font-size: 16px;
            }

            .wallet-card .icon {
                font-size: 20px;
            }

            .wallet-card .icon-background {
                width: 60px;
                height: 60px;
                top: -10px;
                right: -10px;
            }

            table {
                font-size: 10px;
            }

            .toggle-btn {
                padding: 4px 8px;
                font-size: 10px;
            }

            .toggle-btn i {
                font-size: 12px;
            }
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

            <div class="table-responsive">
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
                                <td class="night">{{ $wallet->id }}</td>
                                <td class="night">RM{{ $wallet->refund_user_balance }}</td>
                                <td class="night">RM{{ $wallet->refund_user_deposit }}</td>
                                <td class="night">{{ \Carbon\Carbon::parse($wallet->created_at)->format('Y-m-d') }}</td>
                                <td class="night">{{ \Carbon\Carbon::parse($wallet->updated_at)->format('H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $adminwallets->links() }}
            </div>
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
                localStorage.setItem('mode', className);
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
