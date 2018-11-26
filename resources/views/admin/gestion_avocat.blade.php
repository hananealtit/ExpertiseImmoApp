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
        th{
            text-align: center;
        }
        td{
            text-align: center;
        }
    </style>
@endsection
@section('body')
    <div class="col-md-10 offset-md-1">

        <br><br>
        <table class="table ">
            <thead class="table-info">
            <th>#</th>
            <th>العنوان</th>
            <th>المدينة</th>
            <th>الاسم الكامل</th>
            </thead>
            <tbody>
            @foreach($avocats as $avocat)
                <tr>
                    <td><table><tr><td style="border:0;"></td>
                    <td style="border:0;"><a href="{{route('avocat.edit',$avocat->id_avocat)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td></tr></table></td>
                    <td>{{$avocat->adresse_avocat}}</td>
                    <td>{{$avocat->ville}}</td>
                    <td>{{$avocat->nom_avocat}}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="navigation col-sm-6 offset-md-5">
            {{$avocats->links('vendor.pagination.bootstrap-4')}}
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