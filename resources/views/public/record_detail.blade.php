@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/css/record.css">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">جزئیات مسابقه</div>
                    <div class="panel-body">
                        <div class="padding col-md-12">
                            <label class="col-md-6 control-label">مسابقه مرحله {{$round->number}}</label>
                        </div>
                        @foreach($record->teams as $team)
                            <div class="padding col-md-12">
                                <label class="col-md-6 control-label">
                                    @if($loop->index == 0) تیم اول @else تیم دوم @endif :
                                    {{$team->name}}
                                </label>
                            </div>
                        @endforeach
                        @if($round->attachment)
                            <div class="padding col-md-12">
                                <label class="control-label">فایل دیتای مرحله:</label>
                                <a href="{{ $round->attachment->getPath() }}">
                                    <span>{{ $round->attachment->real_name }}</span>
                                </a>
                                <hr>
                            </div>
                        @endif
                        <div class="padding">
                            <lable>تست کیس ها</lable>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ورودی</th>
                                    <th>خروجی</th>
                                    <th>وضعیت تیم اول</th>
                                    <th>وضعیت تیم دوم</th>
                                    <th>RMSE تیم اول</th>
                                    <th>RMSE تیم دوم</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($round->test_cases as $test_case)
                                    <tr>
                                        @foreach($test_case->attachments as $attachment)
                                            <td>
                                                <div class="">
                                                    <a href="{{ $attachment->getPath() }}">
                                                        <span>{{ $attachment->real_name }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        @endforeach
                                        <?php $usersRun = [$runs[0][$loop->index], $runs[1][$loop->index]]; ?>
                                        @foreach($usersRun as $userRun)
                                            <td>
                                <span style="color: {{ $userRun->status == 'AC' ? 'green' : 'red'}}"
                                      @if($userRun->message) data-title="{{ $userRun->message }}" @endif>
                                    {{ trans('general.'.$userRun->status, [], null, 'en') }}
                                </span>
                                            </td>
                                        @endforeach
                                        @foreach($usersRun as $userRun)
                                            <td>
                                                {{ $userRun->RMSE }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: center">مجموع RMSE ها</td>
                                    @foreach($record->teams as $team)
                                        <td>{{ \App\Utils\Submissions\RunSubmission::finalScore($team, $round) }}</td>
                                    @endforeach
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
