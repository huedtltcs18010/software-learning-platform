@extends('layouts.backend')

@section('content')
    @include('shared.breadcrumb')

    <h1>Edit a video</h1>

    {{ Form::model($video, ['route' => ['admin.videos.update', $video->id], 'method' => 'put', 'files' => true]) }}
        @include('admin.videos.form')
    {{ Form::close() }}

@endsection
