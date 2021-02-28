@extends('layouts.admin')

@section('title', 'Actualizar Aula')

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

        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li> {{ $error }}</li>
            @endforeach
        </div>
        @endif

        <div class="">
            <h3>Criar Aula</h3>
            <form action="{{route('lesson.update', $lesson->id)}}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nome da aula</label>
                    <input type="text" maxlength="255" value="{{$lesson->name}}" required class="form-control" name="name" id="name" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="module">Escolha o módulo</label>
                    <select class="form-control" name="module_id" id="module">
                        @foreach($modules as $module)
                            <option @if($lesson->module->id == $module->id) selected @endif value="{{$module->id}}">{{$module->name}}</option>
                        @endforeach  
                    </select>
                </div>
                <div class="form-group">
                    <label for="order">Número de ordem da aula</label>
                    <input type="text" maxlength="255" value="{{$lesson->order}}" required class="form-control" name="order" id="order" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="pdf">Documento PDF (Somente se quiser alterar o PDF) </label>
                    <input type="file" name="pdf" id="pdf" accept=".pdf">
                </div>

                <div class="form-group">
                    <label for="video_link">Link do Vídeo</label>
                    <input type="text" maxlength="255" value="{{$lesson->video_link}}" required class="form-control" name="video_link" id="video_link" aria-describedby="emailHelp">
                </div>

                <div class="form-group">
                    <label for="descripion">Descrição da categoria</label>
                    <textarea class="form-control" id="body" placeholder="Enter the Description" name="description">
                        {{$lesson->description}}
                    </textarea>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Aula</button>
            </form>
        </div>
    </div>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#body'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection