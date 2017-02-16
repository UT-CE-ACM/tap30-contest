@extends('admin.problem.base')

@section('main-content')
    @if($problem->id == null)
        <h3>ایجاد سوال جدید</h3>
    @else
        <h3>ویرایش سوال</h3>
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
    @if($problem->id==NULL)
        {{Form::open(array('url' => '/admin/problem', 'method' => 'post', 'files'=>true , 'class' => 'form-horizontal ls_form'))}}
    @else
        {{Form::model($problem, array('url' => '/admin/problem/'. $problem->id, 'method' => 'put' ,'files' => true, 'class' => 'form-horizontal ls_form'))}}
    @endif
    <div class="row ls_divider last">
        <div class="form-group form-padding">
            <div class="row padding">
                <label class="col-md-2 control-label">عنوان سوال</label>
                <div class="col-md-10">
                    {{ Form::text('title', old('title'), ['placeholder' => 'سوال تپسی', "class" => 'form-control input-lg ls-group-input']) }}
                </div>
            </div>

            <div class="row padding">
                <label class="col-md-2 control-label">توضیحات</label>
                <div class="col-md-10">
                    {{ Form::textarea('description', old('description'), ['placeholder' => 'توضیحات سوال', "class" => 'form-control', "rows" => 5]) }}
                </div>
            </div>
            <div class="row padding">
                <label class="col-md-2 control-label">متن سوال</label>
                <div class="col-md-10 attachment-container">
                    @if($problem->attachment)
                        <div class="inner-attachment-container">
                            <a href="/admin/attachment/remove/{{ $problem->attachment->id }}" class="remove-link" title="حذف">
                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </a>
                            <a href="{{ $problem->attachment->getPath() }}">
                                <span>{{ $problem->attachment->real_name }}</span>
                            </a>
                        </div>
                    @else
                        {{ Form::file('attachment', ['placeholder' => 'خروجی', "class" => 'form-control']) }}
                    @endif
                </div>
            </div>

            {{--<div class="padding" id="testcase-container"></div>

            <div class="col-md-2 pull-right  top-padding">
                <button class="btn btn-success btn-block" type="button" id="add-testcase">افزودن تست کیس</button>
            </div>
            <div class="clearfix"></div>--}}

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