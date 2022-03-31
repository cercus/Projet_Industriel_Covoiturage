@extends('base')

@section('title')
    A propos
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('navbarSequel')
    @if(session()->has('user'))
        <div class="pmd-user-info "> 
                <div class="dropdown">
                    <button data-toggle="dropdown" class="dropdown-toggle" type="button" style="background-color: rgb(51, 63, 80); border: 1px solid rgb(51, 63, 80);"><img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"></button>
                        <div class="dropdown-menu">
                            <li class="sous-menu"><a tabindex="-1">{{session()->get('user')['prenom']}} {{session()->get('user')['nom']}}</a></li>
                            <hr>
                            <li><a tabindex="-1" class="dropdown-item sous-menu" href="{{route('user', ['idUtilisateur' => session()->get('user')['id']])}}">Mon Profil</a></li>
                            <form method="POST" action="{{route('logout.post')}}">@csrf<button class="dropdown-item nav-link" type="submit">Déconnexion</button></form>
                            
                        </div> 
                </div>
        </div>
    @else
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{route('inscription')}}">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('connexion')}}">Connexion</a>
            </li>
        </ul>
    @endif
@endsection

@section('content')
    <ul>
    <a class="center-title" ><h1>A PROPOS</h1><br/></a>
    <a class="center-title"><h3><strong>Descriptif de l’application</h3></a>
    <a class="center-title" style="color : rgb(51, 63, 80); text-align: justify;" ><h4>Cette application met en relation des personnes réalisant régulièrement
         des trajets de et vers l’université de Luminy. Elle propose aux conducteurs de véhicule et aux 
         personnes cherchant à se déplacer par le biais de covoiturage de proposer de mettre en communs 
         leurs trajets.<br/><br/></h4></a>

    <a class="center-title"><h3><strong>Objectifs</strong></h3></a>
    <a class="center-title" style="color : rgb(51, 63, 80);  text-align: justify;"><h4>Cette application a pour objectif de réduire le temps de trajet des 
        passagers, de partager des frais de conduite, de diminuer le trafic entre Marseille et Luminy, 
        mais surtout de diminuer l’émission des polluants engendrés par les véhicules.<br/><br/></h4></a>

    <a class="center-title"><h3><strong>Utilité</strong></h3></a>
    <a class="center-title" style="color : rgb(51, 63, 80);  text-align: justify;"><h4>L’utilité rejoint les objectifs, diminuer les émissions de polluants, 
        les couts et le temps de transport.</h4></a>
    </ul>
@endsection