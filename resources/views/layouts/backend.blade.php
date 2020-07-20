
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex, nofollow">

        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/fontawesome/css/all.css">
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Bai+Jamjuree:wght@700&family=Roboto+Condensed:wght@400;700&family=Mali:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/backend/css/style.css">

        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body>
        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
            <a href="/" class="navbar-brand col-sm-3 col-md-2 mr-0" target="_blank">{{ config('app.name', 'Laravel') }}</a>
            <div class="w-100 text-right">
                <div class="pr-2">
                    <a href="" class="d-inline-block pr-2 btn btn-danger" href="javascript:void(0);" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.categories.index') }}"><i class="far fa-folder-open"></i> Categories</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.series.index') }}"><i class="far fa-folder-open"></i> Series</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.videos.index') }}"><i class="fas fa-photo-video"></i> Videos</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <main class="col-md-9 ml-sm-auto col-lg-10 px-4">

                    @if (session('success_message'))
                        <div class="alert alert-success">
                            {{ session('success_message') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>

        <script src="/js/jquery.min.js"></script>
        <script src="/js/popper.min.js"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        <script src="/tinymce/tinymce.min.js"></script>
        <script src="/backend/js/start.js"></script>

    </body>
</html>
