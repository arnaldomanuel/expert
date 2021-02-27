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
               

                  <div class="row">
                      <div class="col-sm-6">
                        <p>Aulas sob demanda</p>
                        <div id="ondemanddiv1" class="form-check form-check-inline">
                            <input class="form-check-input"  type="radio" name="ondemand" id="ondemand1" value="1">
                            <label class="form-check-label" for="ondemand1">Sim</label>
                        </div>
                          <div class="form-check form-check-inline" id="ondemanddiv2">
                            <input class="form-check-input" type="radio" name="ondemand" id="ondemand2" checked value="0">
                            <label class="form-check-label" for="ondemand2">Não</label>
                          </div> <p></p>
                      </div>
                      <div class="col-sm-6" id="demand">
                        <div class="form-group">
                            <label for="start_lesson">Data de ínicio das aulas</label>
                            <input required type="date"  value="{{old('start_lesson')}}"  
                            class="form-control" name="start_lesson" id="start_lesson"  >
                        </div>
                      </div>
                  </div>
                <button type="submit" class="btn btn-primary">Criar Curso</button>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>

    $(document).ready(function(){
        $('#demand').hide()
        $('#ondemanddiv1').click(function(){
            $('#demand').show()
        })
        $('#ondemanddiv2').click(function(){
            $('#demand').hide()
        })
    })




    $("#lesson_start").flatpickr({ enableTime: true,
    dateFormat: "Y-m-d H:i",});
ClassicEditor
.create( document.querySelector( '#body' ) )
.catch( error => {
console.error( error );
} );
</script>
<script src="/js/additem.js"></script>

@endsection