@extends('layout/layout')

@section('title')
    社員詳細
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

                    @foreach($users as $user)
                        <table class="table table-striped">
                            <tbody>

                            <tr>
                                <th>name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>role</th>
                                <td>{{ $user->role }}</td>
                            </tr>
                            <tr>
                                <th>group</th>
                                <td>{{ $user->group }}</td>
                            </tr>
                            <tr>
                                <th>作成日時</th>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                            <tr>
                                <th>更新日時</th>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                            <tr>
                                <th>更新者</th>
                                <td>{{ $user->updated_by }}</td>
                            </tr>
                            <tr>
                                <th><a href="/users/" class="btn btn-lg btn-default btn-block">戻る</a></th>
                                <td>
                                    {{--
                                                    <form method="POST" action="/users/{{ $user->id }}">
                                                          <input name="_method" type="hidden" value="DELETE">
                                                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    --}}
                                    <a href="/users/{{ $user->id }}/edit"
                                       class="btn btn-lg btn-success btn-block">編集</a>
                                    {{--
                                                      <button type="submit" class="btn btn-danger btn-xs">削除</button>
                                                    </form>
                                    --}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
@stop
