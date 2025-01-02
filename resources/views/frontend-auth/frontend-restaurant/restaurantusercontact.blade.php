@extends('frontend-auth.newlayout')

@section('frontend-section')

    <style>
        .contact-form {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-textarea {
            resize: vertical;
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #00b09b;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #96c93d;
        }
    </style>

    {{-- back-arrow-circle css --}}
    <style>
        .back-arrow-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            margin-left: 15px;
            /* 与容器的左边距对齐 */
            margin-top: 10px;
            /* 进一步缩短上边距 */
        }

        .back-arrow-circle a {
            color: #007bff;
            text-decoration: none;
            font-size: 20px;
        }

        .container {
            margin-top: 0;
            /* 完全去除容器的上边距 */
        }
    </style>

    <br><br><br><br><br><br><br>

    <div class="back-arrow-circle">
        <a href="{{ route('restaurant-detail', ['id' => $restaurants->id]) }}">
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>

    <!-- Contact Section Starts -->
    <section class="contact" id="contact">
        <h1 class="heading">
            <span>C</span>
            <span>o</span>
            <span>n</span>
            <span>t</span>
            <span>a</span>
            <span>c</span>
            <span>t</span>
        </h1>

        <div class="row">
            <div class="img">
                <img src="{{ asset('new/img/book-img.jpg') }}" alt="">
            </div>
            <form action="{{ url('contactrestaurant') }}" method="post" class="contact-form">
                @csrf

                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                <input type="hidden" name="ownertype" value="{{ $restaurants->name }}">
                <input type="hidden" name="ownername" value="{{ $restaurants->user->name }}">

                <div class="inputBox">
                    <input type="number" name="phone" placeholder="Phone Number" class="form-input">
                    <input type="text" name="subject" placeholder="subject" class="form-input">
                </div>
                <textarea placeholder="message" name="message" cols="30" rows="10" class="form-textarea"></textarea>
                <input type="submit" class="btn" value="send message">
            </form>
        </div>
    </section>

    {{-- Toastr New JS --}}
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- New Toastr --}}
    <script>
        @if (Session::has('success'))
            Toastify({
                text: "{{ Session::get('success') }}",
                duration: 10000,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)"
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

    <!-- Contact Section Ends -->
@endsection
