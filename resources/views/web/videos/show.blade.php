@extends('layouts.web')

@section('content')
    <div class="show-top-grids">
        <div class="col-sm-8 single-left">
            <div class="song">
                <div class="song-info">
                    <h3>{{ $video->name }}</h3>
                </div>
                <div class="video-grid">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video class="embed-responsive-item" width="560" height="315" controls autoplay>
                            <source src="{{ route('streams.show', [$video->id]) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
            <div class="song-grid-right">
                <div class="share">
                    <h5>Share this</h5>
                    <ul>
                        <li><a href="#" class="icon fb-icon">Facebook</a></li>
                        <li><a href="#" class="icon dribbble-icon">Dribbble</a></li>
                        <li><a href="#" class="icon twitter-icon">Twitter</a></li>
                        <li><a href="#" class="icon pinterest-icon">Pinterest</a></li>
                        <li><a href="#" class="icon whatsapp-icon">Whatsapp</a></li>
                        <li><a href="#" class="icon like">Like</a></li>
                        <li><a href="#" class="icon comment-icon">Comments</a></li>
                        <li class="view">{{ number_format($video->total_view )}} Views</li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="published">
                <h4>{{ $video->publishedText }}</h4>
                {!! $video->description !!}
            </div>
            <div class="all-comments">
                <div class="all-comments-info">
                    <a href="#">All Comments ({{ number_format($video->total_comment) }})</a>
                    <div class="box">
                        <form>
                            <input type="text" placeholder="Name" required>
                            <input type="text" placeholder="Email" required>
                            <input type="text" placeholder="Phone" required>
                            <textarea placeholder="Message" required></textarea>
                            <input type="submit" value="SEND">
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="all-comments-buttons">
                        <ul>
                            <li><a href="#" class="top newest">Newest First</a></li>
                            <li><a href="#" class="top my-comment">My Comments</a></li>
                        </ul>
                    </div>
                </div>
                <div class="media-grids">

                    {{-- <div class="media">
                        <h5>Tom Brown</h5>
                        <div class="media-left">
                            <a href="#"> </a>
                        </div>
                        <div class="media-body">
                            <p>Maecenas ultricies rhoncus tincidunt maecenas imperdiet ipsum id ex pretium hendrerit maecenas imperdiet ipsum id ex pretium hendrerit</p>
                            <span>View all posts by :<a href="#"> Admin </a></span>
                        </div>
                    </div> --}}

                </div>
            </div>
        </div>
        <div class="col-md-4 single-right">
            <h3>Up Next</h3>
            <div class="single-grid-right">

                {{-- <div class="single-right-grids">
                    <div class="col-md-4 single-right-grid-left">
                        <a href="single.html"><img src="https://picsum.photos/seed/picsum/720/480" alt="" /></a>
                    </div>
                    <div class="col-md-8 single-right-grid-right">
                        <a href="single.html" class="title"> Nullam interdum metus</a>
                        <p class="author"><a href="#" class="author">John Maniya</a></p>
                        <p class="views">2,114,200 views</p>
                    </div>
                    <div class="clearfix"></div>
                </div> --}}


            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
