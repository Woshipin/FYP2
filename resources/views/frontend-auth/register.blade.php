<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>

    <!-- Login and Register CSS -->
    <link rel="stylesheet" href="{{ asset('newauth/auth.css') }}">
    {{-- <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>

    <div class="wrapper">

        <form action="{{ route('userregister') }}" method="POST">
            @csrf

            <h1>Register Page</h1>

            <div class="input-box">
                <input type="text" name="name" id="name" placeholder="Enter Your Name">
                <i class="bx bxs-user"></i>
            </div>

            <div class="input-box">
                <input type="text" name="email" id="email" placeholder="Enter Your Email">
                <i class="bx bx-envelope"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Enter Your password">
                <i class="bx bxs-lock-alt"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Comfirm Your password">
                <i class="bx bxs-lock-alt"></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="#">Forgot Password</a>
            </div>

            <button type="submit" class="btn">Register</button>

            <div class="register-link">
                <p>Have an account?<a href="{{ url('login') }}">Login Here!!</a></p>
            </div>

        </form>
    </div>

    {{-- Toastr JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- @if (Session::has('success'))
        <script>
            toastr.success("{!! Session::get('success') !!}");
        </script>
    @endif --}}

    {{-- @if (Session::has('fail'))
        <script>
            toastr.danger("{!! Session::get('fail') !!}");
        </script>
    @endif --}}

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
