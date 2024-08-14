@extends('backend-user.newlayout')

@section('newuser-section')

    <style>
        /* Set a maximum height for the modal body */
        .modal-body {
            max-height: 300px; /* Adjust the height as needed */
            overflow-y: auto; /* Add vertical scroll if content overflows */
        }
    </style>

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

                        <div class="form-group">
                            <label for="price">Room Price</label>
                            <input type="number" class="form-control" name="price" id="price"
                                placeholder="Enter Room Price">
                            <span class="text-danger">
                                @error('price')
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
                            <label for="product">Select Hotel</label>
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

                            <div class="form-group">
                                <label for="price">Room Price </label>
                                <input type="number" class="form-control" name="price" id="price"
                                    placeholder="Enter Table title" value="{{ $room->price }}">
                                <span class="text-danger">
                                    @error('price')
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

    <!-- Import and Export Modal -->
    <div class="modal fade" id="roomexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Resort Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route ('import-room') }}" method="POST" enctype="multipart/form-data">
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
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                {{-- Button to delete all selected items --}}
                                <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecord">Delete All
                                    Selected Rooms</button>
                                {{-- Add Resort --}}
                                <button type="button" class="btn btn-info m-1" data-toggle="modal"
                                    data-target="#roomModal">Add Room</button>
                                <!-- Import Room Model -->
                                <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#roomexcelModal">Import Room</button>
                                {{-- Export Resort --}}
                                <a href="{{ url('export-room') }}"><button type="button" class="btn btn-primary m-1">Export Room</button></a>
                                {{-- Room Excel Template --}}
                                <a href="{{ route('Room.Excel.Template') }}"><button type="button" class="btn btn-dark m-1">Room Excel Template</button></a>

                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" name="" id="select_all_ids"
                                                onclick="checkAll(this)"></th>
                                        <th>Room ID</th>
                                        <th>Hotel Name</th>
                                        <th>Room Name</th>
                                        <th>Room Type</th>
                                        <th>Room Available</th>
                                        <th>Room Price</th>
                                        <th>Status</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($roomss !== null && $roomss->count() > 0)
                                        @foreach ($roomss as $room)
                                            <tr>
                                                <td><input type="checkbox" name="ids" class="checkbox_ids"
                                                        id="" value="{{ $room->id }}"></td>
                                                <td>Room ID: {{ $room->id }}</td>
                                                <td>{{ $room->hotel->name ?? 'No Hotel' }}</td>
                                                <td>{{ $room->name }}</td>
                                                <td>{{ $room->type }}</td>
                                                <td>{{ $room->available }}</td>
                                                <td>{{ $room->price }}</td>
                                                <td>
                                                    @if ($room->status == 0)
                                                        <a href="{{ url('changeroom-status/' . $room->id) }}"
                                                            class="btn btn-sm btn-success"
                                                            onclick="return confirm('Are you sure you want to change this status to close?')">Open</a>
                                                    @else
                                                        <a href="{{ url('changeroom-status/' . $room->id) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to change this status to open?')">Close</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></a> -->
                                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#roomeditModal{{ $room->id }}"><i
                                                            class="fa fa-edit"></i>&nbsp;Edit</a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                                        href="{{ url('deleteRoom/' . $room->id) . '/delete' }}"
                                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9">No Rooms Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination links -->
                    {{ $roomss->links() }}
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

    {{-- Read Excel File Data JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>

    {{-- Read Excel File Data --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // 获取文件输入框和模态框内容区域的元素
        const fileInput = document.querySelector('#roomexcelModal input[type="file"]');
        const modalBody = document.querySelector('#roomexcelModal .modal-body');

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
