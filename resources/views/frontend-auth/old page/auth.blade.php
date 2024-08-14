<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login & SignUp Form</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/style.css') }}">
</head>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <div class="button-box">

                <div id="btn"></div>

                <button type="button" class="toggle-btn" onclick="login()">Login</button>
                <button type="button" class="toggle-btn" id="register-btn" onclick="register()">Register</button>

            </div>

            <!-- <div class="social-media">
                <img src="{{asset('images/fb.png')}}">
                <img src="{{asset('images/insta.jpeg')}}">
                <img src="{{asset('images/twitter.png')}}">
            </div> -->

            <!-- @if(Session::has('success'))
                <center><div class="alert alert-success">{{Session::get('success')}}</div></center>
            @endif
            @if(Session::has('error'))
                <center><div class="alert alert-danger">{{Session::get('error')}}</div></center>
            @endif -->

            <!-- @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif -->

            @if(\Session::has('error'))
                <center><div class="alert alert-danger">{{Session::get('error')}}</div></center>
            @endif

            @if(\Session::has('success'))
                <center><div class="alert alert-success">{{Session::get('success')}}</div></center>
            @endif

            <form action="{{ route('userLogin') }}" class="login-form" id="login" method="POST">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-field" name="email" placeholder="Username" >
                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                </div>

                <input type="password" class="form-field" name="password" placeholder="Password" >
                <span class="text-danger">@error('password') {{$message}} @enderror</span>

                <input type="checkbox" class="checkbox"><span>Remember Password</span>

                <button type="sumbit" class="submit" value="Login">Login</button>
            </form>

            <form action="{{ route('userRegister') }}" class="login-form" id="register" method="POST">
                @csrf

                <input type="text" class="form-field" name="r_name" placeholder="Username" >
                @error('r_name')
                    @if($message == "The r name field must be a string.")
                        <span class="text-danger">Name must be a string</span>
                    @endif
                @enderror

                <input type="email" class="form-field" name="r_email" placeholder="Email Address" >
                <span class="text-danger">@error('r_email') {{$message}} @enderror</span>

                <input type="password" class="form-field" name="r_password" placeholder="Password">
                <span class="text-danger">@error('r_password') {{$message}} @enderror</span>

                <input type="password" class="form-field" name="r_password_confirmation" placeholder="Enter Confirm Password" >
                <!-- <span class="text-danger">@error('r_password_confirmation') {{$message}} @enderror</span> -->

                <input type="checkbox" class="checkbox"><span>I Accept to the Terms & Conditions</span>

                <button type="sumbit" class="submit" value="Register">Register</button>
            </form>
        </div>
    </div>
</body>

@if($errors -> has('r_name') || $errors -> has('r_email') || $errors -> has('r_password') || $errors -> has('r_password_confirmation'))
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var button = document.getElementById('register-btn');
            button.click();
        });
    </script>
@endif

<!-- Javascript file -->
<script src="{{ asset('auth/js/login.js' )}}"></script>

</html>
