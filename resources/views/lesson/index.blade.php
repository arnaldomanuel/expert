@extends('layouts.admin')
@section('title', 'Lista de aulas')

@section('main')
<h3>Lista de aulas</h3>
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

        @foreach ($lessons as $lesson)
        <tr>
            <th scope="row">{{$lesson->id}}</th>
            <td> <a href="/admin/lesson/{{$lesson->id}}">{{$lesson->name}}</a></td>
            <x-modal-bootsrap :modalID="'lesson'.$lesson->id" :modalTitle="'Quer mesmo apagar '. $lesson->name. '?'" 
                 :denyText="'Não'"
                 :confirmText="'Sim'"
                 :formId="'formDelete'.$lesson->id"
                /> 
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
@endsection