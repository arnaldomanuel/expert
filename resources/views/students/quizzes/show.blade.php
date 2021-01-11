@extends('layouts.public')

@section('main')

@if(count($quizzes)>0)
<div id="carousel" class="carousel carousel-slider center">
    @foreach ($quizzes as $quizz)
    <div class="carousel-item card white-text" href="#one!">
        <h2 class="black-text">{{$quizz->question}}</h2>
        <p>
            <label>
              <input name="pergunta{{$quizz->id}}" value="1" type="radio"  />
              <span>{{$quizz->first}}</span>
            </label>
          </p>
          <p>
            <label>
              <input name="pergunta{{$quizz->id}}" value="2" type="radio"  />
              <span>{{$quizz->second}}</span>
            </label>
          </p>
          <p>
            <label>
              <input name="pergunta{{$quizz->id}}" value="3" type="radio"  />
              <span>{{$quizz->third}}</span>
            </label>
          </p>
          <p>
            <label>
              <input name="pergunta{{$quizz->id}}" value="4" type="radio"  />
              <span>{{$quizz->fourth}}</span>
            </label>
          </p>

          
      </div>
    @endforeach

  </div>


    <!-- Modal Structure -->
    <div id="modal1" class="modal">
      <div class="modal-content">
       <span id="sucess">
        <h4 class="center">Parabéns!</h4>
        <p  class="center">   <i  class="prize material-icons">emoji_events</i></p>
      
       </span>
       <span id="failure">
        <h4 class="center">Oh, Não! Tente novamente</h4>
       <p  class="center">   <i  class="prize red-text material-icons">error</i></p>
    
      </span>
      <p class="center"><span id="resultPoints"></span>/ <span id="slideTotalPoints"></span></p>
    </div>
      <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">OK</a>
      </div>
    </div>
 
<p class="center">

 <span id="slideId">1</span>/<span id="slideTotal"></span>
</p>
 <p class="center">
    <button id="next" onclick="prev()" class="btn left">Anterior <i class="material-icons left">arrow_back_ios</i></button>
    <button class="btn" onclick="calc()">Submeter Quizz</button>
    <button id="prev" onclick="next()" class="btn right">Próximo <i class="material-icons right">arrow_forward_ios</i></button>
 </p>
@else 

 <div>
  <h1 class="title-main center">Este teste ainda não está disponível</h1>
  <p class="center"><span class="material-icons prize">
    sentiment_very_dissatisfied
    </span>
    <br>
    <button class="btn" onclick="history.back()">Voltar</button>
  </p>
    
 </div>
@endif
<style>
  .title-main{
    margin-top: 50px;
  }
  .prize{
    font-size: 70px;
    color: #673ab7;
  }
  #searchnav{
    display: none;
  } 
</style>
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script>
  var quizzes = JSON.parse(@json($quizzesJSON));
  var slideId = 1;
  var slideTotal = {{count($quizzes)}};
  var user_id = {{auth()->user()->id}}
  var module_id = {{$module->id}}
</script>
<script src="/js/quizz.js"></script>
@endsection
@endsection