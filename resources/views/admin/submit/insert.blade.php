@extends('admin.submit.base')

@section('main-content')
    @if($submit->id == null)
        <h3>ایجاد فایل</h3>
    @else
        <h3>ویرایش فایل</h3>
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
                <label class="col-md-2 control-label">سوال مربوطه</label>
                <div class="col-md-10">{{ $submit->problem->title }}</div>
            </div>

            <div class="row padding">
                <label class="col-md-2 control-label">گروه</label>
                <div class="col-md-10">{{ $submit->team->name }}</div>
            </div>

            @if($submit->id==NULL)
                {{Form::open(array('url' => '/admin/submit', 'method' => 'post', 'files'=>true , 'class' => 'form-horizontal ls_form'))}}
            @else
                {{Form::model($submit, array('url' => '/admin/submit/'. $submit->id, 'method' => 'put' ,'files' => true, 'class' => 'form-horizontal ls_form'))}}
            @endif

            <div class="form-group">
                {{ Form::label('language_id', 'زبان مورد نظر', array('class' => 'control-label col-sm-2')) }}
                <div class="col-sm-10">
                    {{ Form::select('language_id', \App\Models\Language::listLanguages(), null , ["class" => 'form-control']) }}
                </div>
            </div>

            <div class="row padding">
                <label class="col-md-2 control-label">فایل ارسالی</label>
                <div class="col-md-10 attachment-container">
                @if($submit->attachment)
                    <div class="inner-attachment-container">
                        <a href="/admin/attachment/remove/{{ $submit->attachment->id }}" class="remove-link" title="حذف">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </a>
                        <a href="{{ $submit->attachment->getPath() }}">
                            <span>{{ $submit->attachment->real_name }}</span>
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
@endsection