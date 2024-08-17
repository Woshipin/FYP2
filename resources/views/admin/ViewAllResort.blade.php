@extends('admin.layout')

@section('admin-section')

    <style>
        .table-bordered {
            border: 2px solid black;
            /* 表格的外边框颜色 */
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid grey;
            /* 表格的内边框颜色 */
        }
    </style>

    <!-- 引入Pannellum的JS和CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.css">
    <script src="https://cdn.jsdelivr.net/npm/pannellum/build/pannellum.js"></script>

    <!-- Begin Page Content -->
    <br><br><br><br>
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $resorts->name }} Detail
                    <a href="{{ url('admin/Resorts') }}" class="float-right btn btn-success btn-sm">View All</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Resort Name</th>
                            <td>{{ $resorts->name }}</td>
                        </tr>
                        <tr>
                            <th>Resort Price</th>
                            <td>{{ $resorts->price }}</td>
                        </tr>
                        <tr>
                            <th>Resort Image</th>
                            <td style="border: 5px solid #ddd; padding: 5px; width: 470px; height: 200px; overflow-y: auto; position: relative;">
                                @if (isset($resorts->images) && count($resorts->images) > 0)
                                    <div style="display: flex; flex-wrap: nowrap; width: 100%; height: 100%;">
                                        @foreach ($resorts->images as $image)
                                            <div style="position: relative; margin-right: 5px; width: 80px; height: 80px; border-radius: 2px;">
                                                <img src="{{ asset('images/' . $image->image) }}" alt="Resort Image"
                                                     style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;"
                                                     onclick="show360Image('{{ asset('images/' . $image->image) }}')">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">No Image</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Resort Location</th>
                            <td>{{ $resorts->location }}</td>
                        </tr>
                        <tr>
                            <th>Resort Phone</th>
                            <td>{{ $resorts->phone }}</td>
                        </tr>
                        <tr>
                            <th>Resort Country</th>
                            <td>{{ $resorts->country }}</td>
                        </tr>
                        <tr>
                            <th>Resort State</th>
                            <td>{{ $resorts->state }}</td>
                        </tr>
                        <tr>
                            <th>Resort Description</th>
                            <td>{{ $resorts->description }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div id="map"><iframe src="{{ $resorts->map }}" width="1325" height="450"></iframe></div>
        <br><br>
    </div>
    <!-- /.container-fluid -->

    {{-- View Mutliple Image 360 --}}
    <script>
        function show360Image(imageUrl) {
            var modal = document.createElement('div');
            modal.id = 'pannellumModal';
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            modal.style.zIndex = '1000';
            modal.style.display = 'flex';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';
            modal.innerHTML = `
                <div id="panorama" style="width: 80%; height: 80%;"></div>
                <button onclick="close360View()" style="position: absolute; top: 10px; right: 10px; padding: 10px; background: #fff; border: none; cursor: pointer;">Close</button>
            `;
            document.body.appendChild(modal);

            pannellum.viewer('panorama', {
                type: 'equirectangular',
                panorama: imageUrl,
                autoLoad: true
            });
        }

        function close360View() {
            var modal = document.getElementById('pannellumModal');
            if (modal) {
                modal.remove();
            }
        }
    </script>

@endsection
