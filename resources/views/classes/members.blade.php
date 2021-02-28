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
        <div class="col-sm-12">
            @if (session('activity'))
            <div class="alert alert-success">
                {{ session('activity') }}
            </div>
            @endif
        </div>

        <div class="col-sm-12">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        

        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }}</li>
            @endforeach
        </div>
        @endif

        <div class="">
            <div class="row">
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group" role="group" aria-label="Third group">
                        <button type="button" data-toggle="modal" data-target="#createclass" class="btn btn-secondary">Criar turma</button>
                    </div>                   
                  </div>
            </div>
        </div>

     
    </div>
</div>

@include('modals.create-class')
@endsection