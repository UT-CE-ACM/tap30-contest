@extends('admin.base')

@section('inner-content')
    <div class="panel panel-default">
        <div class="panel-heading">مسابقات</div>
        <div class="panel-body">
            <ol class="breadcrumb">
                <li class="active">مدیریت</li>
                <li class="active">مسابقات</li>
            </ol>
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <a href="/admin/record?round_id={{$round->id}}">
                        <button type="button" class="btn btn-success">مسابقات مرحله {{ $round->number }}</button>
                    </a>
                </div>
                <div class="btn-group" role="group">
                    <a href="/admin/round">
                        <button type="button" class="btn btn-info">مشاهده همه مراحل</button>
                    </a>
                </div>
            </div>
            @yield('main-content')
        </div>
    </div>
@endsection