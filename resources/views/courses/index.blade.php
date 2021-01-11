@extends('layouts.admin')
@section('title', 'Lista de Cursos')

@section('main')
<h3>Lista de Cursos</h3>
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

        @foreach ($courses as $course)
        <tr>
            <th scope="row">{{$course->id}}</th>
            <td> <a href="/admin/course/{{$course->id}}">{{$course->name}}</a></td>
            <td><a href="/admin/course/{{$course->id}}/edit"><i class="fas fa-edit"></i></a></td>
            <x-modal-bootsrap :modalID="'course'.$course->id" :modalTitle="'Quer mesmo apagar '. $course->name. '? Isto vai
                apagar todas as aulas, quizzes e dados relativos ao curso'" 
                 :denyText="'Não'"
                 :confirmText="'Sim'"
                 :formId="'formcourseDelete'.$course->id"
                /> 
            <td>
            <button class="btn" data-toggle="modal" data-target="#{{'course'.$course->id}}"><i class="fas fa-trash"></i></button>
               
                <form action="{{route('course.destroy', $course->id)}}" id="formcourseDelete{{$course->id}}" method="post">
                    @method('delete')
                    @csrf
                   
                </form>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>
<div>
{{ $courses->links() }}
</div>
@endsection