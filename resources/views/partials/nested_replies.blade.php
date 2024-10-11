<!-- resources/views/partials/nested_replies.blade.php -->
@if ($replies && $replies->count() > 0)
    @foreach ($replies as $reply)
        <div class="well reply-well">
            <i><b>{{ $reply->name }}</b></i>&nbsp;&nbsp;
            <span>
                <strong>Replying -> {{ $reply->parent_name }}</strong>&nbsp;&nbsp;
            </span>
            <span>{{ $reply->created_at }}</span><br>

            <span>{{ $reply->reply }}</span>

            <!-- Reply and Delete Options for Nested Reply -->
            <div style="margin-left:10px;">
                <a rname="{{ Auth::user()->name }}" rid="{{ $reply->id }}" style="cursor: pointer;" class="reply-to-reply" token="{{ csrf_token() }}">Reply</a>&nbsp;
                @if($reply->user_id == Auth::id())
                    <a href="#" style="cursor: pointer;" class="delete-reply" data-id="{{ $reply->id }}">Delete</a>
                @endif
            </div>

            <div class="reply-to-reply-form"></div>

            <!-- Recursively include nested replies -->
            @if ($reply->repliesToReplies && $reply->repliesToReplies->count() > 0)
                @include('partials.nested_replies', ['replies' => $reply->repliesToReplies, 'parent_type' => 'reply', 'parent_id' => $reply->id])
            @endif
        </div>
        
    @endforeach
@endif
