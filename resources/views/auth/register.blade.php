@extends('app')

@section('body')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-4">
            <div class="panel panel-default">
                <div class="panel-heading offset-md-2">إنشاء حساب جديد</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('genre') ? ' text-error' : '' }}">
                            <label for="genre" class="col-md-4 control-label">رجل/امرأة</label>

                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-8">{{Form::select('genre',['M'=>'رجل','F'=>'امرأة'],null,['class'=>'form-control','value'=> old('genre'),'id'=>'genre'])}}</dt>
                                    <dd class="col-sm-4"></dd>
                                </dl>
                                @if ($errors->has('genre'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('genre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">الاسم</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">البريد الإلكتروني</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('tel_personnel') ? ' has-error' : '' }}">
                            <label for="tel_personnel" class="col-md-4 control-label">الهاتف</label>

                            <div class="col-md-6">
                                <input id="tel_personnel" type="text" class="form-control" name="tel_personnel" value="{{ old('tel_personnel') }}" required>

                                @if ($errors->has('tel_personnel'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tel_personnel') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('adresse') ? ' text-error' : '' }}">
                            <label for="adresse" class="col-md-4 control-label">العنوان</label>

                            <div class="col-md-6">
                                <input id="adresse" type="text" class="form-control" name="adresse" value="{{ old('adresse') }}" required>

                                @if ($errors->has('adresse'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('adresse') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('fonction') ? ' text-error' : '' }}">
                            <label for="fonction" class="col-md-4 control-label">الوظيفة</label>

                            <div class="col-md-6">
                                <input id="fonction" type="text" class="form-control" name="fonction" value="{{ old('fonction') }}" required>

                                @if ($errors->has('fonction'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fonction') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' text-danger' : '' }}">
                            <label for="password" class="col-md-4 control-label">كلمة السر الجديدة</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">تأكيد كلمة السر</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    إنشاء حساب
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
