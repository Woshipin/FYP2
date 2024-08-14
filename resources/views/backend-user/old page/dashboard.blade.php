@extends('user.layout')

@section('user-section')
<main> 
    <div class="page-header">
        <h1>Dashboard</h1>
        <small>Home / Dashboard</small>
    </div>
    
    <div class="page-content">
        <div class="analytics">
            <div class="card">
                <div class="card-head">
                    <h2>107,200</h2>
                    <span class="las la-user-friends"></span>
                </div>
                <div class="card-progress">
                    <small>User activity this month</small>
                    <div class="card-indicator">
                        <div class="indicator one" style="width: 60%"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <h2>340,230</h2>
                    <span class="las la-eye"></span>
                </div>
                <div class="card-progress">
                    <small>Page views</small>
                    <div class="card-indicator">
                        <div class="indicator two" style="width: 80%"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <h2>$653,200</h2>
                    <span class="las la-shopping-cart"></span>
                </div>
                <div class="card-progress">
                    <small>Monthly revenue growth</small>
                    <div class="card-indicator">
                        <div class="indicator three" style="width: 65%"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <h2>47,500</h2>
                    <span class="las la-envelope"></span>
                </div>
                <div class="card-progress">
                    <small>New E-mails received</small>
                    <div class="card-indicator">
                        <div class="indicator four" style="width: 90%"></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="records table-responsive">
            <div class="record-header">
                <div class="add">
                    <span>Entries</span>
                    <select name="" id="">
                        <option value="">ID</option>
                    </select>
                    <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#resortModal">Add Staff</button>
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
                            <th>Resort ID</th>
                            <th>Resort User ID</th>
                            <th><span class="las la-sort"></span> Resort Name</th>
                            <th><span class="las la-sort"></span> Resort Contact Number</th>
                            <th><span class="las la-sort"></span> Resort Price</th>
                            <th><span class="las la-sort"></span> Resort Location</th>
                            <th><span class="las la-sort"></span> Resort Latitude</th>
                            <th><span class="las la-sort"></span> Resort Longitude</th>
                            <th><span class="las la-sort"></span> Resort Description</th>
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
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></i></a>
                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target=""><i class="las la-pencil-alt"></i></a>
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
</main>

@endsection