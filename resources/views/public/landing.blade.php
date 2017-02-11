@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="css/landing-page.css">
@endsection

@section('content')
<div class="countdown countdown-container container"
     data-start="1"
     data-end="2000"
     data-now="4">
    <div class="clock row">

    	<div class="clock-item clock-seconds countdown-time-value col-sm-6 col-md-3">
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

        <div class="clock-item clock-minutes countdown-time-value col-sm-6 col-md-3">
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

        <div class="clock-item clock-hours countdown-time-value col-sm-6 col-md-3">
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

        <div class="clock-item clock-days countdown-time-value col-sm-6 col-md-3">
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
@endsection

@section('js')
	<script src="js/jquery.final-countdown.min.js"></script>
	<script src="js/kinetic-v5.1.0.min.js"></script>
    <?php
    $d = new DateTime(\App\Models\Timer::all()->first()->starts_at);
    $today = new DateTime();
    ?>
	<script>
		$(document).ready(function() {
	        $('.countdown').final_countdown({
                'start': 0,
                'end': {{$d->getTimestamp()}},
                'now': {{$today->getTimestamp()}}
	        }, function() {
                // Finish Callback
                window.location = "/home";
            });
		});
	</script>
@endsection