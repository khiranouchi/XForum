@extends('layouts.app')

@section('subtitle')
{{ $thread->title }} / {{ $forum->title }}
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




</div>
@endsection
