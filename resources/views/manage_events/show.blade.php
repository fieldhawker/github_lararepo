@extends('layout/layout')

@section('title')
    イベント詳細
@stop

@section('pan')
    <li><a href="/">Home</a></li>
    <li><a href="/mevents/"> イベント一覧</a></li>
    <li>@yield('title')</li>
@stop

@section('contents')
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                @include('layout.contents_head')
                <div class="box-content">

                    @foreach($events as $event)
                        <table class="table table-striped">
                            <tbody>

                            <tr>
                                <th>タイトル</th>
                                <td>{{ $event->title }}</td>
                            </tr>
                            <tr>
                                <th>画像URL</th>
                                <td><img src='{{ $event->image_path }}' class='img-responsive'/></td>
                            </tr>
                            <tr>
                                <th>記事URL</th>
                                <td><a href='{{ $event->article_url }}'>{{ $event->article_url }}</a></td>
                            </tr>
                            <tr>
                                <th>状態</th>
                                <td>@if ($event->status === '1')
                                        <i class="glyphicon glyphicon-ok-sign"></i> 本登録
                                    @else
                                        <i class="glyphicon glyphicon-remove-sign"></i> 仮登録
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>開始日</th>
                                <td>{{ $event->start_date }}</td>
                            </tr>
                            <tr>
                                <th>終了日</th>
                                <td>{{ $event->end_date }}</td>
                            </tr>
                            <tr>
                                <th><a href="/mevents/" class="btn btn-lg btn-default btn-block">戻る</a></th>
                                <td>
                                    <a href="/mevents/{{ $event->id }}/edit"
                                       class="btn btn-lg btn-success btn-block">編集</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
@stop
