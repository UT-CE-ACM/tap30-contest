@extends('admin.sample.base')

@section('main-content')
    <div style="padding-top: 20px;">
        <table class="table">
            <thead>
            <tr>
                <th>شماره تست کیس</th>
                <th>نام سوال مربوطه</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($samples as $sample)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $sample->problem->title }}</td>
                    <td>
                        {{ Form::open(array('url' => '/admin/sample/'.$sample->id, 'method' => 'delete', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-danger" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                        {{Form::close()}}
                        {{Form::open(array('url' => '/admin/sample/'.$sample->id.'/edit', 'method' => 'get', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-info" >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        {{Form::close()}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if(count($samples)==0)
            <h3> داده ای وجود ندارد! </h3>
        @endif
    </div>
@endsection