@extends('layout/layout')

@section('title')
    勤怠詳細
@stop

@section('pan')
    <li><a href="/">Home</a></li>
    <li><a href="/attends/"> 勤怠一覧</a></li>
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
                            <td>{{ $attend->id }}</td>
                        </tr>
                        <tr>
                            <th>name</th>
                            <td>
                                {{ $attend->uname or ''}}
                            </td>
                        </tr>
                        <tr>
                            <th>type</th>
                            <td>
                                @if ($attend->type == '1') 有給（全休） @endif
                                @if ($attend->type == '2') 有給（午前半休） @endif
                                @if ($attend->type == '3') 有給（午後半休） @endif
                                @if ($attend->type == '4') 欠勤 @endif
                                @if ($attend->type == '5') 遅刻 @endif
                                @if ($attend->type == '6') 早退 @endif
                                @if ($attend->type == '7') 代休（全休） @endif
                                @if ($attend->type == '8') 代休（午前半休） @endif
                                @if ($attend->type == '9') 代休（午後半休） @endif
                            </td>
                        </tr>
                        <tr>
                            <th>attend_at</th>
                            <td>{{ $attend->attend_at }}</td>
                        </tr>
                        <tr>
                            <th>biko</th>
                            <td>{!! nl2br( $attend->biko) !!}</td>
                        </tr>
                        <tr>
                            <th>作成日時</th>
                            <td>{{ $attend->created_at }}</td>
                        </tr>
                        <tr>
                            <th>更新日時</th>
                            <td>{{ $attend->updated_at }}</td>
                        </tr>
                        <tr>
                            <th>更新者</th>
                            <td>{{ $attend->updated_by }}</td>
                        </tr>
                        <tr>
                            <th><a href="/attends/" class="btn btn-default btn-block">戻る</a></th>
                            <td><a href="/attends/edit/{{ $attend->id }}" class="btn btn-success btn-block">編集</a></td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


@stop
