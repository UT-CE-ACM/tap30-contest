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

            <h4 class="from-header">مشخصات تیم</h4>
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
                    {{ Form::password('password', ['placeholder' => '***', "class" => 'form-control input-lg ls-group-input']) }}
                </div>
            </div>

            <div class="row padding">
                <label class="col-md-2 control-label">تکرار کلمه عبور </label>
                <div class="col-md-10">
                    {{ Form::password('password_confirmation', ['placeholder' => '***', "class" => 'form-control input-lg ls-group-input']) }}
                </div>
            </div>

            <hr>
            <h4 class="from-header">مشخصات اعضا</h4>
            <div class="row padding">
                <label class="col-md-2 control-label">نام عضو اول</label>
                <div class="col-md-10">
                    {{ Form::text('m1_name', ($user->members()->count()) ? $user->members[0]->name : old('m1_name'), ["class" => 'form-control input-lg ls-group-input']) }}
                </div>
            </div>
            <div class="row padding">
                <label class="col-md-2 control-label">ایمیل عضو اول</label>
                <div class="col-md-10">
                    {{ Form::text('m1_email', ($user->members()->count()) ? $user->members[0]->email : old('m1_email'), ["class" => 'form-control input-lg ls-group-input']) }}
                </div>
            </div>
            <hr>
            <div class="row padding">
                <label class="col-md-2 control-label">نام عضو دوم</label>
                <div class="col-md-10">
                    {{ Form::text('m2_name', ($user->members()->count()) ? $user->members[1]->name : old('m2_name'), ["class" => 'form-control input-lg ls-group-input']) }}
                </div>
            </div>
            <div class="row padding">
                <label class="col-md-2 control-label">ایمیل عضو دوم</label>
                <div class="col-md-10">
                    {{ Form::text('m2_email', ($user->members()->count()) ? $user->members[1]->email : old('m2_email'), ["class" => 'form-control input-lg ls-group-input']) }}
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