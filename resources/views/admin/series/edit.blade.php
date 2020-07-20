@extends('layouts.backend')

@section('content')
    @include('shared.breadcrumb')

    <h1>Edit a series</h1>

    {{ Form::model($series, ['route' => ['admin.series.update', $series->id], 'method' => 'put']) }}
        @include('admin.series.form')
    {{ Form::close() }}

@endsection
