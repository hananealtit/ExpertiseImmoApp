@extends('app')
@section('title','الملفات الموضوعة')
@section('css')
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
        table{
            border-radius: 10px;
        }
        .table th{
            font-size: 11px;
          
            color:#000;
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
       


        #submit{
            cursor: pointer;
        }
    </style>
@endsection
@section('body')
    {{--{{dump($_SERVER)}}--}}
    <div class="col-md-12 ">

        <div class="col-md-8 offset-md-4" dir="rtl" style="margin-bottom: 50px;">
            <input type="text" name="search" placeholder="بحث.." id="search">
        </div>

        <h2 dir="auto">الملفات الموضوعة</h2>
        <table class="table stripped" dir="auto" style="margin-top: 50px;">
            <thead class='table-info'>
            <th>رقم الملف</th>
            <th>القاضي المقرر</th>
            <th>تاريخ التوصل</th>
            <th>مدة الانجاز</th>
            <th>تاريخ الخبرة</th>
            <th>تاريخ الايداع</th>
            <th>الاتعاب</th>
            <th>طلب التمديد</th>
            <th>بيان اخباري</th>
            <th>الجواب على البيان الاخباري</th>
            <th>المكلف باللف</th>
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
                    <td id="d_depot">{{$v['date_depot']}}</td>
                    <td>{{$v['prix_expertise']}}</td>
                    <td id="dp">

                            {{$v['duree_prolongement']}}

                    </td>
                    <td id="date_sent">
                            {{$v['declaration']}}

                    </td>

                    <td id="date_respanse">

                            {{$v['date_repanse']}}

                    </td>
                    <td>{{$v['personnel']}}</td>

                    <td class="row"><form method="POST">
                            {{ method_field('DELETE') }}
                            <a href="{{route('dossier.destroy',$v['num_jugement'])}}" id="delete"><i class="fa fa-trash" aria-hidden="true" style="color: red;"></i></a></form>&nbsp;<a href="{{route('dossier.edit',$v['num_jugement'])}}"><i class="fa fa-pencil-square" aria-hidden="true"></i></a>&nbsp;

                        {{--<a href="{{route('dossier.confirmer',$v['num_jugement'])}}" style="color: forestgreen;" id="confirm"><i class="fa fa-check-circle" aria-hidden="true"></i></a>&nbsp;--}}

                        {{Form::open(['url'=>route('convocation.imprimer'),'id'=>"imprimForm"])}}
                        {{Form::hidden('num_jugement',$v['num_jugement'])}}
                        {{Form::hidden('num_dossier',$v['num_dossier'])}}
                        {{Form::hidden('num_idtribunal',$v['tribunals_id_tribunal'])}}
                        <span type="submit"  style="width: 0px;height:0px;padding: 0;margin: 0;" id="submit"><i class="fa fa-file-word-o fa" aria-hidden="true" style="color:black;"></i></span>
                        {{Form::close()}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="form-group" dir="rtl">
            {{Form::open(['method'=>'get','url'=>route('dossier.excelDeposer')])}}
            <button type="submit" class="btn btn-success">Excel <i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
            {{Form::close()}}
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://jqueryui.com/resources/demos/datepicker/i18n/datepicker-fr.js"></script>
    <script>
        $(function () {
            $('.table').on('click','#submit',function (e) {

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

                $.ajax({
                    type: "GET",
                    url: url+"/searchDeposer",
                    data: $(this).serialize(),
                    success:function (data) {
                        console.log(data);
                        $('table tbody').html(data);


                    }
                });
            });

            $('.table').on('click','#delete',function (e) {
//                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                    }
                });
                $.ajax({
                    type: 'post',
                    url: $(this).attr('href'),
                    data: $(this).serialize(),
                    success:function (data) {
                        console.log(data);
                    }
                });
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