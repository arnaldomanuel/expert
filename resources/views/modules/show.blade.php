@extends('layouts.admin')

@section('title', 'Módulo '. $module->name)

@section('main')
<style>
    body{
        background-color: #F8F8F8;
    }
    .panel-action{
        position: absolute;
        top: 10px;
        right: 0;
    }
    .relative4 {
        position: relative !important;
    }
</style>
<div class="relative container">
   
    <div class="row card relative4">
    @if (session('activity'))
    <div class="alert alert-success">
        {{ session('activity') }}
    </div>
    @endif
    <div style="position: relative;" class="row">
        <span class="btn btn-primary" style="position: absolute; top: 0; right: 0px; 
        color: white !important;"><a style="color: white !important;" href="/admin/module/{{$module->id}}/edit">Editar {{$module->name}}</a></span>
      
      <span class="btn btn-primary" style="position: absolute; top: 50px; right: 0px; 
        color: white !important;">
            <button data-target="#{{'module'.$module->id}}" data-toggle="modal" class="btn btn-primary" style="color: white !important;" 
        >Apagar {{$module->name}}</button>
        </span>
        
        <div class="col-sm1-2">
            <h4>{{$module->name}}</h4>
            <p>Módulo número {{$module->order}} </p>
            <div style="padding-top: 10px;">
                <img style="width: 300px;" src="{{url($module->photo_path)}}" alt="">
            </div>
            <p style="padding-top: 10px;"><i><small>Descrição: </small></i></p>
            <div>
                {!! $module->description !!}
            </div>
        </div>
    </div>

    </div>

    
    <div class="row card" style="margin-top: 40px; padding-top: 15px;" >
    <span class="btn btn-primary" style="position: absolute; top: 0; right: 0px; 
        color: white !important;"><a style="color: white !important;" href="/admin/lesson/create?module_id={{$module->id}}">Adicionar aula</a></span>
   
  
    <h5>Lista de Aulas neste módulo</h5>
        <table class="table table-hover ">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Ordem</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($module->lessons as $lesson)
                <tr>
                    <th scope="row">{{$lesson->id}}</th>
                    <td> <a href="/admin/lesson/{{$lesson->id}}">{{$lesson->name}}</a></td>
                    <td>{{$lesson->order}}</td>
                    <x-modal-bootsrap :modalID="'lesson'.$lesson->id" :modalTitle="'Quer mesmo apagar '. $lesson->name. '?'" :denyText="'Não'" :confirmText="'Sim'" :formId="'formDelete'.$lesson->id" />
                    <td><a href="/admin/lesson/{{$lesson->id}}/edit"><i class="fas fa-edit"></i></a></td>
                    <td>
                        <button class="btn" data-toggle="modal" data-target="#{{'lesson'.$lesson->id}}"><i class="fas fa-trash"></i></button>
                        <form action="{{route('lesson.destroy', $lesson->id)}}" id="formDelete{{$lesson->id}}" method="post">
                            @method('delete')
                            @csrf
                        </form>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>


<div class="row card" style="margin-top: 40px; padding-top: 15px;" >
    
  
    <h5>Perguntas do Quizz</h5>
    <div style="margin-top: 10px; margin-bottom: 10px;" class="col-sm-12">
        <a class="btn btn-primary"
            href="/admin/quizz/create?module_id={{$module->id}}">Adicionar Pergunta do Quizz</a>
    </div>
        <table class="table table-hover table-responsive">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Questão</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($quizzes as $quizz)
                <tr>
                    <th scope="row">{{$quizz->id}}</th>
                    <td> <a href="/admin/quizz/{{$quizz->id}}/edit">{{$quizz->question}}</a></td>
                    <x-modal-bootsrap :modalID="'quizz'.$quizz->id" :modalTitle="'Quer mesmo apagar '. $quizz->question. '?'" :denyText="'Não'" :confirmText="'Sim'" :formId="'formQuizzDelete'.$quizz->id" />
                    <td><a href="/admin/quizz/{{$quizz->id}}/edit"><i class="fas fa-edit"></i></a></td>
                    <td>
                        <button class="btn" data-toggle="modal" data-target="#{{'quizz'.$quizz->id}}"><i class="fas fa-trash"></i></button>
                        <form action="{{route('quizz.destroy', $quizz->id)}}" id="formQuizzDelete{{$quizz->id}}" method="post">
                            @method('delete')
                            @csrf
                        </form>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

<x-modal-bootsrap :modalID="'module'.$module->id" :modalTitle="'Quer mesmo apagar '. $module->name. '? Isto vai
                apagar todas as aulas, quizzes e dados relativos ao curso'" 
                 :denyText="'Não'"
                 :confirmText="'Sim'"
                 :formId="'formmoduleDelete'.$module->id"
                /> 
@endsection