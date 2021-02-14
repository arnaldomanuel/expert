@extends('layouts.public')
@section('title', $lesson->name)

@section('main')
<div style="margin-top: 20px;" class="row">
    <div class="col s12 white" style="margin-bottom: 10px; padding-bottom: 10px;;">
        <div>
            <h1 style="font-size: 26px; margin: 1rem 0 1rem 0;">{{$lesson->name}} - {{$lesson->module->course->name}}</h1>

            <span class="left"> <i><small>Criado por {{$lesson->module->course->user->name}}, 26 de Novembro de 2020</small></i> </span>
        </div>
    </div>
    <div class="col s12 xl8 l8 white">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    @if (isset($lesson->video_link) && isset($lesson->pdf_link))
                        <li class="tab col s6 "><a href="#test1">Aula vídeo</a></li>
                        <li class="tab col s6 "><a class="active" href="#test2">Documento da aula</a></li>
                    @else
                        @if (isset($lesson->video_link))
                            <li class="tab col s12 "><a href="#test1">Aula vídeo</a></li>
                        @endif
                        @if (isset($lesson->pdf_link))
                            <li class="tab col s12 "><a class="active" href="#test2">Documento da aula</a></li>
                        @endif
                    @endif
                    

                </ul>
            </div>
            @if (isset($lesson->video_link))
            <div id="test1" class="col s12">
                <iframe id="player" 
                allowfullscreen="allowfullscreen"
                mozallowfullscreen="mozallowfullscreen" 
                msallowfullscreen="msallowfullscreen" 
                oallowfullscreen="oallowfullscreen" 
                webkitallowfullscreen="webkitallowfullscreen"
                
                type="text/html" style="width: 100%;" height="500px" src="{!!$lesson->video_link.'?enablejsapi=1&origin=https://expert.co.mz'!!}" frameborder="0"></iframe>
            </div>
            @endif
            @if (isset($lesson->pdf_link))
            <div id="test2" class="col s12">
                <iframe src="https://docs.google.com/gview?url={{url($lesson->pdf_link)}}&embedded=true" style="width:100%; height:1000px;" frameborder="0"></iframe>

                <!--<embed src="{{url($lesson->pdf_link)}}" style="width: 100%;" height="500" type="application/pdf">
                --> </div>
            @endif
            
            
        </div>
        <div>
            <h3 style="font-size: medium; color: #673ab7; font-weight: 600; margin-top: 0;">»» {{$lesson->module->name}}
            </h3>
           
        </div>
    </div>
    <div class="col s12 xl4 l4 m12 ">
        <div style="padding: 10px;" class="white">
            <span style="padding-bottom: 10px; display: inline-block;"><small><i>Outras aulas do
                        curso</i></small></span>
            @foreach($suggestions as $lesson)
            <div class="row">
                <div class="col s6">
                    <img style="width: 200px; " src="/img/fabric.jpg" alt="">
                </div>
                <div class="col s6">
                    <h6>{{$lesson->name}}</h6>
                </div>
            </div>
            @endforeach

        </div>
    </div>

</div>
<style>
    body {
        background-color: #edeaf1;
    }
    h1, h2, h3, h4 {
            font-size: large !important;
            font-weight: 600 !important;
        }
</style>
@endsection