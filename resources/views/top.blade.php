@extends('layouts.app')

@section('head')
<script src="{{ asset('js/jquery.autosize.js') }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('labels.sectitle_create_forum') }}</div>

                <div class="card-body">
                    @include('forms.forum_form', ['user' => $user, 'method' => 'POST'])
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
