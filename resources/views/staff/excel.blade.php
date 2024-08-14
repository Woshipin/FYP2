@extends('admin.layout')

@section('admin-section')
<!-- Excel Modal -->
<div class="modal fade" id="staffexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import and Export Staff Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
    
            <form action="{{ route ('import-users') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <label>Select File</label>
                    <input type="file" name="file" class="form-control" />
                    <div class="mt-5">
                        <button type="submit" class="btn btn-info">Submit</button>
                        <a href="{{ route ('export-users') }}" class="btn btn-primary float-right">Export Excel</a>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New Staff</button>
                </div> -->
            </form>
        </div>
    </div>
</div>

<div class="container">
    <br><br><br><br>
    <!-- @if(\Session::has('error'))
        <center><p style="color:red;">{{ \Session::get('error') }}</p></center>
    @endif

    @if(\Session::has('success'))
        <center><p style="color:green;">{{ \Session::get('success') }}</p></center>
    @endif -->

    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->

    <div class="records table-responsive">
        <div class="record-header">
            <div class="add">
                <span>Entries</span>
                <select name="" id="">
                    <option value="">ID</option>
                </select>
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Launch demo modal</button> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staffexcelModal">Export Modal</button>
            </div>

            <div class="browse">
                <input type="search" placeholder="Search" class="record-search">
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

        <div>
            <table width="100%">
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th><span class="las la-sort"></span> Staff Name</th>
                        <th><span class="las la-sort"></span> Staff Phone</th>
                        <th><span class="las la-sort"></span> Staff Salary</th>
                        <th><span class="las la-sort"></span> Staff Address</th>
                        <th><span class="las la-sort"></span> ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></i></a>
                            <a href="" class="btn btn-primary btn-sm"><i class="las la-pencil-alt"></i></i></a>
                            <a onclick="return confirm('Are you sure to delete this data?')" href="" class="btn btn-danger btn-sm"><i class="las la-trash"></i></a>
                        </td>
                    </tr>
                   
                        <tr>
                            <td colspan="9">No Meetings Found</td>
                        </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection