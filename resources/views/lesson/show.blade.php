@extends('layouts.admin')
@section('title', 'Aula')

@section('main')
    <h2>{{$lesson->name}}</h2>
    <p>Aula número {{$lesson->order}} </p>


    <iframe id="player" type="text/html" style="width: 100%;" height="500px"
                            src="{{$lesson->video_link}}?enablejsapi=1&origin=http://expert.co.mz"
                            frameborder="0"></iframe>

    <embed src="{{url($lesson->pdf_link)}}" style="width: 100%;"
                            height="500" type="application/pdf">

    <audio style="width: 100%;" controls>
        <source src="{{url($lesson->audio_path)}}" type="audio/mpeg">
        Your browser does not support the audio tag.
        </audio>    
    
    <p>Curso: <a href="/admin/course/{{$lesson->module->course->id}}">{{$lesson->module->course->name}}</a></p>
    <p>Módulo: <a href="/admin/module/{{$lesson->module->name}}">{{$lesson->module->name}}</a></p>
    <p><b>Transcrito</b>: {{$lesson->audio_transcript}}</p>
    
    <small>Descrição: </small>
    <div>
        {!!$lesson->description!!}
    </div>
@endsection