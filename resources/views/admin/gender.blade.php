@extends('admin.layout')

@section('admin-section')

<!--Add Gender Modal -->
<div class="modal fade" id="genderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Gender Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ url('admin/addGender') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="gender">Gender Title</label>
                        <input type="text" class="form-control" name="gender" id="gender" placeholder="Enter Resort Name">
                        <span class="text-danger">@error('gender') {{$message}} @enderror</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New Gender</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Resort Model -->
@foreach($genders as $gender)
    <!-- Modal content for each Resort -->
    <div class="modal fade" id="gendereditModal{{$gender->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header and form -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Gender Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{url('admin/updateGender/'.$gender->id)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="gender">Gender Title</label>
                            <input type="text" class="form-control" name="gender" id="gender" value="{{$gender->title}}">
                            <span class="text-danger">@error('gender') {{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Gender</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- Show All Gender -->
<div class="container">

    <br><br><br>

    <div class="records table-responsive">
        <div class="record-header">
            <div class="add">
                <span>Entries</span>
                <select name="" id="">
                    <option value="">ID</option>
                </select>
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->
                <!-- Gender Model -->
                <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#genderModal">Add Gender</button>
                <!-- Import Resort Model -->
                <!-- <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#resortexcelModal">Import Modal</button> -->
                <!--Export Resort Model -->
                {{-- <a href="{{ url('export-resort') }}"><button type="button" class="btn btn-primary m-1">Export Resort</button></a> --}}
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

        @if(\Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error')}}</div>
        @endif

        @if(\Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif

        <div class="container-fluid mt-3">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Gender List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="p-2">Gender ID</th>
                                    <th class="p-2">Gender Title</th>
                                    <th class="p-2">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($genders !== null && count($genders) > 0)
                                    @foreach ($genders as $gender)
                                        <tr>
                                            <td>{{ $gender->id}}</td>
                                            <td>{{ $gender->title}}</td>
                                            <td>
                                                {{-- <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></a> --}}
                                                <a href="{{url('admin/editGender/'.$gender->id).'/edit'}}"
                                                    class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#gendereditModal{{$gender->id}}"><i class="las la-pencil-alt"></i>&nbsp;Edit</a>
                                                <a onclick="return confirm('Are you sure to delete this data?')"
                                                    href="{{ url('admin/deleteGender/' . $gender->id) . '/delete' }}"
                                                    class="btn btn-danger btn-sm"><i class="las la-trash"></i>&nbsp;Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No Genders Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $genders->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
