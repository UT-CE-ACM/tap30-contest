@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/record.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?php $submit = Auth::user()->submits()->with(['attachment', 'language'])->get()->last() ?>
                <div class="panel panel-default">
                    <div class="panel-heading">وضعیت کاربر</div>
                    <div class="panel-body">
                        <div>
                            <p> نام تیم: {{ Auth::user()->name }}</p>
                            <p>نام کاربری تیم: {{ Auth::user()->username }}</p>
                            <ul>اعضا
                                @foreach(Auth::user()->members as $member)
                                    <li>{{ $member->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @if($submit)
                            <div class="user-uploaded-file">
                                <p>فایل آپلودی:</p>
                                <div class="inner-attachment-container">
                                    {{--{{ Form::open(array('url' => '/submit/'.$submit->id.'/remove', 'method' => 'delete')) }}
                                    <button type="submit" class="remove-link remove-button">
                                        <span class="glyphicon glyphicon-remove " aria-hidden="true"></span>
                                    </button>--}}
                                    <a href="{{ $submit->attachment->getPath() }}">
                                        <span>{{ $submit->attachment->real_name }}</span>
                                    </a>
                                    {{--{{ Form::close() }}--}}
                                </div>
                                <p>زبان: {{ $submit->language->name . ' - ' . $submit->language->version }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">مسابقات</div>
                    <div class="panel-body">
                        <?php $hasRecords = false; ?>
                        <table id="leaderboard-table">
                            <thead>
                            <tr>
                                <th>مرحله</th>
                                <th>وضعیت</th>
                                <th>تیم اول</th>
                                <th>تیم دوم</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(Auth::user()->records()->with(['teams','round'])->get() as $record)
                                <?php $hasRecords = true; ?>
                                <tr class="comp-done">
                                    <td>{{ $record->round->number }}</td>
                                    <td>
                                        @if($record->round->is_finished) انجام شده@else در حال داوری@endif
                                    </td>
                                    @foreach($record->teams as $team)
                                        <td class="team-name @if($record->winner_id == $team->id) winner
                                            @elseif($team->has_lost) loser @endif">
                                            {{ $team->name }}
                                        </td>
                                    @endforeach
                                    <td>
                                        @if($record->round->is_finished)
                                            <a href="/record/{{$record->id}}" class="show-result">مشاهده نتیجه</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @if(!$hasRecords)
                            <tr><td colspan="5">در حال حاضر رکوردی موجود نیست!</td></tr>
                        @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
