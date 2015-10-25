@extends('layout/layout')

@section('title')
    グループ登録
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

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>入力エラー!</strong> 入力情報に不備があります。<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" class="form-horizontal" action="/groups">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th><label class="col-sm-6 control-label">name</label></th>
                                <td>
                                    <div class="col-sm-6">
                                        <input name="name" value="{{ Input::old('name', '') }}" type="text"
                                               class="form-control" placeholder="第一開発課">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-6 control-label">管理番号</label></th>
                                <td>
                                    <div class="col-sm-6">
                                        <input name="group" value="{{ Input::old('group', '') }}" type="text"
                                               class="form-control" placeholder="10">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="/groups/" class="btn btn-lg btn-default btn-block">戻る</a></td>
                                <td>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-lg btn-success btn-block">送信</button>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
