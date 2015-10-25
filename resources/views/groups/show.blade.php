@extends('layout/layout')

@section('title')
    グループ詳細
@stop

@section('pan')
    <li><a href="/">Home</a></li>
    <li><a href="/groups/"> グループ一覧</a></li>
    <li>@yield('title')</li>
@stop

@section('contents')
    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                @include('layout.contents_head')
                <div class="box-content">

                    @foreach($groups as $group)
                        <table class="table table-striped">
                            <tbody>

                            <tr>
                                <th>name</th>
                                <td>{{ $group->name }}</td>
                            </tr>
                            <tr>
                                <th>管理番号</th>
                                <td>{{ $group->group }}</td>
                            </tr>
                            <tr>
                                <th><a href="/groups/" class="btn btn-lg btn-default btn-block">戻る</a></th>
                                <td>
                                    <a href="/groups/{{ $group->id }}/edit"
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
