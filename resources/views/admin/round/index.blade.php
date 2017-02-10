@extends('admin.round.base')

@section('main-content')
    <div style="padding-top: 20px;">
        <table class="table">
            <thead>
            <tr>
                <th>شماره مرحله</th>
                <th>تعداد مسابقات</th>
                <th>تعداد تست کیس ها</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rounds as $round)
                <tr>
                    <td>{{ $round->number }}</td>
                    <td>{{ $round->records()->count() }}</td>
                    <td>{{ $round->test_cases()->count() }}</td>
                    <td>
                        {{ Form::open(array('url' => '/admin/round/'.$round->id, 'method' => 'delete', 'class' => 'horizontal'))}}
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        {{Form::close()}}
                        {{Form::open(array('url' => '/admin/round/'.$round->id.'/edit', 'method' => 'get', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-info" >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        {{Form::close()}}
                        <a href="/admin/record?round_id={{$round->id}}" class="btn btn-primary" title="مشاهده مسابقات">
                            <span class="glyphicon glyphicon-menu-hamburger"></span>
                        </a>
                        @if(!$round->is_finished)
                            {{Form::open(array('url' => '/admin/round/'. \App\Models\Round::all()->last()->id, 'method' => 'put', 'class' => 'horizontal'))}}
                            <button type="submit" class="btn btn-success" title="انجام مرحله">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                            {{Form::close()}}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @if(count($rounds)==0)
            <h3> داده ای وجود ندارد! </h3>
        @endif
    </div>
@endsection