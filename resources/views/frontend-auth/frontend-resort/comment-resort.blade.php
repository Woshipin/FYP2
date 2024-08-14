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
                            <p class="text-success">{{ session('fail') }}</p>
                        @endif

                        <form action="{{ route('addResortComment', ['id' => $resortId]) }}" id="comment-form" method="post">
                            {{ csrf_field() }}

                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="resort_id" value="{{ $resorts->id }}">

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

                        @if ($comments)
                            @foreach ($comments as $comment)
                                <div class="well">
                                    <i><b>{{ $comment->user_name }}</b></i>
                                    <span>{{ $comment->created_at }}</span><br>
                                    <h4>{{ $comment->comment }}</h4>
                                    <div style="margin-left:10px;">
                                        <a style="cursor: pointer;" cid="{{ $comment->id }}" name_a="{{ Auth::user()->name }}"
                                            token="{{ csrf_token() }}" class="reply">Reply</a>&nbsp;
                                        <a onclick="return confirm('Are you sure to delete this Comment?')"
                                            href="{{ url('deleteResortComment/' . $comment->id) . '/delete' }}" style="cursor: pointer;"
                                            class="delete-comment" token="{{ csrf_token() }}"
                                            comment-did="{{ $comment->id }}">Delete</a>
                                        <div class="reply-form">
                                            <!-- Dynamic Reply form -->
                                            @foreach ($replies as $reply)
                                                @if ($reply->comment_id === $comment->id)
                                                    <div class="well">
                                                        <i><b>{{ $reply->name }}</b></i>&nbsp;&nbsp;
                                                        <span>{{ $reply->created_at }}</span><br>
                                                        <span>{{ $reply->reply }}</span>
                                                        <div style="margin-left:10px;">
                                                            <a rname="{{ Auth::user()->name }}" rid="{{ $comment->id }}"
                                                                style="cursor: pointer;" class="reply-to-reply"
                                                                token="{{ csrf_token() }}">Reply</a>&nbsp;
                                                            <a onclick="return confirm('Are you sure to delete this Reply?')"
                                                                href="{{ url('deletereplyresortcomment/' . $reply->id) . '/delete' }}"
                                                                class="delete-reply" token="{{ csrf_token() }}">Delete</a>
                                                        </div>
                                                        <div class="reply-to-reply-form">
                                                            <!-- Dynamic Reply form -->
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>暂无评论。</p>
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

            $(".comment-container").delegate(".reply", "click", function() {

                var well = $(this).parent().parent();
                var cid = $(this).attr("cid");
                var name = $(this).attr('name_a');
                var token = $(this).attr('token');
                var form =
                    '<form method="post" action="/replyresortcomment"><input type="hidden" name="_token" value="' +
                    token + '"><input type="hidden" name="comment_id" value="' + cid +
                    '"><input type="hidden" name="name" value="' + name +
                    '"><div class="form-group"><textarea class="form-control" name="reply" placeholder="Enter your reply" > </textarea> </div> <div class="form-group"> <input class="btn btn-primary" type="submit"> </div></form>';

                well.find(".reply-form").append(form);

            });

            // $(".comment-container").delegate(".delete-comment", "click", function() {

            //     var cdid = $(this).attr("comment-did");
            //     var token = $(this).attr("token");
            //     var well = $(this).parent().parent();
            //     $.ajax({
            //         url: "/comments/" + cdid,
            //         method: "POST",
            //         data: {
            //             _method: "delete",
            //             _token: token
            //         },
            //         success: function(response) {
            //             if (response == 1 || response == 2) {
            //                 well.hide();
            //             } else {
            //                 alert('Oh ! you can delete only your comment');
            //                 console.log(response);
            //             }
            //         }
            //     });

            // });

            $(".comment-container").delegate(".reply-to-reply", "click", function() {
                var well = $(this).parent().parent();
                var cid = $(this).attr("rid");
                var rname = $(this).attr("rname");
                var token = $(this).attr("token")
                var form =
                    '<form method="post" action="/reply/store"><input type="hidden" name="_token" value="' +
                    token + '"><input type="hidden" name="comment_id" value="' + cid +
                    '"><input type="hidden" name="name" value="' + rname +
                    '"><div class="form-group"><textarea class="form-control" name="reply" placeholder="Enter your reply" > </textarea> </div> <div class="form-group"> <input class="btn btn-primary" type="submit"> </div></form>';

                well.find(".reply-to-reply-form").append(form);

            });

            // $(".comment-container").delegate(".delete-reply", "click", function() {

            //     var well = $(this).parent().parent();

            //     if (confirm("Are you sure you want to delete this..!")) {
            //         var did = $(this).attr("did");
            //         var token = $(this).attr("token");
            //         $.ajax({
            //             url: "/replies/" + did,
            //             method: "POST",
            //             data: {
            //                 _method: "delete",
            //                 _token: token
            //             },
            //             success: function(response) {
            //                 if (response == 1) {
            //                     well.hide();
            //                     //alert("Your reply is deleted");
            //                 } else if (response == 2) {
            //                     alert('Oh! You can not delete other people comment');
            //                 } else {
            //                     alert('Something wrong in project setup');
            //                 }
            //             }
            //         })
            //     }
            // });
        });
    </script>
@endsection
