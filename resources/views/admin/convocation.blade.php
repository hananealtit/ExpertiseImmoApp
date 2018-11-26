@extends('app')
@section('title','Convocation')
@section('css')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=b1kbqbjdc49caon3ft5tmqlrda6d4v0ovlqz8s8n5zrqvftd"></script>
    <script>
        tinymce.init({
            selector:'textarea',
            menubar:true,
            themes: "modern",
            entity_encoding: 'raw',
            entities: '160,nbsp,38,amp,60,lt,62,gt',
            plugins: "directionality",
            toolbar: "rtl"

        });
    </script>
    <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

        @keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

        /* The Close Button */
        .close {
            color: gray;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }



        #label{
            margin-left:80px;
        }
        body{
            background: #ebebeb;
        }
        .row#color_white{
            border:1px solid #ccc;
            border-radius: 4px;
            box-shadow: 1px 2px 2px rgba(0,0,0,.1);
        }
        .buttonload {
            background-color: #4CAF50; /* Green background */
            border: none; /* Remove borders */
            color: white; /* White text */
            padding: 12px 24px; /* Some padding */
            font-size: 16px; /* Set a font-size */
        }

        /* Add a right margin to each icon */
        .fa {
            margin-left: -12px;
            margin-right: 8px;
        }
        .tooltip-inner {
            background-color: forestgreen !important;
            /*!important is not necessary if you place custom.css at the end of your css calls. For the purpose of this demo, it seems to be required in SO snippet*/
            color: #fff;
            opacity: 90;
        }

        .tooltip.top .tooltip-arrow {
            border-top-color: #00acd6;
        }

        .tooltip.right .tooltip-arrow {
            border-right-color: #00acd6;
        }

        .tooltip.bottom .tooltip-arrow {
            border-bottom-color: #00acd6;
        }

        .tooltip.left .tooltip-arrow {
            border-left-color: #00acd6;
        }
        .hide{
            display:none;
        }
        #btn33{
            cursor: pointer;
        }#btn44{
            cursor: pointer;
        }
    </style>
@endsection
@section('body')

    <div class="message"></div>
    <div class="modal"  id="myModal1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel" style="margin-left:40%;background:#2a4151;color:white;padding:5px;border-radius: 5px;"><span id="numero2"></span>&nbsp;الاطراف المدعية رقم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close3">&times;</span>
                    </button>
                </div>
                {{Form::open(['url'=>route('procureur.store'),'id'=>'formRegister2'])}}
                <div class="modal-body">
                    <div class="msg1" dir="rtl"></div>
                    <div class="row  offset-sm-2">
                        <div class="form-group">
                            <dl class="row">
                                <label class="radio-inline">
                                    <input type="radio"  value="true" name="genre">أنثى</label>
                                &nbsp;&nbsp;
                                <label class="radio-inline">
                                    <input type="radio"  value="false" name="genre">ذكر</label>
                            </dl>
                        </div>
                    </div>
                    <div class="row col-md-10 offset-sm-1">
                        <div class="form-group">
                            <dl class="row">
                                <dt class="col-sm-8">{{Form::text('nom_procureur',null,['class'=>'form-control','id'=>'nom_p'])}}</dt>
                                <dd class="col-sm-4">{{Form::label('nom_procureur',':الإسم الكامل ')}}</dd>
                            </dl>
                        </div>
                        <div class="form-group">
                            <dl class="row">
                                <dt class="col-sm-8">{{Form::textarea('adresse_procureur',null,['class'=>'form-control','id'=>'adresse_p'])}}</dt>
                                <dd class="col-sm-4">{{Form::label('adresse_procureur',':العنوان ')}}</dd>
                            </dl>
                        </div>

                    </div>
                    <div class="row offset-md-2">
                        <div class="form-group">
                            <dl class="row">
                                <dt class="col-sm-5">{{Form::text('nbr_avocat',null,['class'=>'form-control','style'=>'width:154.83px','id'=>'nb'])}}</dt>
                                <dd class="col-sm-7">{{Form::label('nbr_avocat',':عدد المحامين  ',['id'=>'label'])}}</dd>
                            </dl>
                            <a class="buttonload" data-toggle="modal" data-target="" id="btn33">
                                <i class=""></i>تأكيد
                            </a>
                        </div>
                    </div>
                    <div class="row offset-md-2" id="nbav">

                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::hidden('num_jugement',$jugement->num_jugement)}}
                    {{Form::hidden('num_dossier',$jugement->dossiers_num_dossier)}}
                    {{Form::hidden('num_idtribunal',$jugement->tribunals_id_tribunal)}}
                    <button type="reset" class="btn btn-info b close4" >أغلق</button>
                    <button type="submit" class="btn btn-danger b"  id="next">سجل</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
    <div class="modal"  id="myModal5">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel" style="margin-left:40%;background:#2a4151;color:white;padding:5px;border-radius: 5px;"><span id="numero1"></span>&nbsp;المحامين رقم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="closeav5">&times;</span>
                    </button>
                </div>
                {{Form::open(['url'=>route('avocat.store'),'id'=>'formRegisterav'])}}
                <div class="modal-body">
                    <div class="msg5" dir="rtl"></div>
                    <div class="row offset-sm-2">
                        <div class="form-group">
                            <dl class="row">
                                <label class="radio-inline">
                                    <input type="radio"  value="true" name="genre">أنثى</label>
                                &nbsp;&nbsp;
                                <label class="radio-inline">
                                    <input type="radio"  value="false" name="genre">ذكر</label>
                            </dl>
                        </div>
                    </div>
                    <div class="row col-md-10 offset-sm-1">
                        <div class="form-group">
                            <dl class="row">
                                <dt class="col-sm-8">{{Form::text('nom_avocat',null,['class'=>'form-control','id'=>'nom_av'])}}</dt>
                                <dd class="col-sm-4">{{Form::label('nom_avocat',':الإسم الكامل ')}}</dd>
                            </dl>
                        </div>
                        <div class="form-group">
                            <dl class="row">
                                <dt class="col-sm-8">{{Form::textarea('adresse_avocat',null,['class'=>'form-control','id'=>'adresse_av'])}}</dt>
                                <dd class="col-sm-4">{{Form::label('adresse_avocat',':العنوان ')}}</dd>
                            </dl>
                        </div>
                        <div class="form-group">
                            <dl class="row">
                                <dt class="col-sm-8">{{Form::text('ville_avocat',null,['class'=>'form-control','id'=>'ville_av'])}}</dt>
                                <dd class="col-sm-4">{{Form::label('ville_avocat',':المدينة ')}}</dd>
                            </dl>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::hidden('num_jugement',$jugement->num_jugement)}}
                    {{Form::hidden('num_dossier',$jugement->dossiers_num_dossier)}}
                    {{Form::hidden('num_idtribunal',$jugement->tribunals_id_tribunal)}}
                    <button type="reset" class="btn btn-info b closeav6" >أغلق</button>
                    <button type="submit" class="btn btn-danger b"  id="nextav1">سجل</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
    <div class="modal" id="myModal3">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel" style="margin-left:40%;background:#2a4151;color:white;padding:5px;border-radius: 5px;"><span id="numero"></span>&nbsp;العقار رقم &nbsp;</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close1">&times;</span>
                    </button>
                </div>
                <form id="formRegister" class="form-horizontal" role="form" method="POST" action="{{ route('immobilier.store') }}">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <div class="msg" dir="rtl"></div>
                        <div class="row">
                            <div class="offset-md-2">
                                <div class="form-group">
                                    <dl class="row">
                                        <dt class="col-sm-8">{{Form::text('num_immobilier',null,['class'=>'form-control','id'=>'num_immo'])}}</dt>
                                        <dd class="col-sm-4">{{Form::label('num_immobilier',': الرسم العقاري   ')}}</dd>
                                    </dl>
                                </div>
                                <div class="form-group">
                                    <dl class="row">
                                        <dt class="col-sm-8">{{Form::text('designation_immobilier',null,['class'=>'form-control','id'=>'des_immo'])}}</dt>
                                        <dd class="col-sm-4">{{Form::label('designation_immobilier',': اسم العقار  ')}}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="col-sm-10 offset-md-1">
                                {{--<div class="form-group">--}}
                                {{--<dl class="row">--}}
                                {{--<dt class="col-sm-8">{{Form::select('designationr_nature',$nature,null,['class'=>'form-control'])}}</dt>--}}
                                {{--<dd class="col-sm-4">{{Form::label('designationr_nature',': طبيعة العقار  ')}}</dd>--}}
                                {{--</dl>--}}
                                {{--</div>--}}

                                <div class="form-group col-md-12">
                                    <dl class="row">
                                        <dt class="col-sm-8">{{Form::textarea('adresse_immobilier',null,['class'=>'form-control hanane','id'=>'ad_immo','placeholder'=>'مثال حي الأمل'])}}</dt>
                                        <dd class="col-sm-4">{{Form::label('adresse_immobilier',': العنوان  ')}}</dd>
                                    </dl>
                                </div>
                                <div class="form-group">
                                    <dl class="row">
                                        <dt class="col-sm-8">{{Form::text('ville_immobilier',null,['class'=>'form-control','id'=>'ville_immo','placeholder'=>'المدينة'])}}</dt>
                                        <dd class="col-sm-4">{{Form::label('ville_immobilier',': المدينة  ')}}</dd>
                                    </dl>
                                </div>
                                <div class="form-group">
                                    <dl class="row">
                                        <dt class="col-sm-8">{{Form::text('surface',null,['class'=>'form-control','id'=>'surface_immo'])}}</dt>
                                        <dd class="col-sm-4">{{Form::label('surface',': المساحة  ')}}</dd>
                                    </dl>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{Form::hidden('num_jugement',$jugement->num_jugement)}}
                        {{Form::hidden('num_dossier',$jugement->dossiers_num_dossier)}}
                        {{Form::hidden('num_idtribunal',$jugement->tribunals_id_tribunal)}}
                        <button type="reset" class="btn btn-info b close2">أغلق</button>
                        <button type="submit" class="btn btn-danger b" id="sui">سجل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="myModal4">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel" style="margin-left:40%;background:#2a4151;color:white;padding:5px;border-radius: 5px;"><span id="numero3"></span>&nbsp;الاطراف المدعى عليها رقم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close5">&times;</span>
                    </button>
                </div>
                {{Form::open(['url'=>route('defendeur.store'),'id'=>'formRegister3'])}}
                <div class="modal-body">
                    <div class="msg2" dir="rtl"></div>
                    <div class="row col-md-10 offset-sm-1">
                        <div class="form-group">
                            <dl class="row">
                                <label class="radio-inline">
                                    <input type="radio"  value="true" name="genre">أنثى</label>
                                &nbsp;&nbsp;
                                <label class="radio-inline">
                                    <input type="radio"  value="false" name="genre">ذكر</label>
                            </dl>
                        </div>
                    </div>
                    <div class="row offset-sm-2">
                        <div class="form-group">
                            <dl class="row">
                                <dt class="col-sm-8">{{Form::text('nom_defendeur',null,['class'=>'form-control','id'=>'nom_d'])}}</dt>
                                <dd class="col-sm-4">{{Form::label('nom_defendeur',':الإسم الكامل ')}}</dd>
                            </dl>
                        </div>
                        <div class="form-group">
                            <dl class="row">
                                <dt class="col-sm-8">{{Form::textarea('adresse_defendeur',null,['class'=>'form-control','id'=>'adresse_d'])}}</dt>
                                <dd class="col-sm-4">{{Form::label('adresse_defendeur',':العنوان ')}}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row offset-md-2">
                        <div class="form-group">
                            <dl class="row">
                                <dt class="col-sm-5">{{Form::text('nbr_avocat',null,['class'=>'form-control','style'=>'width:154.83px','id'=>'nbdav'])}}</dt>
                                <dd class="col-sm-7">{{Form::label('nbr_avocat',':عدد المحامين  ',['id'=>'label'])}}</dd>
                            </dl>
                            <a class="buttonload" data-toggle="modal" data-target="" id="btn44">
                                <i class=""></i>تأكيد
                            </a>
                        </div>
                    </div>
                    <div class="row offset-md-2" id="nbavc">

                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::hidden('num_jugement',$jugement->num_jugement)}}
                    {{Form::hidden('num_dossier',$jugement->dossiers_num_dossier)}}
                    {{Form::hidden('num_idtribunal',$jugement->tribunals_id_tribunal)}}
                    <button type="reset" class="btn btn-info b close6" data-dismiss="modal">أغلق</button>
                    <button type="submit" class="btn btn-danger b" id="suivant1">سجل</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
    <div class="modal" id="myModal6">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel" style="margin-left:40%;background:#2a4151;color:white;padding:5px;border-radius: 5px;"><span id="numero4"></span>&nbsp;الاطراف الأخرى رقم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close7">&times;</span>
                    </button>
                </div>
                {{Form::open(['url'=>route('autre.store'),'id'=>'formRegister4'])}}
                <div class="modal-body">
                    <div class="msg4" dir="rtl"></div>
                    <div class="row col-md-10 offset-md-1">
                        <div class="form-group col-md-12">
                            {{ Form::label('description_autre','الاطراف الأخرى') }}
                            {{ Form::textarea('description_autre',null,['placeholder'=>'','class'=>'form-control','row'=>'5','id'=>'texta']) }}
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    {{Form::hidden('num_jugement',$jugement->num_jugement)}}
                    {{Form::hidden('num_dossier',$jugement->dossiers_num_dossier)}}
                    {{Form::hidden('num_idtribunal',$jugement->tribunals_id_tribunal)}}
                    <button type="reset" class="btn btn-info b close8">أغلق</button>
                    <button type="submit" class="btn btn-danger b" id="suivant2">سجل</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
    {{Form::open(['url'=>route('jugement.saveNb'),'id'=>'nbinput'])}}
    <div class="row col-md-10 offset-md-1" id="color_white">
        <div class="list-group col-md-12 offset-md-1 row" style="margin-top:50px;margin-bottom: 50px;">
            <div class="list-group-item list-group-item-action col-md-4" id="list1">

                <div class="form-group" >
                    <dl class="row">
                        <dt class="col-sm-5" id="r1">{{Form::text('nbr_immobilier',null,['class'=>'form-control','style'=>'width:154.83px','id'=>'nbumo'])}}</dt>
                        <dd class="col-sm-7"> <span style="color:red;">*</span>{{Form::label('nbr_immobilier',': عدد الرسوم العقارية  ',['id'=>'label'])}}</dd>
                    </dl>
                    {{Form::hidden('num_jugement',$jugement->num_jugement)}}
                    {{Form::hidden('num_dossier',$jugement->dossiers_num_dossier)}}
                    {{Form::hidden('num_idtribunal',$jugement->tribunals_id_tribunal)}}
                    <button class="buttonload"  id="btn1">
                        <i class=""></i>تأكيد
                    </button>

                </div>
            </div>
            <div class="list-group-item list-group-item-action col-md-4" id="list5">
                <div class="form-group">
                    <dl class="row">
                        <dt class="col-sm-5" id="r5">{{Form::text('nbr_avocat',null,['class'=>'form-control','style'=>'width:154.83px','id'=>'nbavocat'])}}</dt>
                        <dd class="col-sm-7"> <span style="color:red;">*</span>{{Form::label('nbr_avocat',': عدد المحامين  ',['id'=>'label'])}}</dd>
                    </dl>
                    {{Form::hidden('num_jugement',$jugement->num_jugement)}}
                    {{Form::hidden('num_dossier',$jugement->dossiers_num_dossier)}}
                    {{Form::hidden('num_idtribunal',$jugement->tribunals_id_tribunal)}}
                    <button class="buttonload"  id="btnav1">
                        <i class=""></i>تأكيد
                    </button>

                </div>
            </div>
            <div class="list-group-item list-group-item-action col-md-4 " id="list2">
                <div class="form-group">
                    <dl class="row">
                        <dt class="col-sm-5" id="r2">{{Form::text('nbr_procureur',null,['class'=>'form-control','style'=>'width:154.83px','id'=>'nbp'])}}</dt>
                        <dd class="col-sm-7"> <span style="color:red;">*</span>{{Form::label('nbr_procureur',': عدد الاطراف المدعية  ',['id'=>'label'])}}</dd>
                    </dl>
                    <button class="buttonload"  id="btn2">
                        <i class=""></i>تأكيد
                    </button>
                </div>
            </div>
            <div class="list-group-item list-group-item-action col-md-4" id="list3">
                <div class="form-group">
                    <dl class="row">
                        <dt class="col-sm-5" id="r3">{{Form::text('nbr_defendeur',null,['class'=>'form-control','style'=>'width:154.83px','id'=>'nbd'])}}</dt>
                        <dd class="col-sm-7" style="margin-right: -40px;margin-top: -30px"><span style="color:red;position: relative;top: 40px;">*</span>{{Form::label('nbr_defendeur',': عدد الاطراف المدعى عليها',['id'=>'label'])}}</dd>
                    </dl>
                    <button class="buttonload"  id="btn4">
                        <i class=""></i>تأكيد
                    </button>
                </div>
            </div>
            <div class="list-group-item list-group-item-action col-md-4" id="list4">

                <div class="form-group">
                    <dl class="row">
                        <dt class="col-sm-5" id="r4">{{Form::text('nbr_autres',null,['class'=>'form-control','style'=>'width:154.83px','id'=>'nbautre'])}}</dt>
                        <dd class="col-sm-7">{{Form::label('nbr_autres',':  عدد الاطراف الأخرى ',['id'=>'label'])}}</dd>
                    </dl>

                    <button class="buttonload"  id="btn6">
                        <i class=""></i>تأكيد
                    </button>

                </div>
            </div>
        </div>
        <p class="col-md-12"  style="color:red;text-align: center;" >الحقول التي تحتوي على * باللون الأحمر إلزامية</p>
    </div>
    {{Form::close()}}

    <div class="form-group col-md-7 offset-md-2 ">
        <div class="offset-md-2">
            {{Form::open(['url'=>route('convocation.notify'),'id'=>'formNotify'])}}
            <div class='form-group'>
                {{Form::hidden('num_jugement',$jugement->num_jugement)}}
                {{Form::hidden('num_dossier',$jugement->dossiers_num_dossier)}}
                {{Form::hidden('num_idtribunal',$jugement->tribunals_id_tribunal)}}
                <button type='submit' class="btn btn-primary btn-lg btn-block" style="margin-top:1rem;"> إبلاغ &nbsp;&nbsp;&nbsp;<i class="fa fa-bell" aria-hidden="true"></i></button>
            </div>
            {{Form::close()}}
        </div>
    </div>






@endsection
@section('js')

    <script>

        var n=0;
        var nb=0;
        var nbr=0;
        var a=0;
        var $array1=[];
        var btn_sui=0;
        var btn_sui2=0;
        var btn_sui3=0;
        $(function () {


//         $('#list1').attr('data-toggle','tooltip');
//         $('#list1').attr('data-placement','right');
//         $('#list1').addClass("red-tooltip");
//         $('#list1').attr('data-original-title','Tooltip on right3f 3ifjo3ihfiof 3fhi3rhfiurf u3hiduh3iufhi3uhfiu');
//         $('#list1').tooltip();
//         $('#list1').trigger('mouseenter');
//         setInterval(function () {
//             $('#list1').trigger('mouseleave');
//         },4000);




            var modal3 = document.getElementById("myModal3");
            var modal1 = document.getElementById("myModal1");
            var modal5 = document.getElementById("myModal5");
            var modal4 = document.getElementById("myModal4");
            var modal6 = document.getElementById("myModal6");

// Get the button that opens the modal
            var btn1 = document.getElementById("btn1");
            var btn2 = document.getElementById("btn2");
            var btn4 = document.getElementById("btn4");
            var btn6 = document.getElementById("btn6");
            var btnav1 = document.getElementById("btnav1");

// Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close1")[0];
            var btnclose1=document.getElementsByClassName("close2")[0];
            var span1 = document.getElementsByClassName("close3")[0];
            var btnclose2=document.getElementsByClassName("close4")[0];
            var span2 = document.getElementsByClassName("close5")[0];
            var btnclose3=document.getElementsByClassName("close6")[0];
            var span3 = document.getElementsByClassName("close7")[0];
            var btnclose4=document.getElementsByClassName("close8")[0];
            var spanav1 = document.getElementsByClassName("closeav5")[0];
            var btncloseav1=document.getElementsByClassName("closeav6")[0];
// get the button element that close the modal
//         var btnsave1=document.getElementsByClassName('save1')[0];
// When the user clicks the button, open the modal
            var nbumo;
            var nbp;
            var nbd;
            var nbautre;
            var i=1;
            var i1=1;
            var i2=1;
            var i3=1;
            var i4=1;
            var response='';
            var response1='';
            var response2='';
            var response3='';
            var response4='';
            var iserrors='0';
            var iserrors1='0';
            var iserrors2='0';
            var iserrors3='0';
            var iserrors4='0';
            btn1.onclick = function() {
                $('#btn1').click(function () {
                    nbumo=$('#nbumo').val();
                    if(nbumo==null || nbumo==''){
                        $('#btn1 i').removeClass('fa fa-refresh fa-spin');
                        $('.message').addClass('alert alert-danger col-md-8 offset-md-2').attr('dir','rtl').text('* الحقل عدد الرسوم العقارية فارغ !');
                    }
                    if(nbumo!=null && nbumo!=''){
                        $('#numero').text(i);
                        $('.message').removeClass('alert alert-danger').text('');
                        modal3.style.display = "block";
                    }
                });



            }
            btn2.onclick = function() {
                $('#btn2').click(function (){
                    if(btn_sui==0){
                        $('#btn2 i').removeClass('fa fa-refresh fa-spin');
                        $('.message').addClass('alert alert-danger col-md-8 offset-md-2').attr('dir','rtl').text('* لم تقم بإدخال معلومات العقار !');
                    }
                    nbp=$('#nbp').val();
                    if(nbp==null || nbp==''){
                        $('#btn2 i').removeClass('fa fa-refresh fa-spin');
                        $('.message').addClass('alert alert-danger col-md-8 offset-md-2').attr('dir','rtl').text('* الحقل عدد الاطراف المدعية فارغ !');
                    }
                    if(nbp!=null && nbp!='' && btn_sui==1){
                        $('#numero2').text(i2);
                        $('.message').removeClass('alert alert-danger').text('');
                        modal1.style.display = "block";
                    }
                });
            }
            btn4.onclick = function() {
                $('#btn4').click(function () {
                    if(btn_sui2==0){
                        $('#btn4 i').removeClass('fa fa-refresh fa-spin');
                        $('.message').addClass('alert alert-danger col-md-8 offset-md-2').attr('dir','rtl').text('* لم تقم بإدخال معلومات الاطراف المدعية !');
                    }
                    nbd=$('#nbd').val();
                    if(nbd==null || nbd==''){
                        $('#btn4 i').removeClass('fa fa-refresh fa-spin');
                        $('.message').addClass('alert alert-danger col-md-8 offset-md-2').attr('dir','rtl').text('* الحقل عدد الاطراف المدعى عليها فارغ !');
                    }
                    if(nbd!=null && nbd!='' && btn_sui2==1){
                        $('#numero3').text(i3);
                        $('.message').removeClass('alert alert-danger').text('');
                        modal4.style.display = "block";
                    }
                });

            }

            btn6.onclick = function() {
                $('#btn6').click(function(){
                    if(btn_sui3==0){
                        $('#btn6 i').removeClass('fa fa-refresh fa-spin');
                        $('.message').addClass('alert alert-danger col-md-8 offset-md-2').attr('dir','rtl').text('* لم تقم بإدخال معلومات الاطراف المدعى عليها !');
                    }
                    nbautre=$('#nbautre').val();
                    if(nbautre==null || nbautre==''){
                        $('#btn6 i').removeClass('fa fa-refresh fa-spin');
                        $('.message').addClass('alert alert-danger col-md-8 offset-md-2').attr('dir','rtl').text('* الحقل  عدد الاطراف الأخرى فارغ !');
                    }
                    if(nbautre!=null && nbautre!='' && btn_sui3==1){
                        $('#numero4').text(i4);
                        $('.message').removeClass('alert alert-danger').text('');
                        modal6.style.display = "block";
                    }
                });

            }

            btnav1.onclick = function() {
                $('#btnav1').click(function () {
                    nbavocat=$('#nbavocat').val();
                    if(nbavocat==null || nbavocat==''){
                        $('#btnav1 i').removeClass('fa fa-refresh fa-spin');
                        $('.message').addClass('alert alert-danger col-md-8 offset-md-2').attr('dir','rtl').text('* الحقل  عدد المحامين !');
                    }
                    if(nbavocat!=null && nbavocat!=''){
                        $('#numero1').text(i1);
                        $('.message').removeClass('alert alert-danger').text('');
                        modal5.style.display = "block";
                    }
                });

            }
// When the user clicks the button, open the modal


// When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal3.style.display = "none";
                $('#btn1 i').removeClass('fa fa-refresh fa-spin');
            }
            btnclose1.onclick = function() {
                modal3.style.display = "none";
            }
            span1.onclick = function() {
                modal1.style.display = "none";
                $('#btn2 i').removeClass('fa fa-refresh fa-spin');
            }
            btnclose2.onclick = function() {
                modal1.style.display = "none";

            }
            span2.onclick = function() {
                modal4.style.display = "none";
                $('#btn4 i').removeClass('fa fa-refresh fa-spin');
            }
            btnclose3.onclick = function() {
                modal4.style.display = "none";

            }
            span3.onclick = function() {
                modal6.style.display = "none";
                $('#btn6 i').removeClass('fa fa-refresh fa-spin');
            }
            btnclose4.onclick = function() {
                modal6.style.display = "none";

            }
            spanav1.onclick = function() {
                modal5.style.display = "none";
                $('#btnav1 i').removeClass('fa fa-refresh fa-spin');
            }
            btncloseav1.onclick = function() {
                modal5.style.display = "none";

            }

// When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal3) {
                    if (!confirm(' هل تريد إغلاق هذه النافذة ?')) {
                        event.preventDefault();
                    } else {
                        modal3.style.display = "none";
                        $('#btn1 i').removeClass('fa fa-refresh fa-spin');
                    }
                }
                if (event.target == modal1) {
                    if(!confirm(' هل تريد إغلاق هذه النافذة ?')){
                        event.preventDefault();
                    }
                    else{
                        modal1.style.display = "none";
                        $('#btn2 i').removeClass('fa fa-refresh fa-spin');
                    }
                }
                if (event.target == modal4) {
                    if(!confirm(' هل تريد إغلاق هذه النافذة ?')){
                        event.preventDefault();
                    }
                    else{
                        modal4.style.display = "none";
                        $('#btn4 i').removeClass('fa fa-refresh fa-spin');
                    }
                }
                if (event.target == modal6) {
                    if(!confirm(' هل تريد إغلاق هذه النافذة ?')){
                        event.preventDefault();
                    }
                    else{
                        modal6.style.display = "none";
                        $('#btn6 i').removeClass('fa fa-refresh fa-spin');
                    }
                }
                if (event.target == modal5) {
                    if(!confirm(' هل تريد إغلاق هذه النافذة ?')){
                        event.preventDefault();
                    }
                    else{
                        modal5.style.display = "none";
                        $('#btnav1 i').removeClass('fa fa-refresh fa-spin');
                    }
                }

            }
            // ========================ajax==============================


            $(document).on('submit', '#formRegister', function(e) {
                $('#sui').prop('disabled',true)
                $('#sui').append('<i class="fa fa-refresh fa-spin"></i>')
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    success:function(data){
                        $('#sui i').remove()
                        i=i+1;
                        btn_sui=1;
                        console.log(data['data']);
                        $('#num_immo').val('');
                        $('#des_immo').val('');
                        $('#ad_immo').val('');
                        $('#ville_immo').val('');
                        $('#surface_immo').val('');
                        if(data['data']==true){
                        $('.msg').removeClass('alert alert-danger').addClass('alert alert-success').text('تم حفظ المعلومات')
                        }

                        $('#myModal3').find('input, select,#sui').prop('disabled',true);
                        if(n>0) {
                            $('#myModal3 div.modal-footer').prepend('<div class="form-group" style="margin-right: -20%;margin-bottom: 130px;"><span><i class="fa fa-hand-o-right fa-lg" style="cursor:pointer;color:dodgerblue;" >التالي</i></span></div>');
                        }
                        $('#myModal3 div.modal-footer div span i').on('click',function () {
                            $('#myModal3').find('input, select,button').prop('disabled',false);
                            tinymce.activeEditor.setMode('design');

                            console.log(iserrors1)
                            if(iserrors1=='0') {

                                $('#numero').text(i);
                                if (n != 0) {
                                    n--;
                                }
                                if (n == 0) {
                                    $('#myModal3 div.modal-footer div').remove();
                                }
                                $('.msg').removeClass('alert alert-success').text('')
                            }
                            $('#myModal3 div.modal-footer div').remove()
                        });
                        tinymce.activeEditor.setMode('readonly');
                        iserrors1='0';
                    },
                    error:function (data){
                        $('#sui i').remove()
                        $('#sui').prop('disabled',false)
                        try {
                             response1 = JSON.parse(data.responseText);
                        }
                        catch(e){

                        }
                        console.log(response1)
                        if(typeof(response1) === 'object'){
//                            var response = JSON.parse(data.responseText);
                            var errorString = '<ul>';
                            $.each(response1.errors, function (key, value) {
                                errorString += '<li>' + value + '</li>';
                            });
                            errorString += '</ul>';
                            $('.msg').addClass('alert alert-danger').html(errorString)

                        }else{
                            $('.msg').addClass('alert alert-danger').html('لا يمكن الاتصال بالشبكة')

                        }
                        response1='';
                        iserrors1='1';
                    }

                });
            });

            $(document).on('submit', '#formNotify', function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success:function (data) {
                        console.log(data)
                        $('.message').addClass('alert alert-success col-md-8 offset-md-2').attr('dir','rtl').text('تم الابلاغ عن الخبرة القضائية بنجاح');
                    }
                });
            });
            $(document).on('submit', '#formRegister2', function(e) {
                $('#next').prop('disabled',true)
                $('#next').append('<i class="fa fa-refresh fa-spin"></i>')

                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success:function (data) {
                        $('#next i').remove()
                        i2=i2+1;
                        btn_sui2=1;
                        console.log(data);
                        $('#nbav').html('');
                        $('#nb').val('');
                        $('#nom_p').val('');
                        $('#adresse_p').val('');
                            if(data['data']==true) {
                                $('.msg1').removeClass('alert alert-danger').addClass('alert alert-success').text('تم حفظ المعلومات')
                            }
                        $('#myModal1').find('input, select,#next').prop('disabled',true);
                        if(nb>0) {
                            $('#myModal1 div.modal-footer').prepend('<div class="form-group" style="margin-right: -20%;margin-bottom: 130px;"><span><i class="fa fa-hand-o-right fa-lg" style="cursor:pointer;color:dodgerblue;" >التالي</i></span></div>');
                        }
                        $('#myModal1 div.modal-footer div span i').on('click',function () {
                            $('#myModal1').find('input, select,button').prop('disabled',false);
                            tinymce.activeEditor.setMode('design');

//
                            console.log(iserrors2)
                            if(iserrors2=='0'){
                                $('#numero2').text(i2);
                                if (nb!= 0) {
                                    nb--;
                                }
                                if (nb == 0) {
                                    $('#myModal1 div.modal-footer div').remove();
                                }
                                $('.msg1').removeClass('alert alert-success').text('')
                            }
                            $('#myModal1 div.modal-footer div').remove()
                        });
                        tinymce.activeEditor.setMode('readonly');
                        iserrors2='0';



                    },
                    error:function (data) {
                        $('#next i').remove()
                        $('#next').prop('disabled',false)
                        try {
                            response2 = JSON.parse(data.responseText);
                        }
                        catch(e){

                        }
                        console.log(response2)
                        if(typeof(response2) === 'object'){
//                            var response = JSON.parse(data.responseText);
                            var errorString = '<ul>';
                            $.each(response2.errors, function (key, value){
                                errorString += '<li>' + value + '</li>';
                            });
                            errorString += '</ul>';
                            $('.msg1').addClass('alert alert-danger').html(errorString)

                        }else{
                            $('.msg1').addClass('alert alert-danger').html('لا يمكن الاتصال بالشبكة')

                        }
                        response2='';
                        iserrors2='1';
                    }
                    });
            });
            $(document).on('submit', '#formRegisterav', function(e) {
                $('#nextav1').prop('disabled',true)
                $('#nextav1').append('<i class="fa fa-refresh fa-spin"></i>')
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success:function (data) {
                        $('#nextav1 i').remove()
                        i1=i1+1;
                        response='';
                        console.log(data);
                        $('#nom_av').val('');
                        $('#adresse_av').val('');
                        $('#ville_av').val('');
                            if(data['data']==true) {
                                $('.msg5').removeClass('alert alert-danger').addClass('alert alert-success').text('تم حفظ المعلومات')
                            }
                        $('#myModal5').find('input, select,#nextav1').prop('disabled',true);
                        if(a>0) {
                            $('#myModal5 div.modal-footer').prepend('<div class="form-group" style="margin-right: -20%;margin-bottom: 130px;"><span><i class="fa fa-hand-o-right fa-lg" style="cursor:pointer;color:dodgerblue;" >التالي</i></span></div>');
                        }
                        $('#myModal5 div.modal-footer div span i').on('click',function () {
                            $('#myModal5').find('input, select,button').prop('disabled',false);
                            tinymce.activeEditor.setMode('design');

//
                            console.log(iserrors)
                            if(iserrors=='0'){
                                $('#numero1').text(i1);
                                if (a!= 0) {
                                    a--;
                                }
                                if (a == 0) {
                                    $('#myModal5 div.modal-footer div').remove();
                                }
                                $('.msg5').removeClass('alert alert-success').text('')
                            }
                            $('#myModal5 div.modal-footer div').remove()
                        });
                        tinymce.activeEditor.setMode('readonly');
                        iserrors='0';




                    },
                    error:function (data) {
                        $('#nextav1 i').remove()
                        $('#nextav1').prop('disabled',false)
                        try {
                             response = JSON.parse(data.responseText);
                        }
                        catch(e){

                        }
                        console.log(response)
                        if(typeof(response) === 'object'){
//                            var response = JSON.parse(data.responseText);
                            var errorString = '<ul>';
                            $.each(response.errors, function (key, value){
                                errorString += '<li>' + value + '</li>';
                            });
                            errorString += '</ul>';
                            $('.msg5').addClass('alert alert-danger').html(errorString)

                        }else{
                            $('.msg5').addClass('alert alert-danger').html('لا يمكن الاتصال بالشبكة')

                        }
                        response='';
                        iserrors='1';
                    }
                });
            });
            $(document).on('submit', '#formRegister3', function(e) {
                $('#suivant1').prop('disabled',true)
                $('#suivant1').append('<i class="fa fa-refresh fa-spin"></i>')
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success:function (data) {
                        $('#suivant1 i').remove()
                        i3=i3+1;
                        btn_sui3=1;
                        console.log(data);
                        $('#nbavc').html('');
                        $('#nbdav').val('');
                        $('#nom_d').val('');
                        $('#adresse_d').val('');
                        $('#adresse_d').val('');
                            if(data['data']==true) {
                                $('.msg2').removeClass('alert alert-danger').addClass('alert alert-success').text('تم حفظ المعلومات')
                        }
                        $('#myModal4').find('input, select,#suivant1').prop('disabled',true);
                        if(nbr>0) {
                            $('#myModal4 div.modal-footer').prepend('<div class="form-group" style="margin-right: -20%;margin-bottom: 130px;"><span><i class="fa fa-hand-o-right fa-lg" style="cursor:pointer;color:dodgerblue;" >التالي</i></span></div>');
                        }
                        $('#myModal4 div.modal-footer div span i').on('click',function () {
                            $('#myModal4').find('input, select,button').prop('disabled',false);
                            tinymce.activeEditor.setMode('design');
                            console.log(iserrors3)
                            if(iserrors3=='0'){
                                $('#numero3').text(i3);
                                if (nbr!= 0) {
                                    nbr--;
                                }
                                if (nbr == 0) {
                                    $('#myModal4 div.modal-footer div').remove();
                                }
                                $('.msg2').removeClass('alert alert-success').text('')
                            }
                            $('#myModal4 div.modal-footer div').remove()
                        });
                        tinymce.activeEditor.setMode('readonly');
                        iserrors3='0';



                    },
                    error:function (data) {
                        $('#suivant1 i').remove()
                        $('#suivant1').prop('disabled',false)
                        try {
                            response3 = JSON.parse(data.responseText);
                        }
                        catch(e){

                        }
                        console.log(response3)
                        if(typeof(response3) === 'object'){
//                            var response = JSON.parse(data.responseText);
                            var errorString = '<ul>';
                            $.each(response3.errors, function (key, value){
                                errorString += '<li>' + value + '</li>';
                            });
                            errorString += '</ul>';
                            $('.msg2').addClass('alert alert-danger').html(errorString)

                        }else{
                            $('.msg2').addClass('alert alert-danger').html('لا يمكن الاتصال بالشبكة')

                        }
                        response3='';
                    }
                });
            });
            $(document).on('submit', '#formRegister4', function(e) {
                $('#suivant2').prop('disabled',true)
                $('#suivant2').append('<i class="fa fa-refresh fa-spin"></i>')
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success:function (data) {
                        $('#suivant2 i').remove()
                        i4=i4+1;
                        console.log(data);
                        $("#texta").val("");
                            if(data['data']==true){
                                $('.msg4').removeClass('alert alert-danger').addClass('alert alert-success').text('تم حفظ المعلومات')
                            }
                        $('#myModal6').find('input, select,#suivant2').prop('disabled',true);
                        if(a>0){
                            $('#myModal6 div.modal-footer').prepend('<div class="form-group" style="margin-right: -20%;margin-bottom: 130px;"><span><i class="fa fa-hand-o-right fa-lg" style="cursor:pointer;color:dodgerblue;" >التالي</i></span></div>');
                        }
                        $('#myModal6 div.modal-footer div span i').on('click',function () {
                            $('#myModal6').find('input, select,button').prop('disabled',false);
                            tinymce.activeEditor.setMode('design');
                            console.log(iserrors4)
                            if(iserrors4=='0'){
                                $('#numero4').text(i4);
                                if (a != 0) {
                                    a--;
                                }
                                if (a == 0) {
                                    $('#myModal6 div.modal-footer div').remove();
                                }
                                $('.msg4').removeClass('alert alert-success').text('')
                            }
                            $('#myModal6 div.modal-footer div').remove()
                        });
                        tinymce.activeEditor.setMode('readonly');
                        iserrors4='0';
                    },
                    error:function (data) {
                        $('#suivant2 i').remove()
                        $('#suivant2').prop('disabled',false)
                        try{
                             response4 = JSON.parse(data.responseText);
                        }
                        catch(e){

                        }
                        console.log(response4)
                        if(typeof(response4) === 'object'){
//                            var response = JSON.parse(data.responseText);
                            var errorString = '<ul>';
                            $.each(response4.errors, function (key, value){
                                errorString += '<li>' + value + '</li>';
                            });
                            errorString += '</ul>';
                            $('.msg4').addClass('alert alert-danger').html(errorString)

                        }else{
                            $('.msg4').addClass('alert alert-danger').html('لا يمكن الاتصال بالشبكة')

                        }
                        response4='';
                        iserrors4='1';
                    }
                });
            });
            $(document).on('submit', '#nbinput', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success:function (data) {
                        console.log(data);
                    }
                });
            });$(document).on('submit', '#imprimForm', function(e) {
//             e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success:function (data){
                        console.log(data);
                    }
                });
            });

            $(document).on('click', '#btn2', function(e) {
//             e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: location.protocol + "//" + location.host+"/avocat/dataav",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success:function (data) {
//                     array=data;
                        a=Object.keys(data).map(function(k){return {key: k, value: data[k]}})
                        for(var i=0;i<a.length;i++){
                            $array1[a[i].key]=a[i].value;

                        }
                        console.log($array1)



                    }
                });
            });
            $(document).on('click', '#btn4', function(e) {
//             e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: location.protocol + "//" + location.host+"/avocat/dataav",
                    data: $(this).serialize(),
                    dataType: 'json',
                    success:function (data) {
//                     array=data;
                        a=Object.keys(data).map(function(k){return {key: k, value: data[k]}})
                        for(var i=0;i<a.length;i++){
                            $array1[a[i].key]=a[i].value;

                        }
                        console.log($array1)



                    }
                });
            });
            //====================================================
            $('#btn1').on('click', function() {
                $('#btn1 i').addClass('fa fa-refresh fa-spin');
                $('.b').on('click',function () {
                    $('#btn1 i').removeClass('fa fa-refresh fa-spin');
                });
            });$('#btn2').on('click', function() {
                $('#btn2 i').addClass('fa fa-refresh fa-spin');
                $('.b').on('click',function () {
                    $('#btn2 i').removeClass('fa fa-refresh fa-spin');
                });
            });$('#btn3').on('click', function() {
                $('#btn3 i').addClass('fa fa-refresh fa-spin');
                $('.b').on('click',function () {
                    $('#btn3 i').removeClass('fa fa-refresh fa-spin');
                });
            });$('#btn4').on('click', function() {
                $('#btn4 i').addClass('fa fa-refresh fa-spin');
                $('.b').on('click',function () {
                    $('#btn4 i').removeClass('fa fa-refresh fa-spin');
                });
            });$('#btn5').on('click', function() {
                $('#btn5 i').addClass('fa fa-refresh fa-spin');
                $('.b').on('click',function () {
                    $('#btn5 i').removeClass('fa fa-refresh fa-spin');
                });
            });$('#btn6').on('click', function() {
                $('#btn6 i').addClass('fa fa-refresh fa-spin');
                $('.b').on('click',function () {
                    $('#btn6 i').removeClass('fa fa-refresh fa-spin');
                });
            });$('#btnav1').on('click', function() {
                $('#btnav1 i').addClass('fa fa-refresh fa-spin');
                $('.b').on('click',function () {
                    $('#btnav1 i').removeClass('fa fa-refresh fa-spin');
                });
            });
            $('#myModal1').on('click','#btn33',function () {
                var v=$('#nb').val();
                var nb=parseInt(v,10);
                if( nb>0){
                    for (var i=0;i<nb;i++){
                        var form_d  = '<select name="genre_p[]" class="form-control"><option></option>';
                        for(key in $array1)
                        {
                            form_d += '  <option value="'+ key +'">'+ $array1[key] +'</option>';
                        }
                        form_d += '</select>';
                        $('#nbav').append('<div class="form-group col-md-8">'+form_d+'</div>');
                    }

//
                }

//                 console.log(form_d)
            });

            $('#btn2').on('click',function () {
                $('#nbav').html('');
                $('#nb').val('');
                var v=$('#nbp').val();
                nb=parseInt(v,10);

                if(nb > 0){
                    $('#myModal1 div.modal-footer div').remove();
                    nb--;
                }
            });


            $('#btn1').on('click',function () {
//
                $('#nbav').html('');
                $('#nb').val('');
                var v=$('#nbumo').val();
                n=parseInt(v,10);
//
                if(n > 0){
                    $('#myModal3 div.modal-footer div').remove();
                    n--;
                }
            });

            $('#btn4').on('click',function () {
                $('#nbavc').html('');
                $('#nbdav').val('');
                var v=$('#nbd').val();
                nbr=parseInt(v,10);
                if(nbr>0){
                    $('#myModal4 div.modal-footer div').remove();
                    nbr--;
                }
            });
            $('#myModal4').on('click','#btn44',function () {
                var v=$('#nbdav').val();
                console.log(v);
                var d=parseInt(v,10);
                if( d >0){
                    for (var i=0;i<d;i++){
                        var form_d  = '<select name="genre_d[]" class="form-control"><option></option>';
                        for(key in $array1)
                        {
                            form_d += '  <option value="'+ key +'">'+ $array1[key] +'</option>';
                        }
                        form_d += '</select>';
                        $('#nbavc').append('<div class="form-group col-md-8">'+form_d+'</div>');
                    }
                }

            });

            $('#btn6').on('click',function () {
                var v=$('#nbautre').val();
                a=parseInt(v,10);
                if(a > 0){
                    $('#myModal6 div.modal-footer div').remove();
                    a--;
                }
            });
            $('#btnav1').on('click',function () {
                var v=$('#nbavocat').val();
                a=parseInt(v,10);
                if(a > 0){
                    $('#myModal5 div.modal-footer div').remove();
                    a--;
                }
            });
        });




    </script>

@endsection