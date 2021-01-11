@extends('layouts.public')

@section('main')
<div class="row">
    <div class="col s12 m12 l12 xl12">
        <h1 style="border-bottom: 1px solid black;  padding-bottom: 10px; padding-top:20px;"><span class="material-icons">
                pages
            </span> Cursos </h1>
    </div>

</div>
<div class="row">
    @foreach($courses as $course)
    <div class="col s12 m6 l3 xl3">
        <x-card-image :link="url('/cursos/'.$course->slug)" 
        :imagePath="url($course->thumbnail)"
        :title="''"
         :description="'<b>'.$course->name.'</b>'" />
    </div>
    @endforeach
</div>
@endsection