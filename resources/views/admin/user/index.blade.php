@extends('admin.user.base')

@section('main-content')
    <div style="padding-top: 20px;">
        <table class="table">
            <thead>
            <tr>
                <th>شماره تیم</th>
                <th>نام تیم</th>
                <th>وضعیت در مسابقه</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <th>
                        @if($user->has_lost)
                            <button class="btn btn-danger" >
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        @else
                            <button class="btn btn-success" >
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        @endif
                    </th>
                    <td>
                        {{ Form::open(array('url' => '/admin/user/'.$user->id, 'method' => 'delete', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-danger" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                        {{Form::close()}}
                        {{Form::open(array('url' => '/admin/user/'.$user->id.'/edit', 'method' => 'get', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-info" >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        {{Form::close()}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if(count($users)==0)
            <h3> داده ای وجود ندارد! </h3>
        @endif
    </div>
@endsection