@extends('layouts.public')
@section('css')
    <link rel="stylesheet" href="/css/loading.css">
@endsection
@section('main')
<div class="row" >


    <div class="col s12 l6 m12">
      
       <div style="padding-bottom: 20px;" class="card">
            <img class="materialboxed course-thumbnail circle responsive-img" 
            style="width: 100% !important; max-height:500px;" 
            src="{{url($course->thumbnail)}}" alt="">
            <h1 class="center" style="width:100%; padding-top: 20px; color: black;" class="center circle">{{$course->name}}</h1>
        </div>
        <div class="row">
            <div class="col s12 m6 l5 xl5">
                    <div class="card-panel orange lighten-2 z-depth-1">
                        <div class="row">
                            <div class="col s12">
                                <img src="{{url('img/avatar.jpg') }}"
                                 class="circle  responsive-img"> <!-- notice the "circle" class -->
                            </div>
                            <div class="col s12">
                                <span class="black-text">
                                    <p style="font-weight: 700;" class="center">{{$course->user->name}}</p>
                                    <p class="center"><i class="material-icons">school</i></p>
                                </span>
                                <p class="black-text center">
                                    {{$course->user->biography}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <div class=" col s12 m6 l7 xl7">
             
                <div class="card-panel">
                    {!!$course->description!!}
                </div>
            </div>
        </div>

    </div>
    <div class="col s12 m12 l6">
        <div class="card-panel grey lighten-5 z-depth-1">
          

        <div>
            @if (!isset($courseGrant) ||  $courseGrant->authorize==\App\Models\CourseGrant::REPROVED)
                <p style="text-align: right;">
                    <button  id="btnRequest" onclick="requestToken()" class="waves-effect waves-light btn"><i class="material-icons left">event_note</i>Requisitar acesso</button> 
                </p>
                <span id="loader" style="display: none" class="lds-dual-ring"></span>
            @endif
            @if (isset($courseGrant)) 
                @if( $courseGrant->authorize==\App\Models\CourseGrant::UNPROCESSED)
                <div style="padding-bottom: 0px; margin-bottom:0;" class="row">
                    <div style="padding-bottom: 0px; margin-bottom:0;" class="col s4 l4 xl4 ">
                        <p class="fit-content">
                            <small>   A aguardar confirmação para acesso.    
                            </small></p> 
                    </div>
                    <div style="padding-bottom: 0px; margin-bottom:0;" class="col s4 l4 xl4 ">
                        <p style="margin-bottom:0;">
                            <small>
                                <span class="left material-icons">
                                    announcement
                                    </span>
                                    Código de acesso: <b>{{$courseGrant->token}}</b> 
                            </small>
                        </p>
                    </div>
                </div> 
                @endif  
            @endif
            
        </div>
        
        <p style="margin-top:0;" ><small><i>
            <span style="font-size: 12px;" class="material-icons">
                schedule
                </span></i> 
             Curso publicado  em {{$course->created_at}}  
             </small>
        </p>
       <h3>Objectivos do curso</h3>
        <div>
            <ul  class="collection">
               @foreach ($course->objectives as $objective)
                    <li class="collection-item avatar">
                        <i class="material-icons orange circle">check_box</i>
                        <p>{{$objective->description}}
                        </p>
                        <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
                    </li>
               @endforeach
                
               
                
            </ul>
        </div>
        </div>
        
        
    </div>

       
</div>            
            <div class="">
                <div class="row">
                    <div class="col s12 m12 l12 xl12">
                        <h1 style="border-bottom: 1px solid black; padding-bottom: 10px; padding-top:20px;"><span class="material-icons">
                                pages
                            </span> Módulos do curso </h1>
                    </div>
        
                </div>
                <div class="row">
                    @foreach($modules as $module)
                    <div class="col s12 m6 l3 xl3">
                   
                    <x-card-image  :link="url('/modulos/'.$module->id)" 
                        :imagePath="url($module->photo_path)"
                        :title="''"
                        :description="$module->name" />
                    </div>
                    @endforeach
                </div>
        
            </div>
            <div class="">
                <div class="row">
                    <div class="col s12 m12 l12 xl12">
                        <h1 style="border-bottom: 1px solid black; padding-bottom: 10px; padding-top:20px;"><span class="material-icons">
                                pages
                            </span> Testes do curso </h1>
                    </div>
        
                </div>
                <div class="row">
                    @foreach($modules as $module)
                    <div class="col s12 m6 l3 xl3">
                        <a href="/quizz/{{$module->id}}">
                            <div class="card-panel teal">
                                <span class="white-text">{{$module->name}} <i class="material-icons right">help</i> </span>
                              </div>
                        </a>
                       
                    </div>
                    @endforeach
                </div>
        
            </div>
        </div>
    </div>

  
</div>

<div class="fixed-action-btn">
    <a href="https://wa.me/{{$course->whatsapp_number}}" class="btn-floating btn-large green accent-2">
      <i class="large material-icons">whatsapp</i>
    </a>
    
  </div>
        
<!-- Modal Structure -->
<div id="modal1" class="modal">
  <div class="modal-content">
      <h1>Requisição feita</h1>
      <p>Para ganhar acesso precisa pagar {{$course->price}}MT pelo MPESA e 
        depois enviar o comprovativo  do pagamento e o código de acesso <span class="token"></span>  
         para o whatsapp {{$course->user->whatsapp_number}} </p>
     
             <table>
                 <tr>
                     <td>Número MPESA </td> <td>{{$course->user->mpesa_number}}</td>

                 </tr>
                 <tr>
                     <td>Nome que aparece no MPESA </td> <td>{{$course->user->mpesa_name}}</td>
                 </tr>
                 <tr>
                     <td>Código de acesso </td> <td><span class="token"></span></td>
                 </tr>
             </table>     
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">OK</a>
    </div>
    </div>

<script>
   var course_id = {{$course->id}}
</script>

<style>
    .course-thumbnail {
    border: 0px solid #673ab7 !important
    ;
    border-radius: 4px;
    padding: 5px;
    width: 150px;
}

    .height-300{
        height: 270px !important;
    }

</style>

@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="/js/requesttoken.js"></script>
@endsection
@endsection