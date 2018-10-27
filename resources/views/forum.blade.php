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
                <div class="card-header">{{ __('labels.sectitle_create_thread') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('threads.store') }}">
                        @csrf

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

<script>
$(document).ready(function(){
    // activate autosize
    autosize($('textarea'));
});
</script>

@endsection
