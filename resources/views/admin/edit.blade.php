@extends('app')
@section('title','edit')
@section('css')
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection
@section('body')

    <div class="offset-md-2">
       {{Form::model($jugement,['method'=>'put','url'=>route('dossier.update',$jugement->num_jugement)])}}
        {{--<div class="form-group">--}}
            {{--<dl class="row">--}}
                {{--<dt class="col-sm-8">{{Form::text('dossiers_num_dossier',null,['class'=>'form-control'])}}</dt>--}}
                {{--<dd class="col-sm-4">{{Form::label('dossiers_num_dossier',': ملف رقم')}}</dd>--}}
            {{--</dl>--}}
        {{--</div>--}}
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('nom_juge',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('nom_juge',': القاضي المقرر ')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('date_arrivee',null,['class'=>'form-control','id'=>'date'])}}</dt>
                <dd class="col-sm-4"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> {{Form::label('date_arrivee',': تاريخ التوصل')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('duree_jugement',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('duree_jugement',': المدة ')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('date_convocation',$convocation->date_convocation,['class'=>'form-control','id'=>'datepicker','data-date-format','dd/mm/yyyy'])}}</dt>
                <dd class="col-sm-4"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> {{Form::label('date_convocation',': تاريخ الخبرة')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('date_depot',null,['class'=>'form-control','id'=>'datepicker1','data-date-format','dd/mm/yyyy'])}}</dt>
                <dd class="col-sm-4"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> {{Form::label('date_depot',': تاريخ الايداع')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('prix_expertise',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('prix_expertise',': مصروف الخبرة  ')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('duree_prolongement',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('duree_prolongement',': طلب التمديد')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('declaration',null,['class'=>'form-control','id'=>'datepicker2','data-date-format','dd/mm/yyyy'])}}</dt>
                <dd class="col-sm-4"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> {{Form::label('declaration',': بيان اخباري')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('date_repanse',null,['class'=>'form-control','id'=>'datepicker3','data-date-format','dd/mm/yyyy'])}}</dt>
                <dd class="col-sm-4"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> {{Form::label('date_repanse',': الجواب على البيان الاخباري')}}</dd>
            </dl>
        </div>
        <div class="form-group">
            <dl class="row">
                <dt class="col-sm-8" dir="rtl"><select class="form-control col-sm-4" name="personnels_id_personnel">
                        <option></option>
                        @foreach($personnel as $k=>$value)
                            <option value="{{$k}}" <?php if($id_personnel->id_personnel==$k){ echo 'selected'; } ?>>{{$value}}</option>
                        @endforeach
                    </select></dt>
                <dd class="col-sm-4">{{Form::label('personnels_id_personnel',': المسؤل عن الملف  ')}}</dd>
            </dl>
        </div>
        <div class="form-group col-md-8" >
            <button type="submit" class="btn btn-success btn-block btn-lg">تسجيل</button>
        </div>
        {{Form::close()}}
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://jqueryui.com/resources/demos/datepicker/i18n/datepicker-fr.js"></script>
    <script>
        $("#datepicker").datepicker({

        });$("#datepicker1").datepicker({

        });$("#datepicker2").datepicker({

        });$("#datepicker3").datepicker({

        });
        $("#date").datepicker({

        });
    </script>
@endsection