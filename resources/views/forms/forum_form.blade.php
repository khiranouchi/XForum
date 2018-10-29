<form method="POST"
      @if ($method === 'PATCH')
      action="{{ route('forums.update', ['forum' => $forum]) }}"
      @else
      action="{{ route('forums.store') }}"
      @endif
      >

    @csrf

    @if ($method === 'PATCH')
    <input name="_method" type="hidden" value="PATCH">
    @endif

    <!-- title -->
    <div class="form-group row">
        <label for="title" class="col-lg-4 col-form-label text-lg-right">{{ __('labels.form_forum_title') }}</label>
        <div class="col-lg-6">
            <input type="text" name="title" id="title" class="form-control" required autofocus
                   @if ($method === 'PATCH')
                   value="{{ $forum->title }}"
                   @else
                   value="{{ old('title') }}"
                   @endif
            >
        </div>
    </div>

    <!-- description -->
    <div class="form-group row">
        <label for="description" class="col-lg-4 col-form-label text-lg-right">{{ __('labels.form_forum_description') }}</label>
        <div class="col-lg-6">
            <textarea name="description" id="description" class="form-control" autofocus
            @if ($method === 'PATCH')
            >{{ $forum->description }}</textarea>
            @else
            >{{ old('description') }}</textarea>
            @endif
        </div>
    </div>

    @if ($method !== 'PATCH')
    @if ($user)
    <!-- password -->
    <div class="form-group row">
        <label for="password" class="col-lg-4 col-form-label text-lg-right">{{ __('labels.form_forum_password') }}</label>
        <div class="col-lg-6">
            <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" autofocus>
        </div>
    </div>
    @endif
    @endif

    <div class="form-group row">
        <div class="col-lg-6 offset-lg-4">
            <button type="submit" class="btn btn-primary">
                @if ($method === 'PATCH')
                {{ __('labels.btn_update_forum') }}
                @else
                {{ __('labels.btn_create_forum') }}
                @endif
            </button>
        </div>
    </div>
</form>
