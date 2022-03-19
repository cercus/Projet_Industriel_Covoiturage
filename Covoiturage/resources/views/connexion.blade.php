@extends('base')

@section('title')
    Connexion
@endsection

@section('style')
    <link rel="stylesheet" href="css/style.css">
@endsection
    
@section('navbarSequel')
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{route('inscription')}}">Inscription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('connexion')}}">Connexion</a>
        </li>
    </ul>
@endsection

@section('content')
    <form method="POST" action="{{route('store.connexion')}}" >
    <h1 class="center-title">Connectez-vous à votre espace</h1>

    <form style="padding-top: 60px;" method="POST" action="{{route('store.connexion')}}">
        @csrf
        @if($errors->any())
            <div class="alert alert-warning">
                La connexion n'a pas pu se réaliser &#9785; {{implode('', $errors->all(':message'))}}
            </div>
        @endif

        <div class="form-group col-md-8 mx-auto">
            <label for="email">Adresse mail</label>
            <input type="email" id="utilisateur" name="email" value="{{old('email')}}" placeholder="votreEmail@exemple.com"
                class="form-control input-form @error('email') is-invalid @enderror" required value="{{old('email')}}"/>
        </div>

        <div class="form-group col-md-8 mx-auto">
            <label for="password">Mot de passe</label>
            <input type="password" id="motDePasse" name="password" value="{{old('password')}}" placeholder="Saisir votre mot de passe"
                class="form-control input-form @error('password') is-invalid @enderror" required />
            @error('paswword')
            <div id="objet_feedback" class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="center-title">
            <label>Se souvenir de moi</label>
            <input  type="checkbox" id="rememberMe" name="rememberme" value="" checked>
        </div><br>

        <div class="center-title">
            <strong class="psw">
                <a href="{{route('reinitialisation_mdp')}}"><u>Mot de passe oublié ?</u></a>
            </strong>
        </div>

        <div class="center-title">
            <label>Pas encore de compte ?</label>
            <a href="{{route('inscription')}}">
                <strong><u>Inscrivez-vous, c'est gratuit !</u></strong>
            </a>
        </div>
      
        <button type="submit" class="btn button-form mx-auto">Connexion !</button>
    </form>

@endsection