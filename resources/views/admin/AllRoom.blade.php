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
                        <h6 class="m-0 font-weight-bold text-primary">Room List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="p-2">Room ID</th>
                                        <th class="p-2">Hotel Name</th>
                                        <th class="p-2">Room Title</th>
                                        <th class="p-2">Room Price</th>
                                        <th class="p-2">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rooms as $room)
                                        <tr>
                                            <td>{{ $room->id }}</td>
                                            <td>{{ optional($room->hotel)->name }}</td>
                                            <td>{{ $room->name }}</td>
                                            <td>RM{{ $room->price }}</td>
                                            <td>
                                                <a href="{{ url('admin/editRoom/' . $room->id) . '/edit' }}"
                                                    class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#adminroomeditModal{{ $room->id }}"><i
                                                        class="las la-pencil-alt"></i>&nbsp;Edit</a>
                                                <a onclick="return confirm('Are you sure to delete this data?')"
                                                    href="{{ url('admin/deleteRoom/' . $room->id) . '/delete' }}"
                                                    class="btn btn-danger btn-sm"><i
                                                        class="las la-trash"></i>&nbsp;Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $rooms->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Table Model -->
    @foreach ($rooms as $room)
        <!-- Modal content for each Resort -->
        <div class="modal fade" id="adminroomeditModal{{ $room->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal header and form -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Table Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ url('admin/updateRoom/' . $room->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <select class="form-control" name="hotel_id">
                                {{-- <option value="">-------</option> --}}
                                @foreach ($hoteld as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="name">Room Title </label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter Room Name" value="{{ $room->name }}">
                                <span class="text-danger">
                                    @error('title')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Room</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    
@endsection
