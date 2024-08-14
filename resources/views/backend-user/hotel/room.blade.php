@extends('user.newlayout')

@section('newuser-section')

    {{-- Add New Room Model --}}
    <div class="modal fade" id="roomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Room Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('addRoom') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <!-- {{ Auth::id() }} -->
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <select class="form-control" name="hotel_id">
                            <option value="">---------Select Hotel---------</option>
                            @foreach ($hotels as $hotel)
                                <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="title">Room Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Room title">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="title">Room Type</label>
                            <input type="text" class="form-control" name="type" id="type"
                                placeholder="Enter Room title">
                            <span class="text-danger">
                                @error('type')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="title">Room Available</label>
                            <input type="number" class="form-control" name="available" id="available"
                                placeholder="Enter Room title">
                            <span class="text-danger">
                                @error('available')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add New Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit New Room Model --}}
    @foreach ($rooms as $room)
        <!-- Modal content for each Resort -->
        <div class="modal fade" id="roomeditModal{{ $room->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Modal header and form -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Room Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ url('/updateRoom/' . $room->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <select class="form-control" name="hotel_id">
                                <option value="">-------</option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}"
                                        {{ $hotel->id == $room->hotel_id ? 'selected' : '' }}>
                                        {{ $hotel->name }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="name">Room Name </label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter Table title" value="{{ $room->name }}">
                                <span class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="type">Room Type </label>
                                <input type="text" class="form-control" name="type" id="type"
                                    placeholder="Enter Table title" value="{{ $room->type }}">
                                <span class="text-danger">
                                    @error('type')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="available">Room Available </label>
                                <input type="number" class="form-control" name="available" id="available"
                                    placeholder="Enter Table title" value="{{ $room->available }}">
                                <span class="text-danger">
                                    @error('available')
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

    {{-- show all rooms --}}
    <div class="container">

        {{-- <div id="map" style="height: 400px;"></div><br> --}}

        <div class="row">
            <div class="col-12">
                <div class="data_table">

                    @if (\Session::has('rooms'))
                        <div class="alert alert-danger">{{ Session::get('rooms') }}</div>
                    @endif

                    @if (\Session::has('room'))
                        <div class="alert alert-success">{{ Session::get('room') }}</div>
                    @endif

                    <!-- Button to delete all selected items -->
                    <form action="{{ route('rooms.mutlipledeleteroom') }}" method="post" id="deleteMultipleForm">
                        @csrf
                        <!-- Your table code here -->
                        <table id="example" class="table table-striped table-bordered">
                            {{-- Button to delete all selected items --}}
                            <button type="submit" class="btn btn-primary m-1" id="deleteAllSelectedRecord">Delete All
                                Selected Rooms</button>
                            {{-- Add Resort --}}
                            <button type="button" class="btn btn-info m-1" data-toggle="modal"
                                data-target="#roomModal">Add Room</button>
                            {{-- Export Resort --}}
                            <a href="{{ url('export-room') }}"><button type="button" class="btn btn-primary m-1">Export
                                    Room</button></a>
                            <thead class="table-dark">
                                <tr>
                                    <th><input type="checkbox" name="" id="select_all_ids"
                                            onclick="checkAll(this)"></th>
                                    <th>Room ID</th>
                                    <th>Restaurant Name</th>
                                    <th>Room Name</th>
                                    <th>Room Type</th>
                                    <th>Room Available</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($rooms !== null && $rooms->count() > 0)
                                    @foreach ($rooms as $room)
                                        <tr>
                                            <td><input type="checkbox" name="ids" class="checkbox_ids"
                                                    id="" value="{{ $room->id }}"></td>
                                            <td>Room ID: {{ $room->id }}</td>
                                            <td>{{ $room->hotel->name }}</td>
                                            <td>{{ $room->name }}</td>
                                            <td>{{ $room->type }}</td>
                                            <td>{{ $room->available }}</td>
                                            <td>
                                                <!-- <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></a> -->
                                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#roomeditModal{{ $room->id }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('Are you sure to delete this data?')"
                                                    href="{{ url('deleteRoom/' . $room->id) . '/delete' }}"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9">No Resorts Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </form>

                    <!-- Pagination links -->

                </div>
            </div>
        </div>
    </div>

    {{-- New Delete Selected All Table --}}
    <script>
        // Function to check/uncheck all checkboxes
        function checkAll(checkbox) {
            const checkboxes = document.getElementsByClassName('checkbox_ids');
            for (const cb of checkboxes) {
                cb.checked = checkbox.checked;
            }
        }

        document.getElementById('deleteAllSelectedRecord').addEventListener('click', function() {
            const checkboxes = document.getElementsByClassName('checkbox_ids');
            const selectedIds = [];

            for (const checkbox of checkboxes) {
                if (checkbox.checked) {
                    selectedIds.push(parseInt(checkbox.value));
                }
            }

            if (selectedIds.length === 0) {
                alert('Please select at least one restaurant to delete.');
            } else {
                const form = document.getElementById('deleteMultipleForm');
                const idsInput = document.createElement('input');
                idsInput.type = 'hidden';
                idsInput.name = 'ids';
                idsInput.value = JSON.stringify(selectedIds);
                form.appendChild(idsInput);

                form.submit();
            }
        });
    </script>

@endsection
