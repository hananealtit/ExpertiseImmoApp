@extends('app')
@section('title','إدارة العاملين')
@section('css')
@endsection
@section('body')
    <div class="col-md-10 offset-md-1" style="border-bottom: 1px solid #c8c8c8;border-right:1px solid #c8c8c8 ;box-shadow:  5px 10px 18px #888888;padding-top: 1%; ">
        {{Form::model($personnel,['method'=>'put','url'=>route('personnel.update',$personnel->id_personnel)])}}
        <div class="form-group col-md-4">
        <dl class="row">
        <dt class="col-sm-8">{{Form::select('genre',['M'=>'رجل','F'=>'امرأة'],null,['class'=>'form-control'])}}</dt>
        <dd class="col-sm-4">{{Form::label('genre',': رجل/امرأة  ')}}</dd>
        </dl>
        </div>
         <div class="row">
        <div class="form-group col-md-6">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('name',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('name',':الاسم الكامل')}}</dd>
            </dl>
        </div><div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('tel_personnel',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('tel_personnel',':الهاتف')}}</dd>
            </dl>
        </div>
        </div>
        <div class="form-group col-md-6" style="margin-left: -1.2%;">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('email',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('email',':البريد الإلكتروني')}}</dd>
            </dl>
        </div><div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('adresse',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('adresse',':العنوان')}}</dd>
            </dl>
        </div><div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('fonction',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('fonction',':المهمة')}}</dd>
            </dl>
        </div>
        <div class="form-group offset-md-7">
            <button class="btn btn-outline-primary">تسجيل</button>
        </div>
    </div>

    {{Form::close()}}
@endsection
@section('js')
@endsection