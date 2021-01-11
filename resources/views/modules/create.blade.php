@extends('layouts.admin')

@section('title', 'Criar Módulo')

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
            <h3>Criar Módulo</h3>
            <form action="{{url('/admin/module')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nome do Módulo</label>
                    <input type="text" maxlength="255" value="{{old('name')}}" required class="form-control" name="name" id="name" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="course_id">Curso do módulo</label>
                    <select class="form-control" name="course_id" id="course_id">
                        @foreach($courses as $course)
                            <option value="{{$course->id}}">{{$course->name}}</option>
                        @endforeach
                    </select>
                </div>
                <p>Thumbnail do módulo</p>
                <div class="custom-file">
                    
                    <input type="file" class="custom-file-input" accept="image/x-png,image/gif,image/jpeg" name="photo_path" id="photo_path">
                    <label class="custom-file-label" for="photo_path">Choose file</label>
                </div>
                <div class="form-group">
                    <label for="descripion">Descrição da categoria</label>
                    <textarea class="form-control" id="body" placeholder="Enter the Description" name="description"></textarea>    
                </div>
                <button type="submit" class="btn btn-primary">Criar Módulo</button>
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