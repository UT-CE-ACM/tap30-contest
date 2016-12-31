@extends('admin.user.base')

@section('main-content')
    @if($user->id == null)
        <h3>ایجاد تیم جدید</h3>
    @else
        <h3>ویرایش تیم</h3>
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
    @if($user->id==NULL)
        {{Form::open(array('url' => '/admin/user', 'method' => 'post', 'files'=>true , 'class' => 'form-horizontal ls_form'))}}
    @else
        {{Form::model($user, array('url' => '/admin/user/'. $user->id, 'method' => 'put' ,'files' => true, 'class' => 'form-horizontal ls_form'))}}
    @endif
    <div class="row ls_divider last">
        <div class="form-group form-padding">

            <div class="row padding">
                <label class="col-md-2 control-label">نام تیم</label>
                <div class="col-md-10">
                    {{ Form::text('name', old('name'), ['placeholder' => 'نام تیم', "class" => 'form-control input-lg ls-group-input']) }}
                </div>
            </div>

                <div class="row padding">
                    <label class="col-md-2 control-label"> نام کاربری</label>
                    <div class="col-md-10">
                        {{ Form::text('username', old('username'), ['placeholder' => 'نام کاربری', "class" => 'form-control input-lg ls-group-input']) }}
                    </div>
                </div>
                    <div class="row padding">
                        <label class="col-md-2 control-label">کلمه عبور </label>
                        <div class="col-md-10">
                            {{ Form::text('password', '', ['autocomplete'=>'off','placeholder' => 'کلمه عبور',"class" => 'form-control input-lg ls-group-input']) }}
                        </div>
                    </div>

                    <div class="row padding">
                        <label class="col-md-2 control-label">تکرار کلمه عبور </label>
                        <div class="col-md-10">
                            {{ Form::text('password_confirmation', '', ['autocomplete'=>'off','placeholder' => 'تکرار کلمه عبور', "class" => 'form-control input-lg ls-group-input']) }}
                        </div>
                    </div>


            {{--<div class="row padding">--}}
                {{--<label class="col-md-2 control-label">توضیحات</label>--}}
                {{--<div class="col-md-10">--}}
                    {{--{{ Form::textarea('description', old('description'), ['placeholder' => 'توضیحات سوال', "class" => 'form-control', "rows" => 5]) }}--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="col-md-2 pull-right  top-padding">
                <button class="btn btn-success btn-block" type="submit">ذخیره</button>
            </div>
        </div>
    </div>


    {{ Form::close() }}

@endsection


@section('js')
@endsection