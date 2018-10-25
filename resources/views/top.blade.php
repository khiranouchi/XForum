@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('labels.sectitle_create_forum') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('forums.store') }}">
                        @csrf

                        <!-- title -->
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('labels.form_forum_title') }}</label>
                            <div class="col-md-6">
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required autofocus>
                            </div>
                        </div>

                        <!-- description -->
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('labels.form_forum_description') }}</label>
                            <div class="col-md-6">
                                <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" autofocus>
                            </div>
                        </div>

                        @if ($user)
                        <!-- password -->
                        <div class="form-group row">
                            <label for="password" name="password" class="col-md-4 col-form-label text-md-right">{{ __('labels.form_forum_password') }}</label>
                            <div class="col-md-6">
                                <input type="password" id="password" class="form-control" value="{{ old('password') }}" autofocus>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('labels.btn_create_forum') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
