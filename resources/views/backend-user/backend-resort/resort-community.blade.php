@extends('backend-user.newlayout')

@section('newuser-section')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Resort Facilities
                        </h3>
                        <div class="card-tools">
                            <!-- Add Facility Button -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#addFacilityModal">
                                <i class="fas fa-plus"></i> Add Facility
                            </button>
                            <!-- Import Excel Button -->
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#importFacilityModal">
                                <i class="fas fa-file-import"></i> Import Excel
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>Charge Type</th>
                                    <th>Display Order</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($facilities as $facility)
                                    <tr>
                                        <td>
                                            <i class="fas {{ $facility->icon_class }}"></i>
                                        </td>
                                        <td>{{ $facility->name }}</td>
                                        <td>
                                            @if ($facility->charge_type === 'free')
                                                <span class="badge badge-success">Free</span>
                                            @elseif($facility->charge_type === 'additional_charge')
                                                <span class="badge badge-warning">Additional Charge</span>
                                            @else
                                                <span class="badge badge-info">None</span>
                                            @endif
                                        </td>
                                        <td>{{ $facility->display_order }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteFacility({{ $facility->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
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

    <!-- Add Facility Modal -->
    <div class="modal fade" id="addFacilityModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('backend-resort.facilities.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Facility</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Charge Type</label>
                            <select name="charge_type" class="form-control" required>
                                <option value="none">None</option>
                                <option value="free">Free</option>
                                <option value="additional_charge">Additional Charge</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Display Order</label>
                            <input type="number" name="display_order" class="form-control" value="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Facility</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Import Excel Modal -->
    <div class="modal fade" id="importFacilityModal" tabindex="-1" role="dialog">
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
                    <div class="modal-body">
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
    </div>

    <script>
        function deleteFacility(facilityId) {
            if (confirm('Are you sure you want to delete this facility?')) {
                axios.delete(`/backend-resort/facilities/${facilityId}`)
                    .then(response => {
                        window.location.reload();
                    })
                    .catch(error => {
                        alert('Error deleting facility');
                    });
            }
        }
    </script>

    {{-- Read Excel File Data JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
@endsection
