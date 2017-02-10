@extends('admin.record.base')

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
                        <a href="/admin/record/{{$record->id}}" class="btn btn-primary" title="جزئیات مسابقه">
                            <span class="glyphicon glyphicon-info-sign"></span>
                        </a>
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