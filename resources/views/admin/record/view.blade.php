@extends('admin.record.base')

@section('main-content')
    <h3>جزئیات مسابقه</h3>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row ls_divider last">
        <div class="form-group form-padding">
            @foreach($record->teams as $team)
                <div class="padding col-md-12">
                    <label class="col-md-6 control-label"> فایل آپلودی تیم {{$team->name}}</label>
                    <a href="{{ $team->submits->last()->attachment->getPath() }}">
                        <span>{{ $team->submits->last()->attachment->real_name }}</span>
                    </a>
                </div>
            @endforeach
            @if($round->attachment)
                <div class="padding col-md-12">
                    <label class="col-md-6 control-label">فایل دیتای مرحله</label>
                    <a href="{{ $round->attachment->getPath() }}">
                        <span>{{ $round->attachment->real_name }}</span>
                    </a>
                </div>
            @endif
                <hr>
                <hr>
                <hr>
                <hr>
                <hr>
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
                                <span style="color: {{ $userRun->status == 'AC' ? 'green' : 'red'}}" data-title="{{ $userRun->message }}">
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

@endsection


@section('js')
@endsection