@extends('layouts.admin')
@section('title', $course->name)

@section('main')
<div class="col-sm-12">
    @if (session('activity'))
    <div class="alert alert-success">
        {{ session('activity') }}
    </div>
    @endif
</div>

<div class="p-3 mb-2 bg-light text-dark">
    <div style="position: relative;" class="row">
        <span class="btn btn-primary" style="position: absolute; top: 0; right: 0px; 
        color: white !important;"><a style="color: white !important;" href="/admin/course/{{$course->id}}/edit">Editar {{$course->name}}</a></span>
        
        <span   style="position: absolute; top: 50px; right: 0px; 
        color: white !important;"><button data-target="#{{'course'.$course->id}}" data-toggle="modal" class="btn btn-primary" style="color: white !important;" 
        >Apagar {{$course->name}}</button></span>

        <span class="btn btn-primary" style="position: absolute; top: 100px; right: 0px; 
        color: white !important;"><a style="color: white !important;" href="/admin/course/{{$course->id}}/members">Turmas</a></span>
        
        
        <div class="col-sm1-2">
            <h4>{{$course->name}}</h4>
            <div style="padding-top: 10px;">
                <img style="width: 300px;" src="{{url($course->thumbnail)}}" alt="">
            </div>
            <p style="padding-top: 10px;"><i><small>Descrição: </small></i></p>
            <div>
                {!! $course->description !!}
            </div>
        </div>
    </div>
</div>
<h5>Objectivos do módulo</h5>
<div style="margin-bottom: 5px;" class="row">
    <div class="col-sm-12">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#objectivecreate">
            Adicionar Objectivo
        </button> 
    </div>
</div>

<table class="table table-hover ">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Descrição</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($objectives as $objective)
        <tr>
            <td> {{$objective->description}}</td>
            <td> <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#objective{{$objective->id}}">
                    Editar Objectivo
              </button> 

              
                  <form style="display: inline-block;" action="/admin/delete/objective" method="post">@csrf
                    <input type="hidden" name="objective_id" value="{{$objective->id}}">
                    <button type="submit" class="btn btn-danger">Apagar</button>
            </form>
            </td>
        </tr>
    @endforeach


    </tbody>
</table>

<h5 style="margin-top: 10px;">Módulos de {{$course->name}}</h5>
<table class="table table-hover ">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Curso</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($course->modules as $module)
        <tr>
            <th scope="row">{{$module->id}}</th>
            <td> <a href="/admin/module/{{$module->id}}">{{$module->name}}</a></td>
            <td> <a href="/admin/course/{{$module->course->id}}">{{$module->course->name}}</a></td>
            <td><a href="/admin/module/{{$module->id}}/edit"><i class="fas fa-edit"></i></a></td>
            <x-modal-bootsrap :modalID="'module'.$module->id" :modalTitle="'Quer mesmo apagar '. $module->name. '? Isto vai
                apagar todas as aulas, quizzes e dados relativos ao módulo'" 
                 :denyText="'Não'"
                 :confirmText="'Sim'"
                 :formId="'formModuleDelete'.$module->id"
                /> 
            <td>
            <button class="btn" data-toggle="modal" data-target="#{{'module'.$module->id}}">
                <i class="fas fa-trash"></i></button>
               
                <form action="{{route('module.destroy', $module->id)}}" id="formModuleDelete{{$module->id}}" method="post">
                    @method('delete')
                    @csrf
                </form>
            </td>
        </tr>
        @endforeach


    </tbody>
</table>

<x-modal-bootsrap :modalID="'course'.$course->id" :modalTitle="'Quer mesmo apagar '. $course->name. '? Isto vai
                apagar todas as aulas, quizzes e dados relativos ao curso'" 
                 :denyText="'Não'"
                 :confirmText="'Sim'"
                 :formId="'formcourseDelete'.$course->id"
                /> 
<form action="{{route('course.destroy', $course->id)}}" id="formcourseDelete{{$course->id}}" method="post">
    @method('delete')
    @csrf
</form>

@foreach ($objectives as $objective)
<div class="modal fade" id="objective{{$objective->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alterar objectivo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/admin/update/objective" method="post">
            @csrf
              <input type="hidden" value="{{$objective->id}}" name="objective_id">
            <div class="form-group">
                <input type="text" name="objective" class="form-control" value="{{$objective->description}}">
            </div>
            <button class="btn btn-primary" type="submit">Salvar</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="objectivecreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Adicionar objectivo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/admin/create/objective" method="post">
            @csrf
              <input type="hidden" value="{{$course->id}}" name="course_id">
            <div class="form-group">
                <input type="text" name="objective" class="form-control">
            </div>
            <button class="btn btn-primary" type="submit">Salvar</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
</div>

@endsection