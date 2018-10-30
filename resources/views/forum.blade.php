@extends('layouts.app')

@section('subtitle')
{{ $forum->title }}
@endsection

@section('head')
<script src="{{ asset('js/jquery.autosize.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <!-- Forum info -->
    <div class="x-part row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div id="x_forum_info" class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">{{ __('labels.forum_title') }}</dt>
                        <dd class="col-sm-9">{{ $forum->title }}</dd>

                        @if ($forum->description)
                        <dt class="col-sm-3">{{ __('labels.forum_description') }}</dt>
                        <dd class="col-sm-9">{{ $forum->description }}</dd>
                        @endif

                        @if ($forum->creator_user)
                        <dt class="col-sm-3">{{ __('labels.forum_creator_user_name') }}</dt>
                        <dd class="col-sm-9">{{ $forum->creator_user->name }}</dd>
                        @endif

                        <dd class="col-sm-12">
                            <!-- edit forum -->
                            <button class="btn btn-outline-secondary x-btn-small-padding x-inline-form"
                                    onclick="SwitchToEditMode('x_forum_info', '{{ route('forums.edit', ['forum' => $forum->id]) }}')">
                                {{ __('labels.btn_edit_forum') }}
                            </button>
                            <!-- delete forum -->
                            @if (($user and $forum->creator_user and $user->id === $forum->creator_user_id) or ($guest_id and $guest_id === $forum->creator_guest_id))
                            <form class="x-inline-form"
                                  action="{{ route('forums.destroy', ['forum' => $forum]) }}" method="post"
                                  onclick="ShowCheckDialog('{{ __('texts.dialog_delete_forum_1') }}', '{{ __('texts.dialog_delete_forum_2') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary x-btn-small-padding">
                                    {{ __('labels.btn_delete_forum') }}
                                </button>
                            </form>
                            @endif
                        </dd>
                    </dl>

                    <!-- TODO button to edit info -->

                </div>
            </div>
        </div>
    </div>

    <!-- Create thread form -->
    <div class="x-part row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10">{{ __('labels.sectitle_create_thread') }}</div>
                        <div class="col-2 text-right x-hover-pointer"
                             onclick="ShowHideBlock(this, 'z_create_thread_form_body')">&#x25bc;</div>
                    </div>
                </div>

                <div class="card-body" id="z_create_thread_form_body" style="display: none">
                    @include('forms.thread_form', ['forum' => $forum, 'user' => $user, 'method' => 'POST'])
                </div>
            </div>
        </div>
    </div>

    <!-- Thread list -->
    <div class="x-part row justify-content-center">
        <div class="col-md-8">
            <h5>{{ __('labels.sectitle_thread_list') }}</h5>

            @foreach ($threads as $thread)
            <div class="list-group">
                <a href="{{ route('threads.show', ['forum' => $forum, 'thread' => $thread]) }}"
                   class="list-group-item list-group-item-action">
                    <div class="row">
                        <div class="col-sm-7 x-font-large x-text-ellipsis">{{ $thread->title }}</div>

                        <div class="col-sm-5 text-sm-right x-text-ellipsis">
                            @if ($thread->creator_user)
                            Created by {{ $thread->creator_user->name }}
                            @elseif (!is_null($thread->creator_name) and $thread->creator_name !== "")
                            Created by {{ $thread->creator_name }}
                            @endif
                        </div>
                    </div>

                    @if (is_null($thread->description) or $thread->description === "")
                    <div>{{ __('labels.text_no_description') }}</div>
                    @else
                    <div class="x-text-ellipsis">{{ $thread->description }}</div>
                    @endif
                </a>
            </div>
            @endforeach
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
