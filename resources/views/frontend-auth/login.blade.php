<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <!-- Login and Register CSS -->
    <link rel="stylesheet" href="{{ asset('newauth/auth.css') }}">
    {{-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>

<body>

    <div class="wrapper">

        {{-- @if (\Session::has('error'))
            <center><div class="alert alert-danger">{{Session::get('error')}}</div></center>
        @endif

        @if (\Session::has('success'))
            <center><div class="alert alert-success">{{Session::get('success')}}</div></center>
        @endif --}}

        <form action="{{ route('userlogin') }}" method="POST">
            @csrf

            <h1>Login Page</h1>

            <div class="input-box">
                <input type="email" name="email" id="email" placeholder="Enter Your Email">
                <i class="bx bx-envelope"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Enter Your password">
                <i class="bx bxs-lock-alt"></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox" name="remember">Remember Me</label>
                {{-- <a href="{{ route('password.request') }}">Forget Password?</a> --}}
                <a href="{{ route("forget.password") }}">Forget Password?</a>
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="register-link">
                <p>Don't have an account?<a href="{{ url('register') }}">Register Here!!</a></p>
            </div>

        </form>

    </div>

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

</body>

</html>
