@extends('admin.layout')

@section('admin-section')

    {{-- Community Modal CSS --}}
    {{-- <style>
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
    </style> --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <br><br><br>

    {{-- Show Community --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Community Category
                        </h3>
                        <div class="card-tools">
                            <!-- Add Community Button -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#addCommunityModal">
                                <i class="fas fa-plus"></i> Add Community
                            </button>
                            <!-- Import Excel Button -->
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#importCommunityModal">
                                <i class="fas fa-file-import"></i> Import Excel
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Community Icon</th>
                                    <th>Community Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($communitycategorys as $communitycategory)
                                    <tr>
                                        <td>
                                            <i class="fas {{ $communitycategory->icon }}"></i>
                                        </td>
                                        <td>{{ $communitycategory->name }}</td>

                                        <td>
                                            <!-- 删除社区类别的表单 -->
                                            <form action="{{ route('Delete.CommunityCategory', $communitycategory->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this community category?')">
                                                    <i class="fa fa-trash"></i>&nbsp;Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Community Modal -->
    <div class="modal fade" id="addCommunityModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('Add.CommunityCategory')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Community</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Community Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Community</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Excel Modal -->
    {{-- <div class="modal fade" id="importFacilityModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('backend-resort.facilities.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Import Facilities from Excel</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="excelPreview">
                        <div class="form-group">
                            <label>Select Excel File</label>
                            <input type="file" name="file" class="form-control-file" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import Facilities</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    {{-- Read Excel File Data JS --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script> --}}

    {{-- Read Excel File Data --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 获取文件输入框和模态框内容区域的元素
            const fileInput = document.querySelector('#importFacilityModal input[type="file"]');
            const modalBody = document.querySelector('#importFacilityModal .modal-body');

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
    </script> --}}

@endsection
