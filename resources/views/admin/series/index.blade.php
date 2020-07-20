@extends('layouts.backend')

@section('content')
    @include('shared.breadcrumb')

    <h1>Series</h1>
    <a href="{{ route('admin.series.create') }}"><i class="far fa-plus-square"></i> Add new</a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            @if($series->count() == 0)
                <tr>
                    <td colspan="4">No data.</td>
                </tr>
            @else
                @foreach($series as $obj)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $obj->name }}</td>
                        <td>{{ $obj->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.series.edit', [$obj->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>

                            {{ Form::open(['route' => ['admin.series.destroy', $obj->id], 'method' => 'delete', 'class' => 'd-inline-block']) }}
                                <button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i> Delete</button>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    {{ $series->links() }}
@endsection
