@extends('backend-user.newlayout')

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
                    {{-- <span class="currency-value"><i class="fab fa-bitcoin bitcoin"></i> BTC</span> --}}
                </div>
                <div class="d-flex flex-column align-items-end">
                    <span>RM{{ $wallet->profit ?? '0.00' }}</span>
                    {{-- <span class="currency-value">0.900 BTC</span> --}}
                </div>
            </div>

            <div class="mt-2 d-flex flex-row justify-content-between rounded-border plain-color px-3 py-4">
                <div class="d-flex flex-column">
                    <span class="currency-name">Refund Price</span>
                    {{-- <span class="currency-value"><i class="fab fa-ethereum ethereum"></i> ETH</span> --}}
                </div>
                <div class="d-flex flex-column align-items-end">
                    <span>RM{{ $wallet->refund_price ?? '0.00' }}</span>
                    {{-- <span class="currency-value">3.503 ETH</span> --}}
                </div>
            </div>

            <div class="mt-2 d-flex flex-row justify-content-between rounded-border green-color px-3 py-4">
                <div class="d-flex flex-column">
                    <span class="currency-name">Refund Deposit</span>
                    {{-- <span class="currency-value"><i class="fas fa-dot-circle ripple"></i> XRP</span> --}}
                </div>
                <div class="d-flex flex-column align-items-end">
                    <span>RM{{ $wallet->refund_deposit ?? '0.00' }}</span>
                    {{-- <span class="currency-value">1.533 XRP</span> --}}
                </div>
            </div>
        @else
            <p>Wallet information is not available.</p>
        @endif


        {{-- <div class="d-flex flex-row menu justify-content-between px-3 py-5 mt-4">
            <i class="fas fa-home active"></i>
            <i class="fas fa-paper-plane "></i>
            <i class="fas fa-chart-bar "></i>
            <i class="fas fa-user"></i>
        </div> --}}

    </div>
@endsection
