@extends('app')
@section('title','ماهية الحكم')
@section('css')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=b1kbqbjdc49caon3ft5tmqlrda6d4v0ovlqz8s8n5zrqvftd"></script>
    <script>tinymce.init({
            selector:'textarea',
            plugins: "link code",
            themes: "modern",
            force_br_newlines : true,
            apply_source_formatting : false,
            force_p_newlines : true,
            invalid_elements :'strong,b,em,span,div,img,a,table,td,th,tr,header,font,body,h,h1,h2,h3,h4,h5',
            invalid_styles: 'color font-size text-decoration font-weight',
            menubar: true,
            toolbar:false,
            statusbar:false,
            forced_root_block : "",
            cleanup: true,
            remove_linebreaks: true,
            convert_newlines_to_brs: false,
            inline_styles : false,
            entity_encoding: 'raw',
            entities: '160,nbsp,38,amp,60,lt,62,gt',

        });
    </script>
@endsection
@section('body')
    <div class="col-md-8 offset-md-2">
        <form action="{{route('dossier.add_content_report',$id)}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group col-md-8">
                <dl class="row">
                    <dt class="col-sm-8">{{Form::select('num_immo',$immobiliers,null,['class'=>'form-control'])}}</dt>
                    <dd class="col-sm-4">{{Form::label('num_immo',': العقار  ')}}</dd>
                </dl>
            </div>
            <div class="form-group" dir="rtl">
                {{ Form::label('titre','  العنوان  :') }}
                {{Form::text('titre',null,['class'=>'form-control','placeholder'=>'العنوان '])}}
            </div>
        <div class="form-group" dir="rtl">
            {{ Form::label('contents','  نص التقرير :') }}
            <br><br>
            {{ Form::textarea('contents',null,['placeholder'=>'نص التقرير','class'=>'form-control','row'=>'5','id'=>'texta']) }}
        </div>
            <div class="col-md-8" style="float:left;">
                <table class="table">
                    <tr>
                        <td>
                            {{Form::label('name','الصورة ')}}
                            {{Form::file('name[]')}}
                        </td>
                        <td class="col-md-4">
                            <a href="" id="add_img">إضافة صورة أخرى</a>
                        </td>
                    </tr>
                </table>

            </div>
            <br><br>
        <div class="form-group" dir="rtl">
            <button class="btn btn-primary "><i class="fa fa-plus fa-lg"></i></button>

        </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        $(function () {
            $('#add_img').on('click',function (e) {
                e.preventDefault()
            $('.table').append('<tr><td>{{Form::label('name','الصورة ')}}{{Form::file('name[]')}}</td></tr>')
            })
        })
    </script>
@endsection