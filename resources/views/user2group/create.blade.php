@extends('layout/layout')

@section('title')
    グループ一括更新
@stop

@section('pan')
    <li><a href="/">Home</a></li>
    <li><a href="/user2group">所属グループ一覧</a></li>
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

                    <form method="POST" class="form-horizontal" action="/user2group">

                        <br>
                        <ul class="thumbnails">
                            {{--*/ $div_group = '' /*--}}
                            @foreach($users as $num => $user)
                                @if ( $div_group == '' && $div_group <> $user->group )
                                    <h3>{{ $user->gname }}</h3>
                                @endif
                                @if ( $div_group <> '' && $div_group <> $user->group)
                        </ul>
                        <ul class="thumbnails">
                            <h3>{{ $user->gname }}</h3>
                            @endif
                            {{--*/ $div_group = $user->group /*--}}

                            <li id="image-{{ $num }}" class="thumbnail">
                                <div class="chosen-container" style="width: 89px;" title="">

                                    <div class="">
                                        <div class="">
                                            <select class="form-control" name="group[]">
                                                <option value="10"
                                                        @if (Input::old('group', $user->group) == '10') selected="selected" @endif >
                                                    営業
                                                </option>
                                                <option value="20"
                                                        @if (Input::old('group', $user->group) == '20') selected="selected" @endif >
                                                    総務
                                                </option>
                                                <option value="30"
                                                        @if (Input::old('group', $user->group) == '30') selected="selected" @endif >
                                                    川崎
                                                </option>
                                                <option value="40"
                                                        @if (Input::old('group', $user->group) == '40') selected="selected" @endif >
                                                    第一開発課
                                                </option>
                                                <option value="50"
                                                        @if (Input::old('group', $user->group) == '50') selected="selected" @endif >
                                                    第二開発課
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{ $user->name }}
                                <input name="key[]" type="hidden" value="{{ $user->key }}">
                            </li>
                            @endforeach
                            <button type="submit" class="btn btn-lg btn-success btn-block">更新</button>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </ul>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
@stop
