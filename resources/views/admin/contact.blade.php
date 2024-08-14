@extends('admin.layout')

@section('admin-section')

<!-- Show All Contact -->
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
                <!--Export Contact Model -->
                <a href="{{ url('export-contact') }}"><button type="button" class="btn btn-primary m-1">Export Contact</button></a>
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

        {{-- <div>
            <table width="100%">
                <thead>
                    <tr>
                        <th class="p-2">User Name</th>
                        <th class="p-2">User Email</th>
                        <th class="p-2">Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}

        <div class="container-fluid mt-3">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contact List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="p-2">User Name</th>
                                    <th class="p-2">User Email</th>
                                    <th class="p-2">Message</th>
                                    <th class="p-2">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->message }}</td>
                                        <td><a onclick="return confirm('Are you sure to delete this data?')"
                                            href="" class="btn btn-danger btn-sm"><i class="las la-trash"></i>&nbsp;Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{ $contacts->links() }}
            </div>
        </div>


    </div>
</div>

@endsection
