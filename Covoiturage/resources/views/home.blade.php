@extends('base')

@section('title')
    Page d'accueil
@endsection

@section('style')
    <link rel="stylesheet" href="/css/style.css">
@endsection
           
@section('navbarSequel')
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="#">Inscription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Connexion</a>
        </li>
    </ul>
@endsection

@section('content')
    Contenu de la page d'accueil
@endsection
