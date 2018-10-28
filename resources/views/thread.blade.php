@extends('layouts.app')

@section('subtitle')
{{ $thread->title }} / {{ $forum->title }}
@endsection

@section('titlelink')
{{ route('forums.show', ['forum' => $forum]) }}
@endsection

@section('head')
<script src="{{ asset('js/jquery.autosize.js') }}"></script>
<link href="{{ asset('css/thread.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <!-- Thread info -->
    <div class="x-part row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">{{ __('labels.thread_title') }}</dt>
                        <dd class="col-sm-9">{{ $thread->title }}</dd>

                        @if ($thread->description)
                        <dt class="col-sm-3">{{ __('labels.thread_description') }}</dt>
                        <dd class="col-sm-9">{{ $thread->description }}</dd>
                        @endif

                        @if ($thread->creator_user)
                        <dt class="col-sm-3">{{ __('labels.thread_creator_name') }}</dt>
                        <dd class="col-sm-9">{{ $thread->creator_user->name }}</dd>
                        @elseif (!is_null($thread->creator_name) and $thread->creator_name !== "")
                        <dt class="col-sm-3">{{ __('labels.thread_creator_name') }}</dt>
                        <dd class="col-sm-9">{{ $thread->creator_name }}</dd>
                        @endif
                    </dl>

                    <!-- TODO button to edit info -->

                </div>
            </div>
        </div>
    </div>

    <!-- Comment list -->
    <div class="x-part row justify-content-center">
        <div class="col-md-8">
            <h5>{{ __('labels.sectitle_comment_list') }}</h5>

            <!-- comments -->
            @foreach ($comments as $comment)
            <div class="x-subpart">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12 x-text-ellipsis">
                                @if (is_null($comment->title) or $comment->title === "")
                                {{ __('labels.text_no_title') }}
                                @else
                                {{ $comment->title }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {!! nl2br(e($comment->content)) !!}
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-7 x-text-ellipsis">
                                {{ $comment->getCreatedAtDate() }}
                                @if ($comment->created_at != $comment->updated_at)
                                {{ __('labels.text_edited') }}
                                @endif
                            </div>

                            <div class="col-4 text-right x-text-ellipsis">
                                @if ($comment->creator_user)
                                {{ $comment->creator_user->name }}
                                @elseif (!is_null($comment->creator_name) and $comment->creator_name !== "")
                                {{ $comment->creator_name }}
                                @endif
                            </div>

                            <div class="col-1">

                                <!-- TODO menu -->

                            </div>
                        </div>
                    </div>
                </div>

                <!-- replies -->
                @foreach ($dict_replies[$comment->id] as $reply)
                <div class="row">
                    <div class="col-11 offset-1">
                        <div class="card">
                            <div class="card-body">
                                {!! nl2br(e($reply->content)) !!}
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-7 x-text-ellipsis">
                                        {{ $reply->getCreatedAtDate() }}
                                        @if ($reply->created_at != $reply->updated_at)
                                        {{ __('labels.text_edited') }}
                                        @endif
                                    </div>

                                    <div class="col-4 text-right x-text-ellipsis">
                                        @if ($reply->creator_user)
                                        {{ $reply->creator_user->name }}
                                        @elseif (!is_null($reply->creator_name) and $reply->creator_name !== "")
                                        {{ $reply->creator_name }}
                                        @endif
                                    </div>

                                    <div class="col-1">

                                        <!-- TODO menu -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Create new reply -->
                <div class="row">
                    <div class="col-11 offset-1">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-10">{{ __('labels.sectitle_create_reply') }}</div>
                                    <div class="col-2 text-right x-hover-pointer"
                                         onclick="ShowHideBlock(this, 'z_create_reply_{{ $comment->id }}_form_body')">&#x25bc;</div>
                                </div>
                            </div>

                            <div class="card-body" id="z_create_reply_{{ $comment->id }}_form_body" style="display: none">
                                <form method="POST" action="{{ route('replies.store', ['forum' => $forum->id, 'thread' => $thread->id, 'comment' => $comment->id]) }}">
                                    @csrf

                                    <div class="form-group">
                                        <textarea name="content" id="content" class="form-control" value="{{ old('content') }}" required autofocus></textarea>
                                    </div>

                                    @if (!$user)
                                    <div class="form-group row">
                                        <div class="col-sm-7">
                                            <input type="text" name="creator_name" id="creator_name" class="form-control"
                                                   placeholder="{{ __('labels.form_reply_creator_name') }}" value="{{ old('creator_name') }}" autofocus>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('labels.btn_create_reply') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Create new comment -->
            <div class="x-subpart">
                <div class="card">
                    <div class="card-header">
	                    <div class="row">
                            <div class="col-10">{{ __('labels.sectitle_create_comment') }}</div>
                            <div class="col-2 text-right x-hover-pointer"
                                 onclick="ShowHideBlock(this, 'z_create_comment_form_body')">&#x25bc;</div>
                        </div>
                    </div>

                    <div class="card-body" id="z_create_comment_form_body" style="display: none">
                        <form method="POST" action="{{ route('comments.store', ['forum' => $forum->id, 'thread' => $thread->id]) }}">
                            @csrf

                            <div class="form-group">
                                <input type="text" name="title" id="title" class="form-control"
                                       placeholder="{{ __('labels.form_comment_title') }}" value="{{ old('title') }}" autofocus>
                            </div>

                            <div class="form-group">
                                <textarea name="content" id="content" class="form-control" value="{{ old('content') }}" required autofocus></textarea>
                            </div>

                            @if (!$user)
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="text" name="creator_name" id="creator_name" class="form-control"
                                           placeholder="{{ __('labels.form_comment_creator_name') }}" value="{{ old('creator_name') }}" autofocus>
                                </div>
                            </div>
                            @endif

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('labels.btn_create_comment') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    // activate autosize
    autosize($('textarea'));
});
</script>

@endsection
