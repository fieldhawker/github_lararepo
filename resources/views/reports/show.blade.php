@extends('layout/layout')

@section('title')
    週報詳細
@stop

@section('pan')
    <li><a href="/">Home</a></li>
    <li><a href="/reports/"> 週報一覧</a></li>
    <li>@yield('title')</li>
@stop

@section('contents')
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                @include('layout.contents_head')
                <div class="box-content">
                    <table class="table table-striped">
                        <tbody>

                        <tr>
                            <th>id</th>
                            <td>{{ $report->id }}</td>
                        </tr>
                        <tr>
                            <th>name</th>
                            <td>
                                {{ $report->uname or ''}}
                            </td>
                        </tr>
                        <tr>
                            <th>week</th>
                            <td>{{ $report->week }}</td>
                        </tr>
                        <tr>
                            <th>station</th>
                            <td>{{ $report->station }}</td>
                        </tr>
                        <tr>
                            <th>place</th>
                            <td>{{ $report->place }}</td>
                        </tr>
                        <tr>
                            <th>work</th>
                            <td>{!! nl2br( $report->work) !!}</td>
                        </tr>
                        <tr>
                            <th>language</th>
                            <td>{!! nl2br( $report->language) !!}</td>
                        </tr>
                        <tr>
                            <th>report</th>
                            <td>{!! nl2br($report->report) !!}</td>
                        </tr>
                        <tr>
                            <th>sales</th>
                            <td>{!! nl2br( $report->sales) !!}</td>
                        </tr>
                        <tr>
                            <th>status</th>
                            <td>{{ $report->status }}</td>
                        </tr>
                        <tr>
                            <th>作成日時</th>
                            <td>{{ $report->created_at }}</td>
                        </tr>
                        <tr>
                            <th>更新日時</th>
                            <td>{{ $report->updated_at }}</td>
                        </tr>
                        <tr>
                            <th>更新者</th>
                            <td>{{ $report->updated_by }}</td>
                        </tr>
                        <tr>
                            <th><a href="/reports/" class="btn btn-default btn-block">戻る</a></th>
                            <td>
                                {{--                <form method="POST" action="/reports/delete/{{ $report->id }}">
                                                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                                --}} <a href="/reports/{{ $report->id }}/edit" class="btn btn-success btn-block">編集</a>
                                {{--                  <button type="submit" class="btn btn-danger btn-xs">削除</button>
                                                </form>
                                --}}              </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


@stop
