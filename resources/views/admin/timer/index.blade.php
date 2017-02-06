@extends('admin.timer.base')

@section('main-content')
    <div style="padding-top: 20px;">
        <table class="table">
            <thead>
            <tr>
                <th>زمان شروع</th>
                <th>زمان پایان</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($timers as $timer)
                <tr>
                    <td>{{ $timer->starts_at_jalali }}</td>
                    <td>{{ $timer->ends_at_jalali }}</td>
                    <td>
                        {{ Form::open(array('url' => '/admin/timer/'.$timer->id, 'method' => 'delete', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                        {{Form::close()}}
                        {{Form::open(array('url' => '/admin/timer/'.$timer->id.'/edit', 'method' => 'get', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-info" >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        {{Form::close()}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if(count($timers)==0)
            <h3> داده ای وجود ندارد! </h3>
        @endif
    </div>
@endsection