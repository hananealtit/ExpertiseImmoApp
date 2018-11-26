@extends('app')
@section('title','إدارة الاطراف  > المحافظ')
@section('css')
    <style>
        #delete{
            cursor: pointer;
            color: #ff281f;
        }
        #delete:hover{
            color: #000;
        }
        th{
            text-align: center;
        }
        td{
            text-align: center;
        }
        #delete{
            cursor: pointer;
        }
    </style>
@endsection
@section('body')
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
                    <p dir="rtl">هل تريد حذف هذا الطرف</p>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-info b close4" >لا</button>
                    <a href="" class="btn btn-danger b " id="next" >نعم</a>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-10 offset-md-1">

        <h3 class="col-md-12" style="padding-left: 69%;">إدارة الاطراف  >الاطراف الأخرى  &nbsp;   <i class="fa fa-address-card" aria-hidden="true"></i></h3>
        <br><br>
        <br><br>
        <div class="col-md-4 ">
            <a href="{{route('autre.create',$id)}}" class="btn btn-success"><i class="fa fa-plus"></i></a>
        </div>
        <br>
        <table class="table ">
            <thead class="table-info">
            <th>#</th>
            <th>الحضور</th>
            <th>المحافظ</th>
            </thead>
            <tbody>
            @foreach($autres as $autre)
                <tr>
                    <td><table>
                    <tr>
                    <td style="border:0;">
                        <span  id="delete"  id_autre="{{$autre->id_autre}}"   ><i class="fa fa-trash fa-lg" id="trash"></i></span>
                     </td>
                    <td style="border:0;"><a href="{{route('autre.edit',[$autre->id_autre,$id])}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td></tr></table></td>
                    <td>{{$autre->present==1?'نعم':'لا'}}</td>
                    <td>{{$autre->description_autre}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
@section('js')
    <script>
        $(function () {
            var modal1 = document.getElementById("myModal1");
            var span1 = document.getElementsByClassName("close3")[0];
            var btnclose2=document.getElementsByClassName("close4")[0];

            span1.onclick = function() {
                modal1.style.display = "none";
            };
            btnclose2.onclick = function() {
                modal1.style.display = "none";

            };
            $('.table').on('click','#delete',function (e){
                modal1.style.display = "block";
                $this=$(this);
//                e.preventDefault();
                $num_j=$this.attr('id_autre');

                $('#next').attr('href','/autre/delete_a/'+$num_j+'');

            });
            $('.table').on('click','#submit',function () {
                $(this).parent().submit();
            })
        })
    </script>
@endsection