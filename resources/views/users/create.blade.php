@extends('layout/layout')

@section('title')
    社員登録
@stop

@section('pan')
    <li><a href="/">Home</a></li>
    <li><a href="/users/"> 社員一覧</a></li>
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
                    <form method="POST" class="form-horizontal" action="/users">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th><label class="col-sm-2 control-label">name</label></th>
                                <td>
                                    <div class="col-sm-4">
                                        <input name="name" value="{{ Input::old('name', '') }}" type="text"
                                               class="form-control" placeholder="山田 太郎">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">kana</label></th>
                                <td>
                                    <div class="col-sm-4">
                                        <input name="kana" value="{{ Input::old('kana', '') }}" type="text"
                                               class="form-control" placeholder="ヤマダ　タロウ">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">password</label></th>
                                <td>
                                    <div class="col-sm-4">
                                        <input name="password" value="{{ Input::old('password', '') }}" type="text"
                                               class="form-control" placeholder="password">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">email</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <input name="email" value="{{ Input::old('email', '')  }}" type="text"
                                               class="form-control" placeholder="example@mail.com">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">role</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="role">
                                            <option value="2"
                                                    @if (Input::old('role') != '1') selected="selected" @endif >管理者
                                            </option>
                                            <option value="1"
                                                    @if (Input::old('role') == '1') selected="selected" @endif>一般
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">group</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="group">
                                            <option value="10"
                                                    @if (Input::old('group') == '10') selected="selected" @endif >営業
                                            </option>
                                            <option value="20"
                                                    @if (Input::old('group') == '20') selected="selected" @endif >総務
                                            </option>
                                            <option value="30"
                                                    @if (Input::old('group') == '30') selected="selected" @endif >川崎
                                            </option>
                                            <option value="40"
                                                    @if (Input::old('group') == '40') selected="selected" @endif >第一開発課
                                            </option>
                                            <option value="50"
                                                    @if (Input::old('group') == '50') selected="selected" @endif >第二開発課
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="/users/" class="btn btn-lg btn-default btn-block">戻る</a></td>
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
