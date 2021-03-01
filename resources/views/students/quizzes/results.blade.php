@extends('layouts.public')

@section('main')

<div class="row">
    <div class="col s12 m4">
        <h2>Resultados dos quizzes feitos</h2>
    </div>
</div>

<div class="row">
   

    @foreach ($quizzResults as $quizzResult)
    <div class="col s12 m4">
      <div class="card {{$quizzResult->count >= $quizzResult->total_count/2 ? 'teal' : 'red darken-2'}}      ">
        <div class="card-content white-text">
         <p class="center"> <span class="card-title">{{$quizzResult->module->name}}</span></p>
          <p class="center"><span style="font-size: 50px;" class="material-icons">
            architecture
            </span>
        </p>
        <p class="center">
            {{$quizzResult->count}}/{{$quizzResult->total_count}}
        </p>
        </div>
     
      </div>
    </div>
    @endforeach

  
  </div>
@endsection