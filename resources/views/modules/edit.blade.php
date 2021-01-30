@extends('layouts.admin')

@section('title', 'Actualizar Módulo')

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
            <h3>Actualizar Módulo</h3>
            <form action="{{route('module.update', $module->id)}}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nome do Módulo</label>
                    <input type="text" maxlength="255" value="{{$module->name}}" required class="form-control" name="name" id="name" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="order">Número de ordem do módulo</label>
                    <input type="text" maxlength="255" value="{{$module->order}}" required class="form-control" name="order" id="order" aria-describedby="emailHelp">
                </div>
              
                <p>Thumbnail do módulo (Apenas se quiser alterar)</p>
                <div class="custom-file">
                    
                    <input type="file" class="custom-file-input" accept="image/x-png,image/gif,image/jpeg" name="photo_path" id="photo_path">
                    <label class="custom-file-label" for="photo_path">Choose file</label>
                </div>
                <div class="form-group">
                    <label for="descripion">Descrição da categoria</label>
                    <textarea class="form-control" id="body" placeholder="Enter the Description" name="description">
                        {{$module->description}}
                    </textarea>    
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Módulo</button>
            </form>
        </div>
    </div>
</div>

<script>
ClassicEditor
.create( document.querySelector( '#body' ) )
.catch( error => {
console.error( error );
} );
</script>

@endsection