<form method="POST"
      @if ($method === 'PATCH')
      action="{{ route('threads.update', ['forum' => $forum->id, 'thread' => $thread->id]) }}"
      @else
      action="{{ route('threads.store', ['forum' => $forum->id]) }}"      
      @endif
      >

    @csrf

    @if ($method === 'PATCH')
    <input name="_method" type="hidden" value="PATCH">
    @endif

    <!-- title -->
    <div class="form-group row">
        <label for="title" class="col-lg-4 col-form-label text-lg-right">{{ __('labels.form_thread_title') }}</label>
        <div class="col-lg-6">
            <input type="text" name="title" id="title" class="form-control" required autofocus
                   @if ($method === 'PATCH')
                   value="{{ $thread->title }}"
                   @else
                   value="{{ old('title') }}"
                   @endif
            >
        </div>
    </div>

    <!-- description -->
    <div class="form-group row">
        <label for="description" class="col-lg-4 col-form-label text-lg-right">{{ __('labels.form_thread_description') }}</label>
        <div class="col-lg-6">
            <textarea name="description" id="description" class="form-control" autofocus
            
            @if ($method === 'PATCH')
            >{{ $thread->description }}</textarea>
            @else
            >{{ old('description') }}</textarea>
            @endif
        </div>
    </div>

    <!-- creator_name -->
    @if (($method === 'PATCH' and !$thread->creator_user) or ($method !== 'PATCH' and !$user))
    <div class="form-group row">
        <label for="creator_name" class="col-lg-4 col-form-label text-lg-right">{{ __('labels.form_thread_creator_name') }}</label>
        <div class="col-lg-6">
            <input type="text" name="creator_name" id="creator_name" class="form-control" autofocus
                   @if ($method === 'PATCH')
                   value="{{ $thread->creator_name }}"
                   @else
                   value="{{ old('creator_name') }}"
                   @endif 
            >
        </div>
    </div>
    @endif

    <div class="form-group row">
        <div class="col-lg-8 offset-lg-4">
            <button type="submit" class="btn btn-primary">
                @if ($method === 'PATCH')
                {{ __('labels.btn_update_thread') }}
                @else
                {{ __('labels.btn_create_thread') }}
                @endif
            </button>
        </div>
    </div>
</form>
