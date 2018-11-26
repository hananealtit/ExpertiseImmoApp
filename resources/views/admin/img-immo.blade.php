@extends('app')
@section('title','ماهية الحكم')
@section('css')
    <style>
        .flex-container {
            display: flex;
            height: 400px;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection
@section('body')
    <div class="col-md-8 offset-md-2 flex-container" style="border-bottom: 1px solid #c8c8c8;border-right:1px solid #c8c8c8 ;box-shadow:  5px 10px 18px #888888;">
        <form action="{{route('dossier.addImg_immo_add',$id)}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col-md-8" style="float:left;">
                <div class="form-group col-md-12">
                    <dl class="row">
                        <dt class="col-sm-8">{{Form::select('num_immo',$immobiliers,null,['class'=>'form-control'])}}</dt>
                        <dd class="col-sm-4">{{Form::label('num_immo',': العقار  ')}}</dd>
                    </dl>
                </div>
                <table class="table">
                    <tr>
                        <td>
                            {{Form::label('name','الصورة ')}}
                            {{Form::file('name')}}
                        </td>
                    </tr>
                </table>
                <br><br>
                <div class="form-group" >
                    <button class="btn btn-success "><i class="fa fa-plus fa-lg"></i></button>

                </div>
            </div>

        </form>
    </div>
@endsection
@section('js')
@endsection