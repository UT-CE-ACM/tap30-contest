@extends('admin.round.base')

@section('main-content')
    @if($round->id == null)
        <h3>ایجاد مرحله</h3>
    @else
        <h3>ویرایش مرحله</h3>
    @endif

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
            <div class="row padding">
                <label class="col-md-2 control-label">شماره مرحله</label>
                <div class="col-md-10">{{ $round->number }}</div>
            </div>
            <hr>

            @if($round->test_cases->count() > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th>ورودی</th>
                        <th>خروجی</th>
                        <th>عملیات</th>
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
                                {{ Form::open(array('url' => '/admin/test-case/'.$test_case->id, 'method' => 'delete', 'class' => 'horizontal'))}}
                                <button type="submit" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                                {{Form::close()}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr>
            @endif

            <div class="row padding">
                <label class="col-md-2 control-label">افزودن تست کیس</label>
            </div>
            {{Form::open(array('url' => '/admin/test-case', 'method' => 'post', 'files'=>true , 'class' => 'form-horizontal ls_form'))}}
            <input type="hidden" name="round_id" value="{{ $round->id }}">

            <div class="row padding">
                <label class="col-md-2 control-label">ورودی</label>
                <div class="col-md-10 attachment-container">
                    {{ Form::file('input', ['placeholder' => 'ورودی', "class" => 'form-control']) }}
                </div>
            </div>

            <div class="row padding">
                <label class="col-md-2 control-label">خروجی</label>
                <div class="col-md-10 attachment-container">
                    {{ Form::file('output', ['placeholder' => 'خروجی', "class" => 'form-control']) }}
                </div>
            </div>

            <div class="col-md-2 pull-right  top-padding">
                <button class="btn btn-success btn-block" type="submit">ذخیره</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection


@section('js')
@endsection