@extends('layout/layout')

@section('title')
    イベント編集
@stop

@section('pan')
    <li><a href="/">Home</a></li>
    <li><a href="/mevents/"> イベント一覧</a></li>
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
                    <form method="POST" class="form-horizontal" action="/mevents/{{ $event->id or '' }}">
                        <input name="_method" type="hidden" value="PUT">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th><label class="col-sm-4 control-label">タイトル</label></th>
                                <td>
                                    <div class="col-sm-8">
                                        <input name="title" value="{{ Input::old('title', $event->title) }}" type="text"
                                               class="form-control" placeholder="イベント名">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-4 control-label">画像URL</label></th>
                                <td>
                                    <div class="col-sm-8">
                                        <input name="image_path"
                                               value="{{ Input::old('image_path', $event->image_path) }}" type="text"
                                               class="form-control" placeholder="http://example.com/image.jpg">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-4 control-label">記事URL</label></th>
                                <td>
                                    <div class="col-sm-8">
                                        <input name="article_url"
                                               value="{{ Input::old('article_url', $event->article_url) }}" type="text"
                                               class="form-control" placeholder="http://example.com/">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th><label class="col-sm-4 control-label">状態</label></th>
                                <td>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="status">
                                            <option value="0"
                                                    @if (Input::old('status', $event->status) != '1') selected="selected" @endif >
                                                仮登録
                                            </option>
                                            <option value="1"
                                                    @if (Input::old('status', $event->status) == '1') selected="selected" @endif>
                                                本登録
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-4 control-label">開始日</label></th>
                                <td>
                                    <div class="col-sm-8">
                                        <input name="start_date"
                                               value="{{ Input::old('start_date', $event->start_date) }}" type="text"
                                               class="form-control datepicker" placeholder="">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="col-sm-4 control-label">終了日</label></th>
                                <td>
                                    <div class="col-sm-8">
                                        <input name="end_date" value="{{ Input::old('end_date', $event->end_date) }}"
                                               type="text" class="form-control datepicker" placeholder="">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><a href="/mevents/" class="btn btn-lg btn-default btn-block">戻る</a></td>
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
