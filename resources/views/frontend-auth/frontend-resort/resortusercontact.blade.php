@extends('frontend-auth.newlayout')

@section('frontend-section')
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
            <form action="{{ url('contactresort') }}" method="post">
                @csrf

                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                <input type="hidden" name="ownertype" value="{{ $resorts->name }}">
                <input type="hidden" name="ownername" value="{{ $resorts->user->name }}">

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
