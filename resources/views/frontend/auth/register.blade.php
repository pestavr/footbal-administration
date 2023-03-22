@extends('frontend.layouts.app')

@section('title', app_name() . ' | Register')

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('labels.frontend.auth.register_box_title') }} Διαιτητή </div>

                <div class="panel-body">

                    {{ Form::open(['route' => 'frontend.auth.register.post', 'class' => 'form-horizontal']) }}

                    <div class="form-group">
                        {{ Form::label('first_name', trans('Όνομα'),
                        ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('first_name', null,
                            ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => trans('Όνομα')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ Form::label('last_name', trans('Επώνυμο'),
                        ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('last_name', null,
                            ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'placeholder' => trans('Επώνυμο')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ Form::label('mobile', trans('Κινητό Τηλέφωνο'), ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::text('mobile', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'placeholder' => trans('Κινητό Τηλέφωνο')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ Form::label('email', trans('Διεύθυνση Email'), ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::email('email', null, ['class' => 'form-control', 'maxlength' => '191', 'required' => 'required', 'placeholder' => trans('Διεύθυνση Email')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ Form::label('password', trans('Κωδικός'), ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::password('password', ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('Κωδικός')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ Form::label('password_confirmation', trans('Επιβεβαίωση Κωδικού'), ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-6">
                            {{ Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('Επιβεβαίωση Κωδικού')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    @if (config('access.captcha.registration'))
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::captcha() !!}
                                {{ Form::hidden('captcha_status', 'true') }}
                            </div><!--col-md-6-->
                        </div><!--form-group-->
                    @endif

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{ Form::submit(trans('labels.frontend.auth.register_button'), ['class' => 'btn btn-primary']) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    {{ Form::close() }}

                </div><!-- panel body -->

            </div><!-- panel -->

        </div><!-- col-md-8 -->

    </div><!-- row -->
@endsection

@section('after-scripts')
    @if (config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif
@endsection