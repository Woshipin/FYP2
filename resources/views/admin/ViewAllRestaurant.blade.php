@extends('admin.layout')

@section('admin-section')
<!-- Begin Page Content -->
<br><br><br><br>
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{$restaurants->name}} Detail
                <a href="{{url('admin/Restaurants')}}" class="float-right btn btn-success btn-sm">View All</a>
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
                        <td><img width="80" src="{{ asset('images/' . $restaurants->image) }}" alt="Image"/></td>
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
                        <th>Restaurant Description</th>
                        <td>{{$restaurants->description}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant Address</th>
                        <td>{{$restaurants->address}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant State</th>
                        <td>{{$restaurants->state}}</td>
                    </tr>
                    <tr>
                        <th>Restaurant Country</th>
                        <td>{{$restaurants->country}}</td>
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
