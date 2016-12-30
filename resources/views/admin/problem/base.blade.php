@extends('admin.base')

@section('inner-content')
    <div class="panel panel-default">
        <div class="panel-heading">سوالات</div>
        <div class="panel-body">
            <ol class="breadcrumb">
                <li class="active">مدیریت</li>
                <li class="active">سوالات</li>
            </ol>
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <a href="/admin/problem">
                        <button type="button" class="btn btn-info">مشاهده همه سوالات</button>
                    </a>
                </div>
                <div class="btn-group" role="group">
                    <a href="/admin/problem/create">
                        <button type="button" class="btn btn-success">ایجاد سوال جدید</button>
                    </a>
                </div>
            </div>
            @yield('main-content')
        </div>
    </div>
@endsection