@extends('backend-user.newlayout')

@section('newuser-section')
    {{-- toastify --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    {{-- Facility CSS --}}
    <style>
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --background: #f3f4f6;
            --card-background: #ffffff;
            --text: #1f2937;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .card-content {
            padding: 1.5rem;
        }

        .facilities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .facility-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 0.375rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .facility-item:hover {
            background-color: var(--background);
        }

        .facility-item input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            height: 20px;
            width: 20px;
            background-color: #fff;
            border: 2px solid var(--border);
            border-radius: 4px;
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .facility-item input[type="checkbox"]:checked~.checkmark {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .checkmark:after {
            content: "";
            display: none;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .facility-item input[type="checkbox"]:checked~.checkmark:after {
            display: block;
        }

        .facility-icon-container {
            display: flex;
            align-items: center;
            margin-right: 1rem;
            /* 增加图标和名称之间的间距 */
        }

        .facility-name {
            font-size: 0.875rem;
        }

        .submit-button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .submit-button:hover {
            background-color: var(--primary-hover);
        }

        @media (max-width: 640px) {
            .facilities-grid {
                grid-template-columns: 1fr;
            }
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

    <div class="back-arrow-circle">
        <a href="{{ url('/showHotel') }}">
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Facilities for {{ $hotel->name }}</h1>
                <p class="card-description">Select the available facilities for this hotel</p>
            </div>
            <div class="card-content">
                <form action="{{ url('backend-user/backend-hotel/hotelfacility/' . $hotel->id . '/add-facilities') }}"
                    method="POST">
                    @csrf
                    <div class="facilities-grid">
                        @foreach ($facilities as $facility)
                            <label class="facility-item">
                                <input type="checkbox" name="facilities[]" value="{{ $facility->id }}"
                                    {{ in_array($facility->id, $selectedFacilities) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <div class="facility-icon-container">
                                    <i class="fas {{ $facility->icon_class }}"></i>
                                    <span class="facility-name">{{ $facility->name }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="submit-button">Add Selected Facilities</button>
                </form>
            </div>
        </div>
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
@endsection
