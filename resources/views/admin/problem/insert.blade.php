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
            <label class="col-md-2 control-label">عنوان سوال</label>
            <div class="col-md-10">
                {{ Form::text('title', old('title'), ['placeholder' => 'سوال تپسی', "class" => 'form-control input-lg ls-group-input']) }}
            </div>

            <label class="col-md-2 control-label">توضیحات</label>
            <div class="col-md-10">
                {{ Form::textarea('description', old('description'), ['placeholder' => 'توضیحات سوال', "class" => 'form-control', "rows" => 5]) }}
            </div>

            <div class="col-md-2 pull-right  top-padding">
                <button class="btn btn-success btn-block" type="submit">ذخیره</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}

@endsection