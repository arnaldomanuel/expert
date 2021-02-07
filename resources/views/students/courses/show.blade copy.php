@extends('layouts.public')
@section('css')
    <link rel="stylesheet" href="/css/loading.css">
@endsection
@section('main')
<div class="row">

    <div style="height: 450px; position:relative; width: 100%; background-color:#673ab7; background-image: url('/img/t1.png'); background-position: bottom;
            background-size:cover;" class="col s12 m12 l12 xl12">
        <div style=" margin-top: 60px; margin-left:auto; margin-right:auto; width:fit-content ">
            <img class="materialboxed course-thumbnail" style=" height: 230px; width: 230px !important;" src="{{url($course->thumbnail)}}" alt="">
           
           
        </div>

        <h1 style="width:100%; padding-top: 20px;" class="center">{{$course->name}}</h1>
        
    </div>

</div>
<div class="row">
    <div class="col s12 m3 l3 xl3">
        <div class="col s12 m12 l12">
            <div class="card-panel grey lighten-5 z-depth-1">
                <div class="row valign-wrapper">
                    <div class="col s6">
                        <img src="{{$course->user->profilepic ? $course->user->profilepic : url('img/avatar.jpg') }}" alt="" class="circle  responsive-img"> <!-- notice the "circle" class -->
                    </div>
                    <div class="col s10">
                        <span class="black-text">
                            <p style="font-weight: 700;" class="center">{{$course->user->name}}</p>
                            <p class="center"><i class="material-icons">school</i></p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m9 l9 xl9">
        <div class="card-panel grey lighten-5 z-depth-1">
            <div style="margin-bottom: 0px;" class="row">
                
                    <div style="padding-bottom:0;" class="col s12 l12 m12 xl12">
                        @if (!isset($courseGrant) ||  $courseGrant->authorize==\App\Models\CourseGrant::REPROVED)
                            <button class="btn left" id="btnRequest" onclick="requestToken()">Requisitar Acesso </button>
                            <span id="loader" style="display: none" class="lds-dual-ring"></span>
                        @endif
 
                        @if (isset($courseGrant)) 
                            @if( $courseGrant->authorize==\App\Models\CourseGrant::UNPROCESSED)
                            <div style="padding-bottom: 0px; margin-bottom:0;" class="row">
                                <div style="padding-bottom: 0px; margin-bottom:0;" class="col s4 l4 xl4 ">
                                    <p class="fit-content">
                                        <small>   A aguardar confirmação para acesso.<span class="material-icons left">watch_later</span>     
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
            </div>
        
            <p style="margin-top:0;" ><small><i>Criado em {{$course->created_at}}</i></small></p>
        <h1>{{$course->name}}</h1>
        <div>
            {!!$course->description!!}
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
            @foreach($course->modules as $module)
            <div class="col s12 m6 l3 xl3">
           
            <x-card-image :link="url('/modulos/'.$module->id)" 
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
            @foreach($course->modules as $module)
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



@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="/js/requesttoken.js"></script>
@endsection
@endsection