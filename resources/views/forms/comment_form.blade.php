<form method="POST"
      onclick="SaveScroll(this);"
      @if ($method === 'PATCH')
      action="{{ route('comments.update', ['forum' => $forum->id, 'thread' => $thread->id, 'comment' => $comment->id]) }}"
      @else
      action="{{ route('comments.store', ['forum' => $forum->id, 'thread' => $thread->id]) }}"
      @endif
      >

    @csrf

    @if ($method === 'PATCH')
    <input name="_method" type="hidden" value="PATCH">
    @endif

    <div class="form-group">
        <input type="text" name="title" id="title" class="form-control" autofocus
               placeholder="{{ __('labels.form_comment_title') }}" 
               @if ($method === 'PATCH')
               value="{{ $comment->title }}"
               @else
               value="{{ old('title') }}"
               @endif
        >
    </div>

    <div class="form-group">
        <textarea name="content" id="content" class="form-control" required autofocus
            @if ($method === 'PATCH')
            >{{ $comment->content }}</textarea>
            @else
            >{{ old('content') }}</textarea>
            @endif 
    </div>

    @if (!$user)
    <div class="form-group row">
        <div class="col-sm-6">
            <input type="text" name="creator_name" id="creator_name" class="form-control" autofocus
                   placeholder="{{ __('labels.form_comment_creator_name') }}"
                   @if ($method === 'PATCH')
                   value="{{ $comment->creator_name }}"
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
            {{ __('labels.btn_update_comment') }}
            @else
            {{ __('labels.btn_create_comment') }}
            @endif
        </button>
    </div>
</form>
