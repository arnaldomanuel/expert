@extends('layouts.admin')

@section('title', 'Criar Curso')

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
            <h3>Criar Curso</h3>
            <form action="{{url('/admin/course')}}" enctype="multipart/form-data" method="POST">
                @csrf

                <div class="row">
                    <div class="col-sm-12 col-lg-8 col-xlg-8">
                        <div class="form-group">
                            <label for="name">Nome do Curso</label>
                            <input required type="text" maxlength="255" value="{{old('name')}}"  class="form-control" name="name" id="name" >
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 col-xlg-4">
                         
                <div class="form-group">
                    <label for="price">Preço do Curso</label>
                    <input required type="number" step=".01" value="{{old('price')}}"  class="form-control" name="price" id="price"  >
                </div>
                    </div>
                </div>
               
                <p>Thumbnail do curso</p>
                <div class="custom-file">
                    <input type="file" required class="custom-file-input" accept="image/x-png,image/gif,image/jpeg" name="thumbnail" id="thumbnail">
                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                </div>

                <div class="form-group">
                    <label for="descripion">Descrição da Curso</label>
                    <textarea class="form-control" id="body" placeholder="Enter the Description" name="description">
                        {{old('description')}}
                    </textarea>    
                </div>
               <div id="objectives">
                <div class="form-group">
                    <label for="objective1">Objectivo</label>
                    <input type="text" class="form-control" maxLength="230" name="objective1" id="objective1">
                </div>
               </div>
                <span class="btn btn-primary" id="addObjective">Adicionar objectivo</span>
               <p></p>
                <p>Aulas sob demanda</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input"  type="radio" name="ondemand" id="ondemand1" value="1">
                    <label class="form-check-label" for="ondemand1">Sim</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ondemand" id="ondemand2" checked value="0">
                    <label class="form-check-label" for="ondemand2">Não</label>
                  </div> <p></p>
                <button type="submit" class="btn btn-primary">Criar Curso</button>
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
<script src="/js/additem.js"></script>

@endsection