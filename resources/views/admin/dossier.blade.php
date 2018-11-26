@extends('app')
@section('title','الملفات الغير الموضوعة')
@section('css')
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>

        table{
            border-radius: 10px;
        }
        .table th{
            font-size: 11px;
            background: #167f92;
            color:white;
            text-align: center;
        }
        .table td{
            text-align: center;
        }
        #plgt{
            width:60px;
            display: none;
            float: left;
        }
        .plgt1{
            width:60px;
            display: none;
        }
        .plgt2{
            width:60px;
            display: none;
        }
        #search {
            width: 130px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: white;
            background-position: 10px 10px;
            background-repeat: no-repeat;
            padding: 12px 20px 12px 40px;
            -webkit-transition: width 0.4s ease-in-out;
            transition: width 0.4s ease-in-out;
        }

        #search:focus {
            width: 100%;
        }
        /*body { background-image: url(http://subtlepatterns.com/patterns/ricepaper.png) }*/



        #submit{
            cursor: pointer;
        } #submit1{
            cursor: pointer;
        } #submit2{
            cursor: pointer;
        }
        #deposer{
            cursor: pointer;
        }
 #delete{
            cursor: pointer;
        }
    </style>
@endsection
@section('body')
<div class="modal"  id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel" style="margin-left:40%;background:#2a4151;color:white;padding:5px;border-radius: 5px;">تحذير </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close3">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p dir="rtl">هل تريد الحذف </p>
                </div>
                <div class="modal-footer">
                    <form method="POST">
                        {{method_field('DELETE')}}

                        <button type="reset" class="btn btn-info b close4" >لا</button>
                        <a href=""  class="btn btn-danger b " id="next" >نعم</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
<div class="col-md-12 ">

    <div class="col-md-8 offset-md-4" dir="rtl" style="margin-bottom: 50px;">
    <input type="text" name="search" placeholder="بحث.." id="search">
    </div>

    <h2 dir="auto">الملفات الغير الموضوعة</h2>
    <table class="table stripped " dir="auto" style="margin-top: 50px;">
        <thead>
        <th>رقم الملف</th>
        <th>القاضي المقرر</th>
        <th>تاريخ التوصل</th>
        <th>مدة الانجاز</th>
        <th>تاريخ الخبرة</th>
        <th>تاريخ الايداع</th>
        <th>الاتعاب</th>
        <th>طلب التمديد</th>
        <th>بيان اخباري</th>
        <th>حالة الملف</th>
       <th>ت.الجلسة|| ت.ج.البيان الاخباري</th>
        <th>المكلف باللف</th>
        <th>ورقة الحضور</th>
        <th>إنهاء</th>
        <th style="width: 60px;">#</th>
        </thead>
        <tbody>
        @foreach($a as $k=>$v)
        <tr>
            <td>{{$v['num_dossier']}}</td>
            <td>{{$v['nom_juge']}}</td>
            <td>{{$v['date_arrivee']}}</td>
            <td>{{$v['duree_jugement']}}</td>
            <td>{{$v['date_jugement']}}</td>
            <td id="d_depot">{{empty($v['declaration'])?$v['date_depot']:'--'}}</td>
            <td>{{$v['prix_expertise']}}</td>
           <td id="dp">

                            {{Form::open(['url'=>route('dossier.prolongement',$v['num_jugement'])])}}

                            <a  id="submit" style=""><i class="fa fa-plus"></i></a>
                            <input type="checkbox" name="dpj" id="check" style=""> &nbsp;{{Form::text('duree_prolongement_jugement',null,['class'=>'form-control','id'=>'plgt'])}}
                            {{Form::close()}}

                    </td>
            <td id="date_sent">
                @if($v['declaration']==null)
                 {{Form::open(['url'=>route('dossier.declaration',$v['num_jugement'])])}}

                            <a  id="submit" style="color:dodgerblue;"><i class="fa fa-plus"></i></a>
                            <input type="checkbox" name="Communique" id="check1" style=""> {{Form::text('date_declaration',null,['class'=>'form-control plgt1','id'=>"picher$k"])}}
                            {{Form::close()}}
                @else
                {{$v['declaration']}}
                    @endif
            </td>
            <td id="scolor">
                @if($v['etat_dossier']>=10 && $v['declaration']==null)
                    <span class="badge badge-success badge-pill ">&nbsp;</span>
                @elseif($v['etat_dossier']>5 && $v['etat_dossier']<10 && $v['declaration']==null)
                    <span class="badge badge-warning badge-pill ">&nbsp;</span>
                @elseif($v['declaration']!=null)
                    @if($v['diff_date']!=null)
                                @if($v['diff_date']>=10)
                                    <span class="badge badge-success badge-pill ">&nbsp;</span>
                                @elseif($v['diff_date']>5 && $v['diff_date']<10)
                                    <span class="badge badge-warning badge-pill ">&nbsp;</span>
                                @elseif($v['diff_date']<=5)
                                    <span class="badge badge-danger badge-pill ">&nbsp;</span>
                                @endif
                            @else
                            <span class="badge badge-default badge-pill " style="background: yellow">&nbsp;</span>
                            @endif
                @elseif($v['etat_dossier']<=5 && $v['declaration']==null)
                    <span class="badge badge-danger badge-pill ">&nbsp;</span>

                @endif

            </td>
            <td id="date_respanse">
               {{Form::open(['url'=>route('dossier.confirmer',$v['num_jugement'])])}}
                            <a id="submit"  style="color:dodgerblue;"><i class="fa fa-plus"></i></a>
                            <input type="checkbox" name="repance_declaration" id="check2" style="">
                            {{Form::text('date_repanse_convocation',null,['class'=>'form-control plgt2','id'=>"picker1$k",'style'=>'float:left'])}}
                            {{Form::text('date_seance',null,['class'=>'form-control plgt2','id'=>"picker2$k",'style'=>'float:left'])}}
                            {{Form::close()}}
               </td>
            <td>{{$v['personnel']}}</td>
            <td>
                {{Form::open(['url'=>route('dossier.imprimerFeuile'),'id'=>"imprimForm1"])}}
                {{Form::hidden('num_jugement',$v['num_jugement'])}}
                {{Form::hidden('num_dossier',$v['num_dossier'])}}
                {{Form::hidden('num_idtribunal',$v['tribunals_id_tribunal'])}}
                <button type="submit"  class="btn btn-default" id="impF"><i class="fa fa-print" aria-hidden="true" style="position: relative;left:6px;"></i></button>
                {{Form::close()}}
            </td>
            <td>
                {{Form::open(['url'=>route('dossier.deposer')])}}
                {{Form::hidden('num_jugement',$v['num_jugement'])}}
                {{Form::hidden('num_dossier',$v['num_dossier'])}}
                {{Form::hidden('num_idtribunal',$v['tribunals_id_tribunal'])}}
                <a    id="deposer" style="width:6px;"><i class="fa fa-hourglass-end" aria-hidden="true" ></i></a>
                {{Form::close()}}
            </td>
            <td class="row">
                    <table style="border:none !important;">
                        <tr>
                            <td class="col-sm-4" style="padding: 0;margin:0;position:relative;left:5px;border:none !important;">
                                <span  id="delete" num_jugement="{{$v['num_jugement']}}"><i class="fa fa-trash" aria-hidden="true" style="color: red;"></i></span>
                               </td>
                            <td class="col-sm-4" style="padding: 0;margin:0;position:relative;left:5px;border:none !important;" ><a href="{{route('dossier.edit',$v['num_jugement'])}}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a></td>
                            <td class="col-sm-4" style="padding: 0;margin:0;position:relative;border:none !important;">
                                {{Form::open(['method'=>'get','url'=>route('dossier.report')])}}
                                {{Form::hidden('num_jugement',$v['num_jugement'])}}
                                {{Form::hidden('num_dossier',$v['num_dossier'])}}
                                {{Form::hidden('num_idtribunal',$v['tribunals_id_tribunal'])}}
                                <img type="submit" id="submit1" src="http://icons.iconarchive.com/icons/carlosjj/microsoft-office-2013/256/Word-icon.png" style="width:20px;height:auto;">
                                {{Form::close()}}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-4" style="padding: 0;margin:0;position:relative;left:5px;border:none !important;">
                                {{Form::open(['url'=>route('convocation.imprimer'),'id'=>"imprimForm"])}}
                                {{Form::hidden('num_jugement',$v['num_jugement'])}}
                                {{Form::hidden('num_dossier',$v['num_dossier'])}}
                                {{Form::hidden('num_idtribunal',$v['tribunals_id_tribunal'])}}
                                <img type="" id="submit1" src="https://cdn1.iconfinder.com/data/icons/fs-icons-ubuntu-by-franksouza-light/512/indicator-messages-new.png" style="width:20px;height:auto;">
                                {{Form::close()}}</td>
                            <td class="col-sm-4" style="padding: 0;margin:0;position:relative;left:5px;border:none !important;">{{Form::open(['method'=>'get','url'=>route('dossier.ticket')])}}
                                {{Form::hidden('num_jugement',$v['num_jugement'])}}
                                {{Form::hidden('num_dossier',$v['num_dossier'])}}
                                {{Form::hidden('num_idtribunal',$v['tribunals_id_tribunal'])}}
                                <img type="" id="submit1" src="https://www.bjcc.org/img/ticket-icon-red.png" style="width:20px;height:auto;">

                                {{Form::close()}}</td>
                            <td class="col-sm-4" style="padding: 0;margin:0;position:relative;left:5px;border:none !important;">{{Form::open(['method'=>'get','url'=>route('dossier.sticky')])}}
                                {{Form::hidden('num_jugement',$v['num_jugement'])}}
                                {{Form::hidden('num_dossier',$v['num_dossier'])}}
                                {{Form::hidden('num_idtribunal',$v['tribunals_id_tribunal'])}}
                                <img type="" id="submit1" src="http://bookitnow.pk/frontend/images/ticket-icon.png" style="width:20px;height:auto;">

                                {{Form::close()}}</td>
                        </tr>
                    </table>






            </td>
        </tr>
            @endforeach
        </tbody>
    </table>
    <div class="form-group" dir="rtl">
        {{Form::open(['method'=>'get','url'=>route('dossier.excel')])}}
        <button type="submit" class="btn btn-success">Excel</button>
        {{Form::close()}}
    </div>
   <div class="navigation col-sm-6 offset-md-5">
        {{$dossiers->links('vendor.pagination.bootstrap-4')}}
   </div>
</div>
@endsection
@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://jqueryui.com/resources/demos/datepicker/i18n/datepicker-fr.js"></script>
    <script>
        $(function () {
            var modal1 = document.getElementById("myModal");
            var span1 = document.getElementsByClassName("close3")[0];
            span1.onclick = function() {
                modal1.style.display = "none";
            };
            var btnclose2=document.getElementsByClassName("close4")[0];
            btnclose2.onclick = function() {
                modal1.style.display = "none";

            };
            $('.table').on('click','#submit',function (e) {

                    $(this).parent().submit();

            });
            $('.table').on('click','#submit2',function (e) {

                    $(this).parent().submit();

            });
            $('.table').on('click','#submit1',function (e) {

                    $(this).parent().submit();

            });
            $(document).on('submit', '#imprimForm', function(e) {
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
                    success:function (data) {
                        console.log(data);
                    }
                });
            });
            $('.table').on('click','#deposer',function (e) {

                    $(this).parent().submit();

            });
            $(document).on('submit', '#imprimForm1', function(e) {
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
                    success:function (data) {
                        console.log(data);
                    }
                });
            });
            $(document).on('submit', '#imprimForm1', function(e) {
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
                    success:function (data) {
                        console.log(data);
                    }
                });
            });
            $('#search').on('input', function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                var url=$(location).attr('href');
                var domaine=url.substring(7,url.indexOf("/",7));

                $.ajax({
                    type: "GET",
                    url: "http://"+domaine+"/dossier/search",
                    data: $(this).serialize(),
                    success:function (data) {
                        console.log(data);
                        $('table tbody').html(data);


                    }
                });
            });

             $('.table').on('click','#delete',function (e){
                modal1.style.display = "block";
                $this=$(this);
//                e.preventDefault();
                 $num_j=$this.attr('num_jugement');

                $('#next').attr('href','/dossier/delete/'+$num_j+'');

            });

            $('.table').on('click','#check',function() {
                if($(this).is(':checked')) {
                    $(this).siblings('#plgt').css('display','block');
//
                } else {
                    $(this).siblings('#plgt').css('display','none');
                }
            });
            $('.table').on('click','#check1',function() {
                if($(this).is(':checked')) {
                    $(this).parent().siblings('#scolor').children().css('background-color','yellow');
                    $(this).siblings('.plgt1').css('display','block');
                } else {
                    $(this).parent().siblings('#scolor').children().css('background-color','yellow');
                    $(this).siblings('.plgt1').css('display','none');

                }

            });
            $('.table').on('focus','.plgt1',function() {

                  $(this).datepicker({

                  });

            });
            $('.table').on('focus','.plgt2',function() {

                  $(this).datepicker({

                  });

            });
            $('.table').on('click','#check2',function() {
                if($(this).is(':checked')) {
                    $(this).siblings('.plgt2').css('display','block');
                } else {
                    $(this).siblings('.plgt2').css('display','none');

                }

            });
            $('.table').on('click','#confirm',function(e) {
                 e.preventDefault();
                 var $this=$(this);
                 var a=$(this).parent().siblings('#dp').find('#plgt').val();
                 var b=$(this).parent().siblings('#date_sent').find('.plgt1').val();
                 var c=$(this).parent().siblings('#date_respanse').find('.plgt2').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('href'),
                    data:{a:a,b:b,c:c},
                    success:function (data) {
                        console.log(data);

                        $this.parent().siblings('#d_depot').text(data);
                        location.reload();
                    }
                });

            });

        });
    </script>
@endsection