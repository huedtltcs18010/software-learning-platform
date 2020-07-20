<div class="p-3">

    <div class="form-group row">
        {{ Form::label('category_id', 'Category', ['class' => 'col-sm-2 col-form-label']) }}
        <div class="col-sm-3">
            {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row search-series-wrapper">
        {{ Form::label('series_id', 'Series', ['class' => 'col-sm-2 col-form-label']) }}
        <div class="col-sm-6">
            <div class="input-group">
                <input type="text" class="form-control txt-keyword" placeholder="Enter series name" value="{{ isset($seriesName) ? $seriesName : '' }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-search-series" type="button" data-ajax-url="{{ route('admin.series.search') }}">Search</button>
                </div>
            </div>
            <div class="result"></div>
            {{ Form::hidden('series_id', null, ['required' => 'required']) }}
        </div>
    </div>

    @if($video->id)
        <div class="form-group row">
            {{ Form::label('thumbnail', 'Thumbnail', ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-4">
                <img src="{{ getVideoThumbnail($video) }}" class="img-fluid mb-1" style="height: 50px;">
                <div class="input-group">
                    <div class="custom-file">
                        {{ Form::file('thumbnail', ['class' => 'custom-file-input', 'accept' => 'image/jpeg', 'data-text' => 'Choose new image']) }}
                        {{ Form::label('thumbnail', 'Choose new image', ['class' => 'custom-file-label']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('filename', 'Video file', ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-4">
                <a href="{{ route('streams.show', ['id' => $video->id]) }}" target="_blank" class="mb-1 d-block"><i class="fas fa-photo-video"></i></a>
                <div class="input-group">
                    <div class="custom-file">
                        {{ Form::file('filename', ['class' => 'custom-file-input', 'accept' => 'video/mp4', 'data-text' => 'Choose new video file']) }}
                        {{ Form::label('filename', 'Choose new video file', ['class' => 'custom-file-label']) }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="form-group row">
            {{ Form::label('thumbnail', 'Thumbnail', ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-4">
                <div class="input-group">
                    <div class="custom-file">
                        {{ Form::file('thumbnail', ['class' => 'custom-file-input', 'accept' => 'image/jpeg', 'required' => 'required', 'data-text' => 'Choose image']) }}
                        {{ Form::label('thumbnail', 'Choose image', ['class' => 'custom-file-label']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            {{ Form::label('filename', 'Video file', ['class' => 'col-sm-2 col-form-label']) }}
            <div class="col-sm-4">
                <div class="input-group">
                    <div class="custom-file">
                        {{ Form::file('filename', ['class' => 'custom-file-input', 'accept' => 'video/mp4', 'required' => 'required', 'data-text' => 'Choose video file']) }}
                        {{ Form::label('filename', 'Choose video file', ['class' => 'custom-file-label']) }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="form-group row">
        {{ Form::label('name', 'Name', ['class' => 'col-sm-2 col-form-label']) }}
        <div class="col-sm-4">
            {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('description', 'Description', ['class' => 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ Form::textarea('description', null, ['class' => 'form-control basic_editor']) }}
        </div>
    </div>

    <div class="form-group row">
        {{ Form::label('status', 'Status', ['class' => 'col-sm-2 col-form-label']) }}
        <div class="col-sm-3">
            {{ Form::select('status', [0 => 'Inactive', 1 => 'Active'], null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
        </div>
    </div>

    @if($video->id)
        <hr>
        <div class="form-group row">
            <div class="col-sm-2">
                Created by
            </div>
            <div class="col-sm-3">
                {{ $video->getCreatedByUsername() }}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                Created at
            </div>
            <div class="col-sm-3">
                {{ $video->created_at }}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                Updated by
            </div>
            <div class="col-sm-3">
                {{ $video->getUpdatedByUsername() }}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                Updated at
            </div>
            <div class="col-sm-3">
                {{ $video->updated_at }}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                Total views
            </div>
            <div class="col-sm-3">
                {{ number_format($video->total_views) }}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                Total comments
            </div>
            <div class="col-sm-3">
                {{ number_format($video->total_comments) }}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-2">
                Rating
            </div>
            <div class="col-sm-3">
                {{ number_format($video->rating, 1) }}
            </div>
        </div>
    @endif

</div>
