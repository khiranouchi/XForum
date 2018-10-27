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
                <div class="card-body">
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
                    <form method="POST" action="{{ route('threads.store') }}">
                        @csrf

                        <input type="hidden" name="forum_id" value="{{ $forum->id }}">

                        <!-- title -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('labels.form_thread_title') }}</label>
                            <div class="col-md-6">
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required autofocus>
                            </div>
                        </div>

                        <!-- description -->
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('labels.form_thread_description') }}</label>
                            <div class="col-md-6">
                                <textarea name="description" id="description" class="form-control" value="{{ old('description') }}" autofocus></textarea>
                            </div>
                        </div>

                        @if (!$user)
                        <!-- password -->
                        <div class="form-group row">
                            <label for="creator_name" class="col-md-4 col-form-label text-md-right">{{ __('labels.form_thread_creator_name') }}</label>
                            <div class="col-md-6">
                                <input type="text" name="creator_name" id="creator_name" class="form-control" value="{{ old('creator_name') }}" autofocus>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('labels.btn_create_thread') }}
                                </button>
                            </div>
                        </div>
                    </form>
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
                <a href="#" class="list-group-item list-group-item-action">
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
