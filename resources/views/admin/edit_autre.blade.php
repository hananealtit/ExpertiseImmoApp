@extends('app')
@section('title','')
@section('css')
@endsection
@section('body')
    <div class="col-md-10 offset-md-1" style="border-bottom: 1px solid #c8c8c8;border-right:1px solid #c8c8c8 ;box-shadow:  5px 10px 18px #888888;padding-top: 1%; ">
        {{Form::model($autre,['method'=>'put','url'=>route('autre.update',$autre->id_autre)])}}

         <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('description_autre',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('description_autre',':المحافظ')}}</dd>
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