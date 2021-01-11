@extends('layouts.admin')
@section('title', 'Aula')

@section('main')
    <h2>{{$lesson->name}}</h2>


    <iframe id="player" type="text/html" style="width: 100%;" height="500px"
                            src="{{$lesson->video_link}}?enablejsapi=1&origin=http://example.com"
                            frameborder="0"></iframe>

    <embed src="{{url($lesson->pdf_link)}}" style="width: 100%;"
                            height="500" type="application/pdf">
    
    <p>Curso: <a href="/admin/course/{{$lesson->module->course->id}}">{{$lesson->module->course->name}}</a></p>
    <p>Módulo: <a href="/admin/module/{{$lesson->module->name}}">{{$lesson->module->name}}</a></p>
   
    
    <small>Descrição: </small>
    <div>
        {!!$lesson->description!!}
    </div>
@endsection