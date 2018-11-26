@extends('app')
@section('title','إدارة العاملين')
@section('css')
@endsection
@section('body')
    <div class="col-md-10 offset-md-1" style="border-bottom: 1px solid #c8c8c8;border-right:1px solid #c8c8c8 ;box-shadow:  5px 10px 18px #888888;padding-top: 1%; ">
        {{Form::model($avocat,['method'=>'put','url'=>route('avocat.update',$avocat->id_avocat)])}}

         <div class="row">
             <div class="form-group col-md-4">
                 <dl class="row">
                     <dt class="col-sm-8">{{Form::select('genre',['M'=>'رجل','F'=>'امرأة'],null,['class'=>'form-control'])}}</dt>
                     <dd class="col-sm-4">{{Form::label('genre',': رجل/امرأة  ')}}</dd>
                 </dl>
             </div>
        <div class="form-group col-md-6">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('nom_avocat',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('nom_avocat',':الاسم الكامل')}}</dd>
            </dl>
        </div>
        </div>
       <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('adresse_avocat',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('adresse_avocat',':العنوان')}}</dd>
            </dl>
        </div><div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('ville',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('ville',':المدينة')}}</dd>
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