<nav class="white">
  <div class="white false-container nav-wrapper">
    <a href="#" data-target="slide-out" class="sidenav-trigger brand-logo1 black-text" href="#"><span class="material-icons">
        menu
      </span></a>
    <a href="/" class="black-text brand-logo"><img width="100px" style="margin-top: 7px;" src="/img/logo.jpeg" alt=""></a>

    <ul id="nav-mobile" class="right ">
      @auth
        <li><a href='#' data-target='dropdown1' class="uppercase dropdown-trigger profile-link white-text" >
          {{substr(auth()->user()->name, 0, 1)}}</a>
        </li>
      @endauth
      @guest
        <li><a style="color: #673ab7 !important; font-weight: 700;" href='/auth/sign-in' >Login</a>
        </li>
      @endguest
     
    </ul>
  </div>
</nav>
<ul id='dropdown1' class='dropdown-content'>

  @auth
    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
     document.getElementById('formLogout').submit()">
    <i class="material-icons">power_settings_new</i>Logout</a></li>
  @endauth

 

</ul>
@auth
<form style="display: inline-block;" id="formLogout" method="POST" action="{{ route('logout') }}">
  @csrf
</form>
@endauth
