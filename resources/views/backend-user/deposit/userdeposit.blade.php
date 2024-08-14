@extends('backend-user.newlayout')

@section('newuser-section')

{{-- Payment Card CSS --}}
<link rel="stylesheet" href="{{ asset('paymentcard/css/style.css') }}">

<!--Add Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ url('/RefundDeposit') }}" method="POST" enctype="multipart/form-data" id="searchMap2">
                @csrf
                <div class="modal-body">

                    <div class="container-payment">

                        <div class="card-container">

                            <div class="front">
                                <div class="image">
                                    <img src="{{ asset ('new/img/image/chip.png') }}" alt="">
                                    <img src="{{ asset ('new/img/image/visa.png') }}" alt="">
                                </div>
                                <div class="card-number-box">################</div>
                                <div class="flexbox">
                                    <div class="box">
                                        <span>card holder</span>
                                        <div class="card-holder-name">full name</div>
                                    </div>
                                    <div class="box">
                                        <span>expires</span>
                                        <div class="expiration">
                                            <span class="exp-month">mm</span>
                                            <span class="exp-year">yy</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="back">
                                <div class="stripe"></div>
                                <div class="box">
                                    <span>cvv</span>
                                    <div class="cvv-box"></div>
                                    <img src="{{ asset ('new/img/image/visa.png') }}" alt="">
                                </div>
                            </div>

                        </div>
                        <br>

                        <h3>Refund Deposit Fee RM100</h3>
                        <input type="hidden" name="deposit_price" value="100">
                        <input type="hidden" name="owner_name" value="{{ auth()->user()->name }}">

                        <div class="inputBox">
                            <span>Customer Name</span>
                            <input type="text" id="customer_name" value="" name="customer_name" required>
                        </div>

                        <div class="inputBox">
                            <span>Card Number</span>
                            <input type="text" id="card_number" value="" name="card_number" maxlength="16" class="card-number-input" placeholder="0000 0000 0000 0000" required>
                        </div>

                        <div class="inputBox">
                            <span>Card Holder</span>
                            <input type="text" name="card_holder" value="" class="card-holder-input">
                        </div>

                        <div class="flexbox">
                            <div class="inputBox">
                                <span>expiration mm</span>
                                <select name="card_month" id="card_month" class="month-input" value="">
                                    <option value="month" selected disabled>month</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="inputBox">
                                <span>expiration yy</span>
                                <select name="card_year" id="card_year" class="year-input" value="">
                                    <option value="year" selected disabled>year</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>
                            <div class="inputBox">
                                <span>cvv</span>
                                <input type="number" name="cvv" maxlength="4" value="" class="cvv-input">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Refund Deposit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Refund User Deposit Model -->
@foreach ($userdeposits as $userdeposit)
<!-- Modal content for each Refund User Deposit -->
<div class="modal fade" id="refunduserdepositModal{{ $userdeposit->id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal header and form -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Refund User Deposit Fee Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ url('/RefundDepositToUser/' . $userdeposit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="container-payment">

                        <div class="card-container">

                            <div class="front">
                                <div class="image">
                                    <img src="{{ asset ('new/img/image/chip.png') }}" alt="">
                                    <img src="{{ asset ('new/img/image/visa.png') }}" alt="">
                                </div>
                                <div class="card-number-box">################</div>
                                <div class="flexbox">
                                    <div class="box">
                                        <span>card holder</span>
                                        <div class="card-holder-name">full name</div>
                                    </div>
                                    <div class="box">
                                        <span>expires</span>
                                        <div class="expiration">
                                            <span class="exp-month">mm</span>
                                            <span class="exp-year">yy</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="back">
                                <div class="stripe"></div>
                                <div class="box">
                                    <span>cvv</span>
                                    <div class="cvv-box"></div>
                                    <img src="{{ asset ('new/img/image/visa.png') }}" alt="">
                                </div>
                            </div>

                        </div>
                        <br>

                        <h3>Refund Deposit Fee RM100</h3>
                        <input type="hidden" name="deposit_price" value="{{ $userdeposit->deposit_price }}">
                        <input type="hidden" name="refund_name" value="{{ auth()->user()->name }}">

                        <div class="inputBox">
                            <span>Customer Name</span>
                            <input type="text" id="customer_name" value="{{ $userdeposit->user_name }}" name="customer_name" required>
                        </div>

                        <div class="inputBox">
                            <span>User Booked Type Name</span>
                            <input type="text" id="type_name" value="{{ $userdeposit->type_name }}" name="type_name" required>
                        </div>

                        <div class="inputBox">
                            <span>User Card Number</span>
                            <input type="text" id="card_number" value="{{ $userdeposit->card_number }}" name="card_number" maxlength="16" class="card-number-input" placeholder="0000 0000 0000 0000" required>
                        </div>

                        <div class="inputBox">
                            <span>Card Holder</span>
                            <input type="text" name="card_holder" value="" class="card-holder-input">
                        </div>

                        <div class="inputBox">
                            <span>Card Number</span>
                            <input type="text" id="my_card_number" value="" name="my_card_number" maxlength="16" class="card-number-input" placeholder="0000 0000 0000 0000" required>
                        </div>

                        <div class="flexbox">
                            <div class="inputBox">
                                <span>expiration mm</span>
                                {{-- <input type="text" id="card_number" value="" name="card_number" maxlength="16" class="card-number-input" placeholder="0000 0000 0000 0000" required> --}}
                                <select name="card_month" id="card_month" class="month-input" value="">
                                    <option value="month" selected disabled>month</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="inputBox">
                                <span>expiration yy</span>
                                {{-- <input type="text" id="card_number" value="" name="card_number" maxlength="16" class="card-number-input" placeholder="0000 0000 0000 0000" required> --}}
                                <select name="card_year" id="card_year" class="year-input" value="">
                                    <option value="year" selected disabled>year</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                </select>
                            </div>
                            <div class="inputBox">
                                <span>cvv</span>
                                <input type="text" name="cvv" maxlength="4" value="" class="cvv-input">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Refund Deposit Fee To User</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endforeach

{{-- Show All Deposit --}}
<div class="container">

    {{-- <div id="map" style="height: 400px;"></div><br> --}}

    <div class="row">
        <div class="col-12">
            {{-- Search Resort Function --}}
            <form action="{{ route('DepositSearch') }}" method="GET" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-white small m-2" name="user_name" placeholder="Search for User Name" aria-label="Search" aria-describedby="basic-addon2">
                    <input type="text" class="form-control bg-white small m-2" name="card_number" placeholder="Search for Card_Number" aria-label="Search" aria-describedby="basic-addon2">
                    <input type="text" class="form-control bg-white small m-2" name="date" placeholder="Search for Date" aria-label="Search" aria-describedby="basic-addon2">
                    <input type="text" class="form-control bg-white small m-2" name="month" placeholder="Search for Month" aria-label="Search" aria-describedby="basic-addon2">
                    <input type="text" class="form-control bg-white small m-2" name="year" placeholder="Search for Year" aria-label="Search" aria-describedby="basic-addon2">
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
                <form action="{{ route('resorts.deleteMultipledeposit') }}" method="post" id="deleteMultipleForm">
                    @csrf
                    <!-- Your table code here -->
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered">
                            {{-- Button to delete all selected items --}}
                            <button type="submit" class="btn btn-danger m-1" id="deleteAllSelectedRecord">Delete All Selected Resorts</button>
                            {{-- Add Refund User Deposit --}}
                            {{-- <button type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#refundModal">Refund</button> --}}
                            {{-- Export Resort --}}
                            <a href="{{ url('export-deposit') }}"><button type="button" class="btn btn-primary m-1">Export Deposit</button></a>

                            <thead class="table-dark">
                                <tr>
                                    <th><input type="checkbox" name="" id="select_all_ids" onclick="checkAll(this)"></th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Type Name</th>
                                    <th>Deposit</th>
                                    <th>User Card Number</th>
                                    <th>Card Holder</th>
                                    <th>Card Month</th>
                                    <th>Card Year</th>
                                    <th>Refund Status</th>
                                    <th>Refund Deposit</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($userdeposits !== null && count($userdeposits) > 0)
                                    @foreach ($userdeposits as $userdeposit)
                                        <tr id="resort_ids{{ $userdeposit->id }}">
                                            <td><input type="checkbox" name="ids" class="checkbox_ids" id="" value="{{ $userdeposit->id }}"></td>
                                            <td>{{ $userdeposit->user_name }}</td>
                                            <td>{{ $userdeposit->user_email }}</td>
                                            <td>{{ $userdeposit->type_name }}</td>
                                            <td>{{ $userdeposit->deposit_price }}</td>
                                            <td>{{ $userdeposit->card_number }}</td>
                                            <td>{{ $userdeposit->card_holder }}</td>
                                            <td>{{ $userdeposit->card_month }}</td>
                                            <td>{{ $userdeposit->card_year }}</td>
                                            {{-- <td>{{ $userdeposit->cvv }}</td> --}}
                                            <td>
                                                @if ($userdeposit->status == 0)
                                                    <a href="{{ url('changedeposit-status/' . $userdeposit->id) }}"
                                                        class="btn btn-sm btn-danger">Havent</a>
                                                @else
                                                    <a href="{{ url('changedeposit-status/' . $userdeposit->id) }}"
                                                        class="btn btn-sm btn-success">Has</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('refunduserdeposit/' . $userdeposit->id) }}"
                                                    class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#refunduserdepositModal{{ $userdeposit->id }}"><i class="fa fa-reply"></i>&nbsp;Refund</a>
                                            </td>
                                            <td>
                                                {{-- <a href="{{ url('showResortMap/' . $resort->id) . '/map' }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a> --}}
                                                {{-- <a href="{{ url('refunduserdeposit/' . $userdeposit->id) }}"
                                                    class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#refunduserdepositModal{{ $userdeposit->id }}"><i
                                                        class="fa fa-edit"></i></a><br> --}}
                                                <a onclick="return confirm('Are you sure to delete this data?')"
                                                    href="{{ url('deleteDeposit/' . $userdeposit->id) . '/delete' }}"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9">No User Deposit Found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>

                <!-- Pagination links -->
                {{ $userdeposits->links() }}
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
