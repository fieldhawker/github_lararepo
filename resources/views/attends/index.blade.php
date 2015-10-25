@extends('layout/layout')

@section('title')
    勤怠連絡一覧
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

                    <form method="GET" action="/attends" class="form-search">
                        @if ($header_role > 1)
                            <div class="form-group">
                                <label for="exampleInputEmail1">name</label>
                                <select class="form-control  input-sm" name="user_key">
                                    <option value=''>未指定</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->key }}"
                                                @if (Input::old('user_key', $data['user_key']) == $user->key) selected="selected" @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        {{--<div class="form-group">--}}
                        {{--<label for="exampleInputEmail1">week</label>--}}
                        {{--<select class="form-control  input-sm" name="week">--}}
                        {{--<option value=''>未指定</option>--}}
                        {{--@foreach($weeks as $week)--}}
                        {{--<option value="{{ $week->week }}" @if (Input::old('week', $data['week']) == $week->week) selected="selected" @endif>{{ $week->week }}</option>--}}
                        {{--@endforeach--}}
                        {{--</select>--}}
                        {{--</div>--}}
                        <button type="submit" class="btn btn-default btn-block">検索</button>
                        <a href="/attends/create" class="btn btn-warning btn-block">新規登録</a>
                        {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
                    </form>
                    <br/>

                    <table class="table table-striped table-bordered  responsive ">
                        <thead>
                        <tr>

                            <th>name</th>
                            <th>attend_at</th>
                            <th>type</th>
                            {{--<th>salaried</th>--}}
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($attends as $attend)
                            <tr>

                                <td>{{ $attend->uname }}</td>
                                <td><span> {{ date('Y-m-d', strtotime($attend->attend_at)) }}</span></td>

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
                                {{--                <td>{{ $attend->salaried }}</td>--}}

                                <td><a href="/attends/show/{{ $attend->id }}" class="btn btn-default btn-xs">詳細</a></td>
                                <td><a href="/attends/edit/{{ $attend->id }}" class="btn btn-success btn-xs">編集</a></td>

                                <td>
                                    <form method="POST" action="/attends/destroy/{{ $attend->id }}/">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <button type="submit" class="btn btn-danger btn-xs"
                                                onclick='return confirm("削除してよろしいですか？");'>削除
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach

                        {!!$attends->appends(['user_key'=>$data['user_key']])->render()!!}

                        </tbody>
                    </table>
                        <div class="box-content text-center">
                            JSON出力：
                            <a href="/attends/json/{{date('Y-m', strtotime('-2 month'))}}" class="btn btn-link">{{date('m', strtotime('-2 month')).'月分'}}</a>
                            <a href="/attends/json/{{date('Y-m', strtotime('-1 month'))}}" class="btn btn-link">{{date('m', strtotime('-1 month')).'月分'}}</a>
                            <a href="/attends/json/{{date('Y-m')}}" class="btn btn-link">{{date('m').'月分'}}</a>
                        </div>
                        <div class="box-content text-center">
                            _CSV出力：
                            <a href="/attends/csv/{{date('Y-m', strtotime('-2 month'))}}" class="btn btn-link">{{date('m', strtotime('-2 month')).'月分'}}</a>
                            <a href="/attends/csv/{{date('Y-m', strtotime('-1 month'))}}" class="btn btn-link">{{date('m', strtotime('-1 month')).'月分'}}</a>
                            <a href="/attends/csv/{{date('Y-m')}}" class="btn btn-link">{{date('m').'月分'}}</a>
                        </div>
                        <div class="box-content text-center">
                            計 {!!$attends->appends(['user_key'=>$data['user_key']])->total()!!} 件
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop
