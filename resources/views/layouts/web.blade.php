
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- prevent Google index -->
        <meta name="robots" content="noindex, nofollow">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!-- bootstrap -->
        <link href="/css/bootstrap.min.css" rel='stylesheet' type='text/css' media="all" />
        <!-- //bootstrap -->
        <link href="/css/dashboard.css" rel="stylesheet">
        <!-- Custom Theme files -->
        <link href="/css/style.css" rel='stylesheet' type='text/css' media="all" />
        <script src="/js/jquery-1.11.1.min.js"></script>
        <!--start-smoth-scrolling-->
        <!-- fonts -->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
        <!-- //fonts -->

        <!-- pop-up-box -->
        <script type="text/javascript" src="/js/modernizr.custom.min.js"></script>
        <link href="/css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
        <script src="/js/jquery.magnific-popup.js" type="text/javascript"></script>
        <!--//pop-up-box -->
        <script src="/js/responsiveslides.min.js"></script>

        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body>
        @include('shared.web.nav')

        <div class="col-sm-3 col-md-2 sidebar">
            @include('shared.web.sidebar')
        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            @yield('content')
            @include('shared.web.footer')
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/js/bootstrap.min.js"></script>
        <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
        <script type="text/javascript" src="/js/jquery.timeago.js"></script>
        <script type="text/javascript">
            $(function() {
                $("time.timeago").timeago();
            });
        </script>
        @stack('custom-scripts')
    </body>
</html>
