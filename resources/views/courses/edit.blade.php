@extends('layouts.admin')

@section('title', 'Editar Curso')

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
            <h3>Editar Curso</h3>
            <form action="{{route('course.update', $course->id)}}" enctype="multipart/form-data" method="POST">
                @method('PUT')
                @csrf
                
                <div class="form-group">
                    <label for="name">Nome do Curso</label>
                    <input type="text" maxlength="255" value="{{$course->name}}" required  class="form-control" name="name" id="name">
                </div>
                
                <div class="form-group">
                    <label for="price">Preço do Curso</label>
                    <input required type="number" step=".01" value="{{$course->price}}"  class="form-control" name="price" id="price"  >
                </div>
                        
                <div class="form-group">
                    <label for="price">Whatsapp</label>
                    <input required type="text"value="{{$course->whatsapp_number}}"  class="form-control" name="whatsapp_number" >
                </div>
                   
                <p>Actualizar o Thumbnail do curso. Se não quiser alterar, deixe como está</p>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" accept="image/x-png,image/gif,image/jpeg" 
                    name="thumbnail" id="thumbnail">
                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                </div>
               
                <div class="form-group">
                    <label for="descripion">Descrição da Curso</label>
                    <textarea class="form-control" id="body" placeholder="Enter the Description" name="description">
                        {!!$course->description!!}
                    </textarea>    
                </div>
                <div class="row">
                    <div class="row">
                        <div class="col-sm-12">
                          <p>Aulas sob demanda</p>
                          <div id="ondemanddiv1" class="form-check form-check-inline">
                              <input class="form-check-input"  type="radio"
                              @if ($course->ondemand == 1)
                                  checked
                              @endif
                              name="ondemand" id="ondemand1" value="1">
                              <label class="form-check-label" for="ondemand1">Sim</label>
                          </div>
                            <div class="form-check form-check-inline" id="ondemanddiv2">
                              <input class="form-check-input" type="radio" name="ondemand" id="ondemand2" @if ($course->ondemand == 0)
                                  checked
                              @endif value="0">
                              <label class="form-check-label" for="ondemand2">Não</label>
                            </div> <p></p>
                        </div>
                    </div>
                </div>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Curso</button>
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