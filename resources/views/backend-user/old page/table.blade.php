@extends('user.layout')

@section('user-section')

<!--Add Table Modal -->
<div class="modal fade" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Table Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('addTable') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">

                    <!-- {{ Auth::id() }} -->
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                    <select class="form-control" name="restaurant_id">
                        <option value="">Select Restaurant</option>
                        @foreach($restaurantd as $restaurant)
                            <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                        @endforeach
                    </select>

                    <br>

                    <div class="form-group">
                        <label for="title">Table Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Table title">
                        <span class="text-danger">@error('title') {{$message}} @enderror</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New Restaurant</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Show All Table -->
<div class="container">
    <br><br><br>

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
                <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#tableModal">Add Table</button>
                <!--Export Resort Model -->
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

        @if(\Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error')}}</div>
        @endif

        @if(\Session::has('table'))
            <div class="alert alert-success">{{Session::get('table')}}</div>
        @endif

        <div>
            <table width="100%">
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
                            <td>{{ $table->restaurant->name }}</td>
                            <td>{{ $table->title }}</td>
                            <td>
                                <!-- <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></a> -->
                                <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tableeditModal{{ $table->id }}"><i class="las la-pencil-alt"></i></a>
                                <a onclick="return confirm('Are you sure to delete this data?')" href="{{ url('deleteTable/'.$table->id).'/delete' }}" class="btn btn-danger btn-sm"><i class="las la-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Table Model -->
@foreach($tables as $table)
    <!-- Modal content for each Resort -->
    <div class="modal fade" id="tableeditModal{{$table->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header and form -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Table Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{url('/updateTable/'.$table->id)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <select class="form-control" name="restaurant_id">
                            <option value="">-------</option>
                            @foreach($restaurantd as $restaurant)
                                <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="title">Table Title </label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter Table title" value="{{$table->image}}">
                            <span class="text-danger">@error('title') {{$message}} @enderror</span>
                        </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Table</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach



@endsection

{{-- <option>--- Select Table ---</option>
@foreach($tables as $tableId)
    @php
        $table = \App\Models\Table::find($tableId);
    @endphp
    <option value="{{$table->id}}">{{$table->title}}</option>
@endforeach --}}


{{-- 根据提供的代码，问题似乎出在 JavaScript 代码中，其中发出 AJAX 请求以根据选定的入住时间获取可用房间。

您可以检查以下几项来调试问题：

1. 验证JavaScript代码是否正在执行：确保JavaScript代码包含在页面中，并且浏览器控制台中没有JavaScript错误。

2. 检查 AJAX 请求 URL：AJAX 请求 URL 是使用 `url('bookings/available-rooms')` 和入住时间作为参数构造的。 确保 URL 正确并与路由文件中定义的路由匹配。

3. 验证服务器端逻辑：在 BookingController 的 available_rooms 方法中，检查获取可用表的查询是否正常工作。 您可以记录 SQL 查询或使用 `dd($availableTables)` 来检查查询是否返回预期结果。

4. 验证来自服务器的响应：在AJAX 成功回调函数中，将`res` 变量记录到浏览器控制台并检查它是否包含预期数据。 您可以使用 `console.log(res)` 或 `console.dir(res)` 来检查响应对象。

通过检查这些点，您应该能够确定问题的原因并相应地进行调试。 --}}
