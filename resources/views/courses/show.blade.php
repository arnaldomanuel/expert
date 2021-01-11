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

<h5 style="margin-top: 10px;">Módulos de {{$course->name}}</h5>
<table class="table table-hover table-responsive">
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
@endsection