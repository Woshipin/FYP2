@extends('admin.layout')

@section('admin-section')

    <!-- Show All Contact -->
    <div class="container">
        <br><br><br><br>

        <div class="records table-responsive">
            <div class="record-header">
                <div class="add">
                    <!--Export Contact Model -->
                    <a href="{{ url('export-contact') }}"><button type="button" class="btn btn-primary m-1">Export
                            Contact</button></a>
                </div>

                <div class="browse">
                    <input type="search" placeholder="Search by name, email, or date" class="record-search m-1" id="searchInput">
                </div>
            </div>

            @if (\Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif

            @if (\Session::has('table'))
                <div class="alert alert-success">{{ Session::get('table') }}</div>
            @endif

            <div class="container-fluid mt-3">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Contact List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0" id="contactTable">
                                <thead>
                                    <tr>
                                        <th class="p-2">User Name</th>
                                        <th class="p-2">User Email</th>
                                        <th class="p-2">Message</th>
                                        <th class="p-2">Time Created</th>
                                        <th class="p-2">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="searchResultsContainer">
                                    <!-- Content will be dynamically added here based on search -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="paginationContainer">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // 使用事件委托来处理点击事件
                    document.addEventListener('click', function(e) {
                        if (e.target && e.target.classList.contains('reply-btn')) {
                            console.log('Button clicked!'); // 调试日志
                            var contactId = e.target.getAttribute('data-id');
                            var replyForm = document.querySelector('.reply-form-' + contactId);
                            replyForm.style.display = replyForm.style.display === 'none' ? 'table-row' : 'none';
                        }
                    });

                    // Real-time search functionality
                    var searchInput = document.getElementById('searchInput');
                    var initialContacts = @json($contacts->items());

                    function formatDate(dateString) {
                        var date = new Date(dateString);
                        var year = date.getFullYear();
                        var month = ('0' + (date.getMonth() + 1)).slice(-2);
                        var day = ('0' + date.getDate()).slice(-2);
                        var hours = ('0' + date.getHours()).slice(-2);
                        var minutes = ('0' + date.getMinutes()).slice(-2);
                        var seconds = ('0' + date.getSeconds()).slice(-2);
                        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
                    }

                    function updateSearchResults(filteredContacts) {
                        var resultsContainer = document.getElementById('searchResultsContainer');
                        resultsContainer.innerHTML = ''; // 清空之前的结果

                        if (Array.isArray(filteredContacts) && filteredContacts.length > 0) {
                            filteredContacts.forEach(function(contact) {
                                var formattedDate = formatDate(contact.created_at);
                                var contactHTML = `
                                    <tr>
                                        <td>${contact.name}</td>
                                        <td>${contact.email}</td>
                                        <td>${contact.message}</td>
                                        <td>${formattedDate}</td>
                                        <td>
                                            <a onclick="return confirm('Are you sure to delete this data?')"
                                                href="" class="btn btn-danger btn-sm"><i
                                                    class="las la-trash"></i>&nbsp;Delete</a>
                                            <button class="btn btn-primary btn-sm reply-btn"
                                                data-id="${contact.id}">
                                                <i class="las la-reply"></i>&nbsp;Reply
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Reply Form -->
                                    <tr class="reply-form-${contact.id}" style="display:none;">
                                        <td colspan="5">
                                            <div>
                                                <form action="{{ route('send.reply') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="contact_id" value="${contact.id}">
                                                    <div class="form-group">
                                                        <label for="reply-message-${contact.id}">Reply Message</label>
                                                        <textarea class="form-control" id="reply-message-${contact.id}" name="reply_message" rows="3"></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>`;

                                resultsContainer.innerHTML += contactHTML;
                            });
                        } else {
                            resultsContainer.innerHTML = '<tr><td colspan="5">No Contacts Found</td></tr>';
                        }
                    }

                    updateSearchResults(initialContacts);

                    searchInput.addEventListener('input', function() {
                        performSearch();
                    });

                    function performSearch() {
                        var searchTerm = searchInput.value.toLowerCase();
                        var filteredContacts = initialContacts.filter(function(contact) {
                            return contact.name.toLowerCase().includes(searchTerm) ||
                                   contact.email.toLowerCase().includes(searchTerm) ||
                                   formatDate(contact.created_at).toLowerCase().includes(searchTerm);
                        });

                        updateSearchResults(filteredContacts);
                    }
                });
            </script>

        </div>
    </div>
    
@endsection
