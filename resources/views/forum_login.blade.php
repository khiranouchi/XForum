@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('labels.sectitle_forum_login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('forums.authenticate') }}">
                        @csrf

                        <input type="hidden" name="forum_id" value="{{ $forum->id }}">

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('labels.form_forum_login_password') }}</label>
                            <div class="col-md-6">
                                <input type="password" name="password" id="password" class="form-control" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('labels.btn_login_forum') }}
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
