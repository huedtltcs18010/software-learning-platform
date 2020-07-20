@extends('layouts.backend')

@section('content')
    @include('shared.breadcrumb')

    <h1>Add new series</h1>

    {{ Form::model($series, ['route' => 'admin.series.store', 'method' => 'post']) }}
        @include('admin.series.form')
    {{ Form::close() }}

@endsection
