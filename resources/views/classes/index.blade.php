@extends('layouts.admin')

@section('title', 'Lista de turmas')

@section('main')


<style>
    @media only screen and (min-width: 1000px) {
        .min-width-main-card {
            min-width: 50%;
        }
    }

    @media only screen and (max-width: 999px) {
        .min-width-main-card {
            min-width: 70%;
        }
    }

    @media only screen and (max-width: 599px) {
        .min-width-main-card {
            max-width: 80%;
        }
    }

    @media only screen and (max-width: 199px) {
        .min-width-main-card {
            min-width: 100%;
        }
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

<div class="card min-width-main-card">
    <div class="card-body">
        <div class="col-sm-12">
            @if (session('activity'))
            <div class="alert alert-success">
                {{ session('activity') }}
            </div>
            @endif
        </div>

        <div class="col-sm-12">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        

        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }}</li>
            @endforeach
        </div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group" role="group" aria-label="Third group">
                        <button type="button" data-toggle="modal" data-target="#createclass" class="btn btn-secondary">Criar turma</button>
                    </div>                   
                  </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <h4>Lista de turmas de todos os cursos</h4>
                <table class="table table-hover ">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Activo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($schoolClasses as $schoolClass)
                        <tr>
                            <td> {{$schoolClass->class_name}}</td>
                            <td> {{$schoolClass->course->name}}</td>
                            <td> {{$schoolClass->active === 1 ? 'Sim' : 'Não'}}</td>
                            <td>
                                <button data-target="#liststudent{{$schoolClass->id}}" data-toggle="modal" class="btn btn-primary" >Ver lista de alunos</button>
                                <button data-target="#createclass{{$schoolClass->id}}" data-toggle="modal" class="btn btn-primary">Editar</button>
                            </td>
                        </tr>
                    @endforeach
                
                
                    </tbody>
                </table>
                
            </div>
        </div>

     
    </div>
</div>
@include('modals.list-students')
@include('modals.create-class')
@include('modals.edit-class')
@endsection