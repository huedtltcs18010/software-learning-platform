@extends('layouts.web')

@section('content')
    <div class="main-grids">
        @if($recent)
            <div class="top-grids">
                <div class="recommended-info">
                    <h3>Recent Videos</h3>
                </div>
                @foreach($recent as $obj)
                    <div class="col-md-4 resent-grid recommended-grid slider-top-grids">
                        <div class="resent-grid-img recommended-grid-img">
                            <a href="{{ $obj->url }}"><img src="{{ $obj->thumbnail }}" alt="" /></a>
                            <div class="time">
                                <p>{{ $obj->duration }}</p>
                            </div>
                            <div class="clck">
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            </div>
                        </div>
                        <div class="resent-grid-info recommended-grid-info">
                            <h3><a href="{{ $obj->url }}" class="title title-info">{{ $obj->name }}</a></h3>
                            <ul>
                                <li>
                                    <p class="author author-info"><a href="{{ $obj->created_by_url }}" class="author">{{ $obj->created_by_name }}</a></p>
                                </li>
                                <li class="right-list"><p class="views views-info">{{ number_format($obj->total_view) }} views</p></li>
                            </ul>
                        </div>
                    </div>
                @endforeach
                <div class="clearfix"></div>
            </div>
        @endif

        @foreach($series as $obj)
            <div class="recommended">
                <div class="recommended-grids">
                    <div class="recommended-info">
                        <h3>{{ $obj->name }}</h3>
                    </div>

                    <div id="top" class="callbacks_container">
                        <ul class="rslides" id="slider3">
                            @foreach($obj->videos->chunk(4) as $chunk)
                                <li>
                                    <div class="animated-grids">
                                        @foreach($chunk as $obj1)
                                            <div class="col-md-3 resent-grid recommended-grid slider-first">
                                                <div class="resent-grid-img recommended-grid-img">
                                                    <a href="{{ $obj1->url }}"><img src="{{ $obj1->thumbnail }}" /></a>
                                                    <div class="time small-time slider-time">
                                                        <p>{{ $obj1->duration }}</p>
                                                    </div>
                                                    <div class="clck small-clck">
                                                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                                    </div>
                                                </div>
                                                <div class="resent-grid-info recommended-grid-info">
                                                    <h5><a href="{{ $obj1->url }}" class="title">{{ $obj1->name }}</a></h5>
                                                    <div class="slid-bottom-grids">
                                                        <div class="slid-bottom-grid">
                                                            <p class="author author-info"><a href="{{ $obj1->created_by_url }}" class="author">{{ $obj1->created_by_name }}</a></p>
                                                        </div>
                                                        <div class="slid-bottom-grid slid-bottom-right">
                                                            <p class="views views-info">{{ number_format($obj1->total_view) }} views</p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="clearfix"></div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <script>
                        // You can also use "$(window).load(function() {"
                        $(function () {
                            // Slideshow 4
                            $("#slider3").responsiveSlides({
                                auto: true,
                                pager: false,
                                nav: true,
                                speed: 500,
                                namespace: "callbacks",
                                before: function () {
                                    $(".events").append("<li>before event fired.</li>");
                                },
                                after: function () {
                                    $(".events").append("<li>after event fired.</li>");
                                },
                            });
                        });
                    </script>

                </div>
            </div>
        @endforeach

        <div class="clearfix"></div>
    </div>

@endsection
