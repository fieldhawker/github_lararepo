<!DOCTYPE html>
<html lang="jp">
<head>

    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">

    <!-- COMMON -->
    <link href="{{url('/css/app.css')}}" rel="stylesheet">

    <link id="bs-css" href="/css/bootstrap-united.min.css" rel="stylesheet">
    <link href="{{url('css/charisma-app.css')}}" rel="stylesheet">
    <link href="{{url('bower_components/fullcalendar/dist/fullcalendar.css')}}" rel='stylesheet'>
    <link href="{{url('bower_components/fullcalendar/dist/fullcalendar.print.css')}}" rel='stylesheet' media='print'>
    <link href="{{url('bower_components/chosen/chosen.min.css')}}" rel='stylesheet'>
    <link href="{{url('bower_components/colorbox/example3/colorbox.css')}}" rel='stylesheet'>
    <link href="{{url('bower_components/responsive-tables/responsive-tables.css')}}" rel='stylesheet'>
    <link href="{{url('bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css')}}" rel='stylesheet'>
    <link href="{{url('css/jquery.noty.css')}}" rel='stylesheet'>
    <link href="{{url('css/noty_theme_default.css')}}" rel='stylesheet'>
    <link href="{{url('css/elfinder.min.css')}}" rel='stylesheet'>
    <link href="{{url('css/elfinder.theme.css')}}" rel='stylesheet'>
    <link href="{{url('css/jquery.iphone.toggle.css')}}" rel='stylesheet'>
    <link href="{{url('css/uploadify.css')}}" rel='stylesheet'>
    <link href="{{url('css/animate.min.css')}}" rel='stylesheet'>

    <script src="{{url('bower_components/jquery/jquery.min.js')}}"></script>

    <link href="/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
    <script src="/js/bootstrap-datepicker.js"></script>
    <script src="/js/locales/bootstrap-datepicker.ja.js"></script>

    <script type="text/javascript">
        $(function () {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                language: 'ja',
            });
        });
    </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="/img/favicon.ico">
</head>
<body>

<div class="navbar navbar-default" role="navigation">
    <div class="navbar-inner">
        <button type="button" class="navbar-toggle pull-left animated flip">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/home"> <img alt="Charisma Logo" src="/img/logo20.png" class="hidden-xs"/>
            <span>SEP</span></a>

        <div class="btn-group pull-right">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i><span
                        class="hidden-sm hidden-xs"> {{ $header_name or ''}}</span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li>
                    @if ($header_role > 1)
                        <a>管理者</a>
                    @else
                        <a>一般</a>
                    @endif
                </li>
                <li class="divider"></li>
                @if (\Auth::check())
                    <li><a href="/users/{{ $header_id or ''}}">Profile</a></li>
                @endif

                <li class="divider"></li>
                <li><a href="/auth/logout">Logout</a></li>
            </ul>
        </div>

        {{--
                <div class="btn-group pull-right theme-container  tada"><!-- animated -->
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-tint"></i><span class="hidden-sm hidden-xs"> Change Theme / Skin</span>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" id="themes">
                        <li><a data-value="classic" href="#"><i class="whitespace"></i> Classic</a></li>
                        <li><a data-value="cerulean" href="#"><i class="whitespace"></i> Cerulean</a></li>
                        <li><a data-value="cyborg" href="#"><i class="whitespace"></i> Cyborg</a></li>
                        <li><a data-value="simplex" href="#"><i class="whitespace"></i> Simplex</a></li>
                        <li><a data-value="darkly" href="#"><i class="whitespace"></i> Darkly</a></li>
                        <li><a data-value="lumen" href="#"><i class="whitespace"></i> Lumen</a></li>
                        <li><a data-value="slate" href="#"><i class="whitespace"></i> Slate</a></li>
                        <li><a data-value="spacelab" href="#"><i class="whitespace"></i> Spacelab</a></li>
                        <li><a data-value="united" href="#"><i class="whitespace"></i> United</a></li>
                    </ul>
                </div>

                <ul class="collapse navbar-collapse nav navbar-nav top-menu">
                    <li><a href="#"><i class="glyphicon glyphicon-globe"></i> Visit Site</a></li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown"><i class="glyphicon glyphicon-star"></i> Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                    <li>
                        <form class="navbar-search pull-left">
                            <input placeholder="Search" class="search-query form-control col-md-10" name="query" type="text">
                        </form>
                    </li>
                </ul>
                --}}
    </div>
</div>

<div class="ch-container">
    <div class="row">

        @if ($header_role > 1)
            @include('layout.admin_menu')
        @else
            @include('layout.user_menu')
        @endif


        <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>
        <div id="content" class="col-lg-10 col-sm-10">
            <div>
                <ul class="breadcrumb">
                    @yield('pan')
                </ul>
            </div>
            @yield('contents')


        </div>
    </div>

    {{--

    <div class="row">
        <div class="col-md-9 col-lg-9 col-xs-9 hidden-xs">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

            <ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-5108790028230107" data-ad-slot="3193373905"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div class="col-md-2 col-lg-3 col-sm-12 col-xs-12 email-subscription-footer">aaaaaaaaaaaa
            <div class="mc_embed_signup">
                <form action="//halalit.us3.list-manage.com/subscribe/post?u=444b176aa3c39f656c66381f6&amp;id=eeb0c04e84" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <div>
                        <label>Keep up with my work</label>
                        <input type="email" value="" name="EMAIL" class="email" placeholder="Email address" required>
                        <div class="power_field"><input type="text" name="b_444b176aa3c39f656c66381f6_eeb0c04e84" tabindex="-1" value=""></div>
                        <div class="clear"><input type="submit" value="Subscribe" name="subscribe" class="button"></div>
                    </div>
                </form>
            </div>

        </div>
    </div>
--}}

    <hr>
    {{--
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Settings</h3>
                </div>
                <div class="modal-body">
                    <p>Here settings can be configured...</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Save changes</a>
                </div>
            </div>
        </div>
    </div>

    --}}
    <footer class="row">

        <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy;
            <a href="http://se-project.co.jp" target="_blank">se-project.co.jp</a> 1985 - 2015</p>

        <p class="col-md-3 col-sm-3 col-xs-12 powered-by">Powered by: <a href="/">fieldhawker</a></p>
    </footer>
</div>

<script src="{{url('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<script src="{{url('js/jquery.cookie.js')}}"></script>

<script src="{{url('bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{url('bower_components/fullcalendar/dist/fullcalendar.min.js')}}"></script>

<script src="{{url('js/jquery.dataTables.min.js')}}"></script>

<script src="{{url('bower_components/chosen/chosen.jquery.min.js')}}"></script>

<script src="{{url('bower_components/colorbox/jquery.colorbox-min.js')}}"></script>

<script src="{{url('js/jquery.noty.js')}}"></script>

<script src="{{url('bower_components/responsive-tables/responsive-tables.js')}}"></script>

<script src="{{url('bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js')}}"></script>

<script src="{{url('js/jquery.raty.min.js')}}"></script>

<script src="{{url('js/jquery.iphone.toggle.js')}}"></script>

<script src="{{url('js/jquery.autogrow-textarea.js')}}"></script>

<script src="{{url('js/jquery.uploadify-3.1.min.js')}}"></script>

<script src="{{url('js/jquery.history.js')}}"></script>

<script src="{{url('js/charisma.js')}}"></script>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!--<script src="{{url('js/app.js')}}"></script>-->
</body>
</html>


























