@extends('layouts.public')
@section($module->name, 'Página do módulo')
@section('main')
<div class="row">

    <div style="height: 260px; width: 100%; background-image: url(/img/p4.jpg); background-position: bottom;
            background-size:cover;" class="col s12 m12 l12 xl12">
        <div style=" margin-top: 80px; margin-left:10px; height: 120px; width: 120px !important;">
            <img style=" height: 180px; width: 180px !important;" src="{{url($module->photo_path)}}" alt="">

        </div>
    </div>

</div>
<div class="row">
    <div class="col s12 m3 l3 xl3">
        <div class="col s12 m12 l12">
            <div class="card-panel grey lighten-5 z-depth-1">
                <div class="row valign-wrapper">
                    <div class="col s6">
                       
                            <img src="{{$module->course->user->profilepic ? $module->course->user->profilepic : url('img/avatar.jpg') }}" alt="" class="circle  responsive-img"> <!-- notice the "circle" class -->
                        
                    </div>
                    <div class="col s10">
                        <span class="black-text">
                            <p class="center">{{$module->course->user->name}}</p>
                            <p class="center"><i class="material-icons">school</i></p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m9 l9 xl9">
        <div class="card-panel grey lighten-5 z-depth-1">
            <div >
              
                <h1 class="">{{$module->name}}</h1>
            
            </div>
            <div style="">
                {!!$module->description!!}
            </div>
        </div>

    </div>

    <div class="">
        <div class="row">
            <div class="col s12 m12 l12 xl12">
                <h1 style="border-bottom: 1px solid black; padding-bottom: 10px;"><span class="material-icons">
                        pages
                    </span> Aulas do Módulo  <a class="btn right" href="/quizz/{{$module->id}}">Fazer Teste</a></h1>
                   
            </div>

        </div>
        <div class="row">
            <div class="col s12 m6 l12 xl12">
                <ul class="collapsible">
                    @foreach($module->lessons as $lesson)
                    <li>
                        <div class="collapsible-header"><i class="material-icons">play_lesson</i>{{$lesson->name}}</div>
                        <div class="collapsible-body" class="center">
                            <p class="center"><a class="btn" href="/aulas/{{$lesson->id}}">Assistir aula</a></p>
                        </div>
                    </li>
                    @endforeach
                    
                    
                </ul>
            </div>

        </div>



    </div>
</div>
@endsection