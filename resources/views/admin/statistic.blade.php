@extends('app')

@section('title','الملفات الغير الموضوعة')

@section('css')
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection

@section('body')
    <div class="col-md-8 offset-md-2">
        <div class="form-group" style="float:right;">
            <dl class="row">
                <dt class="col-sm-8">{{Form::text('date',null,['class'=>'form-control','id'=>'datepicker','data-date-format','dd/mm/yyyy'])}}</dt>
                <dd class="col-sm-4"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> {{Form::label('date_jugement',': التاريخ')}}</dd>
            </dl>
        </div>
    </div>
    <br><br><br><br><br>
    <div class="col-md-8 offset-md-2">
        <?php
        $month = date('m');
        $date=[];
            foreach ($dossiers->all() as $dossier){
                $created_at=explode(' ',$dossier->created_at);
                $m=explode('-',$created_at[0]);
                    if($month==$m[1]){
                        $date[]=$dossier;
                    }
            }
            $nd_file=count($date);
        ?>

    <div id="columnchart_values" style="width: 900px; height: 300px;"></div>

    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://jqueryui.com/resources/demos/datepicker/i18n/datepicker-fr.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        $("#datepicker").datepicker({

        });
       $(function () {
           var month = new Array();
           month[1] = "January";
           month[2] = "February";
           month[3] = "March";
           month[4] = "April";
           month[5] = "May";
           month[6] = "June";
           month[7] = "July";
           month[8] = "August";
           month[9] = "September";
           month[10] = "October";
           month[11] = "November";
           month[12] = "December";
           var d = new Date();
           m = d.getMonth();
           var nb_dossiers="<?php echo($nd_file);?>"
           nb_dossiers=parseInt(nb_dossiers)
           date='';
           $("#datepicker").change(function () {
               date=$("#datepicker").val();
               date=date.split('/')
               console.log(date[1])
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': '<?php echo csrf_token(); ?>'
                   }
               });
               var url=$(location).attr('href');
               var domaine=url.substring(7,url.indexOf("/",7));

               $.ajax({
                   type: "GET",
                   url: "http://"+domaine+"/statistic/chart",
                   data: {date:date[1]},
                   success:function (data) {
                       nb_dossiers=parseInt(data)
                       google.charts.load("current", {packages: ['corechart']});
                       google.charts.setOnLoadCallback(drawChart);
                       function drawChart() {
                           var data = google.visualization.arrayToDataTable([
                               ["Element", "عدد الملفات", {role: "style"}],
                               [month[parseInt(date[1])], nb_dossiers, "#b87333"],
//                   ["Silver", 10.49, "silver"],
//                   ["Gold", 19.30, "gold"],
//                   ["Platinum", 21.45, "color: #e5e4e2"]
                           ]);

                           var view = new google.visualization.DataView(data);
                           view.setColumns([0, 1,
                               {
                                   calc: "stringify",
                                   sourceColumn: 1,
                                   type: "string",
                                   role: "annotation"
                               },
                               2]);

                           var options = {
                               title: "عدد الملفات المنجزة  NB dossier  ",
                               width: 600,
                               height: 400,
                               bar: {groupWidth: "95%"},
                               legend: {position: "none"},
                           };
                           var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
                           chart.draw(view, options);
                       }


                   }
               });

           })
           google.charts.load("current", {packages: ['corechart']});
           google.charts.setOnLoadCallback(drawChart);
           function drawChart() {
               var data = google.visualization.arrayToDataTable([
                   ["Element", "عدد الملفات", {role: "style"}],
                   [month[m+1], nb_dossiers, "#b87333"],
//                   ["Silver", 10.49, "silver"],
//                   ["Gold", 19.30, "gold"],
//                   ["Platinum", 21.45, "color: #e5e4e2"]
               ]);

               var view = new google.visualization.DataView(data);
               view.setColumns([0, 1,
                   {
                       calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation"
                   },
                   2]);

               var options = {
                   title: "عدد الملفات المنجزة  NB dossier  ",
                   width: 600,
                   height: 400,
                   bar: {groupWidth: "95%"},
                   legend: {position: "none"},
               };
               var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
               chart.draw(view, options);
           }
       })
    </script>
@endsection