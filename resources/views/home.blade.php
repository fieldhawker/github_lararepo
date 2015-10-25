@extends('layout/layout')

@section('title')
    Dashboard
@stop

@section('pan')
    <li>Home</li>
    <li></li>
@stop

@section('contents')

    <div class="row">
        <div class="box col-md-12">
            <div class="box-inner">
                @include('layout.contents_head')
                <div class="box-content">


                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#info">お知らせ</a></li>
                        <li><a href="#sample">サンプル</a></li>
                        <li><a href="#sample2">サンプル</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane active" id="info">
                            <h3>お知らせとか書く感じ？</h3>

                            <p>{!! nl2br(e($information->text)) !!}</p>
                        </div>
                        <div class="tab-pane" id="sample">
                            <h3>サンプル</h3>

                            <p>test 2 messages.</p>
                        </div>
                        <div class="tab-pane" id="sample2">
                            <h3>サンプル</h3>

                            <p>test 3 messages.</p>
                        </div>
                    </div>


                    {{--
                                    <ol>
                                        <li>
                                            <a href="{{url('/')}}/" target="_blank">
                                                {{url('/')}}/</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/home" target="_blank">
                                                {{url('/')}}/home</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/auth/login" target="_blank">
                                                {{url('/')}}/auth/login</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/auth/register" target="_blank">
                                                {{url('/')}}/auth/register</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/password/resetmail" target="_blank">
                                                {{url('/')}}/password/resetmail</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/password/reset/user/aaaaaa" target="_blank">
                                                {{url('/')}}/password/reset/user/aaaaaa</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/password/reset/admin/bbbbbb" target="_blank">
                                                {{url('/')}}/password/reset/admin/bbbbbb</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/users/" target="_blank">
                                                {{url('/')}}/users/</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/users/show/" target="_blank">
                                                {{url('/')}}/users/show/</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/users/edit/" target="_blank">
                                                {{url('/')}}/users/edit/</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/reports/" target="_blank">
                                                {{url('/')}}/reports/</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/reports/create" target="_blank">
                                                {{url('/')}}/reports/create</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/reports/show/1" target="_blank">
                                                {{url('/')}}/reports/show/1</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/reports/edit/1" target="_blank">
                                                {{url('/')}}/reports/edit/1</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/reports/show/3" target="_blank">
                                                {{url('/')}}/reports/show/3</a>
                                        </li>
                                        <li>
                                            <a href="{{url('/')}}/reports/edit/3" target="_blank">
                                                {{url('/')}}/reports/edit/3</a>
                                        </li>




                                        <li>
                                            <a href="{{url('/')}}/auth/logout" target="_blank">
                                                {{url('/')}}/auth/logout</a>
                                        </li>


                                    </ol>
                    --}}
                </div>
            </div>
        </div>

    </div>
@stop
