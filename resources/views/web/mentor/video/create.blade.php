@extends('layouts.web')

@section('content')
    <div class="show-top-grids">
        <h1>Upload new video</h1>
        {{ Form::model($video, ['route' => 'user.mentor.storeVideo', 'method' => 'post', 'files' => true]) }}
            @include('web.mentor.video.form')
        {{ Form::close() }}
    </div>
@endsection
