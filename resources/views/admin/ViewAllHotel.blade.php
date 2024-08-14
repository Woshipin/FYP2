@extends('admin.layout')

@section('admin-section')
<!-- Begin Page Content -->
<br><br><br><br>
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{$hotels->name}} Detail
                <a href="{{url('admin/Hotels')}}" class="float-right btn btn-success btn-sm">View All</a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" >
                    <tr>
                        <th>Hotel Owner Name</th>
                        <td>{{$hotels->name}}</td>
                    </tr>
                    <tr>
                        <th>Hotel Image</th>
                        <td><img width="80" src="{{ asset('images/' . $hotels->image) }}" alt="Image"/></td>
                    </tr>
                    <tr>
                        <th>Hotel Owner Email</th>
                        <td>{{$hotels->email}}</td>
                    </tr>
                    <tr>
                        <th>Hotel Phone</th>
                        <td>{{$hotels->phone}}</td>
                    </tr>
                    <tr>
                        <th>Hotel Country</th>
                        <td>{{$hotels->country}}</td>
                    </tr>
                    <tr>
                        <th>Hotel State</th>
                        <td>{{$hotels->state}}</td>
                    </tr>
                    <tr>
                        <th>Hotel Address</th>
                        <td>{{$hotels->address}}</td>
                    </tr>
                    <tr>
                        <th>Hotel Latitude</th>
                        <td>{{$hotel->latitude}}</td>
                    </tr>
                    <tr>
                        <th>Hotel Longitude</th>
                        <td>{{$hotel->longitude}}</td>
                    </tr>
                    <tr>
                        <th>Hotel Description</th>
                        <td>{{$hotels->description}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div id="map"><iframe src="{{$hotels->map}}" width="1325" height="450"></iframe></div>
    <br><br>
</div>
<!-- /.container-fluid -->

@endsection
