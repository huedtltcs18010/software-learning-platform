@extends('layouts.web')

@section('content')
    <div class="show-top-grids">
        <div class="main-grids news-main-grids">
            <div class="recommended-info">
                <h3>History Of My Play</h3>
                <p class="history-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus efficitur, eros sed suscipit porttitor, diam felis tempus odio, eget sollicitudin purus sem sit amet dolor. Integer euismod non mauris commodo rutrum. Nulla
                    risus felis, rhoncus vel est sed, consequat efficitur ante. Phasellus mi sapien, accumsan vitae lobortis vitae, laoreet dapibus metus. Pellentesque id ipsum vel nibh imperdiet imperdiet ac ac mauris. Suspendisse ac leo
                    augue. Nullam venenatis massa ut pulvinar scelerisque. Duis vel vehicula urna. Quisque semper vitae lectus a feugiat. Sed dignissim egestas nunc, nec suscipit mauris interdum lobortis.
                    <span>
                        Duis iaculis justo nec tellus bibendum rhoncus. Phasellus quis pretium leo, sed porta ligula. Mauris vitae ornare nisi, et dapibus elit. Vestibulum vel urna malesuada, bibendum orci sed, venenatis nunc. Morbi dignissim
                        est tortor, ac aliquam augue blandit at. Pellentesque pulvinar convallis augue, in sodales risus feugiat et. Ut viverra pellentesque tellus eu consectetur. Maecenas eget massa nulla. Fusce convallis et sapien a
                        hendrerit. Etiam viverra maximus dolor, ac tempor sapien.
                    </span>
                </p>

                @foreach($videos as $date => $objs)

                    <h4><time class="timeago" datetime="{{ $date }}">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</time></h4>
                    @foreach($objs as $obj)
                        @include('shared.web.grid_video_item')
                    @endforeach
                    <div class="clearfix"></div>

                    <hr>
                @endforeach

            </div>
        </div>
    </div>

@endsection
