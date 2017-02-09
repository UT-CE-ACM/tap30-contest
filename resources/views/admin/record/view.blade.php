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
                <div class="padding col-md-6">
                    <label class="col-md-2 control-label">نام تیم</label>
                    <div class="col-md-10">{{ $team->name }}</div>
                </div>
                <div class="padding col-md-6">
                    <label class="col-md-2 control-label">فایل آپلودی</label>
                    <a href="{{ $attachment->getPath() }}">
                        <span>{{ $attachment->real_name }}</span>
                    </a>
                </div>
                <hr>
                <lable>تست کیس ها</lable>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ورودی</th>
                        <th>خروجی</th>
                        <th>نتیجه</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($runs[$loop->index] as $run)
                        <tr>
                            @foreach($run->$test_case->attachments as $attachment)
                                <td>
                                    <div class="inner-attachment-container">
                                        <a href="{{ $attachment->getPath() }}">
                                            <span>{{ $attachment->real_name }}</span>
                                        </a>
                                    </div>
                                </td>
                            @endforeach
                            <td>
                                {{ $run->RMSE }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr>
            @endforeach
        </div>
    </div>

@endsection


@section('js')
@endsection