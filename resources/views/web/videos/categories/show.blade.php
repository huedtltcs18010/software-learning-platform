@extends('layouts.web')

@section('content')
    <div class="show-top-grids">
        <div class="col-sm-10 show-grid-left main-grids">

            <div class="recommended">
                <div class="recommended-grids english-grid">
                    <div class="recommended-info">
                        <div class="heading">
                            <h3>{{ $category->name }}</h3>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    @if($videos->count() == 0)
                        <p>Content is coming soon.</p>
                    @else
                        @foreach($videos as $obj)
                            @include('shared.web.grid_video_item')
                        @endforeach
                    @endif

                    <div class="clearfix"></div>
                    {{ $videos->links() }}
                </div>
            </div>

        </div>
        <div class="col-md-2 show-grid-right">
            <h3>Upcoming Channels</h3>

            <div class="show-right-grids">
                <ul>
                    <li class="tv-img">
                        <a href=""><img src="/images/mv.png" alt=""></a>
                    </li>
                    <li><a href="">English Movies</a></li>
                </ul>
            </div>

        </div>
        <div class="clearfix"></div>
    </div>

@endsection
