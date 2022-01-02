@extends('layouts.admin')

@section('title', 'Banner')

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
                <form style="width: 80%;" action="{{url('/admin/banner')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Descrição do banner</label>
                        <input required type="text" maxlength="255"   
                        class="form-control" name="description" id="name" >
                    </div>
                    <div class="form-group">
                        <label for="name">Nome do ícone</label>
                        <input required type="text" maxlength="255"  
                        class="form-control" name="icon" id="name" >
                    </div>
                    
                    <br>
                   
                    <br>
                    <button type="submit" class="btn btn-primary">Adicionar banner</button>
                </form>
            </div>
        </div>
     
    </div>
</div>

@endsection