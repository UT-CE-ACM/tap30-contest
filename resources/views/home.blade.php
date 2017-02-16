@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="css/landing-page.css">
    <style>
        .countdown-container {
    margin-top: 25px;
    padding: 0;
    right: 0;
    left: 0;
    width: 600px;
    position: static;
    top: initial;
    transform: initial;
}
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
    <div class="countdown countdown-container container"
         data-start="1"
         data-end="2000"
         data-now="4">
        <div class="clock row">

            <div class="clock-item clock-seconds countdown-time-value col-sm-4 col-md-4">
                <div class="wrap">
                    <div class="inner">
                        <div id="canvas-seconds" class="clock-canvas"></div>

                        <div class="text">
                            <p class="val">0</p>
                            <p class="type-seconds type-time">ثانیه</p>
                        </div><!-- /.text -->
                    </div><!-- /.inner -->
                </div><!-- /.wrap -->
            </div><!-- /.clock-item -->

            <div class="clock-item clock-minutes countdown-time-value col-sm-4 col-md-4">
                <div class="wrap">
                    <div class="inner">
                        <div id="canvas-minutes" class="clock-canvas"></div>

                        <div class="text">
                            <p class="val">0</p>
                            <p class="type-minutes type-time">دقیقه</p>
                        </div><!-- /.text -->
                    </div><!-- /.inner -->
                </div><!-- /.wrap -->
            </div><!-- /.clock-item -->

            <div class="clock-item clock-hours countdown-time-value col-sm-4 col-md-4">
                <div class="wrap">
                    <div class="inner">
                        <div id="canvas-hours" class="clock-canvas"></div>

                        <div class="text">
                            <p class="val">0</p>
                            <p class="type-hours type-time">ساعت</p>
                        </div><!-- /.text -->
                    </div><!-- /.inner -->
                </div><!-- /.wrap -->
            </div><!-- /.clock-item -->
            <div class="clock-item clock-days countdown-time-value col-sm-6 col-md-3" style="opacity: 0; transform: scale(0); height: 0; visibility: hidden;">
            <div class="wrap">
                <div class="inner">
                    <div id="canvas-days" class="clock-canvas"></div>

                    <div class="text">
                        <p class="val">0</p>
                        <p class="type-days type-time">روز</p>
                    </div><!-- /.text -->
                </div><!-- /.inner -->
            </div><!-- /.wrap -->
        </div><!-- /.clock-item -->
        </div><!-- /.clock -->
    </div><!-- /.countdown-wrapper -->

    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach(\App\Models\Problem::with('samples')->get() as $problem)
            <div class="panel panel-default">
                <div class="panel-heading">{{ $problem->title }}</div>

                <div class="panel-body">
                    <p style="word-wrap: break-word;">{{ $problem->description }}</p>
                    @if($problem->attachment)
                        <p>متن سوال :
                            <a href="{{ $problem->attachment->getPath() }}">{{ $problem->attachment->real_name }}</a>
                        </p>
                    @endif
                    @foreach($problem->samples as $sample)
                        <hr>
نمونه ی ورودی {{ $loop->index }}
                        <pre>{{ $sample->input }}</pre>
نمونه خروجی {{ $loop->index }}
                        <pre>{{ $sample->output }}</pre>
                        @if($sample->attachments->first())
                            <p>فایل ورودی :
                                <a href="{{ $sample->attachments->first()->getPath() }}">{{ $sample->attachments->first()->real_name }}</a>
                            </p>
                        @endif
                        @if($sample->attachments->get(1))
                            <p>فایل خروجی :
                                <a href="{{ $sample->attachments->get(1)->getPath() }}">{{ $sample->attachments->get(1)->real_name }}</a>
                            </p>
                        @endif
                        @if($sample->attachments->last())
                            <p>فایل داده :
                                <a href="{{ $sample->attachments->last()->getPath() }}">{{ $sample->attachments->last()->real_name }}</a>
                            </p>
                        @endif
                        @endforeach
                    <?php $submit = Auth::user()->submits()->with(['attachment', 'language'])->whereProblemId($problem->id)->first() ?>
                    @if($submit)
                        <div class="user-uploaded-file">
                            <p>فایل آپلودی:</p>
                            <div class="inner-attachment-container">
                                {{ Form::open(array('url' => '/submit/'.$submit->id.'/remove', 'method' => 'delete')) }}
                                <button type="submit" class="remove-link remove-button">
                                    <span class="glyphicon glyphicon-remove " aria-hidden="true"></span>
                                </button>
                                <a href="{{ $submit->attachment->getPath() }}">
                                    <span>{{ $submit->attachment->real_name }}</span>
                                </a>
                                {{ Form::close() }}
                            </div>
                            <p>زبان: {{ $submit->language->name . ' - ' . $submit->language->version }}</p>
                            <p style="background: #ddd;padding: 10px;display: inline-block;border-radius: 4px;border-bottom: 2px solid #bbb;margin: 20px 0 10px;">تعداد درخواست های باقی مانده: {{ \App\Models\User::$maxNumOfRequest - Auth::user()->num_of_requests }}</p>
                            <?php $log = \App\Models\Log::whereSubmitId($submit->id)->first(); ?>
                            @if($log)
                                <div class="row submit-log">
                                    <div class="col-sm-2"><h4>نتیجه ی اجرا</h4></div>
                                    <div class="col-sm-10">
                                        <h4>{{ trans('general.'.$log->status) }}</h4>
                                        <p style="direction: ltr; background-color: #ddd; ">{{ $log->message }}</p>
                                    </div>
                                </div>
                            @else
                                @if($submit->judge_request == 0)
                                    {{ Form::open(array('url'=>"/submit/".$submit->id."/judge-request", 'files' => true, 'class' => 'form-horizontal answer-form')) }}
                                        <div class="form-group">
                                            <div class="col-sm-2">
                                                <button class="btn btn-success btn-block" type="submit">درخواست اجرا کد</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                @else
                                    <div class="col-sm-4">
                                        <button class="btn btn-default btn-block" type="button">درخواست شما در حال بررسی است!</button>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @else
                        {{ Form::open(array('url'=>"/problem/".$problem->id."/submit", 'files' => true, 'class' => 'form-horizontal answer-form')) }}
                            <div class="form-group">
                                {{ Form::label('lang', 'زبان مورد نظر', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-sm-10">
                                    {{ Form::select('lang', $languages, null , ["class" => 'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('attachment', 'ارسال پاسخ', array('class' => 'control-label col-sm-2')) }}
                                <div class="col-sm-10">
                                    {{ Form::file('attachment', ['placeholder' => 'خروجی', "class" => 'form-control']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button class="btn btn-success btn-block" type="submit">ذخیره</button>
                                </div>
                            </div>
                        {{ Form::close() }}
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="js/jquery.final-countdown.min.js"></script>
    <script src="js/kinetic-v5.1.0.min.js"></script>
    <?php
    $start = new DateTime(\App\Models\Timer::all()->first()->starts_at);
    $end = new DateTime(\App\Models\Timer::all()->first()->ends_at);
    $today = new DateTime();
    ?>
    <script>
        $(document).ready(function() {
            $('.countdown').final_countdown({
                'start': {{$start->getTimestamp()}},
                'end': {{$end->getTimestamp()}},
                'now': {{$today->getTimestamp()}}
            }, function() {
                // Finish Callback
                window.location = "/home";
            });
        });
    </script>
@endsection