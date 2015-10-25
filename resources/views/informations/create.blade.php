@extends('layout/layout')

@section('title')
    お知らせ登録
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
                    <form method="POST" class="form-horizontal" action="/informations">
                        <table class="table table-striped">
                            <tbody>
                            <tr>

                                <td colspan="2">
                                    <div class="col-sm-12">
                                        <textarea name="text" class="form-control" rows="20"
                                                  placeholder="お知らせ">{{ Input::old('text', $information->text) }}</textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="/home" class="btn btn-lg btn-default btn-block">戻る</a></td>
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
