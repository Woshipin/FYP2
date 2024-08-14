@extends('admin.layout')

@section('admin-section')

<!-- Show All Table -->
<div class="container">

    <br><br><br><br>

    <!-- <div id="map" style="height: 400px;"></div> -->

    <div class="records table-responsive">
        <div class="record-header">
            <div class="add">
                <span>Entries</span>
                <select name="" id="">
                    <option value="">ID</option>
                </select>
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->
                <!-- Restaurant Model -->
                <!-- <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#restaurantModal">Add Restaurant</button> -->
                <!-- Add Table Model -->
                {{-- <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#tableModal">AddTable</button> --}}
                <!--Export Table Model -->
                <a href="{{ url('export-resort') }}"><button type="button" class="btn btn-primary m-1">Export Table</button></a>
                <!-- View Resort PDF Model -->
                <!-- <form action="{{ url('resort/view-pdf') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger m-1">View In PDF</button>
                    </form> -->
                <!-- Export Resort PDF Model -->
                <!-- <form action="{{ url('resort/download-pdf') }}" method="POST" target="__blank">
                        @csrf
                        <button type="submit" class="btn btn-danger m-1">Download PDF</button>
                    </form> -->
            </div>

            <div class="browse">
                <input type="search" placeholder="Search" class="record-search m-1">
                <select name="" id="">
                    <option value="">Status</option>
                </select>
            </div>
        </div>

        @if (\Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif

        @if (\Session::has('table'))
            <div class="alert alert-success">{{ Session::get('table') }}</div>
        @endif

        <div class="container-fluid mt-3">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Table List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="p-2">Table ID</th>
                                    <th class="p-2">Restaurant Name</th>
                                    <th class="p-2">Table Title</th>
                                    <th class="p-2">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tables as $table)
                                    <tr>
                                        <td>Table ID: {{ $table->id }}</td>
                                        <td>{{ optional($table->restaurant)->name }}</td>
                                        <td>{{ $table->title }}</td>
                                        <td>
                                            <a href="{{ url('admin/editTable/' . $table->id) . '/edit' }}"
                                                class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#admintableeditModal{{ $table->id }}"><i
                                                    class="las la-pencil-alt"></i>&nbsp;Edit</a>
                                            <a onclick="return confirm('Are you sure to delete this data?')"
                                                href="{{ url('admin/deleteTable/' . $table->id) . '/delete' }}"
                                                class="btn btn-danger btn-sm"><i class="las la-trash"></i>&nbsp;Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $tables->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Edit Table Model -->
@foreach($tables as $table)
<!-- Modal content for each Resort -->
<div class="modal fade" id="admintableeditModal{{$table->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal header and form -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Table Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{url('admin/updateTable/'.$table->id)}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <select class="form-control" name="restaurant_id">
                        {{-- <option value="">-------</option> --}}
                        @foreach($restaurantd as $restaurant)
                            <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                        @endforeach
                    </select>

                    <div class="form-group">
                        <label for="title">Table Title </label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Table title" value="{{$table->title}}">
                        <span class="text-danger">@error('title') {{$message}} @enderror</span>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Table</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
