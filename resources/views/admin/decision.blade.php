@extends('app')
@section('title','ماهية الحكم')
@section('css')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=b1kbqbjdc49caon3ft5tmqlrda6d4v0ovlqz8s8n5zrqvftd"></script>
    <script>tinymce.init({
            selector:'textarea',
            menubar:true,
            themes: "modern",
            entity_encoding: 'raw',
            entities: '160,nbsp,38,amp,60,lt,62,gt',
            plugins: "directionality",
            toolbar: "rtl"
        });
    </script>
@endsection
@section('body')
    <div class="col-md-8 offset-md-2">
        <form action="{{route('dossier.decisionAdd')}}" method="post">
            {{csrf_field()}}
            <div class="form-group" dir="rtl">
                {{ Form::label('description_autre','  الملفات :') }}
                <select name="num_dossier" class="form-control">
                    @foreach($dossiers as $dossier)
                    <option value="{{$dossier->num_dossier}}">{{$dossier->num_dossier}}</option>
                    @endforeach
                </select>
            </div>
        <div class="form-group" dir="rtl">

            {{ Form::label('description_autre','  ماهية الحكم :') }}
            <br><br>
            {{ Form::textarea('decision_jugement',null,['placeholder'=>'','class'=>'form-control','row'=>'5','id'=>'texta']) }}
        </div>
        <div class="form-group" dir="rtl">
            <button class="btn btn-success btn-block"><i class="fa fa-plus fa-lg"></i></button>

        </div>
        </form>
    </div>
@endsection
@section('js')
@endsection