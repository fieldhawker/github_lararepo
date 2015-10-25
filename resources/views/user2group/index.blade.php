@extends('layout/layout')

@section('title')
    所属グループ一覧
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

                    <br>
                    <ul class="thumbnails">
                        {{--*/ $div_group = '' /*--}}

                        @foreach($users as $num => $user)
                            @if ( $div_group == '' && $div_group <> $user->group )
                                <h3>{{ $user->gname }}</h3>
                            @endif
                            @if ( $div_group <> '' && $div_group <> $user->group )
                    </ul>
                    <ul class="thumbnails">
                        <h3>{{ $user->gname }}</h3>
                        @endif

                        {{--*/ $div_group = $user->group /*--}}

                        <li id="image-{{ $num }}" class="">
                            {{ $user->name }}
                        </li>
                        @endforeach
                    </ul>


                </div>
            </div>
        </div>
    </div>
    </div>
@stop
