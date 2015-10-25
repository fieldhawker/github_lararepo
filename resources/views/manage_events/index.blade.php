@extends('layout/layout')

@section('title')
    イベント一覧
@stop

@section('pan')
    <li><a href="/">Home</a></li>
    <li>@yield('title')</li>
@stop

@section('contents')
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                @include('layout.contents_head')
                <div class="box-content">

                    @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif

                    <table class="table table-striped table-bordered responsive ">
                        <thead>
                        <tr>
                            <th>状態</th>
                            <th>start_date</th>
                            <th>end_date</th>
                            <th>title</th>
                            <th></th>
                            <th></th>
                            {{--<th></th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>@if ($event->status == '1')
                                        <i class="glyphicon glyphicon-ok-sign"></i> 本登録
                                    @else
                                        <i class="glyphicon glyphicon-remove-sign"></i> 仮登録
                                    @endif
                                </td>
                                <td>{!! date('Y年m月d日', strtotime($event->start_date)) !!}</td>
                                <td>{!! date('Y年m月d日', strtotime($event->end_date)) !!}</td>
                                <td>@if ($event->article_url)
                                        <a href="{{ $event->article_url }}" target="_blank">{{ $event->title }}</a>
                                    @else
                                        {{ $event->title }}
                                    @endif
                                </td>

                                <td><a href="/mevents/{{ $event->id }}" class="btn btn-default btn-xs">詳細</a></td>
                                <td><a href="/mevents/{{ $event->id }}/edit" class="btn btn-success btn-xs">編集</a></td>
                                {{--<td>--}}
                                {{--<form method="POST" action="/mevents/{{ $event->id }}">--}}
                                {{--<input name="_method" type="hidden" value="DELETE">--}}
                                {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
                                {{--<button type="submit" class="btn btn-danger btn-xs"--}}
                                {{--onclick='return confirm("削除してよろしいですか？");'>削除--}}
                                {{--</button>--}}
                                {{--</form>--}}
                                {{--</td>--}}
                            </tr>
                        @endforeach

                        <?php echo $events->render(); ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop
