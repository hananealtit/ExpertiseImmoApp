@extends('app')
@section('title','إدارة العاملين')
@section('css')
    <style>
        .bubble{
            animation: animateElement linear .3s;
            animation-iteration-count: 1;
            background:#e7e7e7;
            margin-bottom:5px;
            width:100%;
            min-height:30px;
            border-radius:10px;
            padding-left: 6%;
            padding-top: 2%;
            padding-bottom: 2%;
        }
        #form_av
        {
            margin:20px;

        }
        @keyframes animateElement{
            0% {
                opacity:0;
                transform:  translate(0px,10px);
            }
            100% {
                opacity:1;
                transform:  translate(0px,0px);
            }
        }
        #add_av{
            margin-left: 20%;
            display: none;
            color: blue;
            cursor: pointer;
        }
        #plus{
            cursor: pointer;
            color: blue;
            width: 1%;
            display: none;
        }
    </style>
@endsection
@section('body')
    <div class="col-md-10 offset-md-1" style="border-bottom: 1px solid #c8c8c8;border-right:1px solid #c8c8c8 ;box-shadow:  5px 10px 18px #888888;padding-top: 1%; ">
        {{Form::open(['route'=>'procureur.create_procureur'])}}
        <div class="form-group col-md-4">
        <dl class="row">
        <dt class="col-sm-8">{{Form::select('genre',['false'=>'رجل','true'=>'امرأة'],null,['class'=>'form-control'])}}</dt>
        <dd class="col-sm-4">{{Form::label('genre',': رجل/امرأة  ')}}</dd>
        </dl>
        </div>
         <div class="row">
        <div class="form-group col-md-6">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('nom_procureur',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('nom_procureur',':الاسم الكامل')}}</dd>
            </dl>
        </div><div class="form-group col-md-6">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('adresse_procureur',null,['class'=>'form-control'])}}</dt>
                <dd class="col-sm-4">{{Form::label('adresse_procureur',':العنوان')}}</dd>
            </dl>
        </div>
        </div>
        {{--<div class="form-group col-md-6" style="margin-left: -1.2%;">--}}
            {{--<dl class="row">--}}
                {{--<dt class="col-sm-8">{{Form::text('nbr_avocat',null,['class'=>'form-control'])}}</dt>--}}
                {{--<dd class="col-sm-4">{{Form::label('nbr_avocat',':عدد المحامون')}}</dd>--}}
            {{--</dl>--}}
        {{--</div>--}}
        <div class="form-group col-md-6" style="margin-left: 14.2%;">
            <dl class="row">
                <dt class="col-sm-2">{{Form::radio('isavocat','نعم',false,['id'=>'yes'])}}&nbsp;{{Form::label('isavocat',': نعم')}}&nbsp;&nbsp;&nbsp;&nbsp;{{Form::radio('isavocat','لا',false,['id'=>'no'])}}&nbsp;{{Form::label('isavocat',': لا')}}</dt>
                <dd class="col-sm-2">{{Form::label('isavocat',': المحامون')}}</dd>
            </dl>
        </div>
        <span id="plus"><i class="fa fa-plus"></i></span>
        <div class="offset-md-9 alert alert-info" style="margin-right: 5%;margin-top: -5%;">
            <a style="cursor:pointer;color:blue;padding-left: 20%; " id="av_exist">تمت إضافة المحامي</a>
        </div>
        <div id="form_av" ></div>
        <span id="add_av">إضافة محام آخر</span>

       {{Form::hidden('num_dossier',$id)}}
        <div class="form-group offset-md-7">
            <button class="btn btn-success">تسجيل</button>
        </div>
    </div>

    {{Form::close()}}
@endsection
@section('js')
    <script>
        $(function () {
            $('#yes').on('click',function () {
                $('.av_f').remove();
                $('#plus').fadeOut()

                $('#form_av').addClass('col-md-6').append('<div class="bubble"><a class="close_span" style="margin-left:110%;cursor:pointer;" ><i class="fa fa-times fa-lg" ></i></a><div class="form-group offset-md-1">' +
                    '<dl class="row">' +
                    '{{Form::select('genre_p[]',['M'=>'رجل','F'=>'امرأة'],null,['class'=>'form-control col-md-6'])}}' +
                    '&nbsp;&nbsp;&nbsp;&nbsp;{{Form::label('genre',': رجل/امرأة  ')}}' +
                    '</dl>' +
                    ' </div>' +
                    ' <div class="form-group">' +
                    '<dl class="row">' +
                    '<dt class="col-sm-8">{{Form::text('nom_avocat[]',null,['class'=>'form-control','id'=>'nom_avocat.0'])}}</dt>' +
                    '<dd class="col-sm-4">{{Form::label('nom_avocat',':الإسم الكامل ')}}</dd>'+
                    '</dl>'+
                    '</div>'+
                    '<div class="form-group">'+
                    ' <dl class="row">'+
                    ' <dt class="col-sm-8">{{Form::textarea('adresse_avocat[]',null,['class'=>'form-control','id'=>'adresse_avocat.0'])}}</dt>'+
                    '<dd class="col-sm-4">{{Form::label('adresse_avocat',':العنوان ')}}</dd>'+
                    '</dl>'+
                    '</div>'+
                    ' <div class="form-group">'+
                    '<dl class="row">'+
                    '<dt class="col-sm-8">{{Form::text('ville_avocat[]',null,['class'=>'form-control','id'=>'ville_avocat.0'])}}</dt>'+
                    '<dd class="col-sm-4">{{Form::label('ville_avocat',':المدينة ')}}</dd>'+
                    '</dl>'+
                    '</div>'+
                     '</div>');
                    $('#add_av').css({'display':'block'})
                $('.close_span').on('click',function () {
                    var $this=$(this)
                    $this.parent().remove()


                })

            })

            $('#no').on('click',function () {
                $('#form_av').html('')
                $('#add_av').css({'display':'none'})
//                $('#av_fild').fadeOut()
                $('#av_fild').val('')
                 $('.av_f').remove();
                $('#plus').fadeOut()

            })

            $('#add_av').on('click',function () {

                $('#form_av').addClass('col-md-6').append('<div class="bubble"><a class="close_span" style="margin-left:110%;cursor:pointer;" ><i class="fa fa-times fa-lg" ></i></a><div class="form-group offset-md-1">' +
                    '<dl class="row">' +
                    '{{Form::select('genre_p[]',['M'=>'رجل','F'=>'امرأة'],null,['class'=>'form-control col-md-6'])}}' +
                    '&nbsp;&nbsp;&nbsp;&nbsp;{{Form::label('genre',': رجل/امرأة  ')}}' +
                    '</dl>' +
                    ' </div>' +
                    ' <div class="form-group">' +
                    '<dl class="row">' +
                    '<dt class="col-sm-8">{{Form::text('nom_avocat[]',null,['class'=>'form-control','id'=>'nom_av'])}}</dt>' +
                    '<dd class="col-sm-4">{{Form::label('nom_avocat',':الإسم الكامل ')}}</dd>'+
                    '</dl>'+
                    '</div>'+
                    '<div class="form-group">'+
                    ' <dl class="row">'+
                    ' <dt class="col-sm-8">{{Form::textarea('adresse_avocat[]',null,['class'=>'form-control','id'=>'adresse_av'])}}</dt>'+
                    '<dd class="col-sm-4">{{Form::label('adresse_avocat',':العنوان ')}}</dd>'+
                    '</dl>'+
                    '</div>'+
                    ' <div class="form-group">'+
                    '<dl class="row">'+
                    '<dt class="col-sm-8">{{Form::text('ville_avocat[]',null,['class'=>'form-control','id'=>'ville_av'])}}</dt>'+
                    '<dd class="col-sm-4">{{Form::label('ville_avocat',':المدينة ')}}</dd>'+
                    '</dl>'+
                    '</div>'+
                    '</div>');
                $('.close_span').on('click',function () {
                    var $this=$(this)
                    $this.parent().remove()


                })

            });

            $('#av_exist').on('click',function () {
                $(this).parent().append('{{Form::select('av_list[]',$avocat,null,['class'=>'form-control av_f'])}}')
                $('#form_av').html('')
                $('#add_av').css({'display':'none'})
                $('#plus').css({'margin-left':'72%'}).fadeIn()
                var id_radio = document.getElementById('yes');
                var id_radio1 = document.getElementById('no');
                id_radio.checked =false;
                id_radio1.checked =false;

            })
            $('#plus').on('click',function () {
                var $this=$(this)
                console.log($this)
                $this.next('div').append('{{Form::select('av_list[]',$avocat,null,['class'=>'form-control av_f'])}}')
                $('.av_f').fadeIn()
            })

        });
    </script>
@endsection