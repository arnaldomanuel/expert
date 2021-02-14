@extends('layouts.public')

@section('main')
<section id="hero">
<div class="row">
    <div class="col s12 m12 l6 xl6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
      <div>
        <h1 class="hero-h1">Cursos certos para sua carreira</h1>
        <h2 class="hero-h2">Escolha o curso que quiser fazer</h2>
        <p id="actionbtn"><a href="#courses" class="btn-get-started scrollto">Ver cursos</a></p>
      </div>
    </div>
    <div class="col s12 m12 l6 xl6 order-lg-2 hero-img" data-aos="fade-left">
      <img src="/assets/img/hero-img.png" class="img-fluid" alt="">
    </div>
  </div>
</section>
<div class="row">
    <div class="col s12 m12 l12 xl12">
    <nav style="margin: 0 auto;" class="nav-search orange">
        <div   class=" nav-search  nav-wrapper orange">
          <form>
            <div  class="input-field">
              <input id="search" type="search" placeholder="Pesquise por cursos e módulos" required>
              <label class="label-icon" for="search"><i class="material-icons">search</i></label>
              <i class="material-icons">close</i>
            </div>
          </form>
        </div>
      </nav>
    </div>
</div>
<div id="courses" class="row">
    <div class="col s12 m12 l12 xl12">
        <h1 style="border-bottom: 1px solid black;  padding-bottom: 10px; padding-top:20px;"><span class="material-icons">
                pages
            </span> Cursos </h1>
    </div>

</div>
<div class="row">
    @foreach($courses as $course)
    <div class="col s12 m6 l3 xl3 ">
        <x-card-image :link="url('/cursos/'.$course->slug)" 
        :imagePath="url($course->thumbnail)"
        :title="''"
         :description="'<b>'.$course->name.'</b>'" />
    </div>
    @endforeach
</div>

<style>
  #hero .btn-get-started {
    font-family: "Raleway", sans-serif;
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-block;
    padding: 12px 28px;
    border-radius: 3px;
    transition: 0.5s;
    color: #fff;
    background: #FF9700;
}
  #hero h1 {
    margin: 50px 0 20px 0;
    font-size: 58px;
    font-weight: 700;
    line-height: 56px;
    color: #364146;
}
#hero h2 {
    color: #576971;
    margin-bottom: 30px;
    font-size: 24px;
}
  #hero{
    margin-top: 30px;
  }
  #hero .hero-img img {
    width: 70%;
}
    .height-300{
        height: 270px !important;
    }
    .nav-search{
        width:80%; margin-top: 0px; border-radius: 30px;
    }
    .justify-content-center {
    -ms-flex-pack: center!important;
    justify-content: center!important;
}

.flex-column {
    -ms-flex-direction: column!important;
    flex-direction: column!important;
}
.d-flex {
    display: -ms-flexbox!important;
    display: flex!important;
}
@media (max-width: 640px){
  #hero h1 {
    margin: 50px 0 20px 0;
    font-size: 30px;
    font-weight: 700;
    line-height: 36px;
    color: #364146;
}
#hero .hero-img img {
    width: 100%;
}
#actionbtn{
text-align: center;
}
.nav-search{
        width:95%; margin-top: 0px; border-radius: 30px;
    }
}
@media (min-width: 992px){
.order-lg-1 {
    -ms-flex-order: 1;
    order: 1;
}
}
@media (min-width: 992px){
.col-lg-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
.order-2 {
    -ms-flex-order: 2;
    order: 2;
}}
</style>
@endsection