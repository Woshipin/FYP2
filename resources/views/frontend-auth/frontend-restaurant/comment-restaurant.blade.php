@extends('frontend-auth.newlayout')

@section('frontend-section')

    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #666;
            --border-color: #e5e7eb;
            --background-color: #f9fafb;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.5;
            color: var(--primary-color);
            background-color: var(--background-color);
        }

        .restaurant-comment-container {
            max-width: 1200px;
            /* 增加容器宽度 */
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .restaurant-comment-section {
            background-color: var(--white);
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .restaurant-comment-section h2 {
            font-size: 2rem;
            /* 增加标题字体大小 */
            margin-bottom: 1.5rem;
        }

        .restaurant-comment-form {
            background-color: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .restaurant-comment-form textarea {
            width: 100%;
            min-height: 100px;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            margin-bottom: 1rem;
            resize: vertical;
            font-family: inherit;
            font-size: 1rem;
        }

        .restaurant-comment-post-button {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 1rem;
            /* 增加按钮字体大小 */
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .restaurant-comment-post-button:hover {
            background-color: #333;
        }

        .restaurant-comment-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .restaurant-comment {
            background-color: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1rem;
        }

        .restaurant-comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .restaurant-comment-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .restaurant-comment-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .restaurant-comment-author-info h3 {
            font-size: 1rem;
            /* 增加作者名字字体大小 */
            font-weight: 600;
        }

        .restaurant-comment-timestamp {
            font-size: 0.875rem;
            /* 增加时间戳字体大小 */
            color: var(--secondary-color);
        }

        .restaurant-comment-content {
            margin: 0.5rem 0;
            font-size: 1rem;
            /* 增加评论内容字体大小 */
        }

        .restaurant-comment-reply-button {
            background: none;
            border: none;
            color: var(--secondary-color);
            font-size: 0.875rem;
            cursor: pointer;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            transition: background-color 0.2s;
        }

        .restaurant-comment-reply-button:hover {
            background-color: var(--background-color);
        }

        .restaurant-comment-replies {
            margin-left: 3rem;
            margin-top: 1rem;
        }

        .restaurant-comment-reply {
            background-color: var(--background-color);
            border-color: var(--border-color);
        }

        @media (max-width: 640px) {
            .restaurant-comment-container {
                padding: 0 0.5rem;
            }

            .restaurant-comment-section {
                padding: 1rem;
            }

            .restaurant-comment-replies {
                margin-left: 1.5rem;
            }

            .restaurant-comment-form textarea {
                min-height: 80px;
            }
        }
    </style>

    <br><br><br>

    <div class="restaurant-comment-container">
        <div class="restaurant-comment-section">
            <h2>Comments</h2>

            <!-- New Comment Form -->
            <div class="restaurant-comment-form">
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

                    <textarea class="form-control" name="comment" placeholder="Write something from your heart..!"></textarea>
                    <button class="restaurant-comment-post-button" type="submit">Post Comment</button>
                </form>
            </div>

            <!-- Comments List -->
            <div class="restaurant-comment-list">
                @if ($comments->count() > 0)
                    @foreach ($comments as $comment)
                        <div class="restaurant-comment">
                            <div class="restaurant-comment-header">
                                <div class="restaurant-comment-author">
                                    <img src="https://via.placeholder.com/40" alt="{{ $comment->user_name }}"
                                        class="restaurant-comment-avatar">
                                    <div class="restaurant-comment-author-info">
                                        <h3>{{ $comment->user_name }}</h3>
                                        <span class="restaurant-comment-timestamp">{{ $comment->created_at }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="restaurant-comment-content">
                                <p>{{ $comment->comment }}</p>
                            </div>
                            <button class="restaurant-comment-reply-button reply" cid="{{ $comment->id }}"
                                name_a="{{ Auth::user()->name }}" token="{{ csrf_token() }}"
                                data-parent-id="{{ $comment->id }}" data-parent-type="comment">Reply</button>
                            @if ($comment->user_id == Auth::id())
                                <button class="restaurant-comment-reply-button delete-comment"
                                    data-id="{{ $comment->id }}">Delete</button>
                            @endif

                            <div class="restaurant-comment-replies reply-form">
                                @if ($comment->replies && $comment->replies->count() > 0)
                                    @foreach ($comment->replies as $reply)
                                        <div class="restaurant-comment restaurant-comment-reply">
                                            <div class="restaurant-comment-header">
                                                <div class="restaurant-comment-author">
                                                    <img src="https://via.placeholder.com/40" alt="{{ $reply->name }}"
                                                        class="restaurant-comment-avatar">
                                                    <div class="restaurant-comment-author-info">
                                                        <h3>{{ $reply->name }}</h3>
                                                        <span class="restaurant-comment-timestamp">Replied ->
                                                            {{ $reply->parent_name }} {{ $reply->created_at }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="restaurant-comment-content">
                                                <p>{{ $reply->reply }}</p>
                                            </div>
                                            <button class="restaurant-comment-reply-button reply-to-reply"
                                                rname="{{ Auth::user()->name }}" rid="{{ $reply->id }}"
                                                token="{{ csrf_token() }}" data-parent-id="{{ $reply->id }}"
                                                data-parent-type="reply">Reply</button>
                                            @if ($reply->user_id == Auth::id())
                                                <button class="restaurant-comment-reply-button delete-reply"
                                                    data-id="{{ $reply->id }}">Delete</button>
                                            @endif

                                            <div class="restaurant-comment-replies reply-to-reply-form">
                                                @if ($reply->repliesToReplies && $reply->repliesToReplies->count() > 0)
                                                    @foreach ($reply->repliesToReplies as $replyToReply)
                                                        <div class="restaurant-comment restaurant-comment-reply">
                                                            <div class="restaurant-comment-header">
                                                                <div class="restaurant-comment-author">
                                                                    <img src="https://via.placeholder.com/40"
                                                                        alt="{{ $replyToReply->name }}"
                                                                        class="restaurant-comment-avatar">
                                                                    <div class="restaurant-comment-author-info">
                                                                        <h3>{{ $replyToReply->name }}</h3>
                                                                        <span class="restaurant-comment-timestamp">Replied
                                                                            -> {{ $replyToReply->parent_name }}
                                                                            {{ $replyToReply->created_at }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="restaurant-comment-content">
                                                                <p>{{ $replyToReply->reply }}</p>
                                                            </div>
                                                            <button class="restaurant-comment-reply-button reply-to-reply"
                                                                rname="{{ Auth::user()->name }}"
                                                                rid="{{ $replyToReply->id }}" token="{{ csrf_token() }}"
                                                                data-parent-id="{{ $replyToReply->id }}"
                                                                data-parent-type="reply">Reply</button>
                                                            @if ($replyToReply->user_id == Auth::id())
                                                                <button
                                                                    class="restaurant-comment-reply-button delete-reply-to-reply"
                                                                    data-id="{{ $replyToReply->id }}">Delete</button>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No comments yet. Be the first to comment!</p>
                @endif
            </div>
        </div>
    </div>

    <br><br>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function appendReplyForm(well, action, cid, name, token, parentId, parentType) {
                var form =
                    `<form method="post" action="${action}"><input type="hidden" name="_token" value="${token}"><input type="hidden" name="comment_id" value="${cid}"><input type="hidden" name="name" value="${name}"><input type="hidden" name="parent_id" value="${parentId}"><input type="hidden" name="parent_type" value="${parentType}"><div class="form-group"><textarea class="form-control" name="reply" placeholder="Enter your reply"></textarea></div><div class="form-group"><input class="btn btn-primary" type="submit"></div></form>`;
                well.find(".reply-form").append(form);
            }

            function appendReplyToReplyForm(well, action, rid, rname, token, parentId, parentType) {
                var form =
                    `<form method="post" action="${action}"><input type="hidden" name="_token" value="${token}"><input type="hidden" name="reply_id" value="${rid}"><input type="hidden" name="name" value="${rname}"><input type="hidden" name="parent_id" value="${parentId}"><input type="hidden" name="parent_type" value="${parentType}"><div class="form-group"><textarea class="form-control" name="reply" placeholder="Enter your reply to ${rname}"></textarea></div><div class="form-group"><input class="btn btn-primary" type="submit"></div></form>`;
                well.find(".reply-to-reply-form").append(form);
            }

            $(".restaurant-comment-list").on("click", ".reply", function() {
                var well = $(this).parent().parent();
                var cid = $(this).attr("cid");
                var name = $(this).attr('name_a');
                var token = $(this).attr('token');
                var parentId = $(this).data('parent-id');
                var parentType = $(this).data('parent-type');
                appendReplyForm(well, "{{ route('replyrestaurantcomment') }}", cid, name, token, parentId,
                    parentType);
            });

            $(".restaurant-comment-list").on("click", ".delete-comment", function(e) {
                e.preventDefault();
                var commentId = $(this).data('id');
                var commentElement = $(this).closest('.restaurant-comment');

                if (confirm("Are you sure you want to delete this comment?")) {
                    $.ajax({
                        url: "{{ route('deleteRestaurantComment', ['id' => ':id']) }}".replace(
                            ':id', commentId),
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

            $(".restaurant-comment-list").on("click", ".delete-reply", function(e) {
                e.preventDefault();
                var replyId = $(this).data('id');
                var replyElement = $(this).closest('.restaurant-comment-reply');

                if (confirm("Are you sure you want to delete this reply?")) {
                    $.ajax({
                        url: "{{ route('deletereplyrestaurantcomment', ['id' => ':id']) }}"
                            .replace(':id', replyId),
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

            $(".restaurant-comment-list").on("click", ".delete-reply-to-reply", function(e) {
                e.preventDefault();
                var replyToReplyId = $(this).data('id');
                var replyToReplyElement = $(this).closest('.restaurant-comment-reply');

                if (confirm("Are you sure you want to delete this reply?")) {
                    $.ajax({
                        url: "{{ route('deleteReplyToReplyRestaurantComment', ['id' => ':id']) }}"
                            .replace(':id', replyToReplyId),
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

            $(".restaurant-comment-list").on("click", ".reply-to-reply", function() {
                var well = $(this).parent().parent();
                var rid = $(this).attr("rid");
                var rname = $(this).attr("rname");
                var token = $(this).attr("token");
                var parentId = $(this).data('parent-id');
                var parentType = $(this).data('parent-type');
                appendReplyToReplyForm(well, "{{ route('storeReplyToReplyRestaurant') }}", rid, rname,
                    token, parentId, parentType);
            });
        });
    </script>

@endsection
