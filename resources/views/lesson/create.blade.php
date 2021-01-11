@extends('layouts.admin')

@section('title', 'Criar Aula')

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
            <form action="{{url('/admin/lesson')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nome da aula</label>
                    <input type="text" maxlength="255" value="{{old('name')}}" required class="form-control" name="name" id="name" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="module">Escolha o módulo</label>
                    <select class="form-control" name="module_id" id="module">
                        @foreach($modules as $module)
                            <option @if(app('request')->input('module_id') == $module->id) selected @endif value="{{$module->id}}">{{$module->name}} 
--> {{$module->course->name}}</option>
                        @endforeach  
                    </select>
                </div>
                <div class="form-group">
                    <label for="pdf">Documento PDF</label>
                    <input type="file" name="pdf" id="pdf" accept=".pdf">
                </div>
                <div class="form-group">
                    <label for="video_link">Link do Vídeo</label>
                    <input type="text" maxlength="255" value="{{old('video_link')}}" required class="form-control" name="video_link" id="video_link" aria-describedby="emailHelp">
                </div>

                <div class="form-group">
                    <label for="descripion">Descrição da aula</label>
                    <textarea class="form-control" id="body" placeholder="Enter the Description" name="description">
                    {{old('description')}}
                    </textarea>
                </div>
                <button type="submit" class="btn btn-primary">Criar Aula</button>
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