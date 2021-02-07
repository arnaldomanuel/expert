@extends('layouts.admin')

@section('title', 'Definições')

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
            <div class="row">
                <form action="{{url('/admin/saveOptions')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nome do MPESA</label>
                        <input required type="text" maxlength="255" value="{{$user->mpesa_name}}"  
                        class="form-control" name="mpesa_name" id="name" >
                    </div>
                    <div class="form-group">
                        <label for="name">Número do MPESA</label>
                        <input required type="text" maxlength="255" value="{{$user->mpesa_number}}"  
                        class="form-control" name="mpesa_number" id="name" >
                    </div>
                    <div class="form-group">
                        <label for="name">Número do Whatsapp (incluir o 258)</label>
                        <input required type="text" maxlength="255" value="{{$user->whatsapp_number}}"  
                        class="form-control" name="whatsapp_number" id="name" >
                    </div>
                    <div class="form-group">
                        <label for="name">Biografia</label>
                        <textarea class="form-control" name="biography" id="" cols="20" rows="10">{{$user->biography}}</textarea>
                       
                    </div>
                    <br>
                    <p>Foto do Perfil</p>
                    @if (auth()->user()->profilepic)
                        <img src="{{url(auth()->user()->profilepic)}}" width="200px" style="margin-bottom: 15px;" class="rounded" alt="Cinque Terre">
                    @endif
                   

                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file"  class="custom-file-input" accept="image/x-png,image/gif,image/jpeg" name="profilepic" id="thumbnail">
                            <label class="custom-file-label" for="thumbnail">Escolha a foto de Perfil</label>
                        </div>
                    </div>
                  
                    <br>
                    <button type="submit" class="btn btn-primary">Actualizar Dados</button>
                </form>
            </div>
        </div>
     
    </div>
</div>

@endsection