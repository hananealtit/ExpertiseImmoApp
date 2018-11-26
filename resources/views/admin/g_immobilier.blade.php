
@extends('app')
@section('title','إدارة نسب التملك')
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
    <div class="col-md-8 offset-md-5">
        <h4 style="color:grey;">إدارة نسب التملك</h4>
    </div>
    <hr>
    <br>
    <div class="col-md-8 offset-md-2">
    <table class="table">
        <thead>
        <th>العقار</th>
        <th>رقم الملف</th>
        </thead>
        <tbody>
         @foreach($a as $k=>$vs)
             <tr>
                 <td>
                     <table class="table table-striped">
                         @foreach($vs as $v)
                         <tr><td><a href="{{route('immobiliers.pourcentagePropriete',[$v,$k])}}">{{$v}}</a></td></tr>
                         @endforeach
                     </table>
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