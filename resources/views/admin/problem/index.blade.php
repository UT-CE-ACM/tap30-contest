@extends('admin.problem.base')

@section('main-content')
    <div style="padding-top: 20px;">
        <table class="table">
            <thead>
            <tr>
                <th>شماره سوال</th>
                <th>نام سوال</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($problems as $problem)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $problem->title }}</td>
                    <td>
                        {{ Form::open(array('url' => '/admin/problem/'.$problem->id, 'method' => 'delete', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-danger" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                        {{Form::close()}}
                        {{Form::open(array('url' => '/admin/problem/'.$problem->id.'/edit', 'method' => 'get', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-info" >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        {{Form::close()}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if(count($problems)==0)
            <h3> داده ای وجود ندارد! </h3>
        @endif
    </div>
@endsection