@extends('layouts.admin')
@section('title', 'Lista de Cursos')

@section('main')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<h3>Lista de Cursos</h3>
<div class="col-sm-12">
    @if (session('activity'))
    <div class="alert alert-success">
        {{ session('activity') }}
    </div>
    @endif
</div>

<table class="table table-hover ">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Descrição</th>
            <th scope="col">Ícone</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>

        @foreach ($banners as $banner)
        <tr>
            <th scope="row">{{$banner->id}}</th>
            <td> {{$banner->description}}</td>
            <td> <span class="material-icons">
                {{$banner->icon}}
                </span></td>
           
            <x-modal-bootsrap :modalID="'bannerModal'.$banner->id" :modalTitle="'Quer mesmo apagar este banner?'" 
                 :denyText="'Não'"
                 :confirmText="'Sim'"
                 :formId="'banner'.$banner->id"
                /> 
            <td>
            <button class="btn" data-toggle="modal" data-target="#{{'bannerModal'.$banner->id}}"><i class="fas fa-trash"></i></button>
               
                <form action="{{route('banner.destroy', $banner->id)}}" id="banner{{$banner->id}}" method="post">
                    @method('delete')
                    @csrf
                   
                </form>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>
<div>
</div>
@endsection