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
                <table class="table table-hover ">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Curso</th>
                        </tr>
                    </thead>
                    <tbody>
                
                        @foreach ($courseGrants as $courseGrant)
                        <tr>
                            <td>{{$courseGrant->nome}}</td>
                            <td> {{$courseGrant->curso}} </td>
                        </tr>
                        @endforeach
                
                    </tbody>
                </table>
                <p class="text-center">{{$courseGrants->links()}}</p>
            </div>
        </div>
     
    </div>
</div>

@endsection