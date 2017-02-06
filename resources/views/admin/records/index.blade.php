@extends('admin.round.base')

@section('main-content')
    <div style="padding-top: 20px;">
        <table class="table">
            <thead>
            <tr>
                <th>شماره مرحله</th>
                <th>تیم اول</th>
                <th>تیم دوم</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $round->number }}</td>
                    @foreach($record->teams as $team)
                        <td>
                            {{ $team->name }}
                            @if($team->id == $record->winner_id)
                                <button class="btn btn-sm btn-success">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </button>
                            @endif
                        </td>
                    @endforeach
                    <td>
                        {{ Form::open(array('url' => '/admin/round/'.$record->id, 'method' => 'delete', 'class' => 'horizontal'))}}
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        {{Form::close()}}
                        {{Form::open(array('url' => '/admin/round/'.$record->id.'/edit', 'method' => 'get', 'class' => 'horizontal'))}}
                        <button type="submit" class="btn btn-info" >
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        {{Form::close()}}
                        @if(!$record->is_finished)
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
        @if(count($records)==0)
            <h3> داده ای وجود ندارد! </h3>
        @endif
    </div>
@endsection