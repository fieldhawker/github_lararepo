@extends('layout/layout')

@section('title')
    グループ一覧
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
                            <th>group</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->group }}</td>

                                <td><a href="/groups/{{ $group->id }}" class="btn btn-default btn-xs">詳細</a></td>
                                <td><a href="/groups/{{ $group->id }}/edit" class="btn btn-success btn-xs">編集</a></td>
                        <td>
                            <form method="POST" action="/groups/{{ $group->id }}">
                                <input name="_method" type="hidden" value="DELETE">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="btn btn-danger btn-xs"
                                        onclick='return confirm("削除してよろしいですか？");'>削除
                                </button>
                            </form>
                        </td>
                            </tr>
                        @endforeach

                        <?php echo $groups->render(); ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop
