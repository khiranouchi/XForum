@extends('layouts.app')

@section('subtitle')
{{ $thread->title }} / {{ $forum->title }}
@endsection

@section('head')
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

            @foreach ($comments as $comment)
            <div class="x-subpart card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-11 x-text-ellipsis">
                            @if (is_null($comment->title) or $comment->title === "")
                            {{ __('labels.text_no_title') }}
                            @else
                            {{ $comment->title }}
                            @endif
                        </div>

                        <div class="col-sm-1">

                            <!-- TODO menu -->

                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {!! nl2br(e($comment->content)) !!}
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-8">
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
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


</div>
@endsection
