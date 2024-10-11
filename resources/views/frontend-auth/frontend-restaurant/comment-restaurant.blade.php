@extends('frontend-auth.newlayout')

@section('frontend-section')
    <br><br><br><br><br><br><br><br><br>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Comment</div>

                    <div class="panel-body">

                        @if (Session::has('success'))
                            <p class="text-success">{{ session('success') }}</p>
                        @endif

                        @if (Session::has('fail'))
                            <p class="text-danger">{{ session('fail') }}</p>
                        @endif

                        <form action="{{ route('addRestaurantComment', ['id' => $restaurant->id]) }}" id="comment-form" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                            <div class="row" style="padding: 10px;">
                                <div class="form-group">
                                    <textarea class="form-control" name="comment" placeholder="Write something from your heart..!"></textarea>
                                </div>
                            </div>
                            <div class="row" style="padding: 0 10px 0 10px;">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-lg" style="width: 100%" name="submit">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Comments</div>

                    <div class="panel-body comment-container">

                        @if ($comments->count() > 0)
                            @foreach ($comments as $comment)
                                <div class="well">
                                    <i><b>{{ $comment->user_name }}</b></i>
                                    <span>{{ $comment->created_at }}</span><br>
                                    <h4>{{ $comment->comment }}</h4>
                                    <div style="margin-left:10px;">
                                        <a style="cursor: pointer;" cid="{{ $comment->id }}"
                                            name_a="{{ Auth::user()->name }}" token="{{ csrf_token() }}"
                                            class="reply" data-parent-id="{{ $comment->id }}" data-parent-type="comment">Reply</a>&nbsp;
                                        @if($comment->user_id == Auth::id())
                                            <a href="#" style="cursor: pointer;" class="delete-comment" data-id="{{ $comment->id }}">Delete</a>
                                        @endif

                                        <div class="reply-form">
                                            <!-- Dynamic Reply form -->
                                            @if ($comment->replies && $comment->replies->count() > 0)
                                                @foreach ($comment->replies as $reply)
                                                    <div class="well reply-well">
                                                        <i><b>{{ $reply->name }}</b></i>&nbsp;&nbsp;
                                                        <span>Replied -> {{ $reply->parent_name }}</span>
                                                        <span>{{ $reply->created_at }}</span><br>
                                                        <span>{{ $reply->reply }}</span>
                                                        <div style="margin-left:10px;">
                                                            <a rname="{{ Auth::user()->name }}" rid="{{ $reply->id }}"
                                                                style="cursor: pointer;" class="reply-to-reply"
                                                                token="{{ csrf_token() }}" data-parent-id="{{ $reply->id }}" data-parent-type="reply">Reply</a>&nbsp;
                                                            @if($reply->user_id == Auth::id())
                                                                <a href="#" style="cursor: pointer;" class="delete-reply" data-id="{{ $reply->id }}">Delete</a>
                                                            @endif
                                                        </div>

                                                        <div class="reply-to-reply-form">
                                                            <!-- Dynamic Reply form -->
                                                            @if ($reply->repliesToReplies && $reply->repliesToReplies->count() > 0)
                                                                @foreach ($reply->repliesToReplies as $replyToReply)
                                                                    <div class="well reply-to-reply-well">
                                                                        <i><b>{{ $replyToReply->name }}</b></i>&nbsp;&nbsp;
                                                                        <span>Replied -> {{ $replyToReply->parent_name }}</span>
                                                                        <span>{{ $replyToReply->created_at }}</span><br>
                                                                        <span>{{ $replyToReply->reply }}</span>
                                                                        <div style="margin-left:10px;">
                                                                            <a rname="{{ Auth::user()->name }}" rid="{{ $replyToReply->id }}"
                                                                                style="cursor: pointer;" class="reply-to-reply"
                                                                                token="{{ csrf_token() }}" data-parent-id="{{ $replyToReply->id }}" data-parent-type="reply">Reply</a>&nbsp;
                                                                            @if($replyToReply->user_id == Auth::id())
                                                                                <a href="#" style="cursor: pointer;" class="delete-reply-to-reply" data-id="{{ $replyToReply->id }}">Delete</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>

                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No comments yet. Be the first to comment!</p>
                        @endif

                    </div>

                </div>
            </div>
        </div>

    </div>

    <br><br><br><br><br>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".comment-container").on("click", ".reply", function() {
                var well = $(this).parent().parent();
                var cid = $(this).attr("cid");
                var name = $(this).attr('name_a');
                var token = $(this).attr('token');
                var parentId = $(this).data('parent-id');
                var parentType = $(this).data('parent-type');
                var form =
                    `<form method="post" action="{{ route('replyrestaurantcomment') }}"><input type="hidden" name="_token" value="${token}"><input type="hidden" name="comment_id" value="${cid}"><input type="hidden" name="name" value="${name}"><input type="hidden" name="parent_id" value="${parentId}"><input type="hidden" name="parent_type" value="${parentType}"><div class="form-group"><textarea class="form-control" name="reply" placeholder="Enter your reply"></textarea></div><div class="form-group"><input class="btn btn-primary" type="submit"></div></form>`;

                well.find(".reply-form").append(form);
            });

            $(".comment-container").on("click", ".delete-comment", function(e) {
                e.preventDefault();
                var commentId = $(this).data('id');
                var commentElement = $(this).closest('.well');

                if (confirm("Are you sure you want to delete this comment?")) {
                    $.ajax({
                        url: "{{ route('deleteRestaurantComment', ['id' => ':id']) }}".replace(':id', commentId),
                        type: 'DELETE',
                        success: function(result) {
                            if (result.success) {
                                commentElement.remove();
                                alert(result.message);
                            } else {
                                alert(result.message);
                            }
                        }
                    });
                }
            });

            $(".comment-container").on("click", ".delete-reply", function(e) {
                e.preventDefault();
                var replyId = $(this).data('id');
                var replyElement = $(this).closest('.reply-well');

                if (confirm("Are you sure you want to delete this reply?")) {
                    $.ajax({
                        url: "{{ route('deletereplyrestaurantcomment', ['id' => ':id']) }}".replace(':id', replyId),
                        type: 'DELETE',
                        success: function(result) {
                            if (result.success) {
                                replyElement.remove();
                                alert(result.message);
                            } else {
                                alert(result.message);
                            }
                        }
                    });
                }
            });

            $(".comment-container").on("click", ".delete-reply-to-reply", function(e) {
                e.preventDefault();
                var replyToReplyId = $(this).data('id');
                var replyToReplyElement = $(this).closest('.reply-to-reply-well');

                if (confirm("Are you sure you want to delete this reply?")) {
                    $.ajax({
                        url: "{{ route('deleteReplyToReplyRestaurantComment', ['id' => ':id']) }}".replace(':id', replyToReplyId),
                        type: 'DELETE',
                        success: function(result) {
                            if (result.success) {
                                replyToReplyElement.remove();
                                alert(result.message);
                            } else {
                                alert(result.message);
                            }
                        }
                    });
                }
            });

            $(".comment-container").on("click", ".reply-to-reply", function() {
                var well = $(this).parent().parent();
                var rid = $(this).attr("rid");
                var rname = $(this).attr("rname");
                var token = $(this).attr("token");
                var parentId = $(this).data('parent-id');
                var parentType = $(this).data('parent-type');
                var form =
                    `<form method="post" action="{{ route('storeReplyToReplyRestaurant') }}"><input type="hidden" name="_token" value="${token}"><input type="hidden" name="reply_id" value="${rid}"><input type="hidden" name="name" value="${rname}"><input type="hidden" name="parent_id" value="${parentId}"><input type="hidden" name="parent_type" value="${parentType}"><div class="form-group"><textarea class="form-control" name="reply" placeholder="Enter your reply to ${rname}"></textarea></div><div class="form-group"><input class="btn btn-primary" type="submit"></div></form>`;

                well.find(".reply-to-reply-form").append(form);
            });
        });
    </script>

@endsection
