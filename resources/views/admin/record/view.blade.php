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
                        <th>نتیجه تیم {{$record->teams->first()->name}}</th>
                        <th>نتیجه تیم {{$record->teams->last()->name}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($round->test_cases as $test_case)
                        <tr>
                            @foreach($test_case->attachments as $attachment)
                                <td>
                                    <div class="inner-attachment-container">
                                        <a href="{{ $attachment->getPath() }}">
                                            <span>{{ $attachment->real_name }}</span>
                                        </a>
                                    </div>
                                </td>
                            @endforeach
                            <td>
                                {{ $runs[0][$loop->index]->RMSE }}
                            </td>
                            <td>
                                {{ $runs[1][$loop->index]->RMSE }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('js')
@endsection