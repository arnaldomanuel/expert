<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @section('css')
        
    @show

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="/css/main.css">
    <title>@yield('title', 'Expert - Cursos online')</title>
</head>

<body>

   @Include('components.topnav')
    <!--Sidenva-->
   @Include('components.sidenav')
    <div class="false-container">
           
           @section('main')

           @show
                
    </div>

    @section('js')
        
    @show
    <!--EndSidenav-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems, {});
             elems = document.querySelectorAll('.dropdown-trigger');
     instances = M.Dropdown.init(elems, {
        constrainWidth : false
     });
     elems = document.querySelectorAll('.collapsible');
    instances = M.Collapsible.init(elems, {});
    var instance = M.Tabs.init(document.querySelectorAll('.tabs'), {});
        });
         elems = document.querySelectorAll('.materialboxed');
     instances = M.Materialbox.init(elems, {});
         
    </script>
</body>

</html>