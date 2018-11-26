@extends('app')
@section('title','إدارة العاملين')
@section('css')
@endsection
@section('body')
    <div class="col-md-10 offset-md-1" style="border-bottom: 1px solid #c8c8c8;border-right:1px solid #c8c8c8 ;box-shadow:  5px 10px 18px #888888;padding-top: 1%; ">
        {{Form::model($procureur,['method'=>'put','url'=>route('procureur.update',$procureur->id_procureur)])}}

         <div class="row">
             <div class="form-group col-md-4">
                 <dl class="row">
                     <dt class="col-sm-8">{{Form::select('genre',['M'=>'رجل','F'=>'امرأة'],null,['class'=>'form-control'])}}</dt>
                     <dd class="col-sm-4">{{Form::label('genre',': رجل/امرأة  ')}}</dd>
                 </dl>
             </div>
            <div class="form-group col-md-6">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('nom_procureur',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('nom_procureur',':الاسم الكامل')}}</dd>
            </dl>
        </div>
        </div>
       <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('adresse_procureur',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('adresse_procureur',':العنوان')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('nbr_avocat',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('nbr_avocat',':عدد المحامون')}}</dd>
            </dl>
        </div>
            <div class="form-group col-md-4">
                <dl class="row">
                    <dt class="col-sm-8">{{Form::select('present',['0'=>'لا','1'=>'نعم'],null,['class'=>'form-control'])}}</dt>
                    <dd class="col-sm-4">{{Form::label('present',': الحضور  ')}}</dd>
                </dl>
            </div>
        {{Form::hidden('num_dossier',$d)}}
        <div class="form-group offset-md-7">
            <button class="btn btn-outline-primary">تسجيل</button>
        </div>
    </div>

    {{Form::close()}}
@endsection
@section('js')
@endsection