@extends('admin.submit.base')

@section('main-content')
    <div style="padding-top: 20px;">
        <table class="table">
            <thead>
            <tr>
                <th>نام گروه</th>
                <th>نام سوال مربوطه</th>
                <th>فایل ارسالی</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($submits as $submit)
                <tr>
                    <td>{{ $submit->team->name }}</td>
                    <td>{{ $submit->problem->title }}</td>
                    <td>
                        @if($submit->attachment)
                        <a href="{{ $submit->attachment->getPath() }}">
                            <span>{{ $submit->attachment->real_name }}</span>
                        </a>
                        @else
                            فایلی موجود نیست!
                        @endif
                    </td>
                    <td>
                        @if($submit->trashed())
                            {{ Form::open(array('url' => '/admin/submit/'.$submit->id, 'method' => 'delete', 'class' => 'horizontal'))}}
                            <input type="hidden" name="force_delete" value="true">
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                            {{Form::close()}}
                        @endif
                        {{ Form::open(array('url' => '/admin/submit/'.$submit->id, 'method' => 'delete', 'class' => 'horizontal'))}}
                        @if($submit->trashed())
                            <button type="submit" class="btn btn-warning">
                                <span class="glyphicon glyphicon-refresh"></span>
                            </button>
                        @else
                            <button type="submit" class="btn btn-warning">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        @endif
                        {{Form::close()}}
                        {{Form::open(array('url' => '/admin/submit/'.$submit->id.'/edit', 'method' => 'get', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-info" >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        {{Form::close()}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if(count($submits)==0)
            <h3> داده ای وجود ندارد! </h3>
        @endif
    </div>
@endsection