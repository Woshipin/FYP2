@extends('backend-user.newlayout')

@section('newuser-section')

    {{-- Modal CSS --}}
    <style>
        .modal-dialog {
            max-width: 80%;
            width: 80%;
            margin: 30px auto;
        }

        .modal-content {
            height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-header,
        .modal-footer {
            flex-shrink: 0;
        }

        .modal-body {
            flex: 1 1 auto;
            overflow-y: auto;
            max-height: calc(90vh - 120px);
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
        }

        /* 调整预览区域 */
        .preview-add-image {
            width: 100%;
            height: 300px;
            /* 可以根据需要调整 */
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        #preview-container {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
        }

        #preview-container img {
            width: 100px;
            /* 调整预览图片的大小 */
            height: 100px;
            object-fit: cover;
            margin: 5px;
        }

        @media (max-height: 600px) {
            .modal-dialog {
                margin: 10px auto;
            }

            .modal-content {
                height: 95vh;
            }

            .modal-body {
                max-height: calc(95vh - 100px);
            }

            .preview-add-image {
                height: 200px;
                /* 在小屏幕上减小高度 */
            }
        }
    </style>

    {{-- Table CSS --}}
    <style>
        /* Custom CSS for better aesthetics */
        .data_table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
            border: 1px solid #dee2e6;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            background-color: #343a40;
            color: #ffffff;
            font-weight: bold;
            padding: 12px;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody tr.table-light:hover {
            background-color: #e9ecef;
        }

        .table tbody td {
            border-top: 1px solid #dee2e6;
            padding: 12px;
        }

        .table tbody tr:first-child td {
            border-top: none;
        }

        .table tbody tr:last-child td {
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .carousel-control-prev-icon:hover,
        .carousel-control-next-icon:hover {
            background-color: rgba(255, 255, 255, 1);
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.2rem;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-success:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
        }
    </style>

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
                            @foreach ($restaurantd as $restaurant)
                                <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                            @endforeach
                        </select>

                        <br>

                        <div class="form-group">
                            <label for="title">Table Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter Table title">
                            <span class="text-danger">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add New Table</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Import and Export Modal -->
    <div class="modal fade" id="tableexcelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Table Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('import-table') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label>Select File</label>
                        <input type="file" name="file" class="form-control" />
                        <span class="text-danger">
                            @error('file')
                                {{ $message }}
                            @enderror
                        </span>
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

    <!-- Show All Table -->
    <div class="container">

        {{-- <div id="map" style="height: 400px;"></div><br> --}}

        <div class="row">
            <div class="col-12">
                <div class="data_table">

                    @if (\Session::has('tables'))
                        <div class="alert alert-danger">{{ Session::get('tables') }}</div>
                    @endif

                    @if (\Session::has('table'))
                        <div class="alert alert-success">{{ Session::get('table') }}</div>
                    @endif

                    <!-- Button to delete all selected items -->
                    <form action="{{ route('tables.deleteMultipletable') }}" method="post" id="deleteMultipleForm">
                        @csrf
                        <!-- Your table code here -->
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                {{-- Button to delete all selected items --}}
                                <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecord">Delete All
                                    Selected Tables</button>
                                {{-- Add Resort --}}
                                <button type="button" class="btn btn-info m-1" data-toggle="modal"
                                    data-target="#tableModal">Add Table</button>
                                <!-- Import Table Model -->
                                <button type="button" class="btn btn-primary m-1" data-toggle="modal"
                                    data-target="#tableexcelModal">Import Table</button>
                                {{-- Export Resort --}}
                                <a href="{{ url('export-table') }}"><button type="button"
                                        class="btn btn-primary m-1">Export Table</button></a>
                                {{-- Table Excel Template --}}
                                <a href="{{ route('Table.Excel.Template') }}"><button type="button"
                                        class="btn btn-dark m-1">Table Excel Template</button></a>

                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" name="" id="select_all_ids"
                                                onclick="checkAll(this)"></th>
                                        <th>Table ID</th>
                                        <th>Restaurant Name</th>
                                        <th>Table Title</th>
                                        <th>Status</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tabless !== null && count($tabless) > 0)
                                        @foreach ($tabless as $table)
                                            <tr>
                                                <td><input type="checkbox" name="ids" class="checkbox_ids"
                                                        id="" value="{{ $table->id }}"></td>
                                                <td>Table ID: {{ $table->id }}</td>
                                                <td>{{ $table->restaurant->name ?? 'No Restaurant' }}</td>
                                                <td>{{ $table->title }}</td>
                                                <td>
                                                    @if ($table->status == 0)
                                                        <a href="{{ url('changetable-status/' . $table->id) }}"
                                                            class="btn btn-sm btn-success"
                                                            onclick="return confirm('Are you sure you want to change this status to close?')">Open</a>
                                                    @else
                                                        <a href="{{ url('changetable-status/' . $table->id) }}"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to change this status to open?')">Close</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- <a href="" class="btn btn-info btn-sm"><i class="las la-eye"></i></a> -->
                                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#tableeditModal{{ $table->id }}"><i
                                                            class="fa fa-edit"></i>&nbsp;Edit</a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                                        href="{{ url('deleteTable/' . $table->id) . '/delete' }}"
                                                        class="btn btn-danger btn-sm"><i
                                                            class="fa fa-trash"></i>&nbsp;Delete</a>
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
                        </div>
                    </form>

                    <!-- Pagination links -->
                    {{ $tabless->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Table Model -->
    @foreach ($tables as $table)
        <!-- Modal content for each Resort -->
        <div class="modal fade" id="tableeditModal{{ $table->id }}" tabindex="-1" role="dialog"
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

                    <form action="{{ url('/updateTable/' . $table->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <label for="name">Select Restaurant</label>
                            <select class="form-control" name="restaurant_id">
                                <option value="">-------</option>
                                @foreach ($restaurantd as $restaurant)
                                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="title">Table Title </label>
                                <input type="text" class="form-control" name="title" id="title"
                                    placeholder="Enter Table title" value="{{ $table->image }}">
                                <span class="text-danger">
                                    @error('title')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // 获取文件输入框和模态框内容区域的元素
            const fileInput = document.querySelector('#tableexcelModal input[type="file"]');
            const modalBody = document.querySelector('#tableexcelModal .modal-body');

            // 为文件输入框添加事件监听，当用户选择了文件后触发
            fileInput.addEventListener('change', function(event) {
                // 获取用户选择的文件
                const selectedFile = event.target.files[0];

                if (selectedFile) {
                    // 创建一个文件阅读器对象
                    const fileReader = new FileReader();

                    // 当文件加载完成时，会执行这个回调函数
                    fileReader.onload = function(e) {
                        // 获取文件的内容（以二进制形式）
                        const data = e.target.result;

                        // 使用 XLSX 库将二进制内容解析成工作簿对象
                        const workbook = XLSX.read(data, {
                            type: 'binary'
                        });

                        // 假设你使用第一个工作表名字
                        const sheetName = workbook.SheetNames[0];

                        // 将工作表的数据解析成 JSON 格式
                        const sheetData = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
                            header: 1
                        });

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

{{-- <option>--- Select Table ---</option>
@foreach ($tables as $tableId)
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
