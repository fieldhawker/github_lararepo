@extends('layout/layout')

@section('title')
    社員一覧
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

                    <table class="table table-striped table-bordered responsive ">
                        <thead>
                        <tr>
                            <th>name</th>
                            <th>email</th>
                            <th>role</th>
                            <th>group</th>
                            @if ($header_role > 1)
                                <th></th>
                                <th></th>
                                <th></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <i class="glyphicon @if ($user->status <> 1) glyphicon-remove @endif"></i><span> {{ $user->name }}</span>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>@if ($user->role > 1) 管理者 @else 一般 @endif</td>
                                <td>{{ $user->gname }}</td>
                                @if ($header_role > 1)
                                    <td><a href="/users/{{ $user->id }}" class="btn btn-default btn-xs">詳細</a></td>
                                    <td><a href="/users/{{ $user->id }}/edit" class="btn btn-success btn-xs">編集</a></td>

                                    <td>
                                        <form method="POST" action="/users/{{ $user->id }}">
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <button type="submit" class="btn btn-danger btn-xs"
                                                    onclick='return confirm("削除してよろしいですか？");'>削除
                                            </button>
                                        </form>
                                    </td>
                                @endif

                            </tr>
                        @endforeach

                        <?php echo $users->render(); ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop
