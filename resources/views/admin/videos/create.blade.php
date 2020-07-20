@extends('layouts.backend')

@section('content')
    @include('shared.breadcrumb')

    <h1>Add new video</h1>

    {{ Form::model($video, ['route' => 'admin.videos.store', 'method' => 'post', 'files' => true]) }}
        @include('admin.videos.form')
    {{ Form::close() }}

@endsection
