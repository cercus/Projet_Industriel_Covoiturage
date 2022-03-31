@extends('base')

@section('title')
    Confirmation d'annuler ma reservation
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection
           
@section('navbarSequel')
@if(session()->has('user'))
    <div class="pmd-user-info "> 
            <div class="dropdown">
                <button data-toggle="dropdown" class="dropdown-toggle" type="button" style="background-color: rgb(51, 63, 80); border: 1px solid rgb(51, 63, 80);"><img class="avatar-img rounded-circle" src="/images/avatar_photo.jpg" width="73" height="73" alt="avatar"></button>
                    <div class="dropdown-menu dropdown-menu-right">
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
    <h1 class="center-title">
        Confirmation
    </h1>
    <div class="col-md-8 border border-dark ml-auto mr-auto mt-4">
        <div class="media mt-4 ">
            <img src="/images/confirmation.png" class="bg-transparent" alt="..." width="120" height="120">
            <div class="media-body">
              <p class="mt-4 mb-4">Vous avez annulé votre reservation !</p>
              <p>Votre message sera transmis au conducteur</p>
            </div>
        </div>
        <div class="col-md-6 mt-3 btn-profil">
            <a href="{{route('reservation_en_cours', $idPassager)}}">
                <button type="submit" class="btn button-form mb-4">Mes réservations en cours</button>
            </a>
        </div>
    </div>
    
@endsection