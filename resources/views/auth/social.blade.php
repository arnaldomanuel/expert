@extends('layouts.public')

@section('main')




    <div class="container">
        <div  class="row">
          
            <div class="inner-card col s6
            offset-s3 z-depth-1 white" id="panell">
             <h1 class="center">Crie uma conta ou Faça Login</h1>
               <a href="/facebook/redirect">
                   <div class="provider-auth deep-purple accent-2 white-text">
                       <p class="center fit-content">Facebook <i class="material-icons left">facebook</i></p>
                   </div>
               </a>
               <a href="/auth/google">
                   <div style="margin-bottom: 20px;" class="provider-auth  orange darken-4 white-text">
                       <p class="center fit-content">Google <i class=" left"><img width="30px" src="/img/g.svg" alt="" ></i></p>
                   </div>
               </a>
               <a href="/register">
                    <div class="provider-auth orange accent-2 white-text">
                        <p class="center fit-content">Criar conta <i class="material-icons left">email</i></p>
                    </div>
                </a>
                <a href="/login">
                    <div class="provider-auth orange accent-2 white-text">
                        <p class="center fit-content">Login <i class="material-icons left">email</i></p>
                    </div>
                </a>
         </div>
        </div>
       
      </div>

      <style>
          .inner-card{
              padding-top: 40px !important;
          }
          .provider-auth p{
              font-size: large;
              margin: 0 auto;
              font-weight: 700;
          }
          
          .provider-auth{
              margin-top: 30px;
              padding-top: 20px;
              padding-bottom: 20px;
          }
         
           .container{
               margin-top: 70px;
           }
        
        @media only screen and (max-width: 700px) {
           
            .inner-card{
              width: 100%!important;
              border: 1px red solid;
          }
          .row .col.offset-s3 {
             margin-left: 0% !important; 
        }
        }
      </style>

@endsection