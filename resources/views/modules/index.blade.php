@extends('layouts.admin')
@section('title', 'Lista de módulos')

@section('main')
<h3>Lista de módulos</h3>
<div class="col-sm-12">
    @if (session('activity'))
    <div class="alert alert-success">
        {{ session('activity') }}
    </div>
    @endif
</div>

<table class="table table-hover table-responsive">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>

        @foreach ($modules as $module)
        <tr>
            <th scope="row">{{$module->id}}</th>
            <td> <a href="/admin/module/{{$module->id}}">{{$module->name}}</a></td>
            <td><a href="/admin/module/{{$module->id}}/edit"><i class="fas fa-edit"></i></a></td>
            <x-modal-bootsrap :modalID="'module'.$module->id" :modalTitle="'Quer mesmo apagar '. $module->name. '? Isto vai
                apagar todas as aulas, quizzes e dados relativos ao módulo'" 
                 :denyText="'Não'"
                 :confirmText="'Sim'"
                 :formId="'formModuleDelete'.$module->id"
                /> 
            <td>
            <button class="btn" data-toggle="modal" data-target="#{{'module'.$module->id}}"><i class="fas fa-trash"></i></button>
               
                <form action="{{route('module.destroy', $module->id)}}" id="formModuleDelete{{$module->id}}" method="post">
                    @method('delete')
                    @csrf
                   
                </form>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>
@endsection