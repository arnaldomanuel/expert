@extends('layouts.admin')
@section('title', 'Aula')

@section('main')
    <h2>{{$lesson->name}}</h2>
    <p>Aula número {{$lesson->order}} </p>

@if($lesson->video_link)
    <iframe id="player" type="text/html" style="width: 100%;" height="500px"
                            src="{{$lesson->video_link}}?enablejsapi=1&origin=http://expert.co.mz"
                            frameborder="0"></iframe>
@endif
@if($lesson->pdf_link)
    <embed src="{{$lesson->pdf_link?url($lesson->pdf_link):''}}" style="width: 100%;"
                            height="500" type="application/pdf">
@endif
@if($lesson->audio_path)
    <audio style="width: 100%;" controls>
        <source src="{{$lesson->audio_path?url($lesson->audio_path):''}}" type="audio/mpeg">
        Your browser does not support the audio tag.
        </audio>    
    @endif
    <p>Curso: <a href="/admin/course/{{$lesson->module->course->id}}">{{$lesson->module->course->name}}</a></p>
    <p>Módulo: <a href="/admin/module/{{$lesson->module->name}}">{{$lesson->module->name}}</a></p>
    <p><b>Transcrito</b>: {{$lesson->audio_transcript}}</p>
    
    <small>Descrição: </small>
    <div>
        {!!$lesson->description!!}
    </div>
@endsection