@extends('admin.layout')

@section('admin-section')

<!--Add Staff Modal -->
<div class="modal fade" id="staffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('addStaff') }}" method="POST">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Staff Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Staff Name">
                        <span class="text-danger">@error('name') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Staff Phone Number</label>
                        <input type="number" class="form-control" name="phone" id="phone" placeholder="Enter Staff Phone Number">
                        <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Staff Salary</label>
                        <input type="number" class="form-control" name="salary" id="salary" placeholder="Enter Staff Salary">
                        <span class="text-danger">@error('salary') {{$message}} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="address">Staff Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Enter Staff Address">
                        <span class="text-danger">@error('address') {{$message}} @enderror</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add New Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Staff Model -->
@foreach($staffs as $staff)
    <!-- Modal content for each staff -->
    <div class="modal fade" id="staffeditModal{{$staff->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal header and form -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Staff Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{url('/updateStaff/'.$staff->id)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Staff Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{$staff->name}}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Staff Phone Number</label>
                            <input type="number" class="form-control" name="phone" id="phone" value="{{$staff->phone}}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Staff Salary</label>
                            <input type="number" class="form-control" name="salary" id="salary" value="{{$staff->salary}}">
                        </div>
                        <div class="form-group">
                            <label for="address">Staff Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{$staff->address}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach


<!-- Import and Export Modal -->
<div class="modal fade" id="staffexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import and Export Staff Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route ('import-staff') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="modal-body">
                    <label>Select File</label>
                    <input type="file" name="file" class="form-control" />
                    <span class="text-danger">@error('file') {{$message}} @enderror</span>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-info">Submit</button>
                        <!-- <button onclick="readExcelFile()">Read File</button> -->
                        <!-- <a href="" class="btn btn-primary float-right">Export Excel</a> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Show All Staff -->
{{-- <div class="container">

    <br><br><br>

    <div class="records table-responsive">
        <div class="record-header">
            <div class="add">
                <span>Entries</span>
                <select name="" id="">
                    <option value="">ID</option>
                </select>
                <!-- Staff Model -->
                <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#staffModal">Add Staff</button>
                <!-- Import Staff Model -->
                <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#staffexcelModal">Import Modal</button>
                <!--Export Staff Model -->
                <a href="{{ route ('export-staff') }}"><button type="button" class="btn btn-primary m-1">Export Staff</button></a>
                <!-- View Staff PDF Model -->
                <form action="{{ route ('viewstaff-pdf') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger m-1">View In PDF</button>
                </form>
                <!-- Export Staff PDF Model -->
                <form action="{{ route ('downloadstaff-pdf') }}" method="POST" target="__blank">
                    @csrf
                    <button type="submit" class="btn btn-danger m-1">Download PDF</button>
                </form>
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

        <div class="container mt-5">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Staff ID</th>
                            <th>Staff Name</th>
                            <th>Staff Phone Number</th>
                            <th>Staff Salary</th>
                            <th>Staff Address</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="table-grey">
                        @if(count($staffs) > 0)
                            @foreach($staffs as $staff)
                                <tr>
                                    <td>{{$staff->id}}</td>
                                    <td>{{$staff->name}}</td>
                                    <td>{{$staff->phone}}</td>
                                    <td>{{$staff->salary}}</td>
                                    <td>{{$staff->address}}</td>
                                    <td>
                                        <a href="{{url('editStaff/'.$staff->id).'/edit'}}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staffeditModal{{$staff->id}}"><i class="las la-pencil-alt"></i></a>
                                        <a onclick="return confirm('Are you sure to delete this data?')" href="{{url('deleteStaff/'.$staff->id).'/delete'}}" class="btn btn-danger btn-sm"><i class="las la-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">No Staffs Found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div> --}}

<div class="container">

    <br><br><br>

    <div class="records table-responsive">
        <div class="record-header">
            <div class="add">
                <span>Entries</span>
                <select name="" id="">
                    <option value="">ID</option>
                </select>
                <!-- Staff Model -->
                <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#staffModal">Add Staff</button>
                <!-- Import Staff Model -->
                <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#staffexcelModal">Import Modal</button>
                <!--Export Staff Model -->
                <a href="{{ route ('export-staff') }}"><button type="button" class="btn btn-primary m-1">Export Staff</button></a>
                <!-- View Staff PDF Model -->
                <form action="{{ route ('viewstaff-pdf') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger m-1">View In PDF</button>
                </form>
                <!-- Export Staff PDF Model -->
                <form action="{{ route ('downloadstaff-pdf') }}" method="POST" target="__blank">
                    @csrf
                    <button type="submit" class="btn btn-danger m-1">Download PDF</button>
                </form>
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
                    <h6 class="m-0 font-weight-bold text-primary">Staff List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Staff ID</th>
                                    <th>Staff Name</th>
                                    <th>Staff Phone Number</th>
                                    <th>Staff Salary</th>
                                    <th>Staff Address</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="table-grey">
                                @if(count($staffs) > 0)
                                    @foreach($staffs as $staff)
                                        <tr>
                                            <td>{{$staff->id}}</td>
                                            <td>{{$staff->name}}</td>
                                            <td>{{$staff->phone}}</td>
                                            <td>{{$staff->salary}}</td>
                                            <td>{{$staff->address}}</td>
                                            <td>
                                                <a href="{{url('editStaff/'.$staff->id).'/edit'}}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staffeditModal{{$staff->id}}"><i class="las la-pencil-alt"></i></a>
                                                <a onclick="return confirm('Are you sure to delete this data?')" href="{{url('deleteStaff/'.$staff->id).'/delete'}}" class="btn btn-danger btn-sm"><i class="las la-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">No Staffs Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $staffs->links() }}
            </div>
        </div>
    </div>
</div>


{{-- Read Excel File Data JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

{{-- Read Excel File Data --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.querySelector('#staffexcelModal input[type="file"]');
        const modalBody = document.querySelector('#staffexcelModal .modal-body');

        fileInput.addEventListener('change', function (event) {
            const selectedFile = event.target.files[0];
            if (selectedFile) {
                const fileReader = new FileReader();

                fileReader.onload = function (e) {
                    const data = e.target.result; // File content in binary
                    const workbook = XLSX.read(data, { type: 'binary' });
                    const sheetName = workbook.SheetNames[0]; // Assuming you're using the first sheet

                    const sheetData = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], { header: 1 });

                    const table = document.createElement('table');
                    table.classList.add('table', 'table-bordered');

                    for (let i = 0; i < sheetData.length; i++) {
                        const row = document.createElement('tr');
                        for (let j = 0; j < sheetData[i].length; j++) {
                            const cell = document.createElement(i === 0 ? 'th' : 'td');
                            cell.textContent = sheetData[i][j];
                            row.appendChild(cell);
                        }
                        table.appendChild(row);
                    }

                    modalBody.appendChild(table);
                };

                fileReader.readAsBinaryString(selectedFile);
            }
        });
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // 获取文件输入框和模态框内容区域的元素
    const fileInput = document.querySelector('#staffexcelModal input[type="file"]');
    const modalBody = document.querySelector('#staffexcelModal .modal-body');

    // 为文件输入框添加事件监听，当用户选择了文件后触发
    fileInput.addEventListener('change', function (event) {
        // 获取用户选择的文件
        const selectedFile = event.target.files[0];

        if (selectedFile) {
            // 创建一个文件阅读器对象
            const fileReader = new FileReader();

            // 当文件加载完成时，会执行这个回调函数
            fileReader.onload = function (e) {
                // 获取文件的内容（以二进制形式）
                const data = e.target.result;

                // 使用 XLSX 库将二进制内容解析成工作簿对象
                const workbook = XLSX.read(data, { type: 'binary' });

                // 假设你使用第一个工作表名字
                const sheetName = workbook.SheetNames[0];

                // 将工作表的数据解析成 JSON 格式
                const sheetData = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], { header: 1 });

                // 创建一个 HTML 表格元素
                const table = document.createElement('table');
                table.classList.add('table', 'table-bordered');

                // 循环遍历数据，创建表格行和单元格
                for (let i = 0; i < sheetData.length; i++) {
                    const row = document.createElement('tr');
                    for (let j = 0; j < sheetData[i].length; j++) {
                        const cell = document.createElement(i === 0 ? 'th' : 'td');
                        cell.textContent = sheetData[i][j];
                        row.appendChild(cell);
                    }
                    table.appendChild(row);
                }

                console.log(sheetData);

                // 将表格添加到模态框内容区域中
                modalBody.appendChild(table);
            };

            // 开始读取文件内容（以二进制字符串形式）
            fileReader.readAsBinaryString(selectedFile);
        }
    });
});
</script>







@endsection
