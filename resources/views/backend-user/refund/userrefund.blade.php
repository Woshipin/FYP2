@extends('backend-user.newlayout')

@section('newuser-section')

    <div class="container">

        {{-- <div id="map" style="height: 400px;"></div><br> --}}

        <div class="row">
            <div class="col-12">
                {{-- Search Resort Function --}}
                <form action="{{ route('RefundSearch') }}" method="GET"
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-white small m-2" name="customer_name"
                            placeholder="Search for Customer Name" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="card_number"
                            placeholder="Search for Card_Number" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="date"
                            placeholder="Search for Date" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="month"
                            placeholder="Search for Month" aria-label="Search" aria-describedby="basic-addon2">
                        <input type="text" class="form-control bg-white small m-2" name="year"
                            placeholder="Search for Year" aria-label="Search" aria-describedby="basic-addon2">
                        <div>
                            <button type="submit" class="btn btn-primary pb-2"><i class="fas fa-search fa-sm"></i></button>
                        </div>
                    </div>
                </form>

                <br>

                <div class="data_table">

                    @if (\Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    @if (\Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif

                    <!-- Button to delete all selected items -->
                    <form action="{{ route('resorts.deleteMultipleRefund') }}" method="post" id="deleteMultipleForm">
                        @csrf
                        <!-- Your table code here -->
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered">
                                {{-- Button to delete all selected items --}}
                                <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecord">Delete All
                                    Selected Resorts</button>
                                {{-- Add Resort --}}
                                {{-- <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#resortModal">Add Resort</button> --}}
                                {{-- Export Resort --}}
                                {{-- <a href="{{ url('export-resort') }}"><button type="button" class="btn btn-primary m-1">Export Resort</button></a> --}}

                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" name="" id="select_all_ids"
                                                onclick="checkAll(this)"></th>
                                        <th>Customer Name</th>
                                        <th>Refund Name</th>
                                        <th>Refund Deposit</th>
                                        <th>User Card Number</th>
                                        <th>My Card Number</th>
                                        <th>Card Holder</th>
                                        <th>Card Month</th>
                                        <th>Card Year</th>
                                        <th>CVV</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($userRefunds !== null && count($userRefunds) > 0)
                                        @foreach ($userRefunds as $userRefund)
                                            <tr id="resort_ids{{ $userRefund->id }}">
                                                <td><input type="checkbox" name="ids" class="checkbox_ids"
                                                        id="" value="{{ $userRefund->id }}"></td>
                                                <td>{{ $userRefund->customer_name }}</td>
                                                <td>{{ $userRefund->refund_name }}</td>
                                                <td>RM{{ $userRefund->deposit_price }}</td>
                                                <td>{{ $userRefund->user_card_number }}</td>
                                                <td>{{ $userRefund->card_number }}</td>
                                                <td>{{ $userRefund->card_holder }}</td>
                                                <td>{{ $userRefund->card_month }}</td>
                                                <td>{{ $userRefund->card_year }}</td>
                                                <td>{{ $userRefund->cvv }}</td>
                                                <td>
                                                    {{-- <a href="{{ url('showResortMap/' . $resort->id) . '/map' }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                <a href="{{ url('editResort/' . $resort->id) . '/edit' }}"
                                                    class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#resorteditModal{{ $resort->id }}"><i
                                                        class="fa fa-edit"></i></a><br> --}}
                                                    <a onclick="return confirm('Are you sure to delete this data?')"
                                                        href="{{ url('deleteRefund/' . $userRefund->id) . '/delete' }}"
                                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9">No Refund Deposit Record Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination links -->
                    {{ $userRefunds->links() }}
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

@endsection
