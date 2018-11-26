
@extends('app')
@section('title','إدارة ')
@section('css')
    <style>
        th{
            text-align: center;
        }
        td{
            text-align: center;
        }
    </style>
@endsection
@section('body')
    <div class="col-md-8 offset-md-2">
        <h3 class="col-md-12" style="background: #f3f3f3;padding-left: 55%;">إدارة الاطراف  > الاطراف المدعى عليها  &nbsp;   <i class="fa fa-address-card" aria-hidden="true"></i></h3>

    </div>

    <br>
    <div class="col-md-8 offset-md-2">
    <table class="table">
        <thead>
        <th> الملف</th>
        <th>رقم </th>
        </thead>
        <tbody>
         @foreach($dossiers as $k=>$dossier)
             <?php $k++;?>
             <tr>
                 <td>
                <a href="{{route('defendeur.administration',$dossier->num_dossier)}}">{{$dossier->num_dossier}}</a>
                 </td>
                 <td>{{$k}}</td>
             </tr>
         @endforeach
        </tbody>
    </table>

    </div>
    <div class="navigation col-sm-6 offset-md-5">
        {{$dossiers->links('vendor.pagination.bootstrap-4')}}
    </div>
@endsection
@section('js')
@endsection