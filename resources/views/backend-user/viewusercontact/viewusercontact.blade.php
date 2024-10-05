@extends('backend-user.newlayout')

@section('newuser-section')

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Toastify CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

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

        .table tbody tr.reply-form {
            background-color: #f8f9fa;
        }

        .table tbody tr.reply-form td {
            padding: 15px;
        }

        .table tbody tr.reply-form .form-group {
            margin-bottom: 15px;
        }

        .table tbody tr.reply-form .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .table tbody tr.reply-form .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .table tbody tr.reply-form .btn-success:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.5);
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
    </style>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="data_table card shadow-sm p-4">
                    {{-- @if (\Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    @if (\Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif --}}

                    <div id="alert-container"></div>

                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-bordered">
                            <thead class="table-dark text-center align-middle">
                                <tr>
                                    <th>ID</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>User Phone Number</th>
                                    <th>Hotel Name</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="text-center align-middle">
                                @foreach ($userscontacts as $userscontact)
                                    <tr class="table-light">
                                        <td>{{ $userscontact->id }}</td>
                                        <td>{{ $userscontact->name ?? 'N/A' }}</td>
                                        <td>{{ $userscontact->email ?? 'N/A' }}</td>
                                        <td>{{ $userscontact->phone ?? 'N/A' }}</td>
                                        <td>{{ $userscontact->ownertype ?? 'N/A' }}</td>
                                        <td>{{ $userscontact->subject ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($userscontact->message ?? '', 50, '...') }}</td>
                                        <td>
                                            <!-- Delete Contact Form -->
                                            <form action="{{ url('contact/' . $userscontact->id . '/delete') }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this data?')">
                                                    <i class="fa fa-trash"></i>&nbsp;Delete
                                                </button>
                                            </form>

                                            <!-- Reply Button -->
                                            <button type="button" class="btn btn-primary btn-sm reply-btn" data-id="{{ $userscontact->id }}">
                                                <i class="fa fa-reply"></i>&nbsp;Reply
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="reply-form-{{ $userscontact->id }}" style="display:none;">
                                        <td colspan="8" class="bg-light p-3">
                                            <div class="form-group">
                                                <label for="reply-message-{{ $userscontact->id }}">Reply Message</label>
                                                <textarea class="form-control" id="reply-message-{{ $userscontact->id }}" rows="3"></textarea>
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm submit-reply" data-id="{{ $userscontact->id }}">
                                                Submit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination links -->
                    <div class="d-flex justify-content-end">
                        {{ $userscontacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
    {{-- Reply Customer Contact --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showToast(message, type) {
                Toastify({
                    text: message,
                    duration: 10000,
                    style: {
                        background: type === 'success' ? "linear-gradient(to right, #00b09b, #96c93d)" : "linear-gradient(to right, #b90000, #c99396)"
                    }
                }).showToast();
            }

            document.querySelectorAll('.reply-btn').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const contactId = this.getAttribute('data-id');
                    const replyForm = document.querySelector('.reply-form-' + contactId);
                    replyForm.style.display = replyForm.style.display === 'none' ? 'table-row' : 'none';
                });
            });

            document.querySelectorAll('.submit-reply').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const contactId = this.getAttribute('data-id');
                    const replyMessage = document.getElementById('reply-message-' + contactId).value;

                    if (!replyMessage) {
                        showToast('Reply message cannot be empty.', 'warning');
                        return;
                    }

                    axios.post('{{ route('customer.send.reply') }}', {
                            contact_id: contactId,
                            reply_message: replyMessage
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(function(response) {
                            if (response.data.success) {
                                showToast(response.data.message, 'success');
                                document.getElementById('reply-message-' + contactId).value = '';
                                document.querySelector('.reply-form-' + contactId).style.display = 'none';
                            } else {
                                showToast(response.data.message || 'An error occurred.', 'danger');
                            }
                        })
                        .catch(function(error) {
                            console.error('Error:', error);
                            showToast(error.response?.data?.message || 'An error occurred. Please try again.', 'danger');
                        });
                });
            });
        });
    </script>

@endsection
