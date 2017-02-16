@extends('admin.base')

@section('inner-content')
    <div class="panel panel-default">
        <div class="panel-heading">فایل های ارسالی</div>
        <div class="panel-body">
            <ol class="breadcrumb">
                <li class="active">مدیریت</li>
                <li class="active">فایل های ارسالی</li>
            </ol>
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <a href="/admin/submit">
                        <button type="button" class="btn btn-info">مشاهده همه فایل ها
                        ({{ \App\Models\Submit::all()->count() }})</button>
                    </a>
                </div>
                <div class="btn-group" role="group">
                    <a href="/admin/submit?trashed=1">
                        <button type="button" class="btn btn-danger">فایل های پاک شده
                            ({{ \App\Models\Submit::onlyTrashed()->get()->count() }})</button>
                    </a>
                </div>
                <div class="btn-group" role="group">
                    <a href="/admin/submit?judge_request=1">
                        <button type="button" class="btn btn-success">فایل های منتظر جاج
                            ({{ \App\Models\Submit::whereJudgeRequest(true)->get()->count() }})</button>
                    </a>
                </div>
                {{--<div class="btn-group" role="group">
                    <a href="/admin/submit/create">
                        <button type="button" class="btn btn-success">ایجاد فایل جدید</button>
                    </a>
                </div>--}}
            </div>
            @yield('main-content')
        </div>
    </div>
@endsection