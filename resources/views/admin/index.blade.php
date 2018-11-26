@extends('app')
@section('css')

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection
@section('body')

<div class="offset-md-2">
    {{Form::open(['url'=>route('convocation.store')])}}
    <div class="form-group">
        <dl class="row">
            <dt class="col-sm-8">{{Form::text('dossier_num_dossier',null,['class'=>'form-control'])}}</dt>
            <dd class="col-sm-4">{{Form::label('dossier_num_dossier',': ملف رقم')}}</dd>
        </dl>
    </div>
    <div class="form-group">
        <dl class="row">
            <dt class="col-sm-8">{{Form::text('num_jugement',null,['class'=>'form-control'])}}</dt>
            <dd class="col-sm-4">{{Form::label('num_jugement',': حكم العدد')}}</dd>
        </dl>
    </div>
    <div class="form-group">
        <dl class="row">
            <dt class="col-sm-8">{{Form::text('date_jugement',null,['class'=>'form-control','id'=>'datepicker','data-date-format','dd/mm/yyyy'])}}</dt>
            <dd class="col-sm-4"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> {{Form::label('date_jugement',': بتاريخ')}}</dd>
        </dl>
    </div>
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
            <dt class="col-sm-8">{{Form::text('prix_expertise',null,['class'=>'form-control'])}}</dt>
            <dd class="col-sm-4">{{Form::label('prix_expertise',': مصروف الخبرة  ')}}</dd>
        </dl>
    </div>
    <div class="form-group">
        <dl class="row">
            <dt class="col-sm-8" dir='rtl'>{{Form::select('tribunals_id_tribunal',$tribunal,null,['class'=>'form-control col-sm-4'])}}</dt>
            <dd class="col-sm-4">{{Form::label('tribunals_id_tribunal',':محكمة  ')}}</dd>
        </dl>
    </div>
    <div class="form-group">
        <dl class="row">
            <dt class="col-sm-8" dir='rtl'>{{Form::select('ville_tribunal',$ville,null,['class'=>'form-control col-sm-4'])}}</dt>
            <dd class="col-sm-4">{{Form::label('ville_tribunal',':مدينة  ')}}</dd>
        </dl>
    </div>
    <div class="form-group">
        <dl class="row">
            <dt class="col-sm-8" dir='rtl'>{{Form::select('personnels_id_personnel',$personnel,null,['class'=>'form-control col-sm-4'])}}</dt>
            <dd class="col-sm-4">{{Form::label('personnels_id_personnel',': المسؤل عن الملف  ')}}</dd>
        </dl>
    </div>
<div class="form-group offset-md-4">
    <button type="reset" class="btn btn-info btn-lg" >تفريغ</button>
    <button type="submit" class="btn btn-danger btn-lg">تسجيل</button>
</div>
{{Form::close()}}
</div>
@endsection
@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://jqueryui.com/resources/demos/datepicker/i18n/datepicker-fr.js"></script>
    <script>


        $("#datepicker").datepicker({

        });
        $("#date").datepicker({

        });
    </script>
@endsection