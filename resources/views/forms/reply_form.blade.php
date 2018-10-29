<form method="POST"
      @if ($method === 'PATCH')
      action="{{ route('replies.update', ['forum' => $forum->id, 'thread' => $thread->id, 'comment' => $comment->id, 'reply' => $reply->id]) }}"
      @else
      action="{{ route('replies.store', ['forum' => $forum->id, 'thread' => $thread->id, 'comment' => $comment->id]) }}"
      @endif
      >

    @csrf

    @if ($method === 'PATCH')
    <input name="_method" type="hidden" value="PATCH">
    @endif

    <div class="form-group">
        <textarea name="content" id="content" class="form-control" required autofocus
        @if ($method === 'PATCH')
        >{{ $reply->content }}</textarea>
        @else
        >{{ old('content') }}</textarea>
        @endif
    </div>

    @if (!$user)
    <div class="form-group row">
        <div class="col-sm-7">
            <input type="text" name="creator_name" id="creator_name" class="form-control" autofocus
                   placeholder="{{ __('labels.form_reply_creator_name') }}"
                   @if ($method === 'PATCH')
                   value="{{ $reply->creator_name }}"
                   @else
                   value="{{ old('creator_name') }}"
                   @endif
            >
        </div>
    </div>
    @endif

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            @if ($method === 'PATCH')
            {{ __('labels.btn_update_reply') }}
            @else
            {{ __('labels.btn_create_reply') }}
            @endif
        </button>
    </div>
</form>
