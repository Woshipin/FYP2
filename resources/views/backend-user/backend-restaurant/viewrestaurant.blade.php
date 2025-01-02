@extends('backend-user.newlayout')

@section('newuser-section')

    <style>
        img {
            width: 80px;
            /* 设置所有图片的宽度为 80 像素 */
            height: auto;
            /* 保持宽高比例 */
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

    <!-- Begin Page Content -->
    <br>

    <div class="back-arrow-circle">
        <a href="{{ url('/showRestaurant') }}">
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>

    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $restaurants->name }} Detail
                    <a href="{{ url('showRestaurant') }}" class="float-right btn btn-success btn-sm">View All</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Restaurant Name</th>
                            <td>{{ $restaurants->name }}</td>
                        </tr>
                        <tr>
                            <th>Restaurant Image</th>
                            <td
                                style="border: 5px solid #ddd; padding: 5px; width: 470px; height: 200px; overflow-y: auto; position: relative;">
                                @if (isset($restaurants->images) && count($restaurants->images) > 0)
                                    <div style="display: flex; flex-wrap: nowrap; width: 100%; height: 100%;">
                                        @foreach ($restaurants->images as $image)
                                            <div
                                                style="position: relative; margin-right: 5px; width: 80px; height: 80px; border-radius 2px">
                                                <img src="{{ asset('images/' . $image->image) }}" alt="Resort Image"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span
                                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">No
                                        Image</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Restaurant Open Date</th>
                            <td>{{ $restaurants->date }}</td>
                        </tr>
                        <tr>
                            <th>Restaurant Open Time</th>
                            <td>{{ $restaurants->time }}</td>
                        </tr>
                        <tr>
                            <th>Restaurant Country</th>
                            <td>{{ $restaurants->country }}</td>
                        </tr>
                        <tr>
                            <th>Restaurant State</th>
                            <td>{{ $restaurants->state }}</td>
                        </tr>
                        <tr>
                            <th>Restaurant Description</th>
                            <td>{{ $restaurants->description }}</td>
                        </tr>
                        <tr>
                            <th>Restaurant Address</th>
                            <td>{{ $restaurants->address }}</td>
                        </tr>
                        <tr>
                            <th>Restaurant Latitude</th>
                            <td>{{ $restaurants->latitude }}</td>
                        </tr>
                        <tr>
                            <th>Restaurant Longitude</th>
                            <td>{{ $restaurants->longitude }}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <div id="map"><iframe src="{{ $restaurants->map }}" width="1325" height="450"></iframe></div>
        <br><br>
    </div>
    <!-- /.container-fluid -->

@endsection
