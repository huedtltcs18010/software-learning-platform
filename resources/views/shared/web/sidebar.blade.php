<div class="top-navigation">
    <div class="t-menu">MENU</div>
    <div class="t-img">
        <img src="/images/lines.png" alt="" />
    </div>
    <div class="clearfix"></div>
</div>
<div class="drop-navigation drop-navigation">
    <ul class="nav nav-sidebar">
        <li>
            <a href="/" class="home-icon"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a>
        </li>
        <li>
            <a href="{{ route('history.index') }}" class="sub-icon"><span class="glyphicon glyphicon-home glyphicon-hourglass" aria-hidden="true"></span>History</a>
        </li>
        <li>
            <a href="#" class="menu1"><span class="glyphicon glyphicon-film" aria-hidden="true"></span>Movies<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></a>
        </li>
        <ul class="cl-effect-2">
            @foreach(getVideoCategories() as $item)
                <li><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
            @endforeach
        </ul>
        <!-- script-for-menu -->
        <script>
            $("li a.menu1").click(function () {
                $("ul.cl-effect-2").slideToggle(300, function () {
                    // Animation complete.
                });
            });
        </script>
        <li>
            <a href="" class="news-icon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>News</a>
        </li>
    </ul>
    <!-- script-for-menu -->
    <script>
        $(".top-navigation").click(function () {
            $(".drop-navigation").slideToggle(300, function () {
                // Animation complete.
            });
        });
    </script>
    <div class="side-bottom">
        <div class="side-bottom-icons">
            <ul class="nav2">
                <li><a href="https://facebook.com" class="facebook" target="_blank"> </a></li>
                <li><a href="https://twitter.com" class="facebook twitter" target="_blank"> </a></li>
                <li><a href="#" class="facebook chrome" target="_blank"> </a></li>
                <li><a href="#" class="facebook dribbble" target="_blank"> </a></li>
            </ul>
        </div>
        <div class="copyright">
            <p>Copyright © 2020 {{ config('app.name', 'Laravel') }}. All Rights Reserved | Design by <a href="http://w3layouts.com/">W3layouts</a></p>
        </div>
    </div>
</div>
