@extends('layouts.public')

@section('main')
<?php $courseUnProcessed = true; $courseAproved = true; ?>

<div class="row">
    <div class="col s12 m12 l12 xl12">
        <h1 style="border-bottom: 1px solid black; font-size: 20px;    padding-bottom: 10px; padding-top:20px;"><span class="material-icons">
                pages
            </span> Cursos aprovados </h1>
    </div>

</div>
<div class="row">
    @foreach($courses as $course)
        @if ($course->authorize==1)
        <?php $courseAproved = false; ?>
            <div class="col s12 m6 l3 xl3">
                <x-card-image :link="url('/cursos/'.$course->slug)" 
                :imagePath="url($course->thumbnail)"
                :title="''"
                :description="'<b>'.$course->name.'</b>'" />
            </div>
        @endif        
    @endforeach

    @if ($courseAproved)
    <p>Sem cursos aprovados</p>
@endif  
</div>
<div class="row">
    <div class="col s12 m12 l12 xl12">
        <h1 style="border-bottom: 1px solid black; font-size: 20px;  padding-bottom: 10px; padding-top:20px;"><span class="material-icons">
                pages
            </span> Cursos requisitados ainda não processados </h1>
    </div>

</div>
<div class="row">

    @foreach($courses as $course)
        @if ($course->authorize==0)
        <?php $courseUnProcessed = false; ?>
            <div class="col s12 m6 l3 xl3">
                <x-card-image :link="url('/cursos/'.$course->slug)" 
                :imagePath="url($course->thumbnail)"
                :title="''"
                :description=" '<b>'.$course->name.'<br></b> Código de acesso: <b>'.
                $course->token .'</b>'" />
            </div>
        @endif        
    @endforeach
   
@if ($courseUnProcessed)
    <p>Sem cursos por aprovar.</p>
@endif

</div>
@endsection