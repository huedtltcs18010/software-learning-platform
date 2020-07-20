<div class="col-md-3 resent-grid recommended-grid movie-video-grid">
    <div class="resent-grid-img recommended-grid-img">
        <a href="{{ $obj->url }}"><img src="{{ $obj->thumbnail }}" alt="" /></a>
        <div class="time small-time show-time movie-time">
            <p>{{ $obj->duration }}</p>
        </div>
        <div class="clck movie-clock">
            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
        </div>
    </div>
    <div class="resent-grid-info recommended-grid-info recommended-grid-movie-info">
        <h5><a href="{{ $obj->url }}" class="title">{{ $obj->name }}</a></h5>
        <ul>
            <li>
                <p class="author author-info"><a href="{{ $obj->created_by_url }}" class="author">{{ $obj->created_by_name }}</a></p>
            </li>
            <li class="right-list"><p class="views views-info">{{ number_format($obj->total_view) }} views</p></li>
        </ul>
    </div>
</div>
