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
        

        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li> {{ $error }}</li>
            @endforeach
        </div>
        @endif

        <div class="">
            <div class="row">

                <div class="col-sm-12">
                    <form action="/admin/coursegrant/search" method="get">
                        <div class="form-group">
                            <label for="name">Pesquisar por token</label>
                            <input type="search" class="form-control" name="search" id="">
                        </div>
                    
                    </form>
                </div>

                <table class="table table-hover ">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Código de acesso</th>
                            <th scope="col">Curso</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                
                        @foreach ($courseGrants as $courseGrant)
                        <tr>
                            <td>{{$courseGrant->user_id}}</td>
                            <td> {{$courseGrant->token}} </td>
                            <td> {{$courseGrant->name}} </td>

                           
                            <td>
                                @if ($courseGrant->authorize == 0)
                                <form style="display: inline-block;" action="/admin/approve-token" method="POST">
                                    <input type="hidden" value="{{$courseGrant->token}}" name="token">
                                    <input type="hidden" value="{{$courseGrant->user_id}}" name="user_id">
                                    @csrf
                                    <button class="btn btn-primary">Aprovar</button> 
                                </form>


                                <form style="display: inline-block;" action="/admin/reprove-token" method="POST">
                                    <input type="hidden" value="{{$courseGrant->token}}" name="token">
                                    <input type="hidden" value="{{$courseGrant->user_id}}" name="user_id">
                                    @csrf
                                    <button class="btn-danger btn" >Reprovar</button> 
                                </form>
                                @endif
                                @if ($courseGrant->authorize == 1)
                                    Aprovado
                                @endif
                                @if ($courseGrant->authorize == 2)
                                    Reprovado
                                @endif
                            </td>
                          


                           
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