<!DOCTYPE html>
<html>

<head>
    <title>OTP Verification</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700">

    {{-- toastify CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- OTP CSS --}}
    <style>
        * {
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: #ccc;
            display: flex;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        .card {
            border: none;
            width: 330px;
            margin: 0 auto;
            border-radius: 10px;
            background: #fff;
            box-shadow: rgb(50 50 93 / 25%) 0px 6px 12px -2px, rgb(0 0 0 / 30%) 0px 3px 7px -3px;
        }

        .card-top {
            color: #fff;
            background-image: linear-gradient(144deg, #5B42F3 50%, #00DDEB);
            text-align: center;
            padding: 30px 0 30px 0;
            border-radius: 10px 10px 0 0;
        }

        .card-top>img {
            width: 150px;
        }

        .card-top h5 {
            font-size: 20px;
            margin: 10px 0 10px 0;
        }

        .input-container {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            padding: 20px 0 30px 0;
        }

        .input-container input {
            width: 40px;
            height: 40px;
            border: none;
            border-bottom: 1px solid #5b42f3;
            text-align: center;
            outline: none;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .resend-otp {
            text-align: center;
        }

        .btn {
            padding: 30px 0 30px 0;
            text-align: center;
        }

        .verify-btn {
            border-radius: 20px;
            border: 0px;
            width: 140px;
            background-color: #3366FF;
        }

        .button-verify {
            margin: 0 auto;
            padding: 12px 70px;
            text-align: center;
            text-transform: uppercase;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            border-radius: 10px;
            display: block;
            border: 0px;
            font-weight: 700;
            box-shadow: 0px 0px 14px -7px #5B42F3;
            background-image: linear-gradient(45deg, #AF40FF 0%, #5B42F3 51%, #00DDEB 100%);
            cursor: pointer;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            background-position: right center;
        }

        .button-verify:hover {
            background-position: unset;
            color: #fff;
            text-decoration: none;
        }

        .button-verify:active {
            transform: scale(0.95);
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1140px;
            }
        }
    </style>

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="container">
        <div class="card">

            <!-- Card top Code -->
            <div class="card-top">
                <img src="{{ asset('OTP/mobile-icon.png') }}" alt="Mobile Icon">
                <h5>OTP Verification</h5>
                <div>
                    <small>Enter the OTP number that has been sent to your email</small>
                </div>
            </div>

            <form action="{{ url('/users/verify-otp') }}" method="POST">
                @csrf
                <div class="input-container">
                    <input type="number" maxlength="1" name="otp[]" required>
                    <input type="number" maxlength="1" name="otp[]" required>
                    <input type="number" maxlength="1" name="otp[]" required>
                    <input type="number" maxlength="1" name="otp[]" required>
                    <input type="number" maxlength="1" name="otp[]" required>
                    <input type="number" maxlength="1" name="otp[]" required>
                    <input type="hidden" name="user_id" value="{{ $id }}">
                </div>

                <!-- Resend Code -->
                <div class="resend-otp">
                    <small>
                        <a href="">Resend OTP?</a>
                    </small>
                </div>

                <!-- Button Code -->
                <div class="btn">
                    <button type="submit" class="button-verify" role="button">verify</button>
                </div>
            </form>
        </div>
    </div>
</body>

{{-- OTP JS --}}
<script>
    // JavaScript to handle OTP input behavior
    document.addEventListener("DOMContentLoaded", function() {
        const inputs = document.querySelectorAll('.input-container input');

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === input.maxLength && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('paste', (event) => {
                const paste = (event.clipboardData || window.clipboardData).getData('text');
                const pasteArray = paste.split('');

                if (pasteArray.length === inputs.length) {
                    inputs.forEach((input, index) => {
                        input.value = pasteArray[index];
                    });
                }

                event.preventDefault();
            });
        });
    });
</script>

{{-- Resend OTP Number --}}
<script>
    // Handle resend OTP link click
    document.getElementById('resend-otp-link').addEventListener('click', function(event) {
            event.preventDefault();

            const userId = document.querySelector('input[name="user_id"]').value;

            fetch('{{ url('/users/resend-otp') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Toastify({
                        text: data.success,
                        duration: 5000,
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)"
                        }
                    }).showToast();
                }
            })
            .catch(error => {
                Toastify({
                    text: "Failed to resend OTP. Please try again.",
                    duration: 5000,
                    style: {
                        background: "linear-gradient(to right, #b90000, #c99396)"
                    }
                }).showToast();
            });
        });
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

</html>
