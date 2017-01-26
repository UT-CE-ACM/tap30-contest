@extends('layouts.app')

@section('content')
<div class="container">
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
                    <p>{{ $problem->description }}</p>
                    @foreach($problem->samples as $sample)
                        <hr>
نمونه ی ورودی {{ $loop->iteration }}
                        <pre>{{ $sample->input }}</pre>
نمونه خروجی {{ $loop->iteration }}
                        <pre>{{ $sample->output }}</pre>
                        @if($sample->attachment)
                            <span>فایل پیوست :
                                <a href="{{ $sample->attachment->getPath() }}">{{ $sample->attachment->real_name }}</a>
                            </span>
                        @endif
                    @endforeach
                    <?php $submit = Auth::user()->submits()->with('attachment')->whereProblemId($problem->id)->first() ?>
                    @if($submit)
                        <div>
                            <span>فایل آپلودی:</span>
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
                            <span>زبان: {{ \App\Models\Submit::$langs[$submit->lang]  }}</span>
                        </div>
                    @else
                        {{ Form::open(array('url'=>"/problem/".$problem->id."/submit", 'files' => true, 'class' => 'form-horizontal')) }}
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
