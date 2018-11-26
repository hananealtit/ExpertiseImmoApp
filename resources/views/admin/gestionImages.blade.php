@extends('app')
@section('title','إدارة الصور')
@section('css')
@endsection
@section('body')
    <div class="col-md-8 offset-md-2">
        {{Form::open(['route'=>'immobiliers.imagesAdd','files'=>true])}}
    <div class="form-group" dir="rtl">
        {{ Form::label('description_autre','  العقارات :') }}
        <select name="num_immobilier" class="form-control">
            @foreach($immobiliers as $immobilier)
                <option value="{{$immobilier->num_immobilier}}">{{$immobilier->num_immobilier}}</option>
            @endforeach
        </select>
    </div>

        <div class="col-md-4" style="float:left;">
            {{Form::label('image_satellite','صورة القمر الصناعي')}}
            {{Form::file('image_satellite')}}
        </div>
        <div class="col-md-4" style="float:right;">
            {{Form::label('image_map','صورة الخريطة')}}
            {{Form::file('image_map')}}
        </div>
        <br>
        <br>
        <br> <br>
        <br>
        <br> <br>

        <div class="form-group"  style="clear:both; text-align: center">
            <button  class="btn btn-outline-primary btn-lg" ><i class="fa fa-plus" style="margin: 0%;"></i></button>

        </div>
        {{Form::close()}}
    </div>
@endsection
@section('js')
@endsection