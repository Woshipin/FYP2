@extends('frontend-auth.newlayout')

@section('frontend-section')

    <style>
        /* Add this to your CSS */
        .bg-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            /* Place it behind other elements */
        }

        .contact {
            /* Add styles for the contact section if needed */
            position: relative;
            z-index: 1;
            /* Place it above the background video */
        }

        .heading span{
            color: black;
        }

        .btn {
            display: inline-block;
            margin-top: 1rem;
            margin-bottom: 1rem;
            margin: 10px;
            background: var(--orange);
            color: #fff;
            padding: .8rem 3rem;
            border: .2rem solid var(--orange);
            cursor: pointer;
            font-size: 1.7rem;
        }

        .btn:hover {
            background: rgba(255, 165, 0, .2);
            color: black;
        }
    </style>

    <!-- Add the background video -->
    <video autoplay muted loop playsinline class="bg-video">
        <source src="{{ asset('contactpage/contactvideo.mp4') }}" type="video/mp4">
    </video>

    <br><br><br><br><br><br><br>

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
            <form action="{{ route('contactus') }}" method="post">
                @csrf

                {{-- <div class="inputBox">
                <input type="text" name="name" placeholder="name">
                <input type="email" name="email" placeholder="email">
            </div> --}}
                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                <div class="inputBox">
                    <input type="number" name="phone" placeholder="Phone Number">
                    <input type="text" name="subject" placeholder="subject">
                </div>
                <textarea placeholder="message" name="message" cols="30" rows="10"></textarea>
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
