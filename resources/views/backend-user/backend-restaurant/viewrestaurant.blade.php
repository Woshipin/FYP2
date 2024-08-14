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

<!-- Begin Page Content -->
<br>
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{$restaurants->name}} Detail
                <a href="{{url('showRestaurant')}}" class="float-right btn btn-success btn-sm">View All</a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" >
                    <tr>
                        <th>Restaurant Name</th>
                        <td>{{$restaurants->name}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant Image</th>
                        <td>
                            @if ($restaurants->image)
                                <img width="80" src="{{ asset('images/' . $restaurants->image) }}" alt="Resort Image" />
                            @else
                                <span width="80">No Image</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Restaurant Open Date</th>
                        <td>{{$restaurants->date}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant Open Time</th>
                        <td>{{$restaurants->time}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant Country</th>
                        <td>{{$restaurants->country}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant State</th>
                        <td>{{$restaurants->state}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant Address</th>
                        <td>{{$restaurants->address}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant Description</th>
                        <td>{{$restaurants->description}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div id="map"><iframe src="{{$restaurants->map}}" width="1325" height="450"></iframe></div>
    <br><br>
</div>
<!-- /.container-fluid -->

@endsection
