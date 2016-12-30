@extends('admin.sample.base')

@section('main-content')
    @if($sample->id == null)
        <h3>ایجاد تست کیس جدید</h3>
    @else
        <h3>ویرایش تست کیس</h3>
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
    @if($sample->id==NULL)
        {{Form::open(array('url' => '/admin/sample', 'method' => 'post', 'files'=>true , 'class' => 'form-horizontal ls_form'))}}
    @else
        {{Form::model($sample, array('url' => '/admin/sample/'. $sample->id, 'method' => 'put' ,'files' => true, 'class' => 'form-horizontal ls_form'))}}
    @endif
    <div class="row ls_divider last">
        <div class="form-group form-padding">
            <div class="row padding">
                <label class="col-md-2 control-label">سوال مربوطه</label>
                <div class="col-md-10">
                    {{ Form::select('problem_id', $problems, null, ["class" => 'form-control']) }}
                </div>
            </div>

            <div class="row padding">
                <label class="col-md-2 control-label">ورودی</label>
                <div class="col-md-10">
                    {{ Form::textarea('input', old('input'), ['placeholder' => 'ورودی', "class" => 'form-control', "rows" => 5]) }}
                </div>
            </div>

            <div class="row padding">
                <label class="col-md-2 control-label">خروجی</label>
                <div class="col-md-10">
                    {{ Form::textarea('output', old('output'), ['placeholder' => 'خروجی', "class" => 'form-control', "rows" => 5]) }}
                </div>
            </div>

            <div class="row padding">
                <label class="col-md-2 control-label">فایل پیوست</label>
                <div class="col-md-10 attachment-container">
                @if($sample->attachment)
                    <div class="inner-attachment-container">
                        <a href="/admin/attachment/remove/{{ $sample->attachment->id }}" class="remove-link" title="حذف">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </a>
                        <a href="{{ $sample->attachment->getPath() }}">
                            <span>{{ $sample->attachment->real_name }}</span>
                        </a>
                    </div>
                @else
                    {{ Form::file('attachment', ['placeholder' => 'خروجی', "class" => 'form-control']) }}
                @endif
                </div>
            </div>

            <div class="col-md-2 pull-right  top-padding">
                <button class="btn btn-success btn-block" type="submit">ذخیره</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}

@endsection


@section('js')
    <script>
        window.tcNumber = 1;
        jQuery("#add-testcase").click(function (event) {
            event.stopPropagation();
            var testcaseBody =
                    "<div class='panel panel-default'>"+
                        "<div class='panel-heading'>تست کیس شماره "+window.tcNumber+"</div>"+
                        "<div class='panel-body'>"+
                            "<label class='col-md-2 control-label'>ورودی</label>"+
                            "<div class='col-md-10'>"+
                                "<textarea name='tc-input-"+window.tcNumber+"' class='form-control' rows='5'></textarea>"+
                            "</div>"+
                            "<label class='col-md-2 control-label'>خروجی</label>"+
                            "<div class='col-md-10'>"+
                                "<textarea name='tc-output-"+window.tcNumber+"' class='form-control' rows='5'></textarea>"+
                            "</div>"+
                        "</div>"+
                    "</div>";
            window.tcNumber ++;
            jQuery("#testcase-container").append(testcaseBody);
        });
    </script>
@endsection