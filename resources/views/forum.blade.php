@extends('layouts.app')

@section('subtitle')
{{ $forum->title }}
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

    <!-- Thread list -->
    <div class="x-part row justify-content-center">
        <div class="col-md-8">
            <h5>{{ __('labels.sectitle_thread_list') }}</h5>

            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <div class="x-font-large">Thread1</div>
                        <div>Created by username1</div>
                    </div>
                    <div>description description description description description</div>
                </a>
            </div>
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <div class="x-font-large">Thread2</div>
                        <div></div>
                    </div>
                    <div>description description description description description description ...</div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
