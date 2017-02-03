@extends('admin.base')

@section('inner-content')
    <div class="panel panel-default">
        <div class="panel-heading">مراحل مسابقه</div>
        <div class="panel-body">
            <ol class="breadcrumb">
                <li class="active">مدیریت</li>
                <li class="active">مراحل مسابقه</li>
            </ol>
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                @if(\App\Models\Round::all()->count() <= \App\Models\Round::$numOfRounds)
                    @if(\App\Models\Round::all()->count() == 0 or \App\Models\Round::all()->last()->is_finished)
                        <div class="btn-group" role="group">
                            <a href="/admin/round/create">
                                <button type="button" class="btn btn-success">ایجاد مرحله جدید</button>
                            </a>
                        </div>
                    @else
                        <div class="btn-group" role="group">
                            {{Form::open(array('url' => '/admin/round/'. \App\Models\Round::all()->last()->id, 'method' => 'put' ,'files' => true))}}
                                <button type="submit" class="btn btn-success">انجام مرحله {{ \App\Models\Round::all()->last()->number }} </button>
                            {{Form::close()}}
                        </div>
                    @endif
                @endif
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