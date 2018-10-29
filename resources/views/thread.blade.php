@extends('layouts.app')

@section('subtitle')
{{ $thread->title }} / {{ $forum->title }}
@endsection

@section('titlelink')
{{ route('forums.show', ['forum' => $forum]) }}
@endsection

@section('head')
<script src="{{ asset('js/jquery.autosize.js') }}"></script>
<script src="{{ asset('js/thread.js') }}"></script>
<link href="{{ asset('css/thread.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <!-- Thread info -->
    <div class="x-part row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div id="x_thread_info" class="card-body">
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

                        <dd class="col-sm-12">
                            <button class="btn btn-outline-secondary x-btn-small-padding"
                                    onclick="SwitchToEditMode('x_thread_info', '{{ route('threads.edit', ['forum' => $forum->id, 'thread' => $thread->id]) }}')">
                                {{ __('labels.btn_edit_thread') }}
                            </button>
                        </dd>
                    </dl>
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

                    <div id="x_comment_content_{{ $comment->id }}" class="card-body">
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

                            <div class="col-5 dropdown">
                                @if ($comment->creator_user)
                                    @if ($user and $user->id === $comment->creator_user->id)
                                    <div class="dropdown-toggle text-right x-text-ellipsis" id="z_dropdown_{{ $comment->id }}"
                                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $comment->creator_user->name }}
                                    </div>
                                    <div class="dropdown-menu" aria-labelledby="z_dropdown_{{ $comment->id }}">
                                        <!-- edit comment -->
                                        <div class="dropdown-item"
                                             onclick="SwitchToEditMode('x_comment_content_{{ $comment->id }}', '{{ route('comments.edit', ['forum' => $forum->id, 'thread' => $thread->id, 'comment' => $comment->id]) }}')">
                                            {{ __('labels.dropdown_edit') }}
                                        </div>
                                        <!-- delete comment -->
                                        <form method="post" name="z_form_comment_destroy_{{ $comment->id }}" class="z_check_dialog"
                                              action="{{ route('comments.destroy', ['forum' => $forum->id, 'thread' => $thread->id, 'comment' => $comment->id]) }}"
                                              onclick="SaveScroll(this);ShowCheckDialog('{{ __('texts.dialog_delete_comment') }}');">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <a class="dropdown-item"
                                               href="javascript:document.z_form_comment_destroy_{{ $comment->id }}.submit();">
                                                {{ __('labels.dropdown_delete') }}
                                            </a>
                                        </form>
                                    </div>
                                    @else
                                    <div class="text-right x-text-ellipsis">
                                        {{ $comment->creator_user->name }}
                                    </div>
                                    @endif
                                @elseif (!is_null($comment->creator_name) and $comment->creator_name !== "")
                                <div class="text-right x-text-ellipsis">
                                    {{ $comment->creator_name }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- replies -->
                @foreach ($dict_replies[$comment->id] as $reply)
                <div class="row">
                    <div class="col-11 offset-1">
                        <div class="card">
                            <div id="x_reply_content_{{ $reply->id }}" class="card-body">
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

                                    <div class="col-5 dropdown">
                                        @if ($reply->creator_user)
                                            @if ($user and $user->id === $reply->creator_user->id)
                                            <div class="dropdown-toggle text-right x-text-ellipsis" id="z_dropdown_{{ $reply->id }}"
                                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ $reply->creator_user->name }}
                                            </div>
                                            <div class="dropdown-menu" aria-labelledby="z_dropdown_{{ $reply->id }}">
                                                <!-- edit reply -->
                                                <div class="dropdown-item"
                                                     onclick="SwitchToEditMode('x_reply_content_{{ $reply->id }}', '{{ route('replies.edit', ['forum' => $forum->id, 'thread' => $thread->id, 'comment' => $comment->id, 'reply' => $reply->id]) }}')">
                                                    {{ __('labels.dropdown_edit') }}
                                                </div>
                                                <!-- delete reply -->
                                                <form method="post" name="z_form_reply_destroy_{{ $reply->id }}" class="z_check_dialog"
                                                      action="{{ route('replies.destroy', ['forum' => $forum->id, 'thread' => $thread->id, 'comment' => $comment->id, 'reply' => $reply->id]) }}"
                                                      onclick="SaveScroll(this);ShowCheckDialog('{{ __('texts.dialog_delete_reply') }}');">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <a class="dropdown-item"
                                                       href="javascript:document.z_form_reply_destroy_{{ $reply->id }}.submit();">
                                                        {{ __('labels.dropdown_delete') }}
                                                    </a>
                                                </form>
                                            </div>
                                            @else
                                            <div class="text-right x-text-ellipsis">
                                                {{ $reply->creator_user->name }}
                                            </div>
                                            @endif
                                        @elseif (!is_null($reply->creator_name) and $reply->creator_name !== "")
                                        <div class="text-right x-text-ellipsis">
                                            {{ $reply->creator_name }}
                                        </div>
                                        @endif
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
                                @include('forms.reply_form', ['forum' => $forum, 'thread' => $thread, 'comment' => $comment, 'user' => $user, 'method' => 'POST'])
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
                        @include('forms.comment_form', ['forum' => $forum, 'thread' => $thread, 'user' => $user, 'method' => 'POST'])
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
    // scroll
    $(window).scrollTop({{ $scroll }});
});
</script>
@endsection
