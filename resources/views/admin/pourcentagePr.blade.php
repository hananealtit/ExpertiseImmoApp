@extends('app')
@section('title','')
@section('css')
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <style>
        th{
            text-align: center;
        }
        td{
            text-align: center;
        }
        #pencil{
            color:#0275d8;
        }
        #trash{
            color:#0275d8;
        }
        #submit{
            cursor: pointer;
        }
        #submit1{
            cursor: pointer;
        }
        #mdf{
            cursor: pointer;
        }
        #delete_row{
            cursor: pointer;
        }
    </style>
@endsection
@section('body')
    <div class="col-md-8 offset-md-8">
        <a href="{{route('immobiliers.gImmobilier')}}" style="color:#00acd6;float: left;margin-left:-10%;"><i class="fa fa-reply" aria-hidden="true"></i>رجوع </a>
        <h4 style="color:grey;">{{$id}} نسب تملك العقار </h4>
    </div>
    <br><br>
    <div class="modal"  id="myModal1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel" style="margin-left:40%;background:#2a4151;color:white;padding:5px;border-radius: 5px;">تحذير </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close3">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                <p dir="rtl">هل تريد حذف هذا طرف</p>
                </div>
                <div class="modal-footer">
                    <form action="{{route('procureur.delete')}}" method="get">
                    <input type="hidden" name="table" value="" id="t1">
                    <input type="hidden" name="num_immobilier" value="" id="t2">
                    <input type="hidden" name="partie" value="" id="t3">
                    <input type="hidden" name="num_dossier" value="" id="t4">
                    <input type="hidden" name="nom_arrivant" value="" id="t5">

                    <button type="reset" class="btn btn-info b close4" >لا</button>
                    <button type="submit" class="btn btn-danger b " id="next" >نعم</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal"  id="myModal2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel" style="margin-left:40%;background:#2a4151;color:white;padding:5px;border-radius: 5px;">تحديث </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="fermer1">&times;</span>
                    </button>
                </div>
                <form action="{{route('procureur.modifier')}}" method="get">
                <div class="modal-body">
                    <div class="col-md-8 offset-md-2">
                        <label for="modif">نسبة التملك</label>
                        <input type="text" name="pr" class="form-control" id="modif">
                        <input type="hidden" name="table" value="" id="tbl">
                        <input type="hidden" name="num_immobilier" value="" id="tbl2">
                        <input type="hidden" name="partie" value="" id="tbl3">
                        <input type="hidden" name="num_dossier" value="" id="tbl4">
                        <input type="hidden" name="nom_arrivant" value="" id="tbl5">
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="reset" class="btn btn-info fermer2" ><i class="fa fa-times fa-lg"></i></button>
                    <button type="submit" class="btn btn-success"  id="update"><i class="fa fa-check fa-lg"></i></button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8 offset-md-2">
        <div class="offset-md-11">
            <button class="w3-button w3-xlarge w3-circle w3-red w3-card-4" id="addtr">+</button>
        </div>

       <p></p>
       <p></p>
        <table class="table table-striped" id="table1">
            <thead>
            <th>#</th>
            <th>نسبة التملك</th>
            <th>الإسم الكامل</th>
            <th>العدد</th>
            </thead>
            <tbody>

            @foreach($a as $k=>$v)
            <?php $k++;?>

             <tr>
                 <td>

                     <span  id="submit1" class="btndelete" num_immobilier="{{$v[0]}}" partie="{{$v[1]}}" num_dossier="{{$v[2]}}" table="{{$v[3]}}" arrivant="{{$v[5]}}"><i class="fa fa-trash fa-lg" id="trash"></i></span>
                         <a id="mdf" table="{{$v[3]}}" num_immobilier="{{$v[0]}}" partie="{{$v[1]}}" num_dossier="{{$v[2]}}" arrivant="{{$v[5]}}"><i class="fa fa-pencil fa-lg" id="pencil"></i></a>


                 </td>
                 <td id="pourcentage">

                     @if($v[3]=='pr')
                     @if($v[4]==null)
                             {{Form::open(['method'=>'get','url'=>route('procureur.addpourcentage')])}}
                             <a id="submit"><i class="fa fa-plus fa-lg" id="pencil"></i></a>
                         <input type="text" class="form-control" name="pourcentage" >
                         {{Form::hidden('num_immobilier',$v[0])}}
                         {{Form::hidden('partie',$v[1])}}
                         {{Form::hidden('num_dossier',$v[2])}}
                         {{Form::hidden('table',$v[3])}}
                         {{Form::close()}}
                         @elseif($v[4]!=null)
                         {{$v[4]}}
                         @endif
                     @elseif($v[3]=='def')
                     @if($v[4]==null)
                             {{Form::open(['method'=>'get','url'=>route('defendeur.addpourcentage')])}}
                             <a id="submit"><i class="fa fa-plus fa-lg" id="pencil"></i></a>
                             <input type="text" class="form-control" name="pourcentage" >
                             {{Form::hidden('num_immobilier',$v[0])}}
                             {{Form::hidden('partie',$v[1])}}
                             {{Form::hidden('num_dossier',$v[2])}}
                             {{Form::hidden('table',$v[3])}}
                             {{Form::close()}}
                         @elseif($v[4]!=null)
                             {{$v[4]}}
                         @endif

                     @endif
                         @if($v[3]=='arr')
                             @if($v[4]==null)
                                 {{Form::open(['method'=>'get','url'=>route('defendeur.addpourcentage')])}}
                                 <a id="submit"><i class="fa fa-plus fa-lg" id="pencil"></i></a>
                                 <input type="text" class="form-control" name="pourcentage" >
                                 {{Form::hidden('num_immobilier',$v[0])}}
                                 {{Form::hidden('partie',$v[1])}}
                                 {{Form::hidden('num_dossier',$v[2])}}
                                 {{Form::hidden('table',$v[3])}}
                                 {{Form::close()}}
                             @elseif($v[4]!=null)
                                 {{$v[4]}}
                             @endif
                         @endif

                 </td>
                 <td>{{$v[5]}}</td>
                 <td>{{$k}}</td>
             </tr>
            @endforeach
            <?php
             $u=[];
             $somme=0;
            ?>
            <tr>

                <td >
                    {{Form::open(['method'=>'post','url'=>route('immobiliers.valider_pourcentage',['a'=>$a])])}}
                    <button class="btn btn-success" id="valider">تأكيد</button>
                    {{Form::close()}}
                </td>
                @foreach($a as $j)
                    <?php
                     if($j[4]!=null) {

                     $x=explode('/',$j[4]);
                     if(isset($x[1])){
                         $racine=$x[0]/$x[1];
                     }else{
                         $racine=$x[0];
                     }

                     $somme=$somme+$racine;
                     }
                    ?>
                @endforeach
                <td>{{$somme}}</td>
                <td>المجموع</td>
                <td></td>

            </tr >
            </tbody>
        </table>
    </div>
@endsection
@section('js')
    <script>
      $(function () {
          var modal1 = document.getElementById("myModal1");
          var modal2 = document.getElementById("myModal2");
          var span1 = document.getElementsByClassName("close3")[0];
          var span2 = document.getElementsByClassName("fermer1")[0];
          var btnclose2=document.getElementsByClassName("close4")[0];
          var btnclose=document.getElementsByClassName("fermer2")[0];

          span1.onclick = function() {
              modal1.style.display = "none";
          };
          span2.onclick = function() {
              modal2.style.display = "none";
          };
          btnclose2.onclick = function() {
              modal1.style.display = "none";

          };
          btnclose.onclick = function() {
              modal2.style.display = "none";

          };

          //m
          $('.table').on('click','#submit',function (e) {

              $(this).parent().submit();

          });
          $('.table').on('click','#submit1',function (e) {
              var $this=$(this);
              modal1.style.display = "block";
              var $table=$this.attr('table');
              var $num_immobilier=$this.attr('num_immobilier');
              var $partie=$this.attr('partie');
              var $nd=$this.attr('num_dossier');
              var $arrivant=$this.attr('arrivant');
              $('#t1').attr('value',$table);
              $('#t2').attr('value',$num_immobilier);
              $('#t3').attr('value',$partie);
              $('#t4').attr('value',$nd);
              $('#t5').attr('value',$arrivant);
              $('#next').click(function () {
                  $this.parent().submit();
              });
          });

          $('.table').on('click','#mdf',function (e) {
              var $this=$(this);
              modal2.style.display = "block";
              var $table=$this.attr('table');
              var $num_immobilier=$this.attr('num_immobilier');
              var $partie=$this.attr('partie');
              var $nd=$this.attr('num_dossier');
              var $arrivant=$this.attr('arrivant');
              $('#tbl').attr('value',$table);
              $('#tbl2').attr('value',$num_immobilier);
              $('#tbl3').attr('value',$partie);
              $('#tbl4').attr('value',$nd);
              $('#tbl5').attr('value',$arrivant);
              $('#update').click(function () {
                  $this.parent().submit();
              });
          });
          $('#addtr').click(function () {
              $('#table1 tbody').prepend("<tr><td colspan='3' ><form action='{{route('procureur.addp')}}' method='get' accept-charset='UTF-8' ><a  id='submit' class='col-md-1' style='float:left;margin-left:10%'><i class='fa fa-check-circle fa-lg' style='color:#8bc34a;'></i></a><input type='text' name='pourcentage' class='form-control col-md-3' style='float:left;margin-left:15%;'><input type='hidden' name='num_immobilier' value='{{$id}}'><input type='text' name='partie' class='form-control col-md-3' style='float:right;margin-right:5%;'><input type='hidden' name='num_dossier' value='{{$num_dossier}}'><input type='hidden' name='table' value='arr'></form></td><td><span id=delete_row><i class='fa fa-window-close' aria-hidden='true'></i></span></td></tr>");
          });

          $('.table').on('click','#delete_row',function (e) {
              $(this).parent().parent().remove();
              return false;
          });
      });
    </script>
@endsection