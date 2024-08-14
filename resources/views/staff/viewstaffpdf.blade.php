<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    
    <div class="container mt-5">
        <table class="table table-bordered table-hover">
        <caption>List of Staff</caption>
            <thead class="table-primary">
                <tr>
                    <th>Staff ID</th>
                    <th>Staff Name</th>
                    <th>Staff Phone Number</th>
                    <th>Staff Salary</th>
                    <th>Staff Address</th>
                </tr>
            </thead>
            <tbody class="table-grey">
                @if(count($staffs) > 0)
                    @foreach($staffs as $staff)
                    <tr>
                        <td>{{ $staff->id }}</td>
                        <td>{{ $staff->name }}</td>
                        <td>{{ $staff->phone }}</td>
                        <td>{{ $staff->salary }}</td>
                        <td>{{ $staff->address }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9">No Meetings Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
