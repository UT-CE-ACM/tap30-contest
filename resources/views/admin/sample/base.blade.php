@extends('admin.base')

@section('inner-content')
    <div class="panel panel-default">
        <div class="panel-heading">تست کیس ها</div>
        <div class="panel-body">
            <ol class="breadcrumb">
                <li class="active">مدیریت</li>
                <li class="active">تست کیس ها</li>
            </ol>
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <a href="/admin/sample">
                        <button type="button" class="btn btn-info">مشاهده همه تست کیس ها</button>
                    </a>
                </div>
                <div class="btn-group" role="group">
                    <a href="/admin/sample/create">
                        <button type="button" class="btn btn-success">ایجاد تست کیس جدید</button>
                    </a>
                </div>
            </div>
            @yield('main-content')
        </div>
    </div>
@endsection