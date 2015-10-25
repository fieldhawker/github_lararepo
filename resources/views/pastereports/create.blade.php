@extends('layout/layout')

@section('title')
    週報コピペ登録
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

                    @if (Session::has('message'))
                        <div class="alert alert-success">{{ Session::get('message') }}</div>
                    @endif

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

                    <p>※週報は月曜から日曜を一週間として扱います。同一週の週報は複数登録できません。</p>

                    <form method="POST" class="form-horizontal" action="/pastereports">
                        <table class="table table-striped">
                            <tbody>
                            @if ($header_role > 1)
                                <tr>
                                    <th><label class="col-sm-2 control-label">name</label></th>
                                    <td>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="user_key">
                                                @foreach($users as $user)
                                                    <option value="{{ $user->key }}"
                                                            @if (Input::old('user_key', '') == $user->key) selected="selected" @endif>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th><label class="col-sm-2 control-label">week</label></th>
                                <td>
                                    <div class="col-sm-4">
                                        <input name="week" value="{{ Input::old('week', date("Y-m-d")) }}" type="text"
                                               class="form-control datepicker" placeholder="">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th><label class="col-sm-2 control-label">work</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <textarea name="work" class="form-control" rows="20"
                                                  placeholder="{{ $message }}">{{ Input::old('work', '') }}</textarea>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><a href="/reports/" class="btn btn-lg btn-default btn-block">戻る</a></td>
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
