<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Theme Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="/bower_components/bootstrap/dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/bower_components/bootstrap/dist/css/theme.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><!--<script src="/bower_components/bootstrap/dist/js/ie8-responsive-file-warning.js"></script>-->
    <![endif]-->
    {{--<script src="/bower_components/bootstrap/dist/js/ie-emulation-modes-warning.js"></script>--}}

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body role="document">

<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">--}}
            {{--<span class="sr-only">Toggle navigation</span>--}}
            {{--<span class="icon-bar"></span>--}}
            {{--<span class="icon-bar"></span>--}}
            {{--<span class="icon-bar"></span>--}}
            {{--</button>--}}
            <a class="navbar-brand" href="#">イベント情報ポータル</a>
        </div>
        {{--<div id="navbar" class="navbar-collapse collapse">--}}
        {{--<ul class="nav navbar-nav">--}}
        {{--<li class="active"><a href="#">Home</a></li>--}}
        {{--<li><a href="#about">About</a></li>--}}
        {{--<li><a href="#contact">Contact</a></li>--}}
        {{--<li class="dropdown">--}}
        {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>--}}
        {{--<ul class="dropdown-menu">--}}
        {{--<li><a href="#">Action</a></li>--}}
        {{--<li><a href="#">Another action</a></li>--}}
        {{--<li><a href="#">Something else here</a></li>--}}
        {{--<li role="separator" class="divider"></li>--}}
        {{--<li class="dropdown-header">Nav header</li>--}}
        {{--<li><a href="#">Separated link</a></li>--}}
        {{--<li><a href="#">One more separated link</a></li>--}}
        {{--</ul>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</div><!--/.nav-collapse -->--}}
    </div>
</nav>

<div class="container theme-showcase" role="main">

    <div class="col-md-9">
        @foreach($events as $key => $event)
            @if($key == 0)
                <div class="col-md-12">
                    @else
                        <div class="col-md-6">
                            @endif
                            <div class="thumbnail">
                                @if ($event->article_url) <a href="{{ $event->article_url }}"> @endif

                                    {!! date('Y年m月d日', strtotime($event->start_date)) !!}
                                    @if($event->end_date != $event->start_date)
                                        - {!! date('Y年m月d日', strtotime($event->end_date)) !!} @endif
                                    <br/>
                                    {{ $event->title }}<br/>
                                    <img src="{{ $event->image_path }}" class="img-responsive"
                                         alt="{{ $event->title }}"/>

                                    {{ $event->place }}

                                    @if ($event->article_url) </a> @endif
                            </div>
                        </div>

                        @endforeach

                </div>

                <div class="col-md-3">
                    <div class="hidden-xs">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">広告枠</h3>
                            </div>
                            <div class="panel-body">
                                <img src="http://placehold.jp/250x500.png" class="img-responsive"
                                     alt="タブレット以上の固定長フォーマットのAdsenseコードを埋め込む">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="hidden-xs">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">広告枠</h3>
                            </div>
                            <div class="panel-body">
                                <img src="http://placehold.jp/250x500.png" class="img-responsive"
                                     alt="タブレット以上の固定長フォーマットのAdsenseコードを埋め込む">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="visible-xs">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">広告枠</h3>
                            </div>
                            <div class="panel-body">
                                <img src="http://placehold.jp/500x200.png" class="img-responsive"
                                     alt="スマホ用の固定長フォーマットのAdsenseコードを埋め込む">

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="visible-xs">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">広告枠</h3>
                            </div>
                            <div class="panel-body">
                                <img src="http://placehold.jp/500x200.png" class="img-responsive"
                                     alt="スマホ用の固定長フォーマットのAdsenseコードを埋め込む">

                            </div>
                        </div>

                    </div>
                </div>


    </div>
    <!-- /container -->

    <hr>
    <footer class="row">
        <div class="container">

            <p class="col-md-9 col-sm-9 col-xs-12 copyright">&copy;
                <a href="http://se-project.co.jp" target="_blank">se-project.co.jp</a> 1985 - 2015</p>

            <p class="col-md-3 col-sm-3 col-xs-12 powered-by">Powered by: <a href="/">fieldhawker</a></p>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    {{--<script src="/bower_components/bootstrap/dist/js/docs.min.js"></script>--}}
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    {{--<script src="/bower_components/bootstrap/dist/js/ie10-viewport-bug-workaround.js"></script>--}}
</body>
</html>
