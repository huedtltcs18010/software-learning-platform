@extends('layouts.backend')

@section('content')
    @include('shared.breadcrumb')

    <h1>Videos</h1>
    <a href="{{ route('admin.videos.create') }}"><i class="far fa-plus-square"></i> Add new</a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Thumbnail</th>
                <th>Name</th>
                <th>Total comment / view</th>
                <th>Rating</th>
                <th>Created by</th>
                <th>Updated by</th>
                <th>Status</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody>
            @if($videos->count() == 0)
                <tr>
                    <td colspan="9">No data.</td>
                </tr>
            @else
                @foreach($videos as $obj)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <img src="{{ getVideoThumbnail($obj) }}" class="img-fluid" style="height: 50px;">
                        </td>
                        <td>
                            <a href="{{ route('videos.show', $obj->slug . '-' . $obj->id) }}" target="_blank">{{ $obj->name }}</a>
                        </td>
                        <td>{{ number_format($obj->total_comment) }} / {{ number_format($obj->total_view) }}</td>
                        <td>{{ number_format($obj->rating_star, 1) }}</td>
                        <td>
                            {{ $obj->created_by }}
                        </td>
                        <td>
                            {{ $obj->updated_by }}
                        </td>
                        <td>{{ $obj->status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.videos.edit', [$obj->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>

                            {{ Form::open(['route' => ['admin.videos.destroy', $obj->id], 'method' => 'delete', 'class' => 'd-inline-block']) }}
                                <button type="button" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i> Delete</button>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    {{ $videos->links() }}
@endsection
