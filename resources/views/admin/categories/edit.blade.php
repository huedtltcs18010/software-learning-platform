@extends('layouts.backend')

@section('content')
    @include('shared.breadcrumb')

    <h1>Edit a category</h1>

    {{ Form::model($category, ['route' => ['admin.categories.update', $category->id], 'method' => 'put']) }}
        @include('admin.categories.form')
    {{ Form::close() }}

@endsection
