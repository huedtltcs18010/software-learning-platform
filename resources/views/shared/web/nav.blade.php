<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><h1></h1></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="top-search">
                <form class="navbar-form navbar-right">
                    <input type="text" class="form-control" placeholder="Search..." />
                    <input type="submit" value=" " />
                </form>
            </div>
            <div class="header-top-right">
                <div class="file">
                    <a href="{{ route('user.mentor.createVideo') }}">Upload</a>
                </div>

                @if(!Auth::check())
                    <div class="signin">
                        <a href="#small-dialog2" class="play-icon popup-with-zoom-anim">Sign Up</a>

                        <div id="small-dialog2" class="mfp-hide">
                            <h3>Create Account</h3>
                            <p>
                                <a href="{{ route('user.register.mentor') }}">CLICK HERE</a> to register an account with mentor role, you can upload and share your videos.
                            </p>
                            <p>
                                <a href="{{ route('user.register.learner') }}">CLICK HERE</a> to register an account with learner role, you can learn everything with our mentors.
                            </p>
                            <div class="clearfix"></div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $(".popup-with-zoom-anim").magnificPopup({
                                    type: "inline",
                                    fixedContentPos: false,
                                    fixedBgPos: true,
                                    overflowY: "auto",
                                    closeBtnInside: true,
                                    preloader: false,
                                    midClick: true,
                                    removalDelay: 300,
                                    mainClass: "my-mfp-zoom-in",
                                });
                            });
                        </script>
                    </div>
                    <div class="signin">
                        <a href="{{ route('login') }}" class="play-icon">Sign In</a>
                    </div>
                @else
                    <div class="signin">
                        <form method="POST" action="{{ route('logout') }}" id="frmLogout">
                            @csrf
                            <a href="javascript:voi(0);" onclick="document.getElementById('frmLogout').submit();" class="play-icon">Sign out</a>
                        </form>
                    </div>
                @endif

                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</nav>
