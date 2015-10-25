@extends('layout/layout')

@section('title')
    社員編集
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


                    <br>
                    <ul class="thumbnails gallery">
                        <li id="image-1" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/1.jpg)"
                               title="Sample Image 1"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/1.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/1.jpg"
                                        alt="Sample Image 1"></a>
                        </li>
                        <li id="image-2" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/2.jpg)"
                               title="Sample Image 2"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/2.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/2.jpg"
                                        alt="Sample Image 2"></a>
                        </li>
                        <li id="image-3" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/3.jpg)"
                               title="Sample Image 3"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/3.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/3.jpg"
                                        alt="Sample Image 3"></a>
                        </li>
                        <li id="image-4" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/4.jpg)"
                               title="Sample Image 4"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/4.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/4.jpg"
                                        alt="Sample Image 4"></a>
                        </li>
                        <li id="image-5" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/5.jpg)"
                               title="Sample Image 5"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/5.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/5.jpg"
                                        alt="Sample Image 5"></a>
                        </li>
                        <li id="image-6" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/6.jpg)"
                               title="Sample Image 6"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/6.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/6.jpg"
                                        alt="Sample Image 6"></a>
                        </li>
                        <li id="image-7" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/7.jpg)"
                               title="Sample Image 7"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/7.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/7.jpg"
                                        alt="Sample Image 7"></a>
                        </li>
                        <li id="image-8" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/8.jpg)"
                               title="Sample Image 8"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/8.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/8.jpg"
                                        alt="Sample Image 8"></a>
                        </li>
                        <li id="image-9" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/9.jpg)"
                               title="Sample Image 9"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/9.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/9.jpg"
                                        alt="Sample Image 9"></a>
                        </li>
                        <li id="image-10" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/10.jpg)"
                               title="Sample Image 10"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/10.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/10.jpg"
                                        alt="Sample Image 10"></a>
                        </li>
                        <li id="image-11" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/11.jpg)"
                               title="Sample Image 11"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/11.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/11.jpg"
                                        alt="Sample Image 11"></a>
                        </li>
                        <li id="image-12" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/12.jpg)"
                               title="Sample Image 12"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/12.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/12.jpg"
                                        alt="Sample Image 12"></a>
                        </li>
                        <li id="image-13" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/13.jpg)"
                               title="Sample Image 13"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/13.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/13.jpg"
                                        alt="Sample Image 13"></a>
                        </li>
                        <li id="image-14" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/14.jpg)"
                               title="Sample Image 14"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/14.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/14.jpg"
                                        alt="Sample Image 14"></a>
                        </li>
                        <li id="image-15" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/15.jpg)"
                               title="Sample Image 15"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/15.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/15.jpg"
                                        alt="Sample Image 15"></a>
                        </li>
                        <li id="image-16" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/16.jpg)"
                               title="Sample Image 16"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/16.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/16.jpg"
                                        alt="Sample Image 16"></a>
                        </li>
                        <li id="image-17" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/17.jpg)"
                               title="Sample Image 17"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/17.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/17.jpg"
                                        alt="Sample Image 17"></a>
                        </li>
                        <li id="image-18" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/18.jpg)"
                               title="Sample Image 18"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/18.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/18.jpg"
                                        alt="Sample Image 18"></a>
                        </li>
                        <li id="image-19" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/19.jpg)"
                               title="Sample Image 19"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/19.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/19.jpg"
                                        alt="Sample Image 19"></a>
                        </li>
                        <li id="image-20" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/20.jpg)"
                               title="Sample Image 20"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/20.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/20.jpg"
                                        alt="Sample Image 20"></a>
                        </li>
                        <li id="image-21" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/21.jpg)"
                               title="Sample Image 21"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/21.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/21.jpg"
                                        alt="Sample Image 21"></a>
                        </li>
                        <li id="image-22" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/22.jpg)"
                               title="Sample Image 22"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/22.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/22.jpg"
                                        alt="Sample Image 22"></a>
                        </li>
                        <li id="image-23" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/23.jpg)"
                               title="Sample Image 23"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/23.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/23.jpg"
                                        alt="Sample Image 23"></a>
                        </li>
                        <li id="image-24" class="thumbnail">
                            <a style="background:url(https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/24.jpg)"
                               title="Sample Image 24"
                               href="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/24.jpg"><img
                                        class="grayscale"
                                        src="https://raw.githubusercontent.com/usmanhalalit/charisma/1.x/img/gallery/thumbs/24.jpg"
                                        alt="Sample Image 24"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        {{--<form method="POST" class="form-horizontal" action="/users/{{ $user->id or '' }}">--}}
        {{--<input name="_method" type="hidden" value="PUT">--}}
        {{--<table class="table table-striped">--}}
        {{--<tbody>--}}
        {{--<tr>--}}
        {{--<th><label class="col-sm-2 control-label">name</label></th>--}}
        {{--<td>--}}
        {{--<div class="col-sm-4">--}}
        {{--<input name="name" value="{{ Input::old('name', $user->name) }}" type="text" class="form-control" placeholder="山田 太郎">--}}
        {{--</div>--}}
        {{--</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th><label class="col-sm-2 control-label">email</label></th>--}}
        {{--<td>--}}
        {{--<div class="col-sm-10">--}}
        {{--<input name="email" value="{{ Input::old('email', $user->email)  }}" type="text" class="form-control" placeholder="example@mail.com" readonly>--}}
        {{--</div>--}}
        {{--</td>--}}
        {{--</tr>--}}
        {{--@if ($header_role > 1)--}}
        {{--<tr>--}}
        {{--<th><label class="col-sm-2 control-label">role</label></th>--}}
        {{--<td>--}}
        {{--<div class="col-sm-10">--}}
        {{--<select class="form-control" name="role">--}}
        {{--<option value="2" @if (Input::old('role', $user->role) != '1') selected="selected" @endif >管理者</option>--}}
        {{--<option value="1" @if (Input::old('role', $user->role) == '1') selected="selected" @endif>一般</option>--}}
        {{--</select>--}}
        {{--</div>--}}
        {{--</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<th><label class="col-sm-2 control-label">group</label></th>--}}
        {{--<td>--}}
        {{--<div class="col-sm-10">--}}
        {{--<select class="form-control" name="group">--}}
        {{--<option value="10" @if (Input::old('group', $user->group) == '10') selected="selected" @endif >営業</option>--}}
        {{--<option value="20" @if (Input::old('group', $user->group) == '20') selected="selected" @endif >総務</option>--}}
        {{--<option value="30" @if (Input::old('group', $user->group) == '30') selected="selected" @endif >川崎</option>--}}
        {{--<option value="40" @if (Input::old('group', $user->group) == '40') selected="selected" @endif >第一開発課</option>--}}
        {{--<option value="50" @if (Input::old('group', $user->group) == '50') selected="selected" @endif >第二開発課</option>--}}
        {{--</select>--}}
        {{--</div>--}}
        {{--</td>--}}
        {{--</tr>--}}
        {{--@endif--}}

        {{--<tr>--}}
        {{--<td><a href="/users/" class="btn btn-lg btn-default btn-block">戻る</a></td><td>--}}
        {{--<div class="col-sm-10">--}}
        {{--<button type="submit" class="btn btn-lg btn-success btn-block">送信</button>--}}
        {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
        {{--</div>--}}
        {{--</td>--}}
        {{--</tr>--}}
        {{--</tbody>--}}
        {{--</table>--}}
        {{--</form>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
@stop
