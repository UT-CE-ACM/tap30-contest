@extends('admin.base')

@section('inner-content')
    <div class="panel panel-default">
        <div class="panel-heading">زمان بندی</div>
        <div class="panel-body">
            <ol class="breadcrumb">
                <li class="active">مدیریت</li>
                <li class="active">زمان بندی</li>
            </ol>
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                @if(\App\Models\Timer::all()->count() == 0)
                <div class="btn-group" role="group">
                    <a href="/admin/timer/create">
                        <button type="button" class="btn btn-info">ایجاد تایمر</button>
                    </a>
                </div>
                {{--@else
                    <div class="btn-group" role="group">
                        <a href="/admin/timer/create">
                            <button type="button" class="btn btn-info">ایجاد تایمر</button>
                        </a>
                    </div>--}}
                @endif
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