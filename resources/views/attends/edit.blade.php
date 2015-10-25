@extends('layout/layout')

@section('title')
    勤怠編集
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

                    <form method="POST" class="form-horizontal" action="/attends/store">
                        <table class="table table-striped">
                            <tbody>

                            @if ($header_role > 1)
                                <tr>
                                    <th><label class="col-sm-2 control-label">name</label></th>
                                    <td>
                                        <div class="col-sm-4">
                                            @foreach($users as $user)
                                                @if ( $attend->user_key == $user->key)
                                                    {{ $user->name }}
                                                    <input type="hidden" name="user_key" value="{{ $user->key }}">
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th><label class="col-sm-2 control-label">attend_at</label></th>
                                <td>
                                    <div class="col-sm-4">
                                        <input name="attend_at"
                                               value="{{ date('Y-m-d', strtotime(Input::old('attend_at', $attend->attend_at))) }}"
                                               type="text" class="form-control datepicker" placeholder="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">type</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="type">
                                            <option value="1"
                                                    @if (Input::old('type', $attend->type) == '1') selected="selected" @endif>
                                                有給（全休）
                                            </option>
                                            <option value="2"
                                                    @if (Input::old('type', $attend->type) == '2') selected="selected" @endif>
                                                有給（午前半休）
                                            </option>
                                            <option value="3"
                                                    @if (Input::old('type', $attend->type) == '3') selected="selected" @endif>
                                                有給（午後半休）
                                            </option>
                                            <option value="4"
                                                    @if (Input::old('type', $attend->type) == '4') selected="selected" @endif>
                                                欠勤
                                            </option>
                                            <option value="5"
                                                    @if (Input::old('type', $attend->type) == '5') selected="selected" @endif>
                                                遅刻
                                            </option>
                                            <option value="6"
                                                    @if (Input::old('type', $attend->type) == '6') selected="selected" @endif>
                                                早退
                                            </option>
                                            <option value="7"
                                                    @if (Input::old('type', $attend->type) == '7') selected="selected" @endif>
                                                代休（全休）
                                            </option>
                                            <option value="8"
                                                    @if (Input::old('type', $attend->type) == '8') selected="selected" @endif>
                                                代休（午前半休）
                                            </option>
                                            <option value="9"
                                                    @if (Input::old('type', $attend->type) == '9') selected="selected" @endif>
                                                代休（午後半休）
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th><label class="col-sm-2 control-label">biko</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <textarea name="biko" class="form-control" rows="10"
                                                  placeholder="備考">{{ Input::old('biko', $attend->biko) }}</textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="/attends/" class="btn btn-lg btn-default btn-block">戻る</a></td>
                                <td>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-lg btn-success btn-block">送信</button>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    </div>
                                </td>
                            </tr>
                            <input type="hidden" name="id" value="{{ Input::old('id', $attend->id) }}">
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
