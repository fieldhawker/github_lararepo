@extends('layout/layout')

@section('title')
    週報編集
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
                    <p>※同一週の週報は複数登録できません。</p>

                    <p>※週報は月曜から日曜を一週間として扱います。週には月曜日を指定してください。</p>

                    <form method="POST" class="form-horizontal" action="/reports/{{ $report->id or '' }}">
                        <input name="_method" type="hidden" value="PUT">
                        <table class="table table-striped">
                            <tbody>

                            @if ($header_role > 1)
                                <tr>
                                    <th><label class="col-sm-2 control-label">name</label></th>
                                    <td>
                                        <div class="col-sm-4">
                                            @foreach($users as $user)
                                                @if ( $report->user_key == $user->key)
                                                    {{ $user->name }}
                                                    <input type="hidden" name="user_key" value="{{ $user->key }}">
                                                @endif
                                            @endforeach


                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <th><label class="col-sm-2 control-label">status</label></th>
                                    <td>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="status">
                                                <option value="0"
                                                        @if (Input::old('status', $report->status) == '0') selected="selected" @endif >
                                                    未承認
                                                </option>
                                                <option value="1"
                                                        @if (Input::old('status', $report->status) == '1') selected="selected" @endif >
                                                    承認
                                                </option>
                                            </select>
                                        </div>

                                    </td>
                                </tr>

                            @endif

                            <tr>
                                <th><label class="col-sm-2 control-label">week</label></th>
                                <td>
                                    <div class="col-sm-5">
                                        <input name="week" value="{{ Input::old('week', $report->week) }}" type="text"
                                               class="form-control datepicker" placeholder="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">station</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <input name="station" value="{{ Input::old('station', $report->station)  }}"
                                               type="station" class="form-control" placeholder="御茶ノ水駅">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">place</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <input name="place" value="{{ Input::old('place', $report->place) }}"
                                               type="place" class="form-control" placeholder="株式会社エス・イー・プロジェクト">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">work</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <textarea name="work" class="form-control" rows="10"
                                                  placeholder="業務内容">{{ Input::old('work', $report->work) }}</textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">language</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <textarea name="language" class="form-control" rows="10"
                                                  placeholder="使用言語">{{ Input::old('language', $report->language) }}</textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">report</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <textarea name="report" class="form-control" rows="10"
                                                  placeholder="報告事項">{{ Input::old('report', $report->report) }}</textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-2 control-label">sales</label></th>
                                <td>
                                    <div class="col-sm-10">
                                        <textarea name="sales" class="form-control" rows="10"
                                                  placeholder="営業情報">{{ Input::old('sales', $report->sales) }}</textarea>
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
                            <input type="hidden" name="id" value="{{ Input::old('id', $report->id) }}">
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
