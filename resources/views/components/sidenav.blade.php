<ul id="slide-out" class="sidenav">
        <li>
            <div  class=" user-view">
                @auth
                    <div class="background">
                        <img src="/img/fabric.jpg">
                    </div>

                    <a class="profile-sidenav" href="#user">
                        <span class="icon-profile-sidenav material-icons">
                                person
                        </span>
                    </a>
                    <a href="#name"><span class="white-text name">{{auth()->user()->name}}</span></a>
                    <a href="#email"><span class="white-text email">{{auth()->user()->email}}</span></a>
                    <a href="#email"><span class="white-text email">Código de App: <strong>{{auth()->user()->mobile_app_code}}</strong></span></a>

                @endauth

                @guest
                    <a href="/auth/sign-in"   class="waves-effect waves-light login-btn btn">
                        <i class="material-icons right">login</i>Login
                    </a>
                @endguest


            </div>
        </li>
    @auth
        <li><a class="waves-effect" href="#mobile_app_code"><i class="material-icons">bookmark_border</i>Código de autennticção App</a></li>
    @endauth
        <li><a class="waves-effect" href="/cursos"><i class="material-icons">bookmark_border</i>Cursos</a></li>
        <li><a class="waves-effect" href="/meus-cursos"><i class="material-icons">bookmark_border</i>Meus cursos</a></li>
         <li><a class="waves-effect" href="/my-results/quizz"><i class="material-icons">help</i>Resultados do Quizz</a></li>

        <li>
            <div class="divider"></div>
        </li>
        <li><a  class="subheader">Expert</a></li>
        <li><a class="waves-effect" href="#!">Sobre nós</a></li>
        <li><a class="waves-effect" href="#!">Perguntas Frequentes</a></li>
    </ul>
