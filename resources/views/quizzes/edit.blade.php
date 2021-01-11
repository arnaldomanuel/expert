@extends('layouts.admin')

@section('title', 'Actualizar Pergunta')

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
            <h3>Actualizar Pergunta</h3>
            <form action="{{route('quizz.update', $quizz->id)}}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Questão</label>
                    <input type="text" maxlength="255" 
                        value=" {{$quizz->question}} " 
                        required class="form-control" name="question" id="name" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="name">Primeira Resposta</label>
                    <input type="text" maxlength="255" value=" {{$quizz->first}} " 
                     required class="form-control" name="first" id="first" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="second">Segunda Resposta</label>
                    <input type="text" maxlength="255" 
                    value="{{$quizz->second}} "
                    required class="form-control" name="second" id="second" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="third">Terceira Resposta</label>
                    <input type="text" maxlength="255" 
                    value="{{$quizz->third}} "
                    required class="form-control" name="third" id="third" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="fourth">Quarta Resposta</label>
                    <input type="fourth" maxlength="255" 
                    value=" {{$quizz->fourth}} "
                    required class="form-control" name="fourth" id="fourth" aria-describedby="emailHelp">
                </div>
        
                <div class="form-group">
                    <label for="course_id">Resposta correcta</label>
                    <select class="form-control" name="correct_index" id="correct_index">

                            <option @if ($quizz->correct_index == "1") selected @endif value="1">Primeira</option>
                            <option @if ($quizz->correct_index == "2") selected  @endif value="2">Segunda</option>
                            <option @if ($quizz->correct_index == "3") selected @endif value="3">Terceira</option>
                            <option @if ($quizz->correct_index == "4") selected @endif value="4">Quarta</option>
                       
                    </select>
                </div>

              
                <button type="submit" class="btn btn-primary">Actualizar Pergunta</button>
            </form>
        </div>
    </div>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#body'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection