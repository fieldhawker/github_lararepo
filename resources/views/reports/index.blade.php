@extends('layout/layout')

@section('title')
    週報一覧
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

                    <form method="GET" action="/reports" class="form-search">

                        <div class="form-group">
                            <label for="exampleInputEmail1">name</label>
                            <select class="form-control  input-sm" name="user_key">
                                <option value=''>未指定</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->key }}"
                                            @if (Input::old('user_key', $data['user_key']) == $user->key) selected="selected" @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">week</label>
                            <select class="form-control  input-sm" name="week">
                                <option value=''>未指定</option>
                                @foreach($weeks as $week)
                                    <option value="{{ $week->week }}"
                                            @if (Input::old('week', $data['week']) == $week->week) selected="selected" @endif>{{ $week->week }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block">検索</button>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </form>
                    <br/>
                    <br/>

                    <table class="table table-striped table-bordered  responsive ">
                        <thead>
                        <tr>

                            <th>name</th>
                            <th>week</th>
                            <th>station</th>
                            <th>work</th>
                            <th>report</th>
                            <th>sales</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $report)
                            <tr>

                                <td>{{ $report->uname }}</td>
                                <td>
                                    <i class="glyphicon @if ($report->status > 0) glyphicon-ok @endif"></i><span> {{ $report->week }}</span>
                                </td>

                                <td>{{ $report->station }}</td>
                                {{--<td>{{ $report->place }}</td>--}}
                                <td>{!! str_limit(nl2br(e($report->work)),100) !!}</td>
                                {{--<td>{!! str_limit(nl2br(e($report->language)),100) !!}</td>--}}
                                <td>{!! str_limit(nl2br(e($report->report)),100) !!}</td>
                                <td>{!! str_limit(nl2br(e($report->sales)),100) !!}</td>

                                <td><a href="/reports/{{ $report->id }}" class="btn btn-default btn-xs">詳細</a></td>
                                <td><a href="/reports/{{ $report->id }}/edit" class="btn btn-success btn-xs">編集</a></td>

                                {{--
                                                <td>
                                                    <form method="POST"  action="/reports/delete/{{ $report->seq }}">
                                                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                  <button type="submit" class="btn btn-danger btn-xs">削除</button>
                                                </form></td>
                                --}}
                            </tr>
                        @endforeach

                        {!!$reports->appends(['user_key'=>$data['user_key']])->render()!!}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
