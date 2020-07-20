@extends('layouts.backend')

@section('content')
    @include('shared.breadcrumb')

    <h1>Add new category</h1>

    {{ Form::model($category, ['route' => 'admin.categories.store', 'method' => 'post']) }}
        @include('admin.categories.form')
    {{ Form::close() }}

@endsection
