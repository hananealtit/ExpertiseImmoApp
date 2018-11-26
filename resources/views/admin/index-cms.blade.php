@extends('app')
@section('title','')
@section('css')
    <style>
        td{
            text-align: center;
            height: 150px;
            line-height: 150px;
            width: 200px;
            background: #ebebeb;
        }
        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            height: 300px;
            justify-content: center;
            align-items: center;
        }
        .flex-container > div {
            width: 400px;
            margin: 10px;
            text-align: center;
            line-height: 75px;
            font-size: 30px;
        }
        a:hover{

            text-decoration:none ;

        }
        .btn.btn-outline-success:hover a{
            color:#FFFFFF;
        }
    </style>
@endsection
@section('body')

    <div class="col-md-8 offset-md-2 flex-container" >

               <div class="btn btn-outline-success"> <span><a href="{{route('dossier.manage_report',$id)}}">مقتضيات تصميم التهيئة</a></span></div>
               <div class="btn btn-outline-success"><span><a href="{{route('dossier.addImg_immo',$id)}}">محيط العقار</a></span></div>

    </div>
@endsection
@section('js')
@endsection