@extends('app')
@section('title','إدارة العاملين')
@section('css')
    <style>
        #submit{
            cursor: pointer;
            color:dodgerblue;
        }
        #submit:hover{
            color: #000;
        }
    </style>
@endsection
@section('body')
    <div class="col-md-10 offset-md-1">
       
        <br><br>
        <table class="table ">
            <thead class="table-info">
            <th>#</th>
            <th>المهمة</th>
            <th>العنوان</th>
            <th>البريد الإلكتروني</th>
            <th>الهاتف</th>
            <th>الاسم الكامل</th>
            </thead>
            <tbody>
            @foreach($personnels as $personnel)
                <tr>
                    <td><table><tr><td style="border:0;">{{Form::open(['method'=>'delete','url'=>url('personnel/'.$personnel->id_personnel)])}}<a   id="submit"><i class="fa fa-trash"></i></a>{{Form::close()}}</td>
                    <td style="border:0;"><a href="{{route('personnel.edit',$personnel->id_personnel)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td></tr></table></td>
                    <td>{{$personnel->fonction}}</td>
                    <td>{{$personnel->adresse}}</td>
                    <td>{{$personnel->email}}</td>
                    <td>{{$personnel->tel_personnel}}</td>
                    <td>{{$personnel->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="navigation col-sm-6 offset-md-5">
            {{$personnels->links('vendor.pagination.bootstrap-4')}}
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function () {
            $('.table').on('click','#submit',function () {
                $(this).parent().submit();
            })
        })
    </script>
@endsection